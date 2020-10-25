<?php
// ------------------------------------------------------------------------- //
// userinfo module for Xoops : Userinfo for Xoops							 //
// Original Author: Alfy													 //
// Author Website : http://www.m-u-g.net									 //
// ------------------------------------------------------------------------- //

require_once './admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/module.textsanitizer.php';

// -------------------------------------------------------------------------
// -------------------------  Affichage des champs -------------------------
// -------------------------------------------------------------------------
function fields()
{
    global $xoopsModule;
    global $xoopsDB;

    xoops_cp_header();
    OpenTable();
    ?>

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <table border="0" align="center">
        <tr class='bg1'>
            <td colspan="4">
                <hr align="center" noshade="noshade">
                <div align="center"><?php echo _AM_USERINFO_FORM; ?></div>
                <hr align="center" noshade="noshade">
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <table border="0" align="center">
                    <tr>
                        <td colspan="5" align="center">
                            <form method="post" action="./form.php?op=new-field">
                                <input type="submit" value="<?php echo _AM_USERINFO_NEWFIELD ?>">
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='4'>&nbsp;</td>
                    </tr>
                    <tr>
                        <td class='bg2'><?php echo _AM_USERINFO_TITLECAT ?></td>
                        <td Class='bg2'><?php echo _AM_USERINFO_TITLEFIELD ?></td>
                        <td class='bg2'><?php echo _AM_USERINFO_VAL ?></td>
                        <td class='bg2' colspan='2'><?php echo _AM_USERINFO_TITLEACTION ?></td>
                        <?php

                        $nomdbform = $xoopsDB->prefix('userinfo_form');
                        $nomdbcat  = $xoopsDB->prefix('userinfo_cat');
                        $nomdbval  = $xoopsDB->prefix('userinfo_val');
                        $sql       = 'SELECT '
                                     . $nomdbform
                                     . '.idfield,'
                                     . $nomdbform
                                     . '.idcat,'
                                     . $nomdbform
                                     . '.idval,'
                                     . $nomdbform
                                     . '.fieldname,'
                                     . $nomdbform
                                     . '.fieldtype,'
                                     . $nomdbcat
                                     . '.idcat,'
                                     . $nomdbcat
                                     . '.affcat,'
                                     . $nomdbcat
                                     . '.nomcat,'
                                     . $nomdbval
                                     . '.idval,'
                                     . $nomdbval
                                     . '.nomval,'
                                     . $nomdbval
                                     . '.numval '
                                     . 'FROM '
                                     . $nomdbform
                                     . ', '
                                     . $nomdbcat
                                     . ', '
                                     . $nomdbval
                                     . ' '
                                     . 'WHERE '
                                     . $nomdbform
                                     . '.idval = '
                                     . $nomdbval
                                     . '.idval AND '
                                     . $nomdbform
                                     . '.idcat = '
                                     . $nomdbcat
                                     . '.idcat AND '
                                     . $nomdbval
                                     . '.numval = - 1 '
                                     . 'ORDER BY '
                                     . $nomdbcat
                                     . '.affcat, '
                                     . $nomdbform
                                     . '.fieldname ASC';
                        //echo $sql; exit;
                        if (!$result = $xoopsDB->query($sql)) {
                            echo _AM_USERINFO_DBERROR;
                            CloseTable();
                            xoops_cp_footer();
                            exit();
                        }
                        $affiche_cat = 0;
                        while (false !== ($row = $xoopsDB->fetchArray($result))) {
                            if ($affiche_cat != $row[idcat]) {
                                echo "<tr class='bg1'><td colspan=\"5\">" . $row[nomcat] . '</td></tr>';
                                $affiche_cat = $row[idcat];
                            }
                            echo '<tr><td>&nbsp;</td>';
                            if ($row[idval] == '0') {
                                echo '<td>' . $row[fieldname] . '</td>';
                                echo '<td>' . _AM_USERINFO_FREEFIELD . '</td>';
                            } else {
                                echo '<td>' . $row[fieldname] . '</td>';
                                echo '<td>' . $row[nomval] . '</td>';
                            }
                            echo '<td><form method="post" action="./form.php?op=modif-field"><input type="hidden" name="num_field" value="' . $row[idfield] . '"><input type="submit" value=' . _AM_USERINFO_CATMODIF . "></td></form>\n";
                            echo '<td><form method="post" action="./form.php?op=demand-erase-field"><input type="hidden" name="num_field" value="' . $row[idfield] . '"><input type="submit" value=' . _AM_USERINFO_CATERASE . "></td></form></tr>\n";
                        }

                        ?>
                </table>
            </td>
        </tr>
    </table>
    <?php
    CloseTable();
    xoops_cp_footer();
}

