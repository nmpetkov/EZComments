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
 * @version     1.3
 * @link        http://noc.postnuke.com/projects/ezcomments/ Support and documentation
 * @license     http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package     Postnuke
 * @subpackage  EZComments
 */

/**
 * Main administration function
 * 
 * This function provides the main administration interface to the comments
 * module. 
 * 
 * @return string output the admin interface
 */
function EZComments_admin_main() 
{
    if (!pnSecAuthAction(0, 'EZComments::', '::', ACCESS_ADMIN)) {
        return _EZCOMMENTS_NOAUTH;
    } 

    // Create output object
    $pnRender =& new pnRender('EZComments');

    // As admin output changes often, we do not want caching.
    $pnRender->caching = false;

    // assign the module vars
    $pnRender->assign(pnModGetVar('EZComments'));
    // presentation values
    $itemsperpage = pnModGetVar('EZComments', 'itemsperpage');
    $startnum = pnVarCleanFromInput('startnum');

    // call the api to get all current comments
    $items = pnModAPIFunc('EZComments',
                          'user',
                          'getall',
                          array('startnum' => $startnum,
                                'numitems' => $itemsperpage));

    if ($items === false) {
        return _EZCOMMENTS_FAILED;
    } 

    // loop through each item adding the relevant links
    $comments = array();
    foreach ($items as $item) {
        $options = array();
        if (pnSecAuthAction(0, 'EZComments::', "$item[mod]:$item[objectid]:$item[id]", ACCESS_EDIT)) {
            $options[] = array('url'   => pnModURL('EZComments', 'admin', 'modify', array('id' => $item['id'])),
                               'title' => _EDIT);
            if (pnSecAuthAction(0, 'EZComments::', "$item[mod]:$item[objectid]:$item[id]", ACCESS_DELETE)) {
                $options[] = array('url'   => pnModURL('EZComments', 'admin', 'delete', array('id' => $item['id'])),
                                   'title' => _DELETE);
            }
        }
        $item['options'] = $options;
        $comments[] = $item;
    }

    // assign the items to the template
    $pnRender->assign('items', $comments);

    // assign the values for the smarty plugin to produce a pager in case of there
    // being many items to display.
    //
    // Note that this function includes another user API function.  The
    // function returns a simple count of the total number of items in the item
    // table so that the pager function can do its job properly
    $pnRender->assign('pager', array('numitems'     => pnModAPIFunc('EZComments',
                                                                    'user',
                                                                    'countitems'),
                                     'itemsperpage' => $itemsperpage));

    // Return the output
    return $pnRender->fetch('ezcomments_admin_view.htm');
}

/**
 * modify an item
 *
 * This is a standard function that is called whenever an administrator
 * wishes to modify a current module item
 *
 * @author       The PostNuke Development Team
 * @param        tid          the id of the item to be modified
 * @return       string       the modification page
 */
function EZComments_admin_modify($args)
{
    // get our input
    list($id,
         $objectid)= pnVarCleanFromInput('id',
                                         'objectid');

    // extract any input passed directly to the function
    extract($args);

    // check for a generic object id
    if (!empty($objectid)) {
        $id = $objectid;
    }

    // The user API function is called.  This takes the item ID which we
    // obtained from the input and gets us the information on the appropriate
    // item.  If the item does not exist we post an appropriate message and
    // return
    $item = pnModAPIFunc('EZComments', 'user', 'get', array('id' => $id));

    if (!$item) {
        return pnVarPrepHTMLDisplay(_NOSUCHITEM);
    }

    // Security check 
    if (!pnSecAuthAction(0, 'EZComments::', "::$id", ACCESS_EDIT)) {
        return pnVarPrepHTMLDisplay(_MODULENOAUTH);
    }

    // Create output object - this object will store all of our output so that
    // we can return it easily when required
    $pnRender =& new pnRender('EZComments');

    // As Admin output changes often, we do not want caching.
    $pnRender->caching = false;

    // Add a hidden variable for the item id.  This needs to be passed on to
    // the update function so that it knows which item for which item to carry
    // out the update
    $pnRender->assign('id', $id);

    // assign the status flags
    $pnRender->assign('statuslevels', array('0' => _EZCOMMENTS_APPROVED, '1' => _EZCOMMENTS_PENDING, '2' => _EZCOMMENTS_REJECTED));

    // For the assignment of name and number we can just assign the associative
    // array $item.
    $pnRender->assign($item);

    // Return the output that has been generated by this function
    return $pnRender->fetch('ezcomments_admin_modify.htm');
}

