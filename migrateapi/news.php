<?php
/**
 * EZComments
 *
 * @copyright (C) EZComments Development Team
 * @link http://code.zikula.org/ezcomments
 * @version $Id$
 * @license See license.txt
 */

/**
 * Do the migration
 * 
 * With this function, the actual migration is done.
 * 
 * @return   boolean   true on sucessful migration, false else
 * @since    0.2
 */
function EZComments_migrateapi_news()
{
    // Security check
    if (!SecurityUtil::checkPermission('EZComments::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerError('News migration: Not Admin');
    }

    // Get datbase setup
    $tables = DBUtil::getTables();

    $EZCommentstable  = $tables['EZComments'];
    $EZCommentscolumn = $tables['EZComments_column'];

    $Commentstable  = $tables['comments'];
    $Commentscolumn = $tables['comments_column'];

    if (version_compare(PN_VERSION_NUM, '1', '>=')) {
        EZComments_get76xcolumns_news($Commentstable, $Commentscolumn);
    }
    if (is_null($Commentstable) || is_null($Commentscolumn)) {
        return LogUtil::registerError('News migration: Comments tables not found');
    }

    $Usertable  = $tables['users'];
    $Usercolumn = $tables['users_column'];

    $sql = "SELECT $Commentscolumn[tid],
                   $Commentscolumn[sid],
                   $Commentscolumn[date], 
                   $Usercolumn[uid],
                   $Commentscolumn[comment],
                   $Commentscolumn[subject],
                   $Commentscolumn[pid]
              FROM $Commentstable
         LEFT JOIN $Usertable
                ON $Commentscolumn[name] = $Usercolumn[uname]";

    $result = DBUtil::executeSQL($sql);

    if ($result == false) {
        return LogUtil::registerError('News migration: DB Error');
    }

    // array to rebuild the patents
    $comments = array(0 => array('newid' => -1));

    // loop through the old comments and insert them one by one into the DB
    $items = DBUtil::marshalObjects($result, array('tid', 'sid', 'date', 'uid', 'comment', 'subject', 'replyto'));

    foreach ($items as $item) {
        // set the correct user id for anonymous users
        if (empty($item['uid'])) {
            $item['uid'] = 1;
        }

        $id = ModUtil::apiFunc('EZComments', 'user', 'create',
                           array('mod'      => 'News',
                                 'objectid' => DataUtil::formatForStore($item['sid']),
                                 'url'      => ModUtil::url('News', 'user', 'display', array('sid' => $item['sid'])),
                                 'comment'  => $item['comment'],
                                 'subject'  => $item['subject'],
                                 'uid'      => $item['uid'],
                                 'date'     => $item['date']));

        if (!$id) {
            return LogUtil::registerError('News migration: Error creating comment');
        }

        $comments[$item['tid']] = array('newid' => $id,
                                        'pid'   => $item['replyto']);
    }

    // rebuild the links to the parents
    $tids = array_keys($comments);
    foreach ($tids as $tid) {
        if ($tid != 0) {
            $v = $comments[$tid];
            $sql = "UPDATE $EZCommentstable
                       SET $EZCommentscolumn[replyto] = '" . $comments[$v['pid']]['newid'] . "'
                     WHERE $EZCommentscolumn[id] = '$v[newid]'";

            $result = DBUtil::executeSQL($sql);
        }
    }

    // activate the ezcomments hook for the news module
    ModUtil::apiFunc('Modules', 'admin', 'enablehooks',
                     array('callermodname' => 'News',
                           'hookmodname'   => 'EZComments'));

 	return LogUtil::registerStatus('News migration successful');
}

function EZComments_get76xcolumns_news(&$Commentstable, &$Commentscolumn)
{
    $Commentstable  = DBUtil::getLimitedTablename('comments');
    $Commentscolumn = array(
        'tid'       => 'pn_tid',
        'pid'       => 'pn_pid',
        'sid'       => 'pn_sid',
        'date'      => 'pn_date',
        'name'      => 'pn_name',
        'email'     => 'pn_email',
        'url'       => 'pn_url',
        'host_name' => 'pn_host_name',
        'subject'   => 'pn_subject',
        'comment'   => 'pn_comment',
        'score'     => 'pn_score',
        'reason'    => 'pn_reason'
    );
}
