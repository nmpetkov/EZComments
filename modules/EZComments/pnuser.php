<?php 
/**
 * $Id$
 * 
 * * EZComments *
 * 
 * Attach comments to any module calling hooks
 * 
 * 
 * * License *
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License (GPL)
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 *
 * @author      Joerg Napp <jnapp@users.sourceforge.net>
 * @author      Mark West <markwest at postnuke dot com>
 * @author      Jean-Michel Vedrine
 * @version     1.4
 * @link        http://noc.postnuke.com/projects/ezcomments/ Support and documentation
 * @license     http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package     Postnuke
 * @subpackage  EZComments
 */


/**
 * Return to index page
 * 
 * This is the default function called when EZComments is called 
 * as a module. As we do not intend to output anything, we just 
 * redirect to the start page.
 * 
 * @since    0.2
 */
function EZComments_user_main($args)
{
    return pnRedirect(pnGetBaseUrl());
}


/**
 * Display comments for a specific item
 * 
 * This function provides the main user interface to the comments
 * module. 
 * 
 * @param    $args['objectid']     ID of the item to display comments for
 * @param    $args['extrainfo']    URL to return to if user chooses to comment
 * @param    $args['template']     Template file to use (with extension)
 * @return   output                the comments
 * @since    0.1
 */
function EZComments_user_view($args)
{
    // work out the input from the hook
    $mod = pnModGetName();
    $objectid = $args['objectid'];

    // security check
    if (!pnSecAuthAction(0, 'EZComments::', "$mod:$objectid:", ACCESS_OVERVIEW)) {
        return _EZCOMMENTS_NOAUTH;
    }

    // we may get some input in from the navigation bar
    list ($template, $order) = pnVarCleanFromInput('template', 'order');

    if ($order == 1) {
        $sortorder = 'DESC';
    } else {
        $sortorder = 'ASC';
    }
    $status = 0;

	// check if we're using the pager
	$enablepager = pnModGetVar('EZComments', 'enablepager');
	if ($enablepager) {
		$numitems = pnModGetVar('EZComments', 'commentsperpage');
		$startnum = pnVarCleanFromInput('comments_startnum');
		if (!isset($startnum) && !is_numeric($startnum)) {
			$startnum = -1;
		}
	} else {
		$startnum = -1;
		$numitems = -1;
	}
    $items = pnModAPIFunc('EZComments',
                          'user',
                          'getall',
                           compact('mod', 'objectid','sortorder','status','numitems','startnum'));

    if ($items === false) {
        return _EZCOMMENTS_FAILED;
    }     

    $comments = EZComments_prepareCommentsForDisplay($items);
	if ($enablepager) {
		$commentcount = pnModAPIFunc('EZComments', 'user', 'countitems', array('mod' => $mod, 'objectid' => $objectid));
	} else {
		$commentcount = count($comments);
	}
    // create the pnRender object
    $pnRender =& new pnRender('EZComments');

    // don't use caching (for now...)
    $pnRender->caching=false;

    $pnRender->assign('comments',   $comments);
	$pnRender->assign('commentcount', $commentcount);
	$pnRender->assign('modinfo',    pnModGetInfo(pnModGetIDFromName($mod)));
    $pnRender->assign('order',      $order);
    $pnRender->assign('allowadd',   pnSecAuthAction(0, 'EZComments::', "$mod:$objectid:", ACCESS_COMMENT));
    $pnRender->assign('loggedin',   pnUserLoggedIn());
    if (!is_array($args['extrainfo'])) {
        $pnRender->assign('redirect',   $args['extrainfo']);
    } else {
        $pnRender->assign('redirect',   $args['extrainfo']['returnurl']);
    }
    $pnRender->assign('objectid',   $objectid);

    // assign all module vars (they may be useful...)
    $pnRender->assign(pnModGetVar('EZComments'));

	// assign the values for the pager
	$pnRender->assign('pager', array('numitems'     => $commentcount,
	                                 'itemsperpage' => $numitems));

    // find out which template to use
    $template = pnModGetVar('EZComments', 'template');
    if (!empty($template)) {
        $template = $template;
    } else if (isset($args['template'])) {
        $template = $args['template'];
    }
    if (!$pnRender->template_exists(pnVarPrepForOS($template . '/ezcomments_user_view.htm'))) {
        $template = pnModGetVar('EZComments', 'template');
    }
    $pnRender->assign('template', $template);
    return $pnRender->fetch(pnVarPrepForOS($template) . '/ezcomments_user_view.htm');
} 

/**
 * Display a comment form 
 * 
 * This function displays a comment form, if you do not want users to
 * comment on the same page as the item is.
 * 
 * @param    $comment     the comment (taken from HTTP put)
 * @param    $modname     the name of the module the comment is for (taken from HTTP put)
 * @param    $objectid    ID of the item the comment is for (taken from HTTP put)
 * @param    $redirect    URL to return to (taken from HTTP put)
 * @param    $subject     The subject of the comment (if any) (taken from HTTP put)
 * @param    $replyto     The ID of the comment for which this an anser to (taken from HTTP put)
 * @param    $template    The name of the template file to use (with extension)
 * @todo     Check out it this function can be merged with _view!
 * @since    0.2
 */