/**
 * Update the item
 *
 * This is a standard function that is called with the results of the
 * form supplied by Example_admin_modify() to update a current item
 *
 * @author       The PostNuke Development Team
 * @param        id              the id of the item to be modified
 * @param        subject         the subject of the item to be updated
 * @param        comment         the main text of the item to be updated
 * @param        status          the status level for the item
 * @return       bool            true on sucess, false on failure
 */
function EZComments_admin_update($args)
{
    // Get parameters from whatever input we need.  All arguments to this
    // function should be obtained from pnVarCleanFromInput(), getting them
    // from other places such as the environment is not allowed, as that makes
    // assumptions that will not hold in future versions of PostNuke
    list($id,
         $objectid,
         $subject,
         $comment,
         $status) = pnVarCleanFromInput('id',
                                        'objectid',
                                        'subject',
                                        'comment',
                                        'status');

    // extract any input passed directly to the function
    extract($args);

    // check for a generic object id
    if (!empty($objectid)) {
        $id = $objectid;
    }

    // Confirm authorisation code.  This checks that the form had a valid
    // authorisation code attached to it.  If it did not then the function will
    // proceed no further as it is possible that this is an attempt at sending
    // in false data to the system
    if (!pnSecConfirmAuthKey()) {
        pnSessionSetVar('errormsg', pnVarPrepHTMLDisplay(_BADAUTHKEY));
        return pnRedirect(pnModURL('EZComments', 'admin', 'main'));
    }

    // Notable by its absence there is no security check here.  This is because
    // the security check is carried out within the API function and as such we
    // do not duplicate the work here

    // The API function is called.
    if(pnModAPIFunc('EZComments', 'admin', 'update',
                    array('id' => $id, 'subject' => $subject, 'comment' => $comment, 'status' => $status))) {
        // Success
        pnSessionSetVar('statusmsg', pnVarPrepHTMLDisplay(_UPDATESUCCEDED));
    }

    // This function generated no output, and so now it is complete we redirect
    // the user to an appropriate page for them to carry on their work
    return pnRedirect(pnModURL('EZComments', 'admin', 'main'));
}

/**
 * delete item
 *
 * This is a standard function that is called whenever an administrator
 * wishes to delete a current module item.  Note that this function is
 * the equivalent of both of the modify() and update() functions above as
 * it both creates a form and processes its output.  This is fine for
 * simpler functions, but for more complex operations such as creation and
 * modification it is generally easier to separate them into separate
 * functions.  There is no requirement in the PostNuke MDG to do one or the
 * other, so either or both can be used as seen appropriate by the module
 * developer
 *
 * @author       The PostNuke Development Team
 * @param        id            the id of the item to be deleted
 * @param        confirmation  confirmation that this item can be deleted
 * @param        redirect      the location to redirect to after the deletion attempt
 * @return       bool            true on sucess, false on failure
 */
function EZComments_admin_delete($args)
{
    // Get parameters from whatever input we need. 
    list($id,
         $objectid,
         $redirect,
         $confirmation) = pnVarCleanFromInput('id',
                                              'objectid',
                                              'redirect',
                                              'confirmation');

    // extract any input passed directly to the function
    extract($args);

    // check for a generic object id
    if (!empty($objectid)) {
        $id = $objectid;
    }

    // The user API function is called.
    $item = pnModAPIFunc('EZComments', 'user', 'get', array('id' => $id));

    if (!$item) {
        return pnVarPrepHTMLDisplay(_NOSUCHITEM);
    }

    // Security check
    if (!pnSecAuthAction(0, 'EZComments::', "::$id", ACCESS_DELETE)) {
        return pnVarPrepHTMLDisplay(_MODULENOAUTH);
    }

    // Check for confirmation.
    if (empty($confirmation)) {
        // No confirmation yet - display a suitable form to obtain confirmation
        // of this action from the user

        // Create output object - this object will store all of our output so that
        // we can return it easily when required
        $pnRender =& new pnRender('EZComments');

        // As Admin output changes often, we do not want caching.
        $pnRender->caching = false;

        // Add a hidden field for the item ID to the output
        $pnRender->assign('id', $id);
        
        // Add a hidden field for the item ID to the output
        $pnRender->assign('redirect', $redirect);

        // Return the output that has been generated by this function
        return $pnRender->fetch('ezcomments_admin_delete.htm');
    }

    // If we get here it means that the user has confirmed the action
    // Confirm authorisation code.
    if (!pnSecConfirmAuthKey()) {
        pnSessionSetVar('errormsg', pnVarPrepHTMLDisplay(_BADAUTHKEY));
        return pnRedirect(pnModURL('EZComments', 'admin', 'main'));
    }

    // The API function is called. 
    if (pnModAPIFunc('EZComments', 'admin', 'delete', array('id' => $id))) {
        // Success
        pnSessionSetVar('statusmsg', pnVarPrepHTMLDisplay(_DELETESUCCEDED));
    }

    // This function generated no output, and so now it is complete we redirect
    // the user to an appropriate page for them to carry on their work
    if (!empty($redirect)) {
        return pnRedirect($redirect);
    } else {
        return pnRedirect(pnModURL('EZComments', 'admin', 'main'));
    }
}

