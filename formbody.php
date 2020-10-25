<?php

$sql = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_cat');
$result = $xoopsDB->query($sql);
$max_categories = $xoopsDB->getRowsNum($result);

echo "<table border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"bg2\">\n";
echo '<tr><td>';
echo "<table border=\"0\" align=\"center\" cellpadding=\"4\" cellspacing=\"1\" >\n";

for ($affiche_cat = 1; $affiche_cat <= $max_categories; $affiche_cat++) {
    // *** affichage de la catégorie ***

    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_cat') . ' ORDER BY affcat ASC LIMIT ' . ($affiche_cat - 1) . ',1';

    $result = $xoopsDB->query($sql);

    $row = $xoopsDB->fetchArray($result);

    $cat_en_cours = $row[idcat];

    echo "<tr class=\"bg1\">\n<td colspan=\"2\">\n<p align=\"center\" class=\"fg2\" title=\"" . $row[comcat] . '">';

    if ($row[imgcat]) {
        echo "<img hspace=\"2\" align='middle' src=\"" . XOOPS_URL . '\\modules\\userinfo\\images\\cat\\' . $row[imgcat] . '"><br>';
    }

    echo '<b>' . $row[nomcat] . "</b></p></td></tr>\n";

    // *** affichage des champs de la catégorie en cours ***

    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_form') . ' WHERE idcat=' . $cat_en_cours;

    $result = $xoopsDB->query($sql);

    $max_fields = $xoopsDB->getRowsNum($result);

    $fieldencours = 0;

    for ($affiche_field = 1; $affiche_field <= $max_fields; $affiche_field++) {
        $sql = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_form') . ' WHERE idcat=' . $cat_en_cours . ' ORDER BY fieldname LIMIT ' . ($affiche_field - 1) . ',1';

        $result = $xoopsDB->query($sql);

        $row_field = $xoopsDB->fetchArray($result);

        echo '<tr';

        if (0 == $fieldencours) {
            echo ' class="bg1"';

            $fieldencours = 1;
        } else {
            echo ' class="bg3"';

            $fieldencours = 0;
        }

        echo " valign=\"top\">\n<td><b>" . $row_field[fieldname] . "</b></td>\n";

        $sql = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_val') . ' WHERE idval=' . $row_field[idval] . ' AND numval != - 1 ORDER BY valeur';

        $result = $xoopsDB->query($sql);

        $max_val = $xoopsDB->getRowsNum($result);

        if (0 != $curuserid) {
            $sql = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_user') . ' WHERE uid=' . $curuserid . ' AND idfield=' . $row_field[idfield];

            //echo $sql."<br>";

            $result_user = $xoopsDB->query($sql);

            $val_user = $xoopsDB->fetchArray($result_user);

            $reponse_user = $xoopsDB->getRowsNum($result_user);
        }

        echo '<input type="hidden" name="repuser[' . $row_field[idfield] . ']" value="' . $reponse_user . "\">\n";

        echo '<input type="hidden" name="fieldtype[' . $row_field[idfield] . ']" value="' . $row_field[fieldtype] . "\">\n";

        if ($reponse_user) {
            $valafficher = $val_user[valeur];

            $valaffichertexte = $val_user[valeurtexte];
        } else {
            $valafficher = $row_field[valdefaut];

            $valaffichertexte = $row_field[valdefauttexte];
        }

        switch ($row_field[fieldtype]) {
            case 1:
                // combo box
                if (true === $modificationform) {
                    echo "<td>\n<select name=\"champ[" . $row_field[idfield] . "]\">\n";

                    echo '<option value="-1"';

                    if ('-1' == $valafficher) {
                        echo ' SELECTED>';
                    } else {
                        echo '>';
                    }

                    echo "</option>\n";

                    while (false !== ($row_val = $xoopsDB->fetchArray($result))) {
                        echo '<option value="' . $row_val[numval] . '"';

                        if ($valafficher == $row_val[numval]) {
                            echo ' SELECTED>';
                        } else {
                            echo '>';
                        }

                        echo $row_val[valeur] . "</option>\n";
                    }

                    echo "</select>\n</td>\n";
                } else {
                    echo "<td>\n";

                    if (0 == $reponse_user) {
                        echo '<p class="fg1">';
                    } else {
                        echo '<p class="fg2">';
                    }

                    while (false !== ($row_val = $xoopsDB->fetchArray($result))) {
                        if ($valafficher == $row_val[numval]) {
                            echo $row_val[valeur];
                        }
                    }

                    echo "</p></td>\n";
                }
                break;
            case 2:
                // list box
                if (true === $modificationform) {
                    $taille_listbox = $max_val - 2;

                    if ($taille_listbox < $userinfo_cfg['selmin']) {
                        $taille_listbox = $userinfo_cfg['selmin'];
                    }

                    if ($taille_listbox > $userinfo_cfg['selmax']) {
                        $taille_listbox = $userinfo_cfg['selmax'];
                    }

                    echo "<td>\n<select size=\"" . $taille_listbox . '" name="champ[' . $row_field[idfield] . "]\">\n";

                    echo '<option value="-1"';

                    if ('-1' == $valafficher) {
                        echo ' SELECTED>';
                    } else {
                        echo '>';
                    }

                    echo "</option>\n";

                    while (false !== ($row_val = $xoopsDB->fetchArray($result))) {
                        echo '<option value="' . $row_val[numval] . '"';

                        if ($valafficher == $row_val[numval]) {
                            echo ' SELECTED>';
                        } else {
                            echo '>';
                        }

                        echo $row_val[valeur] . "</option>\n";
                    }

                    echo "</select>\n</td>\n";
                } else {
                    echo "<td>\n";

                    if (0 == $reponse_user) {
                        echo '<p class="fg1">';
                    } else {
                        echo '<p class="fg2">';
                    }

                    while (false !== ($row_val = $xoopsDB->fetchArray($result))) {
                        if ($valafficher == $row_val[numval]) {
                            echo $row_val[valeur];
                        }
                    }

                    echo "</p>\n</td>\n";
                }
                break;
            case 3:
                // radio button
                if (true === $modificationform) {
                    echo "<td>\n<p class=\"bg1\">";

                    while (false !== ($row_val = $xoopsDB->fetchArray($result))) {
                        echo '<input type="radio" name="champ[' . $row_field[idfield] . ']" value="' . $row_val[numval] . '"';

                        if ($valafficher == $row_val[numval]) {
                            echo ' CHECKED>';
                        } else {
                            echo ">\n";
                        }

                        echo $row_val[valeur] . '<br>';
                    }

                    echo "</p></select>\n</td>\n";
                } else {
                    echo "<td>\n";

                    if (0 == $reponse_user) {
                        echo '<p class="fg1">';
                    } else {
                        echo '<p class="fg2">';
                    }

                    while (false !== ($row_val = $xoopsDB->fetchArray($result))) {
                        if ($valafficher == $row_val[numval]) {
                            echo $row_val[valeur];
                        }
                    }

                    echo "</p>\n</td>\n";
                }
                break;
            case 4:
                // champ libre 'textarea"
                if (true === $modificationform) {
                    $row_val = $xoopsDB->fetchArray($result);

                    echo "<td>\n<textarea cols=\"" . $userinfo_cfg['textareacols'] . '" rows="' . $userinfo_cfg['textarearows'] . '" name="champ[' . $row_field[idfield] . ']">' . $valaffichertexte . "</textarea>\n</td>\n";
                } else {
                    echo "<td>\n";

                    if (0 == $reponse_user) {
                        echo '<p class="fg1">';
                    } else {
                        echo '<p class="fg2">';
                    }

                    echo $myts->displayTarea($valaffichertexte) . "</p>\n</td>\n";
                }
                break;
            case 5:
                // champ libre 'texte'
                if (true === $modificationform) {
                    $row_val = $xoopsDB->fetchArray($result);

                    $textsize = $row_field[valdefaut];

                    if ($textsize > 20) {
                        $textsize = 20;
                    }

                    $row_val = $xoopsDB->fetchArray($result);

                    echo "<td>\n<input type=\"text\" maxlength=\"" . $row_field[valdefaut] . '" size="' . $textsize . '" value="' . $valaffichertexte . '" name="champ[' . $row_field[idfield] . "]\">\n</td>\n";
                } else {
                    echo "<td>\n";

                    if (0 == $reponse_user) {
                        echo '<p class="fg1">';
                    } else {
                        echo '<p class="fg2">';
                    }

                    echo $myts->displayTarea($valaffichertexte) . "</p>\n</td>\n";
                }
                break;
        }

        echo "</tr>\n";
    }
}
echo "</table>\n";
echo '</td></tr></table>';
