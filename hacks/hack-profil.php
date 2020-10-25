// *************************************************
// *** Hack pour affichage module Userinfo (Alfy)***
// *************************************************
require XOOPS_ROOT_PATH . "/modules/userinfo/cache/config.php";
require_once XOOPS_ROOT_PATH . "/modules/userinfo/language/".$xoopsConfig['language']."/main.php";

if ($userinfo_cfg['formactiv'] == "true")
{
$curuserid = $thisUser->getVar("uid");
$curusername = $thisUser->getVar("uname");
echo "
<HR>";
echo "
<table border=\"0\" align=\"center\">
    <tr class='bg1'>
        <td colspan=\"4\">
            <div align=\"center\">
                <b><h4>"._MA_USERINFO_FORMTITLE.$curusername."</b><br>
                <b>".$myts->displayTarea($userinfo_cfg['formtitle'])."</h4></b></div>
            <form action=\"".XOOPS_URL."/modules/userinfo/index.php?modificationform=true\" method=\"post\">
                <input type=\"hidden\" name=\"uid\" value=\"".$curuserid."\">
        </td>
    </tr>
    <tr>
        <td colspan=\"4\">";
            require_once XOOPS_ROOT_PATH . "/modules/userinfo/formbody.php";
            echo "
        </td>
    </tr>
    <tr>
        <td align=\"center\">";
            if ($xoopsUser->uid() == $curuserid) echo "<input type=\"submit\" value=\""._MA_USERINFO_FORMMODIFTITLE."\">";
            echo "</form>
        </td>
    </tr>
</table>";
} else {
echo "
<center><p class=\"bg2\">"._MA_USERINFO_FORMNOTACTIV."</p></center><br>
<HR><br>".$myts->displayTarea($userinfo_cfg['forminactivinfo']."
<HR>");
}

// ************************************************
// ************************************************
// ************************************************