/**
 * process multiple comments
 *
 * This function process the comments selected in the admin view page.
 * Multiple comments may have thier state changed or be deleted
 *
 * @author       The PostNuke Development Team
 * @param        Comments   the ids of the items to be deleted
 * @param        confirmation  confirmation that this item can be deleted
 * @param        redirect      the location to redirect to after the deletion attempt
 * @return       bool          true on sucess, false on failure
 */
function EZComments_admin_processselected($args)
{
    // Get parameters from whatever input we need. 
    list($comments, $action) = pnVarCleanFromInput('comments', 'action');

    // extract any input passed directly to the function
    extract($args);

    // If we get here it means that the user has confirmed the action
    // Confirm authorisation code.
    if (!pnSecConfirmAuthKey()) {
        pnSessionSetVar('errormsg', pnVarPrepHTMLDisplay(_BADAUTHKEY));
        return pnRedirect(pnModURL('EZComments', 'admin', 'main'));
    }

    // loop round each comment deleted them in turn 
    foreach ($comments as $comment) {
		switch(strtolower($action)) {
			case 'delete':
				// The API function is called. 
				if (pnModAPIFunc('EZComments', 'admin', 'delete', array('id' => $comment))) {
					// Success
					pnSessionSetVar('statusmsg', pnVarPrepHTMLDisplay(_DELETESUCCEDED));
				}
				break;
			case 'approve':
				if (pnModAPIFunc('EZComments', 'admin', 'updatestatus', array('id' => $comment, 'status' => 0))) {
					// Success
					pnSessionSetVar('statusmsg', pnVarPrepHTMLDisplay(_UPDATESUCCEDED));
				}
				break;
			case 'hold':
				if (pnModAPIFunc('EZComments', 'admin', 'updatestatus', array('id' => $comment, 'status' => 1))) {
					// Success
					pnSessionSetVar('statusmsg', pnVarPrepHTMLDisplay(_UPDATESUCCEDED));
				}
				break;
			case 'reject':
				if (pnModAPIFunc('EZComments', 'admin', 'updatestatus', array('id' => $comment, 'status' => 2))) {
					// Success
					pnSessionSetVar('statusmsg', pnVarPrepHTMLDisplay(_UPDATESUCCEDED));
				}
				break;
		}
    }

    // This function generated no output, and so now it is complete we redirect
    // the user to an appropriate page for them to carry on their work
    if (!empty($redirect)) {
        return pnRedirect($redirect);
    } else {
        return pnRedirect(pnModURL('EZComments', 'admin', 'main'));
    }
}

/**
 * Modify configuration
 *
 * This is a standard function to modify the configuration parameters of the
 * module
 *
 * @author       The PostNuke Development Team
 * @return       string       The configuration page
 */
function EZComments_admin_modifyconfig() 
{
    if (!pnSecAuthAction(0, 'EZComments::', '::', ACCESS_ADMIN)) {
        return _EZCOMMENTS_NOAUTH;
    } 

    // Create output object
    $pnRender =& new pnRender('EZComments');

    // As admin output changes often, we do not want caching.
    $pnRender->caching = false;

    // assign the module vars
    $pnRender->assign(pnModGetVar('EZComments'));

    // assign all available template sets
    $pnRender->assign('templates', pnModAPIFunc('EZComments', 'user', 'gettemplates'));

    // Return the output
    return $pnRender->fetch('ezcomments_admin_modifyconfig.htm');
}

