<?php
/**
 * EZComments
 *
 * @copyright (C) EZComments Development Team
 * @link http://code.zikula.org/ezcomments
 * @version $Id$
 * @license See license.txt
 */

class EZComments_Api_Admin extends Zikula_Api
{
    /**
     * get Used Modules
     *
     * This function returns an array of the modules
     * for which a comment is available. This is used
     * for the "clean-up" feature that eliminates
     * orphaned comments after a module is deletd.
     *
     * @return list of all modules used
     */
    public function getUsedModules()
    {
        if (!SecurityUtil::checkPermission('EZComments::', '::', ACCESS_ADMIN)) {
            return LogUtil::registerPermissionError(ModUtil::url('EZComments', 'admin', 'main'));
        }

        $tables = DBUtil::getTables();

        $table  = $tables['EZComments'];
        $column = $tables['EZComments_column'];

        // TODO Port to DBUtil
        $sql = "SELECT    $column[modname]
                FROM      $table
                GROUP BY  $column[modname]";

        $result = DBUtil::executeSQL($sql);

        if ($result == false) {
            return false;
        }

        return DBUtil::marshallFieldArray($result);
    }

    /**
     * Delete all comments for a given module
     *
     * Used to clean up orphaned comments.
     *
     * @param $args[module] the module for which to delete for
     * @return boolean sucess status
     */
    public function deleteall($args)
    {
        // Security and argument check
        if (!SecurityUtil::checkPermission('EZComments::', '::', ACCESS_ADMIN)) {
            return LogUtil::registerPermissionError(ModUtil::url('EZComments', 'admin', 'main'));
        }

        if (!isset($args['module'])) {
            return false;
        }

        // get tables
        $tables  = DBUtil::getTables();
        $column  = $tables['EZComments_column'];
        // construct where clause and delete...
        $where   = "WHERE $column[modname] = '$args[module]'";

        return DBUtil::deleteWhere('EZComments',$where);
    }

    /**
     * Delete all comments for a given item
     * 
     * Used to clean up orphaned comments.
     *
     * @author Timo (Numerobis)
     * @since  0.3
     * @param  $args['mod']             string    the module for which to delete for
     * @param  $args['objectid']     int        the module for which to delete for
     * @return boolean sucess status
     */
    public function deletebyitem($args)
    {
        if (!isset($args['objectid'])) {
            return false;
        }

        if ($args['objectid'] <= 0) {
            return false;
        }

        $args['mod'] = isset($args['mod']) ? $args['mod'] : ModUtil::getName();

        // Security check
        $res = ModUtil::apiFunc('EZComments', 'user', 'checkPermission',
                            array('module'   => $args['mod'],
                                  'objectid' => $args['objectid'],
                                  'level'    => ACCESS_DELETE));

        if (!$res) {
            return LogUtil::registerPermissionError(ModUtil::url('EZComments', 'admin', 'main'));
        }

        // get db table and column for where statement
        $tables  = DBUtil::getTables();
        $column  = $tables['EZComments_column'];

        $mod      = DataUtil::formatForStore($args['mod']);
        $objectid = DataUtil::formatForStore($args['objectid']);
        $where    = "$column[modname] = '$mod' AND $column[objectid] = '$objectid'";

        $args['extrainfo']['EZComments'] = DBUtil::deleteWhere('EZComments', $where);
        return $args['extrainfo'];
    }

