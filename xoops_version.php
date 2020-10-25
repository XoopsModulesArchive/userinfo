<?php

$modversion['name'] = _MI_USERINFO_NAME;
$modversion['version'] = 0.04;
$modversion['description'] = _MI_USERINFO_DESC;
$modversion['author'] = 'Alfy';
$modversion['credits'] = 'Alfy@m-u-g.net';
$modversion['help'] = 'http://www.m-u-g.net/aide-userinfo';
$modversion['license'] = 'GPL see LICENSE';
$modversion['official'] = 'yes';
$modversion['image'] = 'userinfo_slogo.jpg';
$modversion['dirname'] = 'userinfo';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminpath'] = 'admin';
$modversion['adminmenu'] = 'admin/menu.php';
$modversion['adminindex'] = 'admin/index.php';

// Tables created by sql file (without prefix!)
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Main contents
$modversion['hasMain'] = 1;

// Blocks
$modversion['blocks'][1]['file'] = 'userinfo.php';
$modversion['blocks'][1]['name'] = _MI_USERINFO_BNAME;
$modversion['blocks'][1]['description'] = _MI_USERINFO_DESC;
$modversion['blocks'][1]['show_func'] = 'b_userinfo_show';
