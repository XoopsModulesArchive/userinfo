<?php
// ------------------------------------------------------------------------- //
// USERINFO module for Xoops : User profile for Xoops   					 //
// Original Author: Alfy													 //
// Author Website : http://www.m-u-g.net									 //
// ------------------------------------------------------------------------- //

function b_userinfo_show($options)
{
    $myts = MyTextSanitizer::getInstance();

    require XOOPS_ROOT_PATH . '/modules/userinfo/cache/config.php';

    global $xoopsConfig;

    global $xoopsDB;

    global $xoopsUser;

    global $xoopsModule;

    if ('true' == $userinfo_cfg['formactiv']) {
        $block['content'] .= '<table align="center" width="100%" border="0"><tr><td align="center">';

        if ($xoopsUser) {
            $block['content'] .= '<a href="' . $xoopsConfig['xoops_url'] . '/modules/userinfo/index.php">' . _MB_USERINFO_SEETHEFORM . '</a><br><br>';
        } else {
            $block['content'] .= _MB_USERINFO_SEETHEFORM . '<br><br>';
        }

        $block['content'] .= '<form name="seeform" method="post" action="' . $xoopsConfig['xoops_url'] . '/modules/userinfo/index.php">';

        $sql = 'SELECT uname, uid FROM ' . $xoopsDB->prefix('users') . ' WHERE uid <> 0 ORDER BY uname';

        $result = $xoopsDB->query($sql);

        if ($myrow = $xoopsDB->fetchArray($result)) {
            $block['content'] .= _MB_USERINFO_SEEUSERFORM . '<br><select name="users">';

            do {
                $block['content'] .= '<option value="' . $myrow['uid'] . '">' . $myrow['uname'] . "</option>\n";
            } while (false !== ($myrow = $xoopsDB->fetchArray($result)));
        }

        $block['content'] .= '</select><br><br><center><input type="submit" value="' . _MB_USERINFO_SEE . '"></center></form>';

        $block['content'] .= '<form name="viewstats" method="post" action="' . $xoopsConfig['xoops_url'] . '/modules/userinfo/viewstats.php">' . _MB_USERINFO_SEESTATS . '<br>';

        $sql = 'SELECT '
                  . $xoopsDB->prefix('userinfo_form')
                  . '.idfield, '
                  . $xoopsDB->prefix('userinfo_form')
                  . '.fieldname, '
                  . $xoopsDB->prefix('userinfo_form')
                  . '.idcat, '
                  . $xoopsDB->prefix('userinfo_cat')
                  . '.nomcat, '
                  . $xoopsDB->prefix('userinfo_cat')
                  . '.idcat, '
                  . $xoopsDB->prefix(
                      'userinfo_cat'
                  )
                  . '.affcat FROM '
                  . $xoopsDB->prefix('userinfo_form')
                  . ', '
                  . $xoopsDB->prefix('userinfo_cat')
                  . ' WHERE '
                  . $xoopsDB->prefix('userinfo_form')
                  . '.idcat = '
                  . $xoopsDB->prefix('userinfo_cat')
                  . '.idcat '
                  . 'ORDER BY '
                  . $xoopsDB->prefix('userinfo_cat')
                  . '.affcat, '
                  . $xoopsDB->prefix('userinfo_form')
                  . '.fieldname';

        $result = $xoopsDB->query($sql);

        if ($myrow = $xoopsDB->fetchArray($result)) {
            $block['content'] .= '<select name="idfield" style="width:140">';

            $aff_categorie = 0;

            do {
                $catencours = $myrow[idcat];

                if ($aff_categorie != $catencours) {
                    if (0 != $aff_categorie) {
                        $block['content'] .= '</optgroup>';
                    }

                    $block['content'] .= '<optgroup label="' . $myrow[nomcat] . '">';

                    $aff_categorie = $catencours;
                }

                $block['content'] .= '<option value="' . $myrow['idfield'] . '">' . $myrow['fieldname'] . "</option>\n";
            } while (false !== ($myrow = $xoopsDB->fetchArray($result)));

            $block['content'] .= '</optgroup></select><br><br><input type="submit" value="' . _MB_USERINFO_VUE . '"></form></td></tr></table>';
        }
    } else {
        $block['content'] .= '<p title="' . htmlspecialchars($userinfo_cfg['forminactivinfo'], ENT_QUOTES | ENT_HTML5) . '">' . _MB_USERINFO_FORMNOTACTIV . '</p>';
    }

    return $block;
}