    /**
     * Delete an item
     *
     * @param  $args['id']  ID of the item
     * @return bool true on success, false on failure
     */
    public function delete($args)
    {
        // Argument check
        if (!isset($args['id']) || !is_numeric($args['id'])) {
            return LogUtil::registerArgsError();
        }

        // The user API function is called.
        $item = ModUtil::apiFunc('EZComments', 'user', 'get', array('id' => $args['id']));

        if (!$item) {
            return LogUtil::registerError($this->__('No such item found.'));
        }

        // Security check
        $securityCheck = ModUtil::apiFunc('EZComments', 'user', 'checkPermission',
                                      array('module'    => '',
                                            'objectid'  => '',
                                            'commentid' => $args['id'],
                                            'level'     => ACCESS_DELETE));
        if (!$securityCheck) {
            return LogUtil::registerPermissionError(ModUtil::url('EZComments', 'admin', 'main'));
        }

        // Check for an error with the database code
        if (!DBUtil::deleteObjectByID('EZComments', (int)$args['id'])) {
            return LogUtil::registerError($this->__('Error! Deletion attempt failed.'));
        }

        // Let any hooks know that we have deleted an item.
        ModUtil::callHooks('item', 'delete', $args['id'], array('module' => 'EZComments'));

        // Let the calling process know that we have finished successfully
        return true;
    }

    /**
     * Update an item
     *
     * @param    $args['id'] the ID of the item
     * @param    $args['subject']  the new subject of the item
     * @param    $args['comment'] the new text of the item
     * @return   bool true on success, false on failure
     */
    public function update($args)
    {
        // Argument check
        if ((!isset($args['subject'])) ||
            (!isset($args['comment'])) ||
            (isset($args['id']) && !is_numeric($args['id'])) ||
            (isset($args['status']) && !is_numeric($args['status']))) {
            return LogUtil::registerArgsError();
        }

        // optional arguments
        if (!isset($args['anonname']))    $args['anonname'] = '';
        if (!isset($args['anonmail']))    $args['anonmail'] = '';
        if (!isset($args['anonwebsite'])) $args['anonwebsite'] = '';

        // Get the item
        $item = ModUtil::apiFunc('EZComments', 'user', 'get', array('id' => $args['id']));

        if (!$item) {
            return LogUtil::registerError($this->__('No such comment found.'));
        }

        // Security check.
        $securityCheck = ModUtil::apiFunc('EZComments', 'user', 'checkPermission',
                                      array('module'    => '',
                                            'objectid'  => '',
                                            'commentid' => (int)$args['id'],
                                            'level'     => ACCESS_EDIT));

        if (!$securityCheck) {
            return LogUtil::registerPermissionError(ModUtil::url('EZComments', 'admin', 'main'));
        }

        // Check for an error with the database code, and if so set an
        // appropriate error message and return
        if (!DBUtil::updateObject($args, 'EZComments')) {
            return LogUtil::registerError($this->__('Error! Update attempt failed.'));
        }

        // Let any hooks know that we have updated an item.
        ModUtil::callHooks('item', 'update', $args['id'], array('module' => 'EZComments'));

        // Let the calling process know that we have finished successfully
        return true;
    }

    /**
     * Clean up comments for a removed module
     *
     * @param $args['extrainfo']   array extrainfo array
     * @return array extrainfo array
     */
    public function deletemodule($args)
    {
        // optional arguments
        if (!isset($args['extrainfo'])) {
            $args['extrainfo'] = array();
        }

        // When called via hooks, the module name may be empty, so we get it from
        // the current module
        $mod = (isset($args['extrainfo']['module']) && !empty($args['extrainfo']['module'])) ? $args['extrainfo']['module'] : ModUtil::getName();

        // Database information
        $tables  = DBUtil::getTables();
        $columns = $tables['EZComments_column'];

        // Get items
        $where = "WHERE $columns[modname] = '" . DataUtil::formatForStore($mod) . "'";

        $args['extrainfo']['EZComments'] = DBUtil::deleteWhere('EZComments', $where);
        return $args['extrainfo'];
    }