function EZComments_user_comment($args)
{
    list($modname,
         $objectid,
         $redirect,
         $comment,
         $subject,
         $replyto,
         $template) = pnVarCleanFromInput('modname',
                                          'objectid',
                                          'redirect',
                                          'comment',
                                          'subject',
                                          'replyto',
                                          'template');

    extract($args);

    // check if commenting is setup for the input module
    if (!pnModAvailable($modname) || !pnModIsHooked('EZComments', $modname)) {
        return _EZCOMMENTS_NOAUTH;
    }

	// check if we're using the pager
	$enablepager = pnModGetVar('EZComments', 'enablepager');
	if ($enablepager) {
		$numitems = pnModGetVar('EZComments', 'commentsperpage');
		$startnum = pnVarCleanFromInput('comments_startnum');
		if (!isset($startnum) && !is_numeric($startnum)) {
			$startnum = -1;
		}
	} else {
		$startnum = -1;
		$numitems = -1;
	}
    $items = pnModAPIFunc('EZComments',
                          'user',
                          'getall',
                           compact('mod', 'objectid','sortorder','status','numitems','startnum'));

    if ($items === false) {
        return _EZCOMMENTS_FAILED;
    }     

    $comments = EZComments_prepareCommentsForDisplay($items);
	if ($enablepager) {
		$commentcount = pnModAPIFunc('EZComments', 'user', 'countitems', array('mod' => $mod, 'objectid' => $objectid));
	} else {
		$commentcount = count($comments);
	}

    $pnRender =& new pnRender('EZComments');

    // don't use caching (for now...)
    $pnRender->caching=false;

    $pnRender->assign('comments',     $comments);
	$pnRender->assign('commentcount', $commentcount);
    $pnRender->assign('order',        $order);
    $pnRender->assign('allowadd',     pnSecAuthAction(0, 'EZComments::', "$modname:$objectid: ", ACCESS_COMMENT));
    $pnRender->assign('addurl',       pnModURL('EZComments', 'user', 'create'));
    $pnRender->assign('loggedin',     pnUserLoggedIn());
    $pnRender->assign('redirect',     $redirect);
    $pnRender->assign('mod',          pnVarPrepForDisplay($modname));
    $pnRender->assign('objectid',     pnVarPrepForDisplay($objectid));
    $pnRender->assign('subject',      pnVarPrepForDisplay($subject));
    $pnRender->assign('replyto',      pnVarPrepForDisplay($replyto));

    // assign all module vars (they may be useful...)
    $pnRender->assign(pnModGetVar('EZComments'));

	// assign the values for the pager
	$pnRender->assign('pager', array('numitems'     => $commentcount,
	                                 'itemsperpage' => $numitems));

    // find out which template to use
    $template = pnModGetVar('EZComments', 'template');
    if (!empty($template)) {
        $template = $template;
    } else if (isset($args['template'])) {
        $template = $args['template'];
    }

    if (!$pnRender->template_exists(pnVarPrepForOS($template . '/ezcomments_user_comment.htm'))) {
        $template = pnModGetVar('EZComments', 'template');
    }
    $pnRender->assign('template', $template);


    if (!$pnRender->template_exists(pnVarPrepForOS($template . '/ezcomments_user_comment.htm'))) {
        return _EZCOMMENTS_FAILED;
    }

    return $pnRender->fetch(pnVarPrepForOS($template) . '/ezcomments_user_comment.htm');
}

/**
 * Create a comment for a specific item
 * 
 * This is a standard function that is called with the results of the
 * form supplied by EZComments_user_view to create a new item
 * 
 * @param    $comment     the comment (taken from HTTP put)
 * @param    $modname     the name of the module the comment is for (taken from HTTP put)
 * @param    $objectid    ID of the item the comment is for (taken from HTTP put)
 * @param    $redirect    URL to return to (taken from HTTP put)
 * @param    $subject     The subject of the comment (if any) (taken from HTTP put)
 * @param    $replyto     The ID of the comment for which this an anser to (taken from HTTP put)
 * @since    0.1
 */