// ------------------------------------------------------------------------
// -----------------------  Modification d'un champ -----------------------
// ------------------------------------------------------------------------
function modif_field()
{
    $myts = MyTextSanitizer::getInstance();
    global $xoopsModule;
    global $xoopsDB;
    global $_POST;
    global $livemodifval;
    global $tempomodifval;
    global $livemodiftype;
    global $tempomodiftype;
    global $idval;
    global $num_field;
    global $num_cat;
    global $defaut_val;
    global $field_name;

    $list_type_field[1] = _AM_USERINFO_LIST_FIELD_1;
    $list_type_field[2] = _AM_USERINFO_LIST_FIELD_2;
    $list_type_field[3] = _AM_USERINFO_LIST_FIELD_3;
    $list_type_field[4] = _AM_USERINFO_LIST_FIELD_4;
    $list_type_field[5] = _AM_USERINFO_LIST_FIELD_5;

    xoops_cp_header();
    OpenTable();

    $nomdbform = $xoopsDB->prefix('userinfo_form');
    $nomdbcat  = $xoopsDB->prefix('userinfo_cat');
    $nomdbval  = $xoopsDB->prefix('userinfo_val');
    $sql       = 'SELECT * FROM ' . $nomdbform . ' WHERE idfield = ' . $num_field;
    //echo $sql; exit;
    if (!$result = $xoopsDB->query($sql)) {
        echo _AM_USERINFO_DBERROR;
        CloseTable();
        xoops_cp_footer();
        exit();
    }
    $row = $xoopsDB->fetchArray($result);

    // récupération des modifications
    if ($livemodiftype) {
        $fieldtype      = $livemodiftype;
        $tempomodiftype = $livemodiftype;
        $idval          = -1;
        $valdefaut      = -1;
    } else {
        if ($tempomodiftype) {
            $fieldtype = $tempomodiftype;
        } else {
            $fieldtype = $row[fieldtype];
        }
        if ($livemodifval) {
            $idval         = $livemodifval;
            $tempomodifval = $livemodifval;
            $valdefaut     = -1;
        } else {
            $idval = $row[idval];
            if ($tempomodifval) {
                $valdefaut = $defaut_val;
            } else {
                $valdefaut = $row[valdefaut];
            }
        }
    }

    if (!$num_cat) {
        $idcat = $row[idcat];
    } else {
        $idcat = $num_cat;
    }
    if (!$field_name) {
        $fieldname = $row[fieldname];
    } else {
        $fieldname = $field_name;
    }
    if (!$val_defaut_texte) {
        $valdefauttexte = $row[valdefauttexte];
    } else {
        $valdefauttexte = $val_defaut_texte;
    }

    //alert ('lmv='+lmv+' - tmv='+tmv+' | lmt='+lmt+' - tmt='+tmt);

    echo "<script>
    	function verify()
		{

			var lmv = document.modif.num_val.value;
			var tmv = '" . $tempomodifval . "';
			var lmt = document.modif.type_field.value;
			var tmt = '" . $tempomodiftype . "';

			if ((lmv == '-1') || (lmt == 4) || (lmt == 5)) lmv = tmv;
			
			if (lmt == '-1') lmt = '';
			if (tmv == '') tmv = lmv;
			if (tmt == '') tmt = lmt;
			
			if ((tmv != lmv) || (tmt != lmt))
			{
				document.modif.valider.value='" . _AM_USERINFO_WAIT . "';
				document.modif.valider.disabled='true';
				return true;
				exit;
			}
			
			var msg = \"" . _AM_USERINFO_FORM_MSGERROR . "\\n\";
			var formok = true;

			if (document.modif.field_name.value.length == 0) {
           		formok = false;
           		msg += \"" . _AM_USERINFO_FIELDNAMEERROR . "\";
			}

			if ((document.modif.num_val.value == '-1') && (formok === true) && (document.modif.type_field.value != 4) && (document.modif.type_field.value != 5)) {
				formok = false;
				msg += \"" . _AM_USERINFO_FIELDVALERROR . "\";
			}

            if (formok === false)
			{
            	alert(msg);
			} else {
				document.modif.valider.value='" . _AM_USERINFO_WAIT . "';
				document.modif.valider.disabled='true';
			}
			return formok;
		}
	</script>";
    ?>

    <table border="0" align="center">
        <tr class='bg1'>
            <td colspan="4">
                <hr align="center" noshade="noshade">
                <div align="center"><?php echo _AM_USERINFO_TITTLEMODFIELD; ?></div>
                <hr align="center" noshade="noshade">
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <table border="0" align="center">
                    <?php

                    // début du formulaire
                    echo '<tr><td><form name="modif" method="post" action="./form.php?op=save-form" onsubmit="return verify();">';
                    echo '<input type="hidden" name="num_field" value="' . $num_field . '">';
                    echo _AM_USERINFO_TITLEFIELD . '</td>';
                    echo '<td><input type="text" name="field_name" size="30" maxlength="40" value="' . $fieldname . '"></td>';
                    echo '<td colspan="2" align="center"><input name="valider" type="submit" value="' . _AM_USERINFO_VALIDATE . '"></td></tr>';

                    // affichage du type de champ
                    echo '<tr><td>' . _AM_USERINFO_TITTLEFIELDTYPE . '</td>';
                    echo '<td><select name="type_field" ';
                    echo "onchange=\"document.modif.action='./form.php?op=save-form&tempomodifval=" . $tempomodifval . "&livemodiftype='+document.modif.type_field.value; ";
                    echo 'document.modif.valider.focus(); ';
                    echo 'document.modif.valider.click();">';
                    for ($boucle = 1; $boucle < 6; $boucle++) {
                        echo '<option value="' . $boucle . '" ';
                        if ($boucle == $fieldtype) {
                            echo 'selected';
                        }
                        echo '>' . $list_type_field[$boucle] . '</option>';
                    }
                    echo '</select>';
                    echo '<input type="hidden" name="tempomodiftype" value="' . $tempomodiftype . '">';
                    echo '</td>';
                    echo '<tr><td colspan="4"><HR></td></tr>';

                    //affichage de la valeur
                    if (($fieldtype != 4) and ($fieldtype != 5)) //si le type de champ n'est pas du texte
                    {
                        // récupération de la liste des valeurs disponibles
                        $sql = 'SELECT * FROM ' . $nomdbval . ' WHERE numval = - 1 AND idval != 0 ORDER BY nomval';
                        if (!$result = $xoopsDB->query($sql)) {
                            echo _AM_USERINFO_DBERROR;
                            CloseTable();
                            xoops_cp_footer();
                            exit();
                        }
                        echo '<tr><td>' . _AM_USERINFO_VAL . '</td>';
                        echo '<td><select name="num_val" ';
                        echo "onchange=\"document.modif.action='./form.php?op=save-form&tempomodiftype=" . $tempomodiftype . "&livemodifval='+document.modif.num_val.value; ";
                        echo 'document.modif.valider.focus(); ';
                        echo 'document.modif.valider.click();">';
                        if ($idval == -1) {
                            echo '<option value="-1" selected></option>';
                        }
                        while (false !== ($row = $xoopsDB->fetchArray($result))) {
                            echo '<option value="' . $row[idval] . '" ';
                            if ($idval == $row[idval]) {
                                echo 'selected';
                            }
                            echo '>' . $row[nomval] . '</option>';
                        }
                        echo '</select>';
                        echo '<input type="hidden" name="tempomodifval" value="' . $tempomodifval . '">';
                        echo '</td>';
                    } else {
                        echo '<input type="hidden" name="num_val" value="' . $idval . '">';
                    }

                    // affichage de la valeur par défaut
                    if (($fieldtype != 4) and ($fieldtype != 5)) {
                        if ($idval != -1) {
                            $sql = 'SELECT * FROM ' . $nomdbval . ' WHERE idval = ' . $idval . ' AND numval != - 1 ORDER BY numval';
                            if (!$result = $xoopsDB->query($sql)) {
                                echo _AM_USERINFO_DBERROR;
                                CloseTable();
                                xoops_cp_footer();
                                exit();
                            }
                            echo '<td>' . _AM_USERINFO_TITTLEVALDEFAULT . '</td>';
                            echo '<td><select name="defaut_val">';
                            if ($valdefaut == -1) {
                                echo '<option value="-1" selected></option>';
                            } else {
                                echo '<option value="-1"></option>';
                            }
                            while (false !== ($row = $xoopsDB->fetchArray($result))) {
                                echo '<option value="' . $row[numval] . '" ';
                                if ($valdefaut == $row[numval]) {
                                    echo 'selected';
                                }
                                echo '>' . $row[valeur] . '</option>';
                            }
                            echo '</select></td></tr>';
                            echo '<tr><td colspan="4"><HR></td></tr>';
                        } else {
                            echo '<td>' . _AM_USERINFO_CHOOSE_A_VALUE . '</td>';
                            echo '<tr><td colspan="4"><HR></td></tr>';
                        }
                    } elseif ($fieldtype == 4) {
                        echo '<td>' . _AM_USERINFO_TITTLEVALDEFAULT . '</td>';
                        echo '<td><input type="text" name="val_defaut_texte" size="30" maxlength="40" value="' . $valdefauttexte . '"></td></tr>';
                        echo '<tr><td colspan="4"><HR></td></tr>';
                    } else {
                        if ($valdefaut == -1) {
                            $valdefaut = 10;
                        }
                        echo '<td>' . _AM_USERINFO_TITTLEVALDEFAULT . '</td>';
                        echo '<td><input type="text" name="val_defaut_texte" size="30" maxlength="40" value="' . $valdefauttexte . '"></td>';
                        echo '<td>' . _AM_USERINFO_TITTLETEXTSIZE . '<input type="text" name="defaut_val" size="3" maxlength="3" value="' . $valdefaut . '"></td></tr>';
                        echo '<tr><td colspan="4"><HR></td></tr>';
                    }

                    //categorie
                    $sql = 'SELECT * FROM ' . $nomdbcat . ' ORDER BY affcat';
                    if (!$result = $xoopsDB->query($sql)) {
                        echo _AM_USERINFO_DBERROR;
                        CloseTable();
                        xoops_cp_footer();
                        exit();
                    }
                    echo '<tr><td>' . _AM_USERINFO_TITLECAT . '</td>';
                    echo '<td><select name="num_cat">';
                    if ($idcat == -1) {
                        echo '<option value="-1" selected></option>';
                    }
                    while (false !== ($row = $xoopsDB->fetchArray($result))) {
                        echo '<option value="' . $row[idcat] . '" ';
                        if ($idcat == $row[idcat]) {
                            echo 'selected ';
                            $comcat = $row[comcat];
                        }
                        echo '>' . $row[nomcat] . '</option>';
                    }
                    echo '</select></td>';
                    echo '<td colspan="2">' . $myts->displayTarea($comcat, 0) . '</td></tr>';

                    echo '</form>';
                    ?>
                </table>
                <br>
            </td>
        </tr>
    </table>
    <?php
    CloseTable();
    xoops_cp_footer();
}

