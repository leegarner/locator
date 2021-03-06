<?php
/**
 *  Common AJAX functions
 *  @author     Lee Garner <lee@leegarner.com>
 *  @copyright  Copyright (c) 2009 Lee Garner <lee@leegarner.com>
 *  @package    locator
 *  @version    1.0.1
 *  @license    http://opensource.org/licenses/gpl-2.0.php 
 *              GNU Public License v2 or later
 *  @filesource
 */

/**
 *  Include required glFusion common functions
 */
require_once '../../../lib-common.php';

// This is for administrators only
if (!SEC_hasRights('locator.admin')) {
    $display .= COM_siteHeader('menu', $MESSAGE[30])
             . COM_showMessageText($MESSAGE[34], $MESSAGE[30])
             . COM_siteFooter();
    COM_accessLog("User {$_USER['username']} tried to illegally access the locator administration screen.");
    echo $display;
    exit;
}

switch ($_POST['action']) {
case 'toggle':
    switch ($_POST['type']) {
    case 'is_origin':
    case 'enabled':
        $newval = Locator\Marker::Toggle($_POST['id'], $_POST['type'], $_POST['oldval']);
        break;

     default:
        exit;
    }

    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-cache, must-revalidate');
    // A date in the past to disable caching
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    $values = array(
        'newval' => $newval,
        'id'    => $_POST['id'],
        'type'  => $_POST['type'],
        'statusMessage' => $LANG_GEO['loc_updated'],
    );
    echo json_encode($values);
    break;
}

?>
