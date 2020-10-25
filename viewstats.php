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
global $xoopsUser;
global $xoopsModule;
global $idfield;
global $pageencours;
global $style;
global $echelle;

if (!$style) {
    $style = 'list';
}
$myts = MyTextSanitizer::getInstance();
require_once XOOPS_ROOT_PATH . '/modules/userinfo/cache/config.php';
global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsModule;

if ('userinfo' == $xoopsConfig['startpage']) {
    $xoopsOption['show_rblock'] = 1;

    require XOOPS_ROOT_PATH . '/header.php';

    make_cblock();
} else {
    $xoopsOption['show_rblock'] = 0;

    require XOOPS_ROOT_PATH . '/header.php';
}

if ('true' == $userinfo_cfg['formactiv']) {
    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_form') . ' WHERE idfield = ' . $idfield;

    $resultfield = $xoopsDB->query($sql);

    $seefield = $xoopsDB->fetchArray($resultfield);

    echo '<center><h3>' . _MA_USERINFO_TITLESTATS . '</h3><br><h4>' . $seefield[fieldname] . '</h4></center>';

    echo "<table border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"bg2\">\n";

    echo '<tr><td>';

    echo "<table border=\"0\" align=\"center\" cellpadding=\"4\" cellspacing=\"1\" width=\"100%\">\n";

    $sql = 'SELECT uid FROM ' . $xoopsDB->prefix('userinfo_user') . ' WHERE idfield = ' . $idfield;

    $resultusers = $xoopsDB->query($sql);

    $nbrrep = $xoopsDB->getRowsNum($resultusers);

    $sql = 'SELECT uid FROM ' . $xoopsDB->prefix('users') . " WHERE user_regdate != ''";

    $resultuid = $xoopsDB->query($sql);

    $nbruseractiv = $xoopsDB->getRowsNum($resultuid);

    $nombredepage = ceil($nbrrep / $userinfo_cfg['nbrowbypage']);

    $percentofrespond = number_format((($nbrrep / $nbruseractiv) * 100), 2);

    echo '<tr class="bg2" colspan="2"><td>';

    echo _MA_USERINFO_NBRREP . '</td><td align="center">' . $nbrrep . '/' . $nbruseractiv . ' (' . $percentofrespond . '%)</td></tr>';

    switch ($seefield[fieldtype]) {
        case 1:
        case 2:
        case 3:
            $sql = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_val') . ' WHERE idval = ' . $seefield[idval] . ' AND numval != - 1';
            $resultval = $xoopsDB->query($sql);
            while (false !== ($seeval = $xoopsDB->fetchArray($resultval))) {
                $sql = 'SELECT uid FROM ' . $xoopsDB->prefix('userinfo_user') . ' WHERE idfield = ' . $seefield[idfield] . ' AND valeur = ' . $seeval[numval];

                $resultuser = $xoopsDB->query($sql);

                $nbrresult = $xoopsDB->getRowsNum($resultuser);

                $percentofvalue = number_format((($nbrresult / $nbrrep) * 100), 2);

                if (-1 == $seeval[numval]) {
                    $valname = _MB_USERINFO_EMPTY;
                } else {
                    $valname = $seeval[valeur];
                }

                echo "<tr class=\"bg3\">\n<td>" . $valname . ' (' . $nbrresult . ' - ' . $percentofvalue . '%)</td>';

                echo '<td colspan="2" width="200"><img src="' . $xoopsConfig['xoops_url'] . '/modules/userinfo/images/' . $userinfo_cfg['barcolor'] . '.gif' . '" width="' . ($percentofvalue * 2) . '" height="10"> </td>';

                echo "</tr>\n";
            }
            break;
        case 4:
        case 5:
            if ('list' == $style) {
                $sql = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_val') . ' WHERE idval = ' . $seefield[idval] . ' AND numval != - 1';

                $resultval = $xoopsDB->query($sql);

                $seeval = $xoopsDB->fetchArray($resultval);

                if (!$pageencours) {
                    $pageencours = 1;
                }

                $sql = 'SELECT '
                       . $xoopsDB->prefix('userinfo_user')
                       . '.uid, '
                       . $xoopsDB->prefix('userinfo_user')
                       . '.valeurtexte, '
                       . $xoopsDB->prefix('users')
                       . '.uname'
                       . ' FROM '
                       . $xoopsDB->prefix('userinfo_user')
                       . ', '
                       . $xoopsDB->prefix('users')
                       . ' WHERE '
                       . $xoopsDB->prefix(
                           'userinfo_user'
                       )
                       . '.idfield = '
                       . $seefield[idfield]
                       . ' AND '
                       . $xoopsDB->prefix('userinfo_user')
                       . '.uid = '
                       . $xoopsDB->prefix('users')
                       . '.uid'
                       . ' ORDER BY '
                       . $xoopsDB->prefix('userinfo_user')
                       . '.valeurtexte '
                       . ' LIMIT '
                       . (($pageencours - 1) * $userinfo_cfg['nbrowbypage'])
                       . ', '
                       . $userinfo_cfg['nbrowbypage'];

                $resultuser = $xoopsDB->query($sql);

                $fondcellule = 0;

                while (false !== ($seeuserval = $xoopsDB->fetchArray($resultuser))) {
                    if (0 == $fondcellule) {
                        echo "<tr class=\"bg1\">\n";

                        $fondcellule = 1;
                    } else {
                        echo "<tr class=\"bg3\">\n";

                        $fondcellule = 0;
                    }

                    echo '<td>' . $myts->displayTarea($seeuserval[valeurtexte]) . '</td><td>' . $seeuserval[uname] . "</td></tr>\n";
                }

                if ($nombredepage > 1) {
                    echo "<tr>\n<td colspan=\"2\" align=\"right\">";

                    echo _MA_USERINFO_PAGE;

                    for ($boucle = 1; $boucle <= $nombredepage; $boucle++) {
                        if ($pageencours == $boucle) {
                            echo ' «' . $boucle . '» ';
                        } else {
                            echo '<a href="./viewstats.php?idfield=' . $idfield . '&pageencours=' . $boucle . '">' . $boucle . '</a> ';
                        }
                    }

                    echo "</td></tr>\n";
                }

                echo "<tr class=\"bg1\">\n<td colspan=\"2\" align=\"center\">";

                echo '<a href="./viewstats.php?idfield=' . $idfield . '&style=num">' . _MA_USERINFO_NUMERICVALUES . "</a></td></tr>\n";
            } else {
                // Affichage en mode numérique

                $sql = 'SELECT sum(valeurtexte), count(valeurtexte), valeurtexte FROM ' . $xoopsDB->prefix('userinfo_user') . ' WHERE idfield = ' . $seefield[idfield] . ' GROUP BY valeurtexte ORDER BY valeurtexte';

                $resultuser = $xoopsDB->query($sql);

                if (!$echelle) {
                    $echelle = 1;
                }

                while (false !== ($seeuserval = $xoopsDB->fetchRow($resultuser))) {
                    if ($seeuserval[0] > 0) {
                        echo "<tr class=\"bg3\">\n<td>" . $seeuserval[2] . '( ' . $seeuserval[1] . ' )</td>';

                        echo '<td colspan="2" width="200"><img src="' . $xoopsConfig['xoops_url'] . '/modules/userinfo/images/' . $userinfo_cfg['barcolor'] . '.gif' . '" width="' . ($seeuserval[1] * $echelle) . '" height="10"> </td>';

                        echo "</tr>\n";
                    }
                }

                echo "<tr class=\"bg1\">\n<td colspan=\"3\">" . _MA_USERINFO_ECHELLE . '  » ';

                if (.001 != $echelle) {
                    echo '<a href="./viewstats.php?idfield=' . $idfield . '&style=num&echelle=.001">.001</a> ';
                } else {
                    echo '«.001»';
                }

                if (.01 != $echelle) {
                    echo '| <a href="./viewstats.php?idfield=' . $idfield . '&style=num&echelle=.01">.01</a> ';
                } else {
                    echo '| «.01»';
                }

                if (.1 != $echelle) {
                    echo '| <a href="./viewstats.php?idfield=' . $idfield . '&style=num&echelle=.1">.1</a> ';
                } else {
                    echo '| «.1»';
                }

                if (1 != $echelle) {
                    echo '| <a href="./viewstats.php?idfield=' . $idfield . '&style=num&echelle=1">1</a> ';
                } else {
                    echo '| «1»';
                }

                if (10 != $echelle) {
                    echo '| <a href="./viewstats.php?idfield=' . $idfield . '&style=num&echelle=10">10</a> ';
                } else {
                    echo '| «10»';
                }

                if (100 != $echelle) {
                    echo '| <a href="./viewstats.php?idfield=' . $idfield . '&style=num&echelle=100">100</a> ';
                } else {
                    echo '| «100»';
                }

                if (1000 != $echelle) {
                    echo '| <a href="./viewstats.php?idfield=' . $idfield . '&style=num&echelle=1000">1000</a> ';
                } else {
                    echo '| «1000»';
                }

                echo '</td></tr>';

                echo "<tr class=\"bg1\">\n<td colspan=\"3\" align=\"center\">";

                echo '<a href="./viewstats.php?idfield=' . $idfield . '&style=list">' . _MA_USERINFO_TEXTVALUES . "</a></td></tr>\n";
            }
            break;
    }

    echo "</table>\n</td></tr>\n</table>";
} else {
    echo '<center><p class="bg2">' . _MA_USERINFO_FORMNOTACTIV . '</p></center><br><HR><br>' . $myts->displayTarea($userinfo_cfg['forminactivinfo'] . '<HR>');
}

require XOOPS_ROOT_PATH . '/footer.php';