/**
 * Update the configuration
 *
 * This is a standard function to update the configuration parameters of the
 * module given the information passed back by the modification form
 * Modify configuration
 *
 * @author       Jim McDonald
 * @param        MailtoAdmin    flag to mail admin on a new comment
 * @param        moderationemail flag to mail admin on a new commennt needing moderation
 * @param        template  the template set to render the comments and submission form
 * @param        itemsperpage number of comments to display per page in admin view
 * @param        anonusersinfo flag to allow anonymous users to submit custom user information
 * @param        moderation flag to turn on comment moderation
 * @param        modlinkcount number of links in comment to trigger moderation
 * @param        modlist list of words to trigger moderation
 * @param        blacklist list of words to trigger rejection of comment
 * @param        alwaymoderate flag to require all comments are moderated
 * @param        logip flag to control logging of ip addresses
 */
function EZComments_admin_updateconfig($args)
{
    if (!pnSecConfirmAuthKey()) {
        pnSessionSetVar('errormsg', _BADAUTHKEY);
        return pnRedirect(pnModURL('EZComments', 'admin', 'main'));
    } 

    list($MailToAdmin, $moderationmail, $template, $itemsperpage, $anonusersinfo, $moderation, $dontmoderateifcommented,
         $modlinkcount, $modlist, $blacklist, $alwaysmoderate, $proxyblacklist, $logip, $feedtype, $feedcount, 
         $enablepager, $commentsperpage) =
        pnVarCleanFromInput('MailToAdmin', 'moderationmail', 'template', 'itemsperpage', 'anonusersinfo', 'moderation', 'dontmoderateifcommented', 
                            'modlinkcount', 'modlist', 'blacklist', 'alwaysmoderate', 'proxyblacklist', 'logip', 'feedtype', 'feedcount', 
							'enablepager', 'commentsperpage');
    extract($args);

    if (!isset($MailToAdmin)) {
        $MailToAdmin = 0;
    }
    pnModSetVar('EZComments', 'MailToAdmin', $MailToAdmin);
    
    if (!isset($moderationmail)) {
        $moderationmail = 0;
    }
    pnModSetVar('EZComments', 'moderationmail', $moderationmail);

    if (!isset($template)) {
        $template = 'AllOnOnePage';
    }
    pnModSetVar('EZComments', 'template', $template);

    if (!isset($itemsperpage)) {
        $itemsperpage = 25;
    }
    pnModSetVar('EZComments', 'itemsperpage', $itemsperpage);

    if (!isset($anonusersinfo)) {
        $anonusersinfo = 0;
    }
    pnModSetVar('EZComments', 'anonusersinfo', $anonusersinfo);

    if (!isset($moderation)) {
        $moderation = 0;
    }
    pnModSetVar('EZComments', 'moderation', $moderation);

    if (!isset($dontmoderateifcommented)) {
        $dontmoderateifcommented = 0;
    }
    pnModSetVar('EZComments', 'dontmoderateifcommented', $dontmoderateifcommented);

    if (!isset($modlinkcount)) {
        $modlinkcount = 2;
    }
    pnModSetVar('EZComments', 'modlinkcount', $modlinkcount);

    if (!isset($modlist)) {
        $modlist = '';
    }
    pnModSetVar('EZComments', 'modlist', $modlist);

    if (!isset($blacklist)) {
        $blacklist = '';
    }
    pnModSetVar('EZComments', 'blacklist', $blacklist);

    if (!isset($alwaysmoderate)) {
        $alwaysmoderate = 0;
    }
    pnModSetVar('EZComments', 'alwaysmoderate', $alwaysmoderate);

    if (!isset($proxyblacklist)) {
        $proxyblacklist = 0;
    }
    pnModSetVar('EZComments', 'proxyblacklist', $proxyblacklist);

    if (!isset($logip)) {
        $logip = 0;
    }
    pnModSetVar('EZComments', 'logip', $logip);

    if (!isset($feedtype)) {
        $feedtype = 'rss';
    }
    pnModSetVar('EZComments', 'feedtype', $feedtype);

    if (!isset($feedcount)) {
        $feedcount = '10';
    }
    pnModSetVar('EZComments', 'feedcount', $feedcount);

    if (!isset($commentsperpage)) {
        $commentsperpage = '25';
    }
    pnModSetVar('EZComments', 'commentsperpage', $commentsperpage);

    if (!isset($enablepager)) {
        $enablepager = false;
    }
    pnModSetVar('EZComments', 'enablepager', $enablepager);

    pnSessionSetVar('statusmsg', _CONFIGUPDATED);
    return pnRedirect(pnModURL('EZComments', 'admin', 'main'));
}