    /**
     * Delete an item
     *
     * @param $args['purgerejected'] Purge all rejected comments
     * @param $args['purgepending']  Purge all pending comments
     * @return bool true on success, false on failure
     */
    public function purge($args)
    {
        // Get arguments from argument array
        extract($args);

        // Argument check
        if (!isset($purgerejected) && !isset($purgepending)) {
            return LogUtil::registerArgsError();
        }

        // Security check
        if (!SecurityUtil::checkPermission('EZComments::', "::", ACCESS_DELETE)) {
            return LogUtil::registerPermissionError(ModUtil::url('EZComments', 'admin', 'main'));
        }

        // Get datbase setup
        $tables  = DBUtil::getTables();
        $column  = $tables['EZComments_column'];

        if ((bool)$purgerejected) {
            $where = "WHERE $column[status] = '2'";
            if (!DBUtil::deleteWhere('EZComments', $where)) {
                return LogUtil::registerError($this->__('Error! Deletion attempt failed.'));
            }
        }

        if ((bool)$purgepending) {
            $where = "WHERE $column[status] = '1'";
            if (!DBUtil::deleteWhere('EZComments', $where)) {
                return LogUtil::registerError($this->__('Error! Deletion attempt failed.'));
            }
        }

        // Let the calling process know that we have finished successfully
        return true;
    }

    /**
     * Update an item status
     *
     * @param $args['id'] the ID of the item
     * @param $args['status']  the new status of the item
     * @return bool true on success, false on failure
     */
    public function updatestatus($args)
    {
        // get arguments
        $id      = $args['id'];
        $status  = $args['status'];

        // Argument check
        if (isset($id) && !is_numeric($id) && isset($status) && !is_numeric($status)) {
            return LogUtil::registerArgsError();
        }

        // Get the comment
        $item = ModUtil::apiFunc('EZComments', 'user', 'get', array('id' => $id));

        if (!$item) {
            return LogUtil::registerError($this->__('No such item found.'));
        }

        // Security check.
        $securityCheck = ModUtil::apiFunc('EZComments', 'user', 'checkPermission',
                                      array('module'    => '',
                                            'objectid'  => '',
                                            'commentid' => $id,
                                            'level'     => ACCESS_EDIT));

        if (!$securityCheck) {
            return LogUtil::registerPermissionError(ModUtil::url('EZComments', 'admin', 'main'));
        }

        // Update item and store item
        $item['status'] = $args['status'];
        if (DBUtil::updateObject($item, 'EZComments')) {
            // Let any hooks know that we have updated an item.
            ModUtil::callHooks('item', 'update', $id, array('module' => 'EZComments'));
            return true;
        }

        return false;
    }

    /**
     * Count items
     *
     * maintained for backwards compatability
     * simply passes parameters onto the user api
     */
    public function countitems($args)
    {
        return ModUtil::apiFunc('EZComments', 'user', 'countitems', $args);
    }

    /**
     * Get available admin panel links
     *
     * @author Mark West
     * @return array array of admin links
     */
    public function getlinks()
    {
        $links = array();

        if (SecurityUtil::checkPermission('EZComments::', '::', ACCESS_ADMIN)) {
            $links[] = array('url' => ModUtil::url('EZComments', 'admin'),                 'text' => $this->__('View comments'));
            $links[] = array('url' => ModUtil::url('EZComments', 'admin', 'cleanup'),      'text' => $this->__('Delete orphaned comments'));
            $links[] = array('url' => ModUtil::url('EZComments', 'admin', 'migrate'),      'text' => $this->__('Migrate comments'));
            $links[] = array('url' => ModUtil::url('EZComments', 'admin', 'purge'),        'text' => $this->__('Purge comments'), 'linebreak' => true);
            $links[] = array('url' => ModUtil::url('EZComments', 'admin', 'stats'),        'text' => $this->__('Comment statistics'));
            $links[] = array('url' => ModUtil::url('EZComments', 'admin', 'applyrules'),   'text' => $this->__('Re-apply moderation rules'));
            $links[] = array('url' => ModUtil::url('EZComments', 'admin', 'modifyconfig'), 'text' => $this->__('Settings'));
        }

        return $links;
    }
}