// ------------------------------------------------------------------------
// ---------------------------  Ajout d'un champ --------------------------
// ------------------------------------------------------------------------
function new_field()
{
    $myts = MyTextSanitizer::getInstance();
    global $xoopsModule;
    global $xoopsDB;
    global $_POST;
    global $livemodifval;
    global $tempomodifval;
    global $livemodiftype;
    global $tempomodiftype;
    global $field_name;
    global $val_defaut_texte;
    global $defaut_val;
    global $num_cat;

    $list_type_field[1] = _AM_USERINFO_LIST_FIELD_1;
    $list_type_field[2] = _AM_USERINFO_LIST_FIELD_2;
    $list_type_field[3] = _AM_USERINFO_LIST_FIELD_3;
    $list_type_field[4] = _AM_USERINFO_LIST_FIELD_4;
    $list_type_field[5] = _AM_USERINFO_LIST_FIELD_5;

    xoops_cp_header();
    OpenTable();

    $nomdbform = $xoopsDB->prefix('userinfo_form');
    $nomdbcat  = $xoopsDB->prefix('userinfo_cat');
    $nomdbval  = $xoopsDB->prefix('userinfo_val');

    if (!$field_name) {
        $fieldname = '';
    } else {
        $fieldname = $field_name;
    }
    if (!$num_cat) {
        $idcat = -1;
    } else {
        $idcat = $num_cat;
    }
    if (!$val_defaut_texte) {
        $valdefauttexte = '';
    } else {
        $valdefauttexte = $val_defaut_texte;
    }

    // récupération des modifications
    if ($livemodiftype) {
        $fieldtype      = $livemodiftype;
        $tempomodiftype = $livemodiftype;
        $idval          = -1;
        $valdefaut      = -1;
    } else {
        if ($tempomodiftype) {
            $fieldtype = $tempomodiftype;
        } else {
            $fieldtype = -1;
        }
        if ($livemodifval) {
            $idval         = $livemodifval;
            $tempomodifval = $livemodifval;
            $valdefaut     = -1;
        } else {
            $idval = -1;
            if ($tempomodifval) {
                $valdefaut = $defaut_val;
            } else {
                $valdefaut = -1;
            }
        }
    }

    //alert ('lmv='+lmv+' - tmv='+tmv+' | lmt='+lmt+' - tmt='+tmt);

    echo "<script>
    	function verify()
		{
			var lmv = document.modif.num_val.value;
			var tmv = '" . $tempomodifval . "';
			var lmt = document.modif.type_field.value;
			var tmt = '" . $tempomodiftype . "';

			if ((lmv == '-1') || (lmt == 4) || (lmt == 5)) lmv = tmv;
			if (lmt == '-1') lmt = '';
			
			if ((tmv != lmv) || (tmt != lmt))
			{
				document.modif.valider.value='" . _AM_USERINFO_WAIT . "';
				document.modif.valider.disabled='true';
				return true;
				exit;
			}
			
			var msg = \"" . _AM_USERINFO_FORM_MSGERROR . "\\n\";
			var formok = true;

			if (document.modif.field_name.value.length == 0) {
           		formok = false;
           		msg += \"" . _AM_USERINFO_FIELDNAMEERROR . "\";
			}

			if ((document.modif.type_field.value == '-1') && (formok === true)) {
				formok = false;
				msg += \"" . _AM_USERINFO_FIELDTYPEERROR . "\";
			}
			
			if ((document.modif.num_val.value == '-1') && (formok === true) && (document.modif.type_field.value != 4) && (document.modif.type_field.value != 5)) {
				formok = false;
				msg += \"" . _AM_USERINFO_FIELDVALERROR . "\";
			}

			if ((document.modif.num_cat.value == '-1') && (formok === true)) {
				formok = false;
				msg += \"" . _AM_USERINFO_FIELDCATERROR . "\";
			}

            if (formok === false)
			{
            	alert(msg);
			} else {
				document.modif.valider.value='" . _AM_USERINFO_WAIT . "';
				document.modif.valider.disabled='true';
			}
			return formok;
		}
	</script>";
    ?>

    <table border="0" align="center">
        <tr class='bg1'>
            <td colspan="4">
                <hr align="center" noshade="noshade">
                <div align="center"><?php echo _AM_USERINFO_TITTLEADDFIELD; ?></div>
                <hr align="center" noshade="noshade">
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <table border="0" align="center">
                    <?php

                    // début du formulaire
                    echo '<tr><td><form name="modif" method="post" action="./form.php?op=save-form" onsubmit="return verify();">';
                    echo '<input type="hidden" name="ajout_champ" value="1">';
                    echo _AM_USERINFO_TITLEFIELD . '</td>';
                    echo '<td><input type="text" name="field_name" size="30" maxlength="40" value="' . $fieldname . '"></td>';
                    echo '<td colspan="2" align="center">';
                    echo '<input name="valider" type="submit" value="' . _AM_USERINFO_VALIDATE . '"></td></tr>';

                    // affichage du type de champ
                    echo '<tr><td>' . _AM_USERINFO_TITTLEFIELDTYPE . '</td>';
                    echo "<td><select name=\"type_field\" \n";
                    echo "onchange=\"document.modif.action='./form.php?op=save-form&tempomodifval=" . $tempomodifval . "&livemodiftype='+document.modif.type_field.value; \n";
                    echo "document.modif.valider.focus(); \n";
                    echo "document.modif.valider.click();\">\n";
                    if ($fieldtype == -1) {
                        echo "<option value=\"-1\" selected></option>\n";
                    }
                    for ($boucle = 1; $boucle < 6; $boucle++) {
                        echo '<option value="' . $boucle . '" ';
                        if ($boucle == $fieldtype) {
                            echo 'selected';
                        }
                        echo '>' . $list_type_field[$boucle] . "</option>\n";
                    }
                    echo "</select>\n";
                    echo '<input type="hidden" name="tempomodiftype" value="' . $tempomodiftype . "\">\n";
                    echo '</td>';
                    echo '<tr><td colspan="4"><HR></td></tr>';

                    //affichage de la valeur
                    if (($fieldtype != 4) and ($fieldtype != -1) and ($fieldtype != 5))//si le type de champ n'est pas du texte
                    {
                        // récupération de la liste des valeurs disponibles
                        $sql = 'SELECT * FROM ' . $nomdbval . ' WHERE numval = - 1 AND idval != 0 ORDER BY nomval';
                        if (!$result = $xoopsDB->query($sql)) {
                            echo _AM_USERINFO_DBERROR;
                            CloseTable();
                            xoops_cp_footer();
                            exit();
                        }
                        echo '<tr><td>' . _AM_USERINFO_VAL . '</td>';
                        echo '<td><select name="num_val" ';
                        echo "onchange=\"document.modif.action='./form.php?op=save-form&tempomodiftype=" . $tempomodiftype . "&livemodifval='+document.modif.num_val.value; ";
                        echo 'document.modif.valider.focus(); ';
                        echo 'document.modif.valider.click();">';
                        if ($idval == -1) {
                            echo '<option value="-1" selected></option>';
                        }
                        while (false !== ($row = $xoopsDB->fetchArray($result))) {
                            echo '<option value="' . $row[idval] . '" ';
                            if ($idval == $row[idval]) {
                                echo 'selected';
                            }
                            echo '>' . $row[nomval] . '</option>';
                        }
                        echo '</select>';
                        echo '<input type="hidden" name="tempomodifval" value="' . $tempomodifval . '">';
                        echo '</td>';
                    } else {
                        echo '<input type="hidden" name="num_val" value="' . $idval . '">';
                    }

                    // affichage de la valeur par défaut
                    if (($fieldtype != 4) and ($fieldtype != 5)) {
                        if ($idval != -1) {
                            $sql = 'SELECT * FROM ' . $nomdbval . ' WHERE idval = ' . $idval . ' AND numval != - 1 ORDER BY numval';
                            if (!$result = $xoopsDB->query($sql)) {
                                echo _AM_USERINFO_DBERROR;
                                CloseTable();
                                xoops_cp_footer();
                                exit();
                            }
                            echo '<td>' . _AM_USERINFO_TITTLEVALDEFAULT . '</td>';
                            echo '<td><select name="defaut_val">';
                            if ($valdefaut == -1) {
                                echo '<option value="-1" selected></option>';
                            }
                            while (false !== ($row = $xoopsDB->fetchArray($result))) {
                                echo '<option value="' . $row[numval] . '" ';
                                if ($valdefaut == $row[numval]) {
                                    echo 'selected';
                                }
                                echo '>' . $row[valeur] . '</option>';
                            }
                            echo '</select></td></tr>';
                            echo '<tr><td colspan="4"><HR></td></tr>';
                        } else {
                            if ($fieldtype != -1) {
                                echo '<td>' . _AM_USERINFO_CHOOSE_A_VALUE . '</td>';
                                echo '<tr><td colspan="4"><HR></td></tr>';
                            }
                        }
                    } elseif ($fieldtype == 4) {
                        echo '<td>' . _AM_USERINFO_TITTLEVALDEFAULT . '</td>';
                        echo '<td><input type="text" name="val_defaut_texte" size="30" maxlength="40" value="' . $valdefauttexte . '"></td></tr>';
                        echo '<tr><td colspan="4"><HR></td></tr>';
                    } else {
                        if ($valdefaut == -1) {
                            $valdefaut = 10;
                        }
                        echo '<td>' . _AM_USERINFO_TITTLEVALDEFAULT . '</td>';
                        echo '<td><input type="text" name="val_defaut_texte" size="30" maxlength="40" value="' . $valdefauttexte . '"></td>';
                        echo '<td>' . _AM_USERINFO_TITTLETEXTSIZE . '<input type="text" name="defaut_val" size="3" maxlength="3" value="' . $valdefaut . '"></td></tr>';
                        echo '<tr><td colspan="4"><HR></td></tr>';
                    }

                    // Affichage de la categorie
                    $sql = 'SELECT * FROM ' . $nomdbcat . ' ORDER BY affcat';
                    if (!$result = $xoopsDB->query($sql)) {
                        echo _AM_USERINFO_DBERROR;
                        CloseTable();
                        xoops_cp_footer();
                        exit();
                    }
                    echo '<tr><td>' . _AM_USERINFO_TITLECAT . '</td>';
                    echo '<td><select name="num_cat">';
                    if ($idcat == -1) {
                        echo '<option value="-1" selected></option>';
                    }
                    while (false !== ($row = $xoopsDB->fetchArray($result))) {
                        echo '<option value="' . $row[idcat] . '" ';
                        if ($idcat == $row[idcat]) {
                            echo 'selected ';
                            $comcat = $row[comcat];
                        }
                        echo '>' . $row[nomcat] . '</option>';
                    }
                    echo '</select></td>';
                    echo '<td colspan="2">' . $myts->displayTarea($comcat, 0) . '</td></tr>';
                    echo '</form>';
                    ?>
                </table>
                <br>
            </td>
        </tr>
    </table>
    <?php
    CloseTable();
    xoops_cp_footer();
}

// -------------------------------------------------------------------------
// -----------------------  Sauvegarde du formulaire -----------------------
// ---------------------------------------