/**
 * Migration functionality
 * 
 * This function provides a common interface to migration scripts.
 * The migration scripts will upgrade from different other modules 
 * (like NS-Comments, Reviews, My_eGallery, ...) to EZComments.
 * 
 * @return output the migration interface
 */
function EZComments_admin_migrate()
{
    if (!pnSecAuthAction(0, 'EZComments::', '::', ACCESS_ADMIN)) {
        return _EZCOMMENTS_NOAUTH;
    } 
    $migrated=unserialize(pnModGetVar('EZComments', 'migrated'));
    $d = opendir('modules/EZComments/pnmigrateapi');
    $selectitems = array();
    while($f = readdir($d)) {
        if(substr($f, -3, 3) == 'php') {
            if (!isset($migrated[substr($f, 0, strlen($f) -4)]) || !$migrated[substr($f, 0, strlen($f) -4)]) {
                $selectitems[substr($f, 0, strlen($f) -4)] = substr($f, 0, strlen($f) -4);
            }
        }
    }
    closedir($d);

    if (!$selectitems) {
        pnSessionSetVar('statusmsg', _EZCOMMENTS_MIGRATE_NOTHINGTODO);
        return pnRedirect(pnModURL('EZComments', 'admin'));
    } 

    // Create output object - this object will store all of our output so that
    // we can return it easily when required
    $pnRender =& new pnRender('EZComments');

    // As Admin output changes often, we do not want caching.
    $pnRender->caching = false;

    // assign the migratation options
     $pnRender->assign('selectitems', $selectitems);

    // Return the output that has been generated by this function
    return $pnRender->fetch('ezcomments_admin_migrate.htm');
}


/**
 * Do the migration
 * 
 * This is the function that is called to do the actual
 * migration.
 * 
 * @param $migrate The plugin to do the migration
 */
function EZComments_admin_migrate_go()
{
    // Permissions
    if (!pnSecAuthAction(0, 'EZComments::', '::', ACCESS_ADMIN)) {
        return _EZCOMMENTS_NOAUTH;
    } 
    // Authentication key
    if (!pnSecConfirmAuthKey()) {
        // return _EZCOMMENTS_NOAUTH;
    } 
    // Parameter
    $migrate = pnVarCleanFromInput('EZComments_migrate');
    if (!isset($migrate)){ 
        return _EZCOMMENTS_MODSARGSERROR;
    }

    // Eintrag in Datenbank
    $migrated=unserialize(pnModGetVar('EZComments', 'migrated'));

    // call the migration function
    if (pnModAPIFunc('EZComments', 'migrate', $migrate)) {
        $migrated[$migrate] = true;
        pnModSetVar('EZComments', 'migrated', serialize($migrated));
    }
    return pnRedirect(pnModURL('EZComments', 'admin', 'migrate'));
}


/**
 * Cleanup functionality
 * 
 * This is the interface to the Cleanup functionality.
 * When a Module is deleted, EZComments doesn't know about
 * this. Thus, any comments for this module stay in the database.
 * With this functionality you can delete these comments.
 * 
 * @return output the cleanup interface
 */
function EZComments_admin_cleanup()
{
    if (!pnSecAuthAction(0, 'EZComments::', '::', ACCESS_ADMIN)) {
        return _EZCOMMENTS_NOAUTH;
    } 
    if (!pnModAPILoad('EZComments', 'admin')) {
        return _EZCOMMENTS_LOADFAILED;
    } 

    // build a simple array of all available modules
    $mods = pnModGetAllMods();
    $allmods = array();
    foreach ($mods as $mod) {
        $allmods[] = $mod['name'];
    } 

    $usedmods = pnModAPIFunc('EZComments', 'admin', 'getUsedModules');

    $orphanedmods = array_diff($usedmods, $allmods);

    if (!$orphanedmods) {
        pnSessionSetVar('statusmsg', _EZCOMMENTS_CLEANUP_NOTHINGTODO);
        return pnRedirect(pnModURL('EZComments', 'admin', 'main'));
    } 

    $selectitems = array();
    foreach ($orphanedmods as $mod) {
        $selectitems[$mod] = $mod;
    }

    $pnRender =& new pnRender('EZComments');
    $pnRender->assign('selectitems', $selectitems);

    return $pnRender->fetch('ezcomments_admin_cleanup.htm');
} 


