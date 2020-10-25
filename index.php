<?php
// ------------------------------------------------------------------------- //
// userinfo module for Xoops : Userinfo for Xoops							 //
// Original Author: Alfy													 //
// Author Website : http://www.m-u-g.net									 //
// ------------------------------------------------------------------------- //
// --- Affichage du formulaire en mode lecture ou en mode modification ----- //
// ------------------------------------------------------------------------- //
include 'header.php';
global $_POST;
global $modificationform;
global $users;
global $xoopsUser;
global $xoopsModule;

$myts = MyTextSanitizer::getInstance();
require_once XOOPS_ROOT_PATH . '/modules/userinfo/cache/config.php';
global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsModule;

if ($xoopsConfig['startpage'] == 'userinfo') {
    $xoopsOption['show_rblock'] = 1;
    require XOOPS_ROOT_PATH . '/header.php';
    make_cblock();
} else {
    $xoopsOption['show_rblock'] = 0;
    require XOOPS_ROOT_PATH . '/header.php';
}

if ($userinfo_cfg['formactiv'] == 'true') {
    if (!$users) {
        if (!$xoopsUser) {
            echo '<center><b>' . _MA_USERINFO_USERNOTIDENTIFIED . '</b></center>';
            require XOOPS_ROOT_PATH . '/footer.php';
            exit;
        } else {
            $curuserid   = $xoopsUser->uid();
            $curusername = $xoopsUser->uname();
        }
    } else {
        $curuserid   = $users;
        $sql         = 'SELECT uname FROM ' . $xoopsDB->prefix('users') . ' WHERE uid=' . $users;
        $result      = $xoopsDB->query($sql);
        $myrow       = $xoopsDB->fetchArray($result);
        $curusername = $myrow['uname'];
    }

    ?>
    <script language="JavaScript">
        function valider() {
            document.formulaire.validform.value =<?php echo "'" . _MA_USERINFO_WAIT . "'"; ?>;
            document.formulaire.validform.disabled = 'true';
            document.formulaire.submit();
        }
    </script>

    <table border="0" align="center">
        <tr class='bg1'>
            <td colspan="4">
                <hr align="center" noshade="noshade">
                <div align="center">
                    <b><?php echo _MA_USERINFO_FORMTITLE . $curusername; ?></b><br>
                    <b><?php echo $myts->displayTarea($userinfo_cfg['formtitle']); ?></b></div>
                <hr align="center" noshade="noshade">
                <?php if ($modificationform === true) {
                    echo '<form action="saveform.php" method="post" name="formulaire">';
                    echo '<input type="hidden" name="uid" value="' . $curuserid . '">';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <?php
                include 'formbody.php';
                ?>
            </td>
        </tr>
        <tr>
            <td align="center">
                <?php
                if ($modificationform === false) {
                    if (!$users) {
                        echo '<form action="./index.php?modificationform=true" method="post"><input type="submit" value="' . _MA_USERINFO_FORMMODIFTITLE . '">';
                    }
                } else {
                    echo '<input name="validform" type="button" value="' . _MA_USERINFO_FORMVALIDATE . '" onclick="valider();">';
                }
                ?>
                </form>
            </td>
        </tr>
    </table>
    <?php
} else {
    echo '<center><p class="bg2">' . _MA_USERINFO_FORMNOTACTIV . '</p></center><br><HR><br>' . $myts->displayTarea($userinfo_cfg['forminactivinfo'] . '<HR>');
}

require XOOPS_ROOT_PATH . '/footer.php';
?>
