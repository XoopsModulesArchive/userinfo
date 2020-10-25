<?php
// ------------------------------------------------------------------------- //
// userinfo module for Xoops : IRC chat with Asterochat.com					 //
// Original Author: Alfy													 //
// Author Website : http://www.m-u-g.net									 //
// ------------------------------------------------------------------------- //

require_once './admin_header.php';

//--------------------------------------------------------------------------
//---------------------------- Menu de principal ---------------------------
//--------------------------------------------------------------------------
function setupindex()
{
    xoops_cp_header();

    OpenTable();

    echo "- <b><a href='./categories.php?op=categories'>" . _MI_USERINFO_CATEGORIES . '</a></b><br>';

    echo "- <b><a href='./valeurs.php?op=valeurs'>" . _MI_USERINFO_VALUES . '</a></b><br>';

    echo "- <b><a href='./form.php?op=fields'>" . _MI_USERINFO_FORM . '</a></b><br>';

    echo "- <b><a href='./seeform.php'>" . _MI_USERINFO_MAIN . '</a></b><br>';

    echo "- <b><a href='./index.php?op=options'>" . _MI_USERINFO_OPTIONS . '</a></b><br>';

    CloseTable();

    xoops_cp_footer();
}

// -------------------------------------------------------------------------
// --------------------------- Options générales ---------------------------
// -------------------------------------------------------------------------
function options()
{
    global $xoopsModule;

    $myts = MyTextSanitizer::getInstance();

    require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/cache/config.php';

    xoops_cp_header();

    OpenTable();

    echo '<script>
    	function verify()
		{
			var msg = "' . _AM_USERINFO_CONFIG_MSGERROR . '\\n";
			var formok = true;

			if (document.options.formtitle.value.length == 0) {
           		formok = false;
           		msg += "\\n' . _AM_USERINFO_FORMTITLEERROR . '";
			}

			if (document.options.selmin.value < 3) {
           		formok = false;
           		msg += "\\n' . _AM_USERINFO_SELMINERROR . '";
			}

			var valmin = Number(document.options.selmin.value);
			var valmax = Number(document.options.selmax.value);
			var difference = valmax - valmin;
			if ( difference < 3 ) {
           		formok = false;
           		msg += "\\n' . _AM_USERINFO_SELSIZEERROR . '";
			}

			if (document.options.textareacols.value < 3) {
           		formok = false;
           		msg += "\\n' . _AM_USERINFO_TEXTAREACOLSERROR . '";
			}

			if (document.options.textarearows.value < 3) {
           		formok = false;
           		msg += "\\n' . _AM_USERINFO_TEXTAREAROWSERROR . '";
			}

			if ((document.options.nbrowbypage.value < 5) || (document.options.nbrowbypage.value > 50)) {
           		formok = false;
           		msg += "\\n' . _AM_USERINFO_NBROWBYPAGEERROR . '";
			}
			
            if (formok === false)
			{
            	alert(msg);
			}
			return formok;
		}
	</script>'; ?>

    <form name="options" action="./index.php?op=save-options" method="post" onsubmit="return verify();">

        <table border="0" align="center">
            <tr class='bg1'>
                <td colspan="2">
                    <hr align="center" noshade="noshade">
                    <div align="center"><?php echo _AM_USERINFO_GENERAL; ?></div>
                    <hr align="center" noshade="noshade">
                </td>
            </tr>
            <tr>
                <td align="right">
                    <?php echo _AM_USERINFO_FORMACTIV; ?> :
                </td>
                <td>
                    <select name="formactiv">
                        <?php
                        if ('false' == $userinfo_cfg['formactiv']) {
                            $chk = " selected='selected'";
                        } else {
                            unset($chk);
                        } ?>
                        <option value="true"><?php echo _AM_USERINFO_YES; ?></option>
                        <option value="false"<?php echo $chk; ?>><?php echo _AM_USERINFO_NO; ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">
                    <?php echo _AM_USERINFO_FORMINTACTVINFO; ?> :
                </td>
                <td>
                    <textarea name="inactivforminfo" cols="50" rows="3"><?php echo $userinfo_cfg['forminactivinfo']; ?></textarea>
                </td>
            </tr>
            <tr>
                <td align="right">
                    <?php echo _AM_USERINFO_FORMTITLE; ?> :
                </td>
                <td>
                    <input type="text" name="formtitle" size="30" maxlength="50" value="<?php echo $userinfo_cfg['formtitle']; ?>">
                </td>
            </tr>
            <tr>
                <td align="right">
                    <?php echo _AM_USERINFO_SELMIN; ?> :
                </td>
                <td>
                    <input type="text" name="selmin" size="3" maxlength="2" value="<?php echo $userinfo_cfg['selmin']; ?>">
                </td>
            </tr>
            <tr>
                <td align="right">
                    <?php echo _AM_USERINFO_SELMAX; ?> :
                </td>
                <td>
                    <input type="text" name="selmax" size="3" maxlength="2" value="<?php echo $userinfo_cfg['selmax']; ?>">
                </td>
            </tr>
            <tr>
                <td align="right">
                    <?php echo _AM_USERINFO_TEXTAREACOLS; ?> :
                </td>
                <td>
                    <input type="text" name="textareacols" size="3" maxlength="2" value="<?php echo $userinfo_cfg['textareacols']; ?>">
                </td>
            </tr>
            <tr>
                <td align="right">
                    <?php echo _AM_USERINFO_TEXTAREAROWS; ?> :
                </td>
                <td>
                    <input type="text" name="textarearows" size="3" maxlength="2" value="<?php echo $userinfo_cfg['textarearows']; ?>">
                </td>
            </tr>
            <tr>
                <td align="right">
                    <?php echo _AM_USERINFO_BARCOLOR; ?> :
                </td>
                <td>
                    <select name="couleur">
                        <option value="aqua"
                        <?php if ('aqua' == $userinfo_cfg['barcolor']) {
                            echo 'SELECTED';
                        }

    echo '>' . _AM_USERINFO_COLOR_AQUA; ?></option>
                        <option value="blue"
                        <?php if ('blue' == $userinfo_cfg['barcolor']) {
        echo 'SELECTED';
    }

    echo '>' . _AM_USERINFO_COLOR_BLUE; ?></option>
                        <option value="brown"
                        <?php if ('brown' == $userinfo_cfg['barcolor']) {
        echo 'SELECTED';
    }

    echo '>' . _AM_USERINFO_COLOR_BROWN; ?></option>
                        <option value="darkgreen"
                        <?php if ('darkgreen' == $userinfo_cfg['barcolor']) {
        echo 'SELECTED';
    }

    echo '>' . _AM_USERINFO_COLOR_DARKGREEN; ?></option>
                        <option value="gold"
                        <?php if ('gold' == $userinfo_cfg['barcolor']) {
        echo 'SELECTED';
    }

    echo '>' . _AM_USERINFO_COLOR_GOLD; ?></option>
                        <option value="green"
                        <?php if ('green' == $userinfo_cfg['barcolor']) {
        echo 'SELECTED';
    }

    echo '>' . _AM_USERINFO_COLOR_GREEN; ?></option>
                        <option value="grey"
                        <?php if ('grey' == $userinfo_cfg['barcolor']) {
        echo 'SELECTED';
    }

    echo '>' . _AM_USERINFO_COLOR_GREY; ?></option>
                        <option value="orange"
                        <?php if ('orange' == $userinfo_cfg['barcolor']) {
        echo 'SELECTED';
    }

    echo '>' . _AM_USERINFO_COLOR_ORANGE; ?></option>
                        <option value="pink"
                        <?php if ('pink' == $userinfo_cfg['barcolor']) {
        echo 'SELECTED';
    }

    echo '>' . _AM_USERINFO_COLOR_PINK; ?></option>
                        <option value="purple"
                        <?php if ('purple' == $userinfo_cfg['barcolor']) {
        echo 'SELECTED';
    }

    echo '>' . _AM_USERINFO_COLOR_PURPLE; ?></option>
                        <option value="red"
                        <?php if ('red' == $userinfo_cfg['barcolor']) {
        echo 'SELECTED';
    }

    echo '>' . _AM_USERINFO_COLOR_RED; ?></option>
                        <option value="yellow"
                        <?php if ('yellow' == $userinfo_cfg['barcolor']) {
        echo 'SELECTED';
    }

    echo '>' . _AM_USERINFO_COLOR_YELLOW; ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">
                    <?php echo _AM_USERINFO_NBROWBYPAGE; ?> :
                </td>
                <td>
                    <input type="text" name="nbrowbypage" size="3" maxlength="2" value="<?php echo $userinfo_cfg['nbrowbypage']; ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" name="submit" value="<?php echo _AM_USERINFO_SAVE; ?>">
                </td>
            </tr>
        </table>
    </form>

    <?php
    CloseTable();

    xoops_cp_footer();
}