/**
 * Do the migration
 * 
 * This is the function that is called to do the actual
 * deletion of orphaned comments.
 * 
 * @param  $EZComments_module The Module to delete for
 */
function EZComments_admin_cleanup_go()
{ 
    // Permissions
    if (!pnSecAuthAction(0, 'EZComments::', '::', ACCESS_ADMIN)) {
        return _EZCOMMENTS_NOAUTH;
    } 
    // Authentication key
    if (!pnSecConfirmAuthKey()) {
        // return _EZCOMMENTS_NOAUTH;
    } 
    // API
    if (!pnModAPILoad('EZComments', 'admin')) {
        return _EZCOMMENTS_LOADFAILED;
    } 

    $module = pnVarCleanFromInput('EZComments_module');
    if (!isset($module)) {
        return _EZCOMMENTS_MODSARGSERROR;
    } 

    if (!pnModAPIFunc('EZComments', 'admin', 'deleteall', compact('module'))) {
        return _EZCOMMENTS_GENERALFAILIURE;
    } 

    return pnRedirect(pnModURL('EZComments', 'admin', 'cleanup'));
} 

/**
 * purge comments
 *
 * @author       The PostNuke Development Team
 * @param        confirmation  confirmation that this item can be deleted
 * @param        redirect      the location to redirect to after the deletion attempt
 * @return       bool          true on sucess, false on failure
 */
function EZComments_admin_purge($args)
{
    // Get parameters from whatever input we need. 
    list($purgepending,
         $purgerejected,
         $confirmation) = pnVarCleanFromInput('purgepending',
                                               'purgerejected',
                                              'confirmation');

    // extract any input passed directly to the function
    extract($args);

    // Security check
    if (!pnSecAuthAction(0, 'EZComments::', "::", ACCESS_DELETE)) {
        return pnVarPrepHTMLDisplay(_MODULENOAUTH);
    }

    // Check for confirmation.
    if (empty($confirmation)) {
        // No confirmation yet - display a suitable form to obtain confirmation
        // of this action from the user

        // Create output object - this object will store all of our output so that
        // we can return it easily when required
        $pnRender =& new pnRender('EZComments');

        // As Admin output changes often, we do not want caching.
        $pnRender->caching = false;

        // Add a hidden field for the item ID to the output
        $pnRender->assign('redirect', $redirect);

        // Return the output that has been generated by this function
        return $pnRender->fetch('ezcomments_admin_purge.htm');
    }

    // If we get here it means that the user has confirmed the action
    // Confirm authorisation code.
    if (!pnSecConfirmAuthKey()) {
        pnSessionSetVar('errormsg', pnVarPrepHTMLDisplay(_BADAUTHKEY));
        return pnRedirect(pnModURL('EZComments', 'admin', 'main'));
    }

    // The API function is called. 
    if (pnModAPIFunc('EZComments', 'admin', 'purge', 
        array('purgepending' => $purgepending, 'purgerejected' => $purgerejected))) {
        // Success
        pnSessionSetVar('statusmsg', pnVarPrepHTMLDisplay(_DELETESUCCEDED));
    }

    // This function generated no output, and so now it is complete we redirect
    // the user to an appropriate page for them to carry on their work
    return pnRedirect(pnModURL('EZComments', 'admin', 'main'));
}

/**
 * display commenting stats
 *
 * @author Mark West
 * @return string html output
 */