function EZComments_user_create($args)
{
    // Confirm authorisation code.
    if (!pnSecConfirmAuthKey()) {
        pnSessionSetVar('errormsg', _BADAUTHKEY);
        return pnRedirect($redirect);
    } 

    list($modname,
         $objectid,
         $redirect,
         $comment,
         $subject,
         $replyto) = pnVarCleanFromInput('modname',
                                         'objectid',
                                         'redirect',
                                         'comment',
                                         'subject',
                                         'replyto');

    // check if the user logged in and if we're allowing anon users to 
    // set a name and e-mail address
    if (!pnUserLoggedIn()) {
        list($anonname, $anonmail, $anonwebsite) = pnVarCleanFromInput('anonname', 'anonmail', 'anonwebsite');
    } else {
        $anonname = '';
        $anonmail = '';
		$anonwebsite = '';
    }

    // decoding the URL. Credits to tmyhre for fixing.
    $redirect = rawurldecode($redirect);
    $redirect = str_replace('&amp;', '&', $redirect);

    $id = pnModAPIFunc('EZComments',
                       'user',
                       'create',
                       array('mod'         => $modname,
                             'objectid'    => $objectid,
                             'url'         => $redirect,
                             'comment'     => $comment,
                             'subject'     => $subject,
                             'replyto'     => $replyto,
                             'uid'         => pnUserGetVar('uid'),
                             'anonname'    => $anonname,
                             'anonmail'    => $anonmail,
							 'anonwebsite' => $anonwebsite));

    return pnRedirect($redirect);
} 

/**
 * Prepare comments to be displayed
 * 
 * We loop through the "raw data" returned from the API to prepare these data
 * to be displayed. 
 * We check for necessary rights, and derive additional information (e.g. user
 * data) drom other modules.
 * 
 * @param    $items    An array of comment items as returned from the API
 * @return   array     An array to display (augmented information / perm. check)
 * @since    0.2
 */
function EZComments_prepareCommentsForDisplay($items)
{
    $comments = array();
    foreach ($items as $item) {
        $comment = $item;
        if ($item['uid'] > 0) {
            // get the user vars and merge into the comment array
            $userinfo = pnUserGetVars($item['uid']);
			// the users url will clash with the comment url so lets move it out of the way
			$userinfo['website'] = $userinfo['url'];
            $comment  = array_merge ($userinfo, $comment);

            // work out if the user is online
            $comment['online'] = false;
            if (pnModAvailable('Members_List')) {
                if (pnModAPIFunc('Members_List', 'user', 'isonline', array('userid' => $userinfo['pn_uid']))) {
                    $comment['onlinestatus'] = true;
                    $comment['online'] = true;
                }
            } else {
                $comment['onlinestatus'] = false;
            }
        } else {
            $comment['uname'] = pnConfigGetVar('Anonymous');
        }
        $comment['del'] = (pnSecAuthAction(0, 'EZComments::', "$comment[mod]:$comment[objectid]:$comment[id]", ACCESS_DELETE));
        $comments[] = $comment;
    }
    return $comments;
}

/**
 * Sort comments by thread
 * 
 * 
 * @param    $comments    An array of comments
 * @return   array        The sorted array
 * @since    0.2
 */
function EZComments_threadComments($comments)
{
    return EZComments_displayChildren($comments, -1, 0);
}

/**
 * Get all child comments
 * 
 * This function returns all child comments to a given comment.
 * It is called recursively
 * 
 * @param    $comments    An array of comments
 * @param    $id          The id of the parent comment
 * @param    $level       The indentation level 
 * @return   array        The sorted array
 * @access   private
 * @since    0.2
 */
function EZComments_displayChildren($comments, $id, $level)
{
    $comments2 = array();
    foreach ($comments as $comment) {
        if ($comment['replyto'] == $id) {
            $comment['level'] = $level;
            $comments2[] = $comment;
            $comments2 = array_merge($comments2, 
                                     EZComments_displayChildren($comments, $comment['id'], $level+1));
        }
    }
    return $comments2;
}

/** 
 * return an rss/atom feed of the last x comments
 *
 * @author Mark west
*/
function EZComments_user_feed()
{
	list($feedcount, $feedtype, $mod, $objectid) = pnVarCleanFromInput('feedcount', 'feedtype', 'mod', 'objectid');

	// check our input
	if (!isset($feedcount) || !is_numeric($feedcount) || $feedcount < 1 || $feedcount > 999) {
		$feedcount = pnModGetVar('EZcomments', 'feedcount');
	}
	if (!isset($feedtype) || !is_string($feedtype) || ($feedtype !== 'rss' && $feedtype !== 'atom')) {
		$feedtype = pnModGetVar('EZComments', 'feedtype');
	}
	if (!isset($mod) || !is_string($mod) || !pnModAvailable($mod)) {
		$mod = null;
	}
	if (!isset($objectid) || !is_string($objectid)) {
		$objectid = null;
	}

    // create the pnRender object
    $pnRender =& new pnRender('EZComments');

	// get the last x comments
	$pnRender->assign('comments', $comments = pnModAPIFunc('EZComments', 'user', 'getall', 
		array('numitems' => $feedcount, 'sortorder' => 'DESC', 'mod' => $mod, 'objectid' => $objectid, 'status' => 0)));

    // grab the item url from one of the comments
    if (isset($comments[0]['url'])) {
        $pnRender->assign('itemurl', $comments[0]['url']);
    } else {
        // attempt to guess the url (api compliant mods only....)
        $pnRender->assign('itemurl', pnModURL($mod, 'user', 'display', array('objectid' => $objectid)));
    }

	// display the feed and notify the core that we're done
	$pnRender->display("ezcomments_user_$feedtype.htm");
	return true;

}

?>