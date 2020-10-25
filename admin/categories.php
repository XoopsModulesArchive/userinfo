<?php
// ------------------------------------------------------------------------- //
// userinfo module for Xoops : IRC chat with Asterochat.com					 //
// Original Author: Alfy													 //
// Author Website : http://www.m-u-g.net									 //
// ------------------------------------------------------------------------- //

require_once './admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/module.textsanitizer.php';

// -------------------------------------------------------------------------
// -----------------------  Affichage des catégories -----------------------
// -------------------------------------------------------------------------
function categories()
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
                <div align="center"><?php echo _AM_USERINFO_CATEGORIES; ?></div>
                <hr align="center" noshade="noshade">
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <table border="0" align="center">
                    <tr>
                        <td align="center" colspan="4">
                            <form method="post" action="./categories.php?op=new-categorie">
                                <input type="submit" value="<?php echo _AM_USERINFO_CATNEWTITTLE ?>">
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='4'>&nbsp;</td>
                    </tr>
                    <tr>
                        <td class='bg2'><?php echo _AM_USERINFO_TITLECAT; ?></td>
                        <td class='bg2' colspan='2'><?php echo _AM_USERINFO_TITLEORD; ?></td>
                        <td class='bg2' colspan='2'><?php echo _AM_USERINFO_TITLEACTION; ?></td>
                    </tr>
                    <?php

                    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_cat') . ' ORDER BY affcat ASC';
                    if (!$result = $xoopsDB->query($sql)) {
                        echo _AM_USERINFO_DBERROR;
                        CloseTable();
                        xoops_cp_footer();
                        exit();
                    }

                    $max_categories = $xoopsDB->getRowsNum($result);

                    while (false !== ($row = $xoopsDB->fetchArray($result))) {
                        echo '<tr><td valign="top"><div title="' . _AM_USERINFO_COMMENT . ' : ' . $row[comcat] . "\n" . _AM_USERINFO_CATMODIMG . ' : ' . $row[imgcat] . '"> ' . $row[nomcat] . '</div></td>';
                        if ($row[affcat] != 1) {
                            echo '<td><form method="post" action="./categories.php?op=categorie-up&aff_categorie=' . $row[affcat] . '&num_categorie=' . $row[idcat] . '"><input type="submit" value="' . _AM_USERINFO_CATUP . '"></form></td>';
                        } else {
                            echo '<td><form><input type="button" value="' . _AM_USERINFO_CATUP . '" DISABLED></form></td>';
                        }
                        if ($row[affcat] != $max_categories) {
                            echo '<td><form method="post" action="./categories.php?op=categorie-down&aff_categorie=' . $row[affcat] . '&num_categorie=' . $row[idcat] . '"><input type="submit" value="' . _AM_USERINFO_CATDOWN . '"></form></td>';
                        } else {
                            echo '<td><form><input type="button" value="' . _AM_USERINFO_CATDOWN . '" DISABLED></form></td>';
                        }
                        echo '<td valign="top"><form method="post" action="./categories.php?op=modif-categorie"><input type="hidden" name="num_categorie" value="' . $row[idcat] . '"><input type="submit" value=' . _AM_USERINFO_CATMODIF . '></td></form>';
                        echo '<td valign="top"><form method="post" action="./categories.php?op=demand-erase-categorie"><input type="hidden" name="num_categorie" value="'
                             . $row[idcat]
                             . '"><input type="hidden" name="aff_categorie" value="'
                             . $row[affcat]
                             . '"><input type="submit" value='
                             . _AM_USERINFO_CATERASE
                             . '></td></form></tr>';
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
// ---------------------  modification d'une catégorie ---------------------
// -------------------------------------------------------------------------
function modif_categories()
{
    global $xoopsModule;
    global $xoopsDB;
    global $_POST;
    xoops_cp_header();
    OpenTable();

    echo '<script>
	    	function verify()
			{
				var cattitle = document.modifcat.cat_name.value;
	
				var msg = "' . _AM_USERINFO_CAT_MSGERROR . "\\n\";
				var formok = true;
	
				if (cattitle == \"\") {
        	   		formok = false;
           			msg += \"" . _AM_USERINFO_CAT_TITLEERROR . "\";
				}

    	        if (formok === false)
				{
            		alert(msg);
				}
				return formok;
			}
			function validform()
			{
				document.modifcat.valider.value='" . _AM_USERINFO_WAIT . "';
				document.modifcat.valider.disabled='true';
				document.modifcat.submit();
			}
	</script>";
    ?>

    <table border="0" align="center">
        <tr class='bg1'>
            <td colspan="4">
                <hr align="center" noshade="noshade">
                <div align="center"><?php echo _AM_USERINFO_TITTLEMODCAT; ?></div>
                <hr align="center" noshade="noshade">
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <table border="0" align="center">
                    <?php
                    $num_categorie = $_POST['num_categorie'];
                    $sql           = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_cat') . " WHERE idcat='" . $num_categorie . "'";
                    //echo $sql;
                    if (!$result = $xoopsDB->query($sql)) {
                        echo _AM_USERINFO_DBERROR;
                        CloseTable();
                        xoops_cp_footer();
                        exit();
                    }

                    while (false !== ($row = $xoopsDB->fetchArray($result))) {
                        echo '<tr><td><form name="modifcat" method="post" action="./categories.php?op=save-categorie" onsubmit="return verify();">';
                        echo _AM_USERINFO_CATMODTITTLE . '</td>';
                        echo '<td><input type="text" name="cat_name" size="15" maxlength="40" value="' . $row[nomcat] . '"></td></tr>';

                        echo '<tr><td>' . _AM_USERINFO_COMMENT . '</td>';
                        echo '<td><textarea name="cat_com" cols="40" rows="5">' . $row[comcat] . '</textarea></td></tr>';

                        echo "<tr><td valign='middle'>" . _AM_USERINFO_CATMODIMG . '</td>';
                        echo "<td valign='middle'><input type=\"text\" name=\"cat_img\" size=\"15\" maxlength=\"40\" value=\"" . $row[imgcat] . '">';
                        echo '<input type="hidden" name="num_categorie" value="' . $num_categorie . '">';
                        if (!$row[imgcat]) {
                            echo ' | ' . _AM_USERINFO_NOIMAGE . '</td></tr>';
                        } else {
                            echo ' | ' . _AM_USERINFO_CATMODIMG . " : <img align='middle' src=\"" . XOOPS_URL . "\\modules\\" . $xoopsModule->dirname() . "\\images\\cat\\" . $row[imgcat] . '"></td></tr>';
                        }

                        echo '<tr><td colspan="2">' . _AM_USERINFO_CATIMGINFO . ': ' . XOOPS_ROOT_PATH . "\\modules\\" . $xoopsModule->dirname() . "\\images\\cat\\</td></tr>";

                        echo '<tr><td colspan="2" align="center"><input name="valider" type="button" value="' . _AM_USERINFO_CATMODIF . '" onclick="validform();">';
                        echo '<br><br><a href="' . $PHP_SELF . '?op=categories">' . _AM_USERINFO_RETURN . '</a></td></form></tr>';
                    }
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
// ------------------------  nouvelle catégorie ------------------------------
// ---------------------------------------------------------------------------
function new_categorie()
{
    global $xoopsModule;
    global $xoopsDB;

    xoops_cp_header();
    OpenTable();

    echo '<script>
	    	function verify()
			{
				var cattitle = document.nouvcat.cat_name.value;
	
				var msg = "' . _AM_USERINFO_CAT_MSGERROR . "\\n\";
				var formok = true;
	
				if (cattitle == \"\") {
        	   		formok = false;
           			msg += \"" . _AM_USERINFO_CAT_TITLEERROR . "\";
				}

    	        if (formok === false)
				{
            		alert(msg);
				}
				return formok;
			}
			function validform()
			{
				document.nouvcat.valider.value='" . _AM_USERINFO_WAIT . "';
				document.nouvcat.valider.disabled='true';
				document.nouvcat.submit();
			}
	</script>";
    ?>
    <table border="0" align="center">
        <tr class='bg1'>
            <td colspan="4">
                <hr align="center" noshade="noshade">
                <div align="center"><?php echo _AM_USERINFO_CATNEWTITTLE; ?></div>
                <hr align="center" noshade="noshade">
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <table border="0" align="center">
                    <?php
                    echo '<tr><td><form name="nouvcat" method="post" action="./categories.php?op=add-categorie" onsubmit="return verify();">';
                    echo _AM_USERINFO_CATMODTITTLE . '</td>';
                    echo '<td><input type="text" name="cat_name" size="15" maxlength="40" value=""></td></tr>';
                    echo '<tr><td>' . _AM_USERINFO_COMMENT . '</td>';
                    echo '<td><textarea name="cat_com" cols="40" rows="5"></textarea></td></tr>';
                    echo "<tr><td valign='middle'>" . _AM_USERINFO_CATMODIMG . '</td>';
                    echo "<td valign='middle'><input type=\"text\" name=\"cat_img\" size=\"15\" maxlength=\"40\" value=\"\">";
                    echo '<tr><td colspan="2">' . _AM_USERINFO_CATIMGINFO . ': ' . XOOPS_ROOT_PATH . "\\modules\\" . $xoopsModule->dirname() . "\\images\\cat\\</td></tr>";
                    echo '<tr><td colspan="2" align="center"><input name="valider" type="button" value="' . _AM_USERINFO_VALIDATE . '" onclick="validform();">';
                    echo '<br><br><a href="' . $PHP_SELF . '?op=categories">' . _AM_USERINFO_RETURN . '</a></td></form></tr>';

                    ?>
                </table>
            </td>
        </tr>
    </table>
    <?php
    CloseTable();
    xoops_cp_footer();
}

// -----------------------------------------------------------------------
// ------------------------- monter une catégorie ------------------------
// -----------------------------------------------------------------------
function categorie_up()
{
    global $xoopsModule;
    global $xoopsDB;
    global $_POST;
    //récupération des variables transmises dans le lien
    global $aff_categorie;
    global $num_categorie;

    $aff_categorie_m = $aff_categorie - 1;

    //récupération de l'ID de la catégorie précédente
    $sql = 'SELECT idcat FROM ' . $xoopsDB->prefix('userinfo_cat') . " WHERE affcat='" . $aff_categorie_m . "'";
    //echo $sql."<br>";
    $result               = $xoopsDB->query($sql);
    $row                  = $xoopsDB->fetchArray($result);
    $categorie_precedente = $row[idcat];

    $sql = 'UPDATE ' . $xoopsDB->prefix('userinfo_cat') . " SET affcat = '" . $aff_categorie_m . "' WHERE idcat = '" . $num_categorie . "';";
    //echo $sql."<br>";
    $result = $xoopsDB->query($sql);

    $sql = 'UPDATE ' . $xoopsDB->prefix('userinfo_cat') . " SET affcat = '" . $aff_categorie . "' WHERE idcat = '" . $categorie_precedente . "';";
    //echo $sql."<br>";
    $result = $xoopsDB->query($sql);

    redirect_header('categories.php?op=categories', 0, _AM_USERINFO_DBUPDATED);
    exit;
}

// -----------------------------------------------------------------------
// ----------------------- descendre une catégorie -----------------------
// -----------------------------------------------------------------------
function categorie_down()
{
    global $xoopsModule;
    global $xoopsDB;
    global $_POST;
    //récupération des variables transmises dans le lien
    global $aff_categorie;
    global $num_categorie;

    $aff_categorie_m = $aff_categorie + 1;

    //récupération de l'ID de la catégorie précédente
    $sql = 'SELECT idcat FROM ' . $xoopsDB->prefix('userinfo_cat') . " WHERE affcat='" . $aff_categorie_m . "'";
    //echo $sql."<br>";
    $result               = $xoopsDB->query($sql);
    $row                  = $xoopsDB->fetchArray($result);
    $categorie_precedente = $row[idcat];

    $sql = 'UPDATE ' . $xoopsDB->prefix('userinfo_cat') . " SET affcat='" . $aff_categorie_m . "' WHERE idcat='" . $num_categorie . "'";
    //echo $sql."<br>";
    $result = $xoopsDB->query($sql);

    $sql = 'UPDATE ' . $xoopsDB->prefix('userinfo_cat') . " SET affcat='" . $aff_categorie . "' WHERE idcat='" . $categorie_precedente . "'";
    //echo $sql."<br>";
    $result = $xoopsDB->query($sql);

    redirect_header('categories.php?op=categories', 0, _AM_USERINFO_DBUPDATED);
    exit();
}

// -----------------------------------------------------------------------
// ---------------------- mise à jour d'une catégorie --------------------
// -----------------------------------------------------------------------
function save_categorie()
{
    $myts = MyTextSanitizer::getInstance();
    global $xoopsModule;
    global $xoopsDB;
    global $_POST;
    //récupération des variables transmises dans le lien
    global $cat_name;
    global $cat_com;
    global $cat_img;
    global $num_categorie;

    $catok = 1;
    if ($cat_name == '') {
        $cat_name = _AM_USERINFO_EMPTY;
        $catok    = 0;
    }
    $sql = 'UPDATE ' . $xoopsDB->prefix('userinfo_cat') . " SET nomcat='" . $myts->addSlashes($cat_name) . "', comcat='" . $myts->addSlashes($cat_com) . "', imgcat='" . $myts->addSlashes($cat_img) . "' WHERE idcat='" . $num_categorie . "'";
    //echo "sql = ".$sql."<br>";
    if (!$result = $xoopsDB->query($sql)) {
        redirect_header('categories.php?op=categories', 2, _AM_USERINFO_DBERROR);
        exit();
    }
    if ($catok == 1) {
        redirect_header('categories.php?op=categories', 2, _AM_USERINFO_DBUPDATED);
    } else {
        redirect_header('categories.php?op=categories', 2, _AM_USERINFO_DBUPDATED . _AM_USERINFO_CATEMPTY_NOTIFY);
    }
    exit();
}

// ------------------------------------------------------------------------
// ------------------------- ajouter une catégorie ------------------------
// ------------------------------------------------------------------------
function add_categorie()
{
    $myts = MyTextSanitizer::getInstance();
    global $xoopsModule;
    global $xoopsDB;
    global $_POST;
    //récupération des variables transmises dans le lien
    global $cat_name;
    global $cat_com;
    global $cat_img;

    $num_categorie = search_idcat();
    $catok         = 1;
    if ($cat_name == '') {
        $cat_name = _AM_USERINFO_CATEMPTY;
        $catok    = 0;
    }
    $sql            = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_cat');
    $result         = $xoopsDB->query($sql);
    $max_categories = ($xoopsDB->getRowsNum($result)) + 1;

    $sql = 'INSERT '
           . $xoopsDB->prefix('userinfo_cat')
           . " (idcat, affcat, nomcat, comcat, imgcat) VALUES ('"
           . $num_categorie
           . "','"
           . $max_categories
           . "','"
           . $myts->addSlashes($cat_name)
           . "','"
           . $myts->addSlashes($cat_com)
           . "', '"
           . $myts->addSlashes($cat_img)
           . "')";
    if (!$result = $xoopsDB->query($sql)) {
        redirect_header('categories.php?op=categories', 2, _AM_USERINFO_DBERROR);
        exit();
    }
    if ($catok == 1) {
        redirect_header('categories.php?op=categories', 2, _AM_USERINFO_DBUPDATED);
    } else {
        redirect_header('categories.php?op=categories', 2, _AM_USERINFO_DBUPDATED . _AM_USERINFO_CATEMPTY_NOTIFY);
    }
    exit();
}

// -----------------------------------------------------------------------
// ---------------- recherche d'un ID de catégorie libre -----------------
// -----------------------------------------------------------------------
function search_idcat()
{
    global $xoopsModule;
    global $xoopsDB;
    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_cat') . ' ORDER BY idcat ASC';
    //echo "sql = ".$sql."<br>";

    if (!$result = $xoopsDB->query($sql)) {
        echo _AM_USERINFO_DBERROR;
        CloseTable();
        xoops_cp_footer();
        exit();
    }
    $num_cat = 1;
    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        if ($row[idcat] == $num_cat) {
            $num_cat += 1;
        }
    }
    return $num_cat;
}

// -----------------------------------------------------------------------
// -------------- Demande de suppression d'une catégorie -----------------
// -----------------------------------------------------------------------
function demand_erase_categorie()
{
    global $_POST;
    global $num_categorie;
    global $aff_categorie;
    xoops_cp_header();
    OpenTable();
    echo "<h4 style='text-align:left;'>" . _AM_USERINFO_CATERASE . '</h4>';
    echo "<span style='color:#ff0000;font-weight:bold;'>" . _AM_USERINFO_DEMANDERASECATEGORIE . '</span><br><br>';
    echo "<table><tr><td>\n";
    echo myTextForm('categories.php?op=erase-categorie&num_categorie=' . $num_categorie . '&aff_categorie=' . $aff_categorie, _AM_USERINFO_YES);
    echo "</td><td>\n";
    echo myTextForm('categories.php?op=categories', _AM_USERINFO_NO);
    echo "</td></tr></table>\n";
    CloseTable();
    xoops_cp_footer();
}

// -----------------------------------------------------------------------
// ----------------------- Suppression d'une catégorie -------------------
// -----------------------------------------------------------------------
function erase_categorie()
{
    global $xoopsModule;
    global $xoopsDB;
    global $_GET;
    global $num_categorie;
    global $aff_categorie;

    //vérification si la catégorie n'est pas déjà utilisée
    $sql            = 'SELECT idcat FROM ' . $xoopsDB->prefix('userinfo_form') . ' WHERE idcat = ' . $num_categorie;
    $result         = $xoopsDB->query($sql);
    $nombre_utilise = $xoopsDB->getRowsNum($result);
    if ($nombre_utilise > 0) {
        redirect_header('categories.php?op=categories', 4, _AM_USERINFO_ERRORERASECAT);
        exit();
    }

    $sql = 'DELETE FROM ' . $xoopsDB->prefix('userinfo_cat') . " WHERE idcat='" . $num_categorie . "'";
    //echo "sql = ".$sql;
    if (!$result = $xoopsDB->query($sql)) {
        redirect_header('categories.php?op=categories', 2, _AM_USERINFO_DBERROR);
        exit();
    }

    $sql            = 'SELECT * FROM ' . $xoopsDB->prefix('userinfo_cat');
    $result         = $xoopsDB->query($sql);
    $max_categories = $xoopsDB->getRowsNum($result);

    for ($i = $aff_categorie; $i <= $max_categories; $i++) {
        $sql = 'UPDATE ' . $xoopsDB->prefix('userinfo_cat') . " SET affcat='" . $i . "' WHERE affcat='" . ($i + 1) . "'";
        $xoopsDB->query($sql);
    }

    redirect_header('categories.php?op=categories', 2, _AM_USERINFO_DBUPDATED);
    exit();
}

// -----------------------------------------------------------------------
// ------------------------ Choix des opérations -------------------------
// -----------------------------------------------------------------------
switch ($op) {
    case 'categories':
        categories();
        break;

    case 'modif-categorie':
        modif_categories();
        break;

    case 'categorie-down':
        categorie_down();
        break;

    case 'categorie-up':
        categorie_up();
        break;

    case 'save-categorie':
        save_categorie();
        break;

    case 'add-categorie':
        add_categorie();
        break;

    case 'new-categorie':
        new_categorie();
        break;

    case 'demand-erase-categorie':
        demand_erase_categorie();
        break;

    case 'erase-categorie':
        erase_categorie();
        break;
}
?>