function EZComments_admin_stats($args)
{
	// security check
    if (!pnSecAuthAction(0, 'EZComments::', '::', ACCESS_ADMIN)) {
        return _EZCOMMENTS_NOAUTH;
    } 

    // Create output object
    $pnRender =& new pnRender('EZComments');

    // As admin output changes often, we do not want caching.
    $pnRender->caching = false;

    // assign the module vars
    $pnRender->assign(pnModGetVar('EZComments'));

	// get a list of the hooked modules
	$hookedmodules = pnModAPIFunc('Modules', 'admin', 'gethookedmodules', array('hookmodname'=> 'EZComments'));

	// get a list of comment stats by module
	$commentstats = array();
	foreach ($hookedmodules as $mod => $hooktype) {
		$commentstat = array();
		$modinfo = pnModGetInfo(pnModGetIDFromName($mod));
		$commentstat = $modinfo;
		$commentstat['modid'] = pnModGetIDFromName($mod);
		$commentstat['approvedcomments'] = pnModAPIFunc('EZComments', 'user', 'countitems', array('status' => 0, 'mod' => $modinfo['name']));
		$commentstat['pendingcomments'] = pnModAPIFunc('EZComments', 'user', 'countitems', array('status' => 1, 'mod' => $modinfo['name']));
		$commentstat['rejectedcomments'] = pnModAPIFunc('EZComments', 'user', 'countitems', array('status' => 2, 'mod' => $modinfo['name']));
		$commentstat['totalcomments'] = $commentstat['approvedcomments'] + $commentstat['pendingcomments'] + $commentstat['rejectedcomments'];
		$commentstats[] = $commentstat;
	}
	$pnRender->assign('commentstats', $commentstats);

    // Return the output
    return $pnRender->fetch('ezcomments_admin_stats.htm');

}

/**
 * display all comments for a module
 *
 * @author Mark West
 * @return string html output
 */
function EZComments_admin_modulestats()
{
	// security check
    if (!pnSecAuthAction(0, 'EZComments::', '::', ACCESS_ADMIN)) {
        return _EZCOMMENTS_NOAUTH;
    } 

	// get our input
	$mod = pnVarCleanFromInput('mod');

    // Create output object
    $pnRender =& new pnRender('EZComments');

    // As admin output changes often, we do not want caching.
    $pnRender->caching = false;

    // assign the module vars
    $pnRender->assign(pnModGetVar('EZComments'));

	// get a list of comments
	$modulecomments = pnModAPIFunc('EZComments', 'user', 'getallbymodule', array('mod' => $mod));

	// assign the module info
	$modid = pnModGetIDFromName($mod);
	$pnRender->assign('modid', $modid);
	$pnRender->assign(pnModGetInfo($modid));

	// get a list of comment stats by module
	$commentstats = array();
	foreach ($modulecomments as $modulecomment) {
		$commentstat = $modulecomment;
		$commentstat['approvedcomments'] = pnModAPIFunc('EZComments', 'user', 'countitems', array('status' => 0, 'mod' => $mod, 'objectid' => $modulecomment['objectid']));
		$commentstat['pendingcomments'] = pnModAPIFunc('EZComments', 'user', 'countitems', array('status' => 1, 'mod' => $mod, 'objectid' => $modulecomment['objectid']));
		$commentstat['rejectedcomments'] = pnModAPIFunc('EZComments', 'user', 'countitems', array('status' => 2, 'mod' => $mod, 'objectid' => $modulecomment['objectid']));
		$commentstat['totalcomments'] = $modulecomment['count'];
		$commentstats[] = $commentstat;
	}
	$pnRender->assign('commentstats', $commentstats);

    // Return the output
    return $pnRender->fetch('ezcomments_admin_modulestats.htm');
}

/**
 * delete all comments attached to a module
 *
 * @author       Mark West
 * @param        modname       the name of the module to delete all comments for
 * @param        confirmation  confirmation that this item can be deleted
 * @return       bool          true on sucess, false on failure
 */
