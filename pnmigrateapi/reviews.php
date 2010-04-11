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
 * @since    0.6
 */
function EZComments_migrateapi_reviews()
{
    // Security check
    if (!SecurityUtil::checkPermission('EZComments::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerError('Reviews migration: Not Admin');
    } 

    // Get datbase setup
    pnModDBInfoLoad('Reviews', 'EZComments/pnmigrateapi/Reviews', true);
    $dbconn  = pnDBGetConn(true);
    $pntable = pnDBGetTables();

    $EZCommentstable  = $pntable['EZComments'];
    $EZCommentscolumn = &$pntable['EZComments_column']; 

    $Commentstable  = $pntable['reviews_comments'];
    $Commentscolumn = $pntable['reviews_comments_column'];

    if (version_compare(PN_VERSION_NUM, '1', '>=')) { 
        EZComments_get76xcolumns_reviews($Commentstable, $Commentscolumn); 
    } 
    if (is_null($Commentstable) || is_null($Commentscolumn)) { 
        return LogUtil::registerError('Reviews migration: Comments tables not found'); 
    } 

    $Usertable  = $pntable['users'];
    $Usercolumn = $pntable['users_column'];

    // note: there's nothing we can do with the score......
    $sql = "SELECT $Commentscolumn[cid],
                   $Commentscolumn[rid],
                   $Commentscolumn[date], 
                   $Usercolumn[uid], 
                   $Commentscolumn[comments],
                   $Commentscolumn[score]
              FROM $Commentstable
         LEFT JOIN $Usertable
                ON $Commentscolumn[userid] = $Usercolumn[uname]";

    $result = $dbconn->Execute($sql); 
    if ($dbconn->ErrorNo() != 0) {
        return LogUtil::registerError('Reviews migration: DB Error');
    }

    // loop through the old comments and insert them one by one into the DB
    for (; !$result->EOF; $result->MoveNext())
    {
        list($cid, $rid, $date, $uid, $comment, $score) = $result->fields;

        $id = pnModAPIFunc('EZComments', 'user', 'create',
                           array('mod'      => 'Reviews',
                                 'objectid' => DataUtil::formatForStore($rid),
                                 'url'      => pnModURL('Reviews', 'user', 'display', array('id' => $rid)),
                                 'comment'  => $comment,
                                 'subject'  => '',
                                 'uid'      => $uid,
                                 'date'     => $date));

        if (!$id) {
            return LogUtil::registerError('Reviews migration: Error creating comment');
        } 
    } 
    $result->Close();

    // activate the ezcomments hook for the Reviews module
    pnModAPIFunc('Modules', 'admin', 'enablehooks',
                 array('callermodname' => 'Reviews',
                       'hookmodname'   => 'EZComments'));

    return LogUtil::registerStatus('Reviews migration successful');
}

function EZComments_get76xcolumns_reviews(&$Commentstable, &$Commentscolumn)
{
    $Commentstable  = DBUtil::getLimitedTablename('reviews_comments');
    $Commentscolumn = array(
        'cid'      => 'pn_cid',
        'rid'      => 'pn_rid',
        'userid'   => 'pn_userid',
        'date'     => 'pn_date',
        'comments' => 'pn_comments',
        'score'    => 'pn_score'
    );
}
