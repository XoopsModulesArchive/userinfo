<?php

include 'header.php';
require_once XOOPS_ROOT_PATH . '/class/module.textsanitizer.php';
$myts = MyTextSanitizer::getInstance();
global $_POST;
global $champ;
global $repuser;
global $fieldtype;
global $uid;

foreach ($champ as $champ_reponse => $reponse) {
    //echo "pour le champ : ".$champ_reponse." -- la réponse est : ".$reponse." -- repuser est : ".$repuser[$champ_reponse]." -- type field : ".$fieldtype[$champ_reponse]."<br>";

    if (0 == $repuser[$champ_reponse]) {
        //Ajout de la ligne dans la base userinfo_user

        if (('4' == $fieldtype[$champ_reponse]) || ('5' == $fieldtype[$champ_reponse])) {
            //Champ texte

            $reponse = $myts->addSlashes($reponse);

            $sql = 'INSERT ' . $xoopsDB->prefix('userinfo_user') . ' (uid, idfield, valeur, valeurtexte) VALUES (' . "'" . $uid . "'," . "'" . $champ_reponse . "'," . "''," . "'" . $reponse . "');";

        //echo $sql."<br>";
        } elseif (-1 != $reponse) {
            //Champ numérique

            $sql = 'INSERT ' . $xoopsDB->prefix('userinfo_user') . ' (uid, idfield, valeur, valeurtexte) VALUES (' . "'" . $uid . "'," . "'" . $champ_reponse . "'," . "'" . $reponse . "'," . "'');";

            //echo $sql."<br>";
        }
    } else {
        //Modification de la ligne dans la base userinfo_user

        if (('4' == $fieldtype[$champ_reponse]) || ('5' == $fieldtype[$champ_reponse])) {
            //Champ texte

            $reponse = $myts->addSlashes($reponse);

            $sql = 'UPDATE ' . $xoopsDB->prefix('userinfo_user') . ' SET ' . "valeurtexte='" . $reponse . "'" . " WHERE uid = '" . $uid . "' AND idfield = '" . $champ_reponse . "';";

        //echo $sql."<br>";
        } elseif (-1 != $reponse) {
            //Champ numérique

            $sql = 'UPDATE ' . $xoopsDB->prefix('userinfo_user') . ' SET ' . "valeur='" . $reponse . "'" . " WHERE uid = '" . $uid . "' AND idfield = '" . $champ_reponse . "';";

        //echo $sql."<br>";
        } else {
            $sql = 'DELETE FROM ' . $xoopsDB->prefix('userinfo_user') . " WHERE uid = '" . $uid . "' AND idfield = '" . $champ_reponse . "';";
        }
    }

    if ($sql) {
        if (!$result = $xoopsDB->query($sql)) {
            redirect_header('index.php', 2, _MA_USERINFO_DBERROR);

            exit();
        }

        $sql = '';
    }
}
redirect_header('index.php', 2, _MA_USERINFO_DBUPDATED);
exit();
require XOOPS_ROOT_PATH . '/footer.php';
