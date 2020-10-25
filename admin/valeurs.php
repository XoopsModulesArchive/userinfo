<?php
// ------------------------------------------------------------------------- //
// userinfo module for Xoops : Userinfo for Xoops							 //
// Original Author: Alfy													 //
// Author Website : http://www.m-u-g.net									 //
// ------------------------------------------------------------------------- //

require_once './admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/module.textsanitizer.php';

// -------------------------------------------------------------------------
// -------------------------  Affichage des valeurs ------------------------
// -------------------------------------------------------------------------
function valeurs()
{
    global $xoopsModule;
    global $xoopsDB;
    global $_POST;
    global $aff_val;
    xoops_cp_header();
    OpenTable();

    if ($aff_val == '' || $aff_val == 0) {
        $n_aff_val = 1;
    } else {
        $n_aff_val = 0;
    }
    ?>

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <table border="0" align="center">
        <tr class='bg1'>
            <td colspan="4">
                <hr align="center" noshade="noshade">
                <div align="center"><?php echo _AM_USERINFO_VALEURS; ?></div>
                <hr align="center" noshade="noshade">
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <table border="0" align="center">
                    <tr>
                        <td colspan="3" align="center">
                            <input type="checkbox" name="aff_valeur" value="aff" <?php if ($aff_val == 1) {
                                echo 'CHECKED';
                            } ?> onclick="document.location='valeurs.php?op=valeurs&aff_val=<?php echo $n_aff_val ?>'"><?php echo _AM_USERINFO_VIEWELEMENT ?><br>
                            <form method="post" action="./valeurs.php?op=new-valeur">
                                <input type="submit" value="<?php echo _AM_USERINFO_NEWVAL ?>">
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='4'>&nbsp;</td>
                    </tr>
                    <tr>
                        <td class='bg2'><?php echo _AM_USERINFO_TITLEVAL ?></td>
                        <td colspan='3' class='bg2'><?php echo _AM_USERINFO_TITLEACTION ?></td>
                    </tr>
                    <?php

                    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_val') . " WHERE idval != 0 ORDER BY 'nomval','numval' ASC";
                    if (!$result = $xoopsDB->query($sql)) {
                        echo _AM_USERINFO_DBERROR;
                        CloseTable();
                        xoops_cp_footer();
                        exit();
                    }

                    while (false !== ($row = $xoopsDB->fetchArray($result))) {
                        if ($row[numval] == -1) {
                            echo '<tr><td>' . $row[nomval] . '</td>';
                            echo '<td><form method="post" action="./valeurs.php?op=modif-valeur"><input type="hidden" name="num_valeur" value="' . $row[idval] . '"><input type="submit" value=' . _AM_USERINFO_CATMODIF . "></td></form>\n";
                            echo '<td><form method="post" action="./valeurs.php?op=demand-erase-valeur"><input type="hidden" name="num_valeur" value="' . $row[idval] . '"><input type="submit" value=' . _AM_USERINFO_CATERASE . "></td></form></tr>\n";
                        } elseif ($aff_val == 1) {
                            echo '<tr><td>&nbsp;</td>';
                            echo '<td>' . _AM_USERINFO_AFFELEMENT . "</td><td colspan='2'>" . $row[valeur] . '</td></tr>';
                        }
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

// -------------------------------------------------------------------------
// -----------------------  Modification d'une valeur ----------------------
// -------------------------------------------------------------------------
function modif_valeur()
{
    global $xoopsModule;
    global $xoopsDB;
    global $_POST;
    xoops_cp_header();
    global $num_valeur;
    OpenTable();
    echo '<script>
	    	function verify()
			{
				var valtitle = document.modifval.val_name.value;
	
				var msg = "' . _AM_USERINFO_VAL_MSGERROR . "\\n\";
				var formok = true;
	
				if (valtitle == \"\") {
        	   		formok = false;
           			msg += \"" . _AM_USERINFO_VAL_TITLEERROR . "\";
				}

    	        if (formok === false)
				{
            		alert(msg);
				}
				return formok;
			}
			function validform()
			{
				document.modifval.valider.value='" . _AM_USERINFO_WAIT . "';
				document.modifval.valider.disabled='true';
				document.modifval.submit();
			}
	</script>";
    ?>

    <table border="0" align="center">
        <tr class='bg1'>
            <td colspan="4">
                <hr align="center" noshade="noshade">
                <div align="center"><?php echo _AM_USERINFO_TITTLEMODVAL; ?></div>
                <hr align="center" noshade="noshade">
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <table border="0" align="center">
                    <?php
                    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_val') . " WHERE idval='" . $num_valeur . "' ORDER BY 'numval'";
                    //echo $sql;
                    if (!$result = $xoopsDB->query($sql)) {
                        echo _AM_USERINFO_DBERROR;
                        CloseTable();
                        xoops_cp_footer();
                        exit();
                    }

                    while (false !== ($row = $xoopsDB->fetchArray($result))) {
                        if ($row[numval] == -1) {
                            echo '<tr><td><form name="modifval" method="post" action="./valeurs.php?op=save-valeur" onsubmit="return verify();">';
                            echo '<input type="hidden" name="idval" value="' . $num_valeur . '">';
                            echo _AM_USERINFO_VALMODTITTLE . '</td>';
                            echo '<td><input type="text" name="val_name" size="30" maxlength="40" value="' . $row[nomval] . '"></td>';
                            echo '<td><input name="valider" type="button" value="' . _AM_USERINFO_VALIDATE . '" onclick="validform();"></td></tr>';
                            echo '<tr><td colspan="4"><hr width="95%"></td></tr>';
                        } else {
                            echo '<td align="right">' . _AM_USERINFO_AFFELEMENT . '</td>';
                            echo '<td><input type="text" name="valeur[' . $row[numval] . ']" size="30" maxlength="40" value="' . $row[valeur] . '"></td>';
                            echo '<td><a href="./valeurs.php?op=demand-erase-element&idval=' . $row[idval] . '&numval=' . $row[numval] . '">' . _AM_USERINFO_TITTLEERASEELEMENT . '</a></td></tr>';
                        }
                    }
                    echo '</form>';
                    echo '<tr><td colspan="4" align="center"><form method="post" action="./valeurs.php?op=new-element">';
                    echo '<input type="hidden" name="idval" value="' . $num_valeur . '">';
                    echo '<input type="submit" value="' . _AM_USERINFO_TITTLEADDELEMENT . '"></form><br><a href="valeurs.php?op=valeurs">' . _AM_USERINFO_RETURN . '</a></td></tr>';
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

// ---------------------------------------------------------------------------
// --------------------------  Nouvelle valeur -------------------------------
// ---------------------------------------------------------------------------
function new_valeur()
{
    global $xoopsModule;
    global $xoopsDB;

    xoops_cp_header();
    OpenTable();

    echo '<script>
	    	function verify()
			{
				var valtitle = document.nouvval.val_name.value;
	
				var msg = "' . _AM_USERINFO_VAL_MSGERROR . "\\n\";
				var formok = true;
	
				if (valtitle == \"\") {
        	   		formok = false;
           			msg += \"" . _AM_USERINFO_VAL_TITLEERROR . "\";
				}

    	        if (formok === false)
				{
            		alert(msg);
				}
				return formok;
			}
			function validform()
			{
				document.nouvval.valider.value='" . _AM_USERINFO_WAIT . "';
				document.nouvval.valider.disabled='true';
				document.nouvval.submit();
			}
	</script>";
    ?>

    <table border="0" align="center">
        <tr class='bg1'>
            <td colspan="4">
                <hr align="center" noshade="noshade">
                <div align="center"><?php echo _AM_USERINFO_TITTLEADDVAL; ?></div>
                <hr align="center" noshade="noshade">
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <table border="0" align="center">
                    <?php
                    echo '<tr><td><form name="nouvval" method="post" action="./valeurs.php?op=add-valeur" onsubmit="return verify();">';
                    echo _AM_USERINFO_VALMODTITTLE . '</td>';
                    echo '<td><input type="text" name="val_name" size="15" maxlength="40" value=""></td>';
                    echo '<td><input name="valider" type="button" value="' . _AM_USERINFO_VALIDATE . '" onclick="validform();"></td></tr>';
                    echo '<tr><td colspan="3" align="center"><a href="valeurs.php?op=valeurs">' . _AM_USERINFO_RETURN . '</a></td></tr>';
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
// --------------------------- Ajouter une valeur -------------------------
// ------------------------------------------------------------------------
function add_valeur()
{
    $myts = MyTextSanitizer::getInstance();
    global $xoopsModule;
    global $xoopsDB;
    global $_POST;
    //récupération des variables transmises dans le lien
    global $val_name;

    $num_valeur = search_idval();
    $valok      = 1;
    if ($val_name == '') {
        $val_name = _AM_USERINFO_EMPTY;
        $valok    = 0;
    }

    $sql = 'INSERT ' . $xoopsDB->prefix('userinfo_val') . " (idval, nomval, numval, valeur) VALUES ('" . $num_valeur . "','" . $myts->addSlashes($val_name) . "','-1','')";
    if (!$result = $xoopsDB->query($sql)) {
        redirect_header('valeurs.php?op=valeurs', 2, _AM_USERINFO_DBERROR);
        exit();
    }
    if ($valok == 1) {
        redirect_header('valeurs.php?op=modif-valeur&num_valeur=' . $num_valeur, 2, _AM_USERINFO_DBUPDATED);
    } else {
        redirect_header('valeurs.php?op=modif-valeur&num_valeur=' . $num_valeur, 2, _AM_USERINFO_DBUPDATED . _AM_USERINFO_VALEMPTY_NOTIFY);
    }
    exit;
}

// -----------------------------------------------------------------------
// ------------------ recherche d'un ID de valeur libre ------------------
// -----------------------------------------------------------------------
function search_idval()
{
    global $xoopsModule;
    global $xoopsDB;
    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_val') . ' WHERE 1 AND numval = - 1 ORDER BY idval ASC';
    //echo "sql = ".$sql."<br>";

    if (!$result = $xoopsDB->query($sql)) {
        echo _AM_USERINFO_DBERROR;
        CloseTable();
        xoops_cp_footer();
        exit();
    }
    $new_num_val = -1;
    do {
        $row = $xoopsDB->fetchArray($result);
        $new_num_val++;
    } while ($new_num_val == $row[idval]);
    return $new_num_val;
}

// ---------------------------------------------------------------------------
// ---------------------------  Nouvel élément -------------------------------
// ---------------------------------------------------------------------------
function new_element()
{
    global $xoopsModule;
    global $xoopsDB;
    global $_POST;
    //récupération des variables transmises dans le lien
    global $idval;

    xoops_cp_header();
    OpenTable();
    echo '<script>
	    	function verify()
			{
				var elementtitle = document.nouvelement.valeur.value;
	
				var msg = "' . _AM_USERINFO_ELE_MSGERROR . "\\n\";
				var formok = true;
	
				if (elementtitle == \"\") {
        	   		formok = false;
           			msg += \"" . _AM_USERINFO_ELE_TITLEERROR . "\";
				}

    	        if (formok === false)
				{
            		alert(msg);
				}
				return formok;
			}
			function validform()
			{
				document.nouvelement.valider.value='" . _AM_USERINFO_WAIT . "';
				document.nouvelement.valider.disabled='true';
				document.nouvelement.submit();
			}
	</script>";

    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_val') . " WHERE idval = '" . $idval . "'";

    $result = $xoopsDB->query($sql);
    $row    = $xoopsDB->fetchArray($result);
    ?>

    <table border="0" align="center">
        <tr class='bg1'>
            <td colspan="4">
                <hr align="center" noshade="noshade">
                <div align="center"><?php echo _AM_USERINFO_TITTLEADDELEMENT2 . "<div class='fg2'>" . $row[nomval] . '</div>'; ?></div>
                <hr align="center" noshade="noshade">
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <table border="0" align="center">
                    <?php
                    echo '<tr><td><form name="nouvelement" method="post" action="./valeurs.php?op=add-element" onsubmit="return verify();">';
                    echo _AM_USERINFO_TITTLEADDELEMENT . '</td>';
                    echo '<td><input type="text" name="valeur" size="30" maxlength="40" value="">';
                    echo '<input type="hidden" name="idval" value="' . $idval . '">';
                    echo '<input type="hidden" name="nomval" value="' . $row[nomval] . '">';
                    echo '<td><input name="valider" type="button" value="' . _AM_USERINFO_VALIDATE . '" onclick="validform();"></td></tr>';
                    echo '<tr><td align="center" colspan="3"><a href="valeurs.php?op=modif-valeur&num_valeur=' . $idval . '">' . _AM_USERINFO_RETURN . '</a></td></tr>';
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
// --------------------------- Ajouter un élément -------------------------
// ------------------------------------------------------------------------
function add_element()
{
    $myts = MyTextSanitizer::getInstance();
    global $xoopsModule;
    global $xoopsDB;
    global $_POST;
    //récupération des variables transmises dans le lien
    global $idval;
    global $valeur;
    global $nomval;

    $num_element = search_numval($idval);
    $numvalok    = 1;
    if ($valeur == '') {
        $valeur   = _AM_USERINFO_EMPTY;
        $valnumok = 0;
    }

    $sql = 'INSERT ' . $xoopsDB->prefix('userinfo_val') . " (idval, nomval, numval, valeur) VALUES ('" . $idval . "','" . $nomval . "','" . $num_element . "','" . $myts->addSlashes($valeur) . "')";
    if (!$result = $xoopsDB->query($sql)) {
        redirect_header('valeurs.php?op=valeurs', 2, _AM_USERINFO_DBERROR);
        exit();
    }
    if ($numvalok == 1) {
        redirect_header('valeurs.php?op=modif-valeur&num_valeur=' . $idval, 1, _AM_USERINFO_DBUPDATED);
    } else {
        redirect_header('valeurs.php?op=modif-valeur&num_valeur=' . $idval, 1, _AM_USERINFO_DBUPDATED . _AM_USERINFO_ELELMENTEMPTY_NOTIFY);
    }
    exit;
}

// -----------------------------------------------------------------------
// ------------------ recherche d'un ID d'élément libre ------------------
// -----------------------------------------------------------------------
function search_numval($idval)
{
    global $xoopsModule;
    global $xoopsDB;
    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_val') . ' WHERE idval = ' . $idval . ' AND numval != - 1 ORDER BY numval ASC';
    //echo "sql = ".$sql."<br>";

    if (!$result = $xoopsDB->query($sql)) {
        echo _AM_USERINFO_DBERROR;
        CloseTable();
        xoops_cp_footer();
        exit();
    }
    $new_num_element = 0;
    do {
        $row = $xoopsDB->fetchArray($result);
        $new_num_element++;
    } while ($new_num_element == $row[numval]);
    return $new_num_element;
}

// -----------------------------------------------------------------------
// ---------------- Demande de suppression d'un élément ------------------
// -----------------------------------------------------------------------
function demand_erase_element()
{
    global $_POST;
    global $numval;
    global $idval;
    //global $xoopsDB;
    xoops_cp_header();
    OpenTable();

    echo "<h4 style='text-align:left;'>" . _AM_USERINFO_TITTLEERASEELEMENT . '</h4>';
    echo "<span style='color:#ff0000;font-weight:bold;'>" . _AM_USERINFO_DEMANDERASEELEMENT . '</span><br><br>';
    echo "<table><tr><td>\n";
    echo myTextForm('valeurs.php?op=erase-element&idval=' . $idval . '&numval=' . $numval, _AM_USERINFO_YES);
    echo "</td><td>\n";
    echo myTextForm('valeurs.php?op=modif-valeur&num_valeur=' . $idval, _AM_USERINFO_NO);
    echo "</td></tr></table>\n";
    CloseTable();
    xoops_cp_footer();
}

// -----------------------------------------------------------------------
// ------------------------- Suppression d'un élément --------------------
// -----------------------------------------------------------------------
function erase_element()
{
    global $xoopsModule;
    global $xoopsDB;
    global $_POST;
    global $numval;
    global $idval;

    $sql = 'DELETE FROM ' . $xoopsDB->prefix('userinfo_val') . ' WHERE idval = ' . $idval . ' AND numval = ' . $numval;
    //echo "sql = ".$sql; exit;
    $result = $xoopsDB->query($sql);

    redirect_header('valeurs.php?op=modif-valeur&num_valeur=' . $idval, 1, _AM_USERINFO_DBUPDATED);
    exit();
}

// -----------------------------------------------------------------------
// ------------------------ Mise à jour d'une valeur ---------------------
// -----------------------------------------------------------------------
function save_valeur()
{
    $myts = MyTextSanitizer::getInstance();
    global $xoopsModule;
    global $xoopsDB;
    global $_POST;
    //récupération des variables transmises dans le lien
    global $idval;
    global $val_name;
    global $valeur;

    $valok = 1;
    if ($val_name == '') {
        $val_name = _AM_USERINFO_EMPTY;
        $valok    = 0;
    }

    $sql = 'UPDATE ' . $xoopsDB->prefix('userinfo_val') . " SET nomval='" . $myts->addSlashes($val_name) . "' WHERE idval='" . $idval . "' AND numval = - 1";
    $xoopsDB->query($sql);

    foreach ($valeur as $numval => $affval) {
        if (($affval == '') and ($valok == 1)) {
            $affval = _AM_USERINFO_EMPTY;
            $valok  = 0;
        }
        $sql = 'UPDATE ' . $xoopsDB->prefix('userinfo_val') . " SET nomval='" . $myts->addSlashes($val_name) . "', valeur='" . $myts->addSlashes($affval) . "' WHERE idval='" . $idval . "' AND numval='" . $numval . "'";
        $xoopsDB->query($sql);
    }
    if ($valok == 1) {
        redirect_header('valeurs.php?op=valeurs', 2, _AM_USERINFO_DBUPDATED);
    } else {
        redirect_header('valeurs.php?op=valeurs', 2, _AM_USERINFO_DBUPDATED . _AM_USERINFO_VALEMPTY);
    }
    exit();
}

// -----------------------------------------------------------------------
// ---------------- Demande de suppression d'une valeur ------------------
// -----------------------------------------------------------------------
function demand_erase_valeur()
{
    global $_POST;
    global $num_valeur;
    xoops_cp_header();
    OpenTable();
    echo "<h4 style='text-align:left;'>" . _AM_USERINFO_TITTLEERASEVAL . '</h4>';
    echo "<span style='color:#ff0000;font-weight:bold;'>" . _AM_USERINFO_DEMANDERASEVALEUR . '</span><br><br>';
    echo "<table><tr><td>\n";
    echo myTextForm('valeurs.php?op=erase-valeur&num_valeur=' . $num_valeur, _AM_USERINFO_YES);
    echo "</td><td>\n";
    echo myTextForm('valeurs.php?op=valeurs', _AM_USERINFO_NO);
    echo "</td></tr></table>\n";
    CloseTable();
    xoops_cp_footer();
}

// -----------------------------------------------------------------------
// ------------------------- Suppression d'une valeur --------------------
// -----------------------------------------------------------------------
function erase_valeur()
{
    global $xoopsModule;
    global $xoopsDB;
    global $_POST;
    global $num_valeur;

    //vérification si l'élément n'est pas déjà utilisé
    $sql            = 'SELECT idval FROM ' . $xoopsDB->prefix('userinfo_form') . ' WHERE idval = ' . $num_valeur;
    $result         = $xoopsDB->query($sql);
    $nombre_utilise = $xoopsDB->getRowsNum($result);
    if ($nombre_utilise > 0) {
        redirect_header('valeurs.php?op=valeurs', 4, _AM_USERINFO_ERRORERASEVAL);
        exit();
    }

    $sql = 'DELETE FROM ' . $xoopsDB->prefix('userinfo_val') . " WHERE idval='" . $num_valeur . "'";
    //echo "sql = ".$sql;
    if (!$result = $xoopsDB->query($sql)) {
        redirect_header('valeurs.php?op=valeurs', 2, _AM_USERINFO_DBERROR);
        exit();
    }

    redirect_header('valeurs.php?op=valeurs', 2, _AM_USERINFO_DBUPDATED);
    exit();
}

// -----------------------------------------------------------------------
// ------------------------ Choix des opérations -------------------------
// -----------------------------------------------------------------------
switch ($op) {
    case 'valeurs':
        valeurs();
        break;

    case 'modif-valeur':
        modif_valeur();
        break;

    case 'new-valeur':
        new_valeur();
        break;

    case 'add-valeur':
        add_valeur();
        break;

    case 'new-element':
        new_element();
        break;

    case 'add-element':
        add_element();
        break;

    case 'demand-erase-element':
        demand_erase_element();
        break;

    case 'erase-element':
        erase_element();
        break;

    case 'save-valeur':
        save_valeur();
        break;

    case 'erase-valeur':
        erase_valeur();
        break;

    case 'demand-erase-valeur':
        demand_erase_valeur();
        break;
}
?>
