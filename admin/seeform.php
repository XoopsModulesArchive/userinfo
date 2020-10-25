<?php
// ------------------------------------------------------------------------- //
// userinfo module for Xoops : Userinfo for Xoops							 //
// Original Author: Alfy													 //
// Author Website : http://www.m-u-g.net									 //
// ------------------------------------------------------------------------- //

global $xoopsModule;
global $xoopsDB;
require_once './admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/module.textsanitizer.php';
require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/cache/config.php';
xoops_cp_header();
OpenTable();
?>
    <table border="0" align="center">
        <tr class='bg1'>
            <td colspan="4">
                <hr align="center" noshade="noshade">
                <div align="center"><b><h4><?php echo _AM_USERINFO_FORMVIEW; ?><br>
                            <?php echo $userinfo_cfg['formtitle']; ?></h4></b></div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <?php
                $curuserid = 0;
                $modificationform = true;
                include '../formbody.php';

                ?>
            </td>
        </tr>
    </table>
<?php
CloseTable();
xoops_cp_footer()
?>