function EZComments_admin_deletemodule($args)
{
    // Get parameters from whatever input we need. 
    list($modid,
         $confirmation) = pnVarCleanFromInput('modid',
                                              'confirmation');

    // extract any input passed directly to the function
    extract($args);

    // Security check
    if (!pnSecAuthAction(0, 'EZComments::', "$mod::", ACCESS_DELETE)) {
        return pnVarPrepHTMLDisplay(_MODULENOAUTH);
    }

	// get our module info
	if (!empty($modid)) {
		$modinfo =  pnModGetInfo($modid);
	}

    // Check for confirmation.
    if (empty($confirmation)) {
        // No confirmation yet - display a suitable form to obtain confirmation
        // of this action from the user

        // Create output object - this object will store all of our output so that
        // we can return it easily when required
        $pnRender =& new pnRender('EZComments');

        // As Admin output changes often, we do not want caching.
        $pnRender->caching = false;

        // Add a hidden field for the item ID to the output
        $pnRender->assign('modid', $modid);
		$pnRender->assign($modinfo);

        // Return the output that has been generated by this function
        return $pnRender->fetch('ezcomments_admin_deletemodule.htm');
    }

    // If we get here it means that the user has confirmed the action
    // Confirm authorisation code.
    if (!pnSecConfirmAuthKey()) {
        pnSessionSetVar('errormsg', pnVarPrepHTMLDisplay(_BADAUTHKEY));
        return pnRedirect(pnModURL('EZComments', 'admin', 'main'));
    }

    // The API function is called. 
	// note: the api call is a little different here since we'll really calling a hook function that will 
	// normally be executed when a module is deleted. The extra nesting of the modname inside an extrainfo
	// array reflects this
    if (pnModAPIFunc('EZComments', 'admin', 'deletemodule', array('extrainfo' => array('module' => $modinfo['name'])))) {
        // Success
        pnSessionSetVar('statusmsg', pnVarPrepHTMLDisplay(_DELETESUCCEDED));
    }

    // This function generated no output, and so now it is complete we redirect
    // the user to an appropriate page for them to carry on their work
    return pnRedirect(pnModURL('EZComments', 'admin', 'main'));
}

/**
 * delete all comments attached to a module
 *
 * @author       Mark West
 * @param        modname       the name of the module to delete all comments for
 * @param        confirmation  confirmation that this item can be deleted
 * @return       bool          true on sucess, false on failure
 */
function EZComments_admin_deleteitem($args)
{
    // Get parameters from whatever input we need. 
    list($mod,
		 $objectid,
         $confirmation) = pnVarCleanFromInput('mod',
											  'objectid',
                                              'confirmation');

    // extract any input passed directly to the function
    extract($args);

	// input check
	if (!isset($mod) || !is_string($mod) || !isset($objectid) || !is_numeric($objectid)) {
		pnSessionSetVar('errormsg', _MODARGSERROR);
		return pnRedirect(pnModURL('EZComments', 'admin', 'main'));
	}

    // Security check
    if (!pnSecAuthAction(0, 'EZComments::', "$mod:$objectid:", ACCESS_DELETE)) {
        return pnVarPrepHTMLDisplay(_MODULENOAUTH);
    }

	// get our module info
	if (!empty($mod)) {
		$modinfo =  pnModGetInfo(pnModGetIDFromName($mod));
	}

    // Check for confirmation.
    if (empty($confirmation)) {
        // No confirmation yet - display a suitable form to obtain confirmation
        // of this action from the user

        // Create output object - this object will store all of our output so that
        // we can return it easily when required
        $pnRender =& new pnRender('EZComments');

        // As Admin output changes often, we do not want caching.
        $pnRender->caching = false;

        // Add a hidden field for the item ID to the output
        $pnRender->assign('objectid', $objectid);
		$pnRender->assign($modinfo);

        // Return the output that has been generated by this function
        return $pnRender->fetch('ezcomments_admin_deleteitem.htm');
    }

    // If we get here it means that the user has confirmed the action
    // Confirm authorisation code.
    if (!pnSecConfirmAuthKey()) {
        pnSessionSetVar('errormsg', pnVarPrepHTMLDisplay(_BADAUTHKEY));
        return pnRedirect(pnModURL('EZComments', 'admin', 'main'));
    }

    // The API function is called. 
	// note: the api call is a little different here since we'll really calling a hook function that will 
	// normally be executed when a module is deleted. The extra nesting of the modname inside an extrainfo
	// array reflects this
    if (pnModAPIFunc('EZComments', 'admin', 'deletebyitem', array('mod' => $modinfo['name'], 'objectid' => $objectid))) {
        // Success
        pnSessionSetVar('statusmsg', pnVarPrepHTMLDisplay(_DELETESUCCEDED));
    }

    // This function generated no output, and so now it is complete we redirect
    // the user to an appropriate page for them to carry on their work
    return pnRedirect(pnModURL('EZComments', 'admin', 'main'));
}

?>