//--------------------------------------------------------------------------
//------------------------- Sauvegarde des options -------------------------
//--------------------------------------------------------------------------

function save_options()
{
    global $_POST;

    $myts = MyTextSanitizer::getInstance();

    require_once '../cache/config.php';

    $userinfo_cfg['formactiv'] = $_POST['formactiv'];

    $userinfo_cfg['formtitle'] = $myts->addSlashes($_POST['formtitle']);

    $userinfo_cfg['selmin'] = $_POST['selmin'];

    $userinfo_cfg['selmax'] = $_POST['selmax'];

    $userinfo_cfg['textareacols'] = $_POST['textareacols'];

    $userinfo_cfg['textarearows'] = $_POST['textarearows'];

    $userinfo_cfg['forminactivinfo'] = $myts->addSlashes($_POST['inactivforminfo']);

    $userinfo_cfg['barcolor'] = $_POST['couleur'];

    $userinfo_cfg['nbrowbypage'] = $_POST['nbrowbypage'];

    save($userinfo_cfg);
}

//--------------------------------------------------------------------------
//------------------------- Sauvegarde des valeurs -------------------------
//--------------------------------------------------------------------------

function save($value)
{
    $content = "<?php\n";

    foreach ($value as $key => $entry) {
        $content .= "\$userinfo_cfg['$key'] = \"$entry\";" . "\n";
    }

    $content .= '?>';

    $fp = fopen('../cache/config.php', w);

    $write = fwrite($fp, trim($content));

    fclose($fp);

    if ($write > -1) {
        redirect_header('index.php?op=options', 1, _AM_USERINFO_CFGUPDATED);
    } else {
        redirect_header('index.php?op=options', 1, _AM_USERINFO_CFGERROR);
    }

    exit();
}

//------------------------------------------------------------------------------------------//

switch ($op) {
    case 'options':
        options();
        break;
    case 'save-options':
        save_options();
        break;
    default:
        setupindex();
        break;
}
include 'admin_footer.php';
?>
