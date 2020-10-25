<?php
// ------------------------------------------------------------------------- //
// USERINFO module for Xoops : User profile for Xoops //
// Original Author: Alfy //
// Author Website : http://www.m-u-g.net //
// ------------------------------------------------------------------------- //
define('_AM_USERINFO_LIST_FIELD_1', 'Drop down list');
define('_AM_USERINFO_LIST_FIELD_2', 'List box');
define('_AM_USERINFO_LIST_FIELD_3', 'Radio button');
define('_AM_USERINFO_LIST_FIELD_4', 'Free text (multicolon)');
define('_AM_USERINFO_LIST_FIELD_5', 'Free text');
// General
define('_AM_USERINFO_CFGUPDATED', 'Configuration updated !');
define('_AM_USERINFO_CFGERROR', "I don't have right to write data!");
define('_AM_USERINFO_SAVE', 'Save');
define('_AM_USERINFO_CANCEL', 'Cancel');
define('_AM_USERINFO_YES', 'Yes');
define('_AM_USERINFO_NO', 'No');
define('_AM_USERINFO_DBUPDATED', 'Database modified');
define('_AM_USERINFO_DBERROR', 'Database not found');
define('_AM_USERINFO_UPDATE', 'Page updating');
define('_AM_USERINFO_RETURN', 'Back');
define('_AM_USERINFO_VALIDATE', 'Validate');
define('_AM_USERINFO_EMPTY', '(empty)');
define('_AM_USERINFO_TITLEACTION', 'Tools');
define('_AM_USERINFO_GENERAL', 'Other options.');
define('_AM_USERINFO_FORMACTIV', 'Form activated');
define('_AM_USERINFO_FORMINTACTVINFO', 'Text to print when the form is deactivated');
define('_AM_USERINFO_SELMIN', "Minimum size of the 'list box'");
define('_AM_USERINFO_SELMAX', "Maximum size of the 'list box'");
define('_AM_USERINFO_TEXTAREACOLS', 'Number of caracters per line for the text-field');
define('_AM_USERINFO_TEXTAREAROWS', 'Number of rows for the text-field');
define('_AM_USERINFO_FORMTITLE', 'Title of the form');
define('_AM_USERINFO_CONFIG_MSGERROR', 'Error in the configuration');
define('_AM_USERINFO_FORMTITLEERROR', "The title of the form can't be empty");
define('_AM_USERINFO_SELMINERROR', 'The list box must have minimum 3 lines');
define('_AM_USERINFO_SELSIZEERROR', 'The difference between min and max of the list box must be minimum 3');
define('_AM_USERINFO_TEXTAREACOLSERROR', 'The text field must have 3 caracters per line minimum');
define('_AM_USERINFO_TEXTAREAROWSERROR', 'The text field must have 3 lines minimum');
define('_AM_USERINFO_NBROWBYPAGEERROR', 'The number of line can be selected between 5 and 50');
define('_AM_USERINFO_LINESPERPAGE', 'Lines per page');
define('_AM_USERINFO_BARCOLOR', 'Bar color (stats.)');
define('_AM_USERINFO_NBROWBYPAGE', 'Number of line by page (stats.)');
define('_AM_USERINFO_WAIT', 'Wait please ...');
// définition des couleurs
define('_AM_USERINFO_COLOR_AQUA', 'Aqua');
define('_AM_USERINFO_COLOR_BLUE', 'Blue');
define('_AM_USERINFO_COLOR_BROWN', 'Brown');
define('_AM_USERINFO_COLOR_DARKGREEN', 'Dark Green');
define('_AM_USERINFO_COLOR_GOLD', 'Gold');
define('_AM_USERINFO_COLOR_GREEN', 'Green');
define('_AM_USERINFO_COLOR_GREY', 'Grey');
define('_AM_USERINFO_COLOR_ORANGE', 'Orange');
define('_AM_USERINFO_COLOR_PINK', 'Pink');
define('_AM_USERINFO_COLOR_PURPLE', 'Purple');
define('_AM_USERINFO_COLOR_RED', 'Red');
define('_AM_USERINFO_COLOR_YELLOW', 'Yellow');
// définition des titres dans le module de gestion
define('_AM_USERINFO_GENERAL', 'General Options');
define('_AM_USERINFO_categoryS', 'categorys');
define('_AM_USERINFO_VALEURS', 'Values');
define('_AM_USERINFO_FORM', 'Form');
// définition des titres dans le module des catégories
define('_AM_USERINFO_TITLECAT', 'categorys');
define('_AM_USERINFO_CAT', 'category : ');
define('_AM_USERINFO_TITTLEMODCAT', 'category modification');
define('_AM_USERINFO_CATERASE', 'Delete a category');
define('_AM_USERINFO_CATMODIF', 'Modify a category');
define('_AM_USERINFO_TITLEORD', 'Order');
define('_AM_USERINFO_CATUP', 'Up');
define('_AM_USERINFO_CATDOWN', 'Down');
define('_AM_USERINFO_CATMODTITTLE', 'Title');
define('_AM_USERINFO_COMMENT', 'Comments');
define('_AM_USERINFO_CATMODIMG', 'Picture');
define('_AM_USERINFO_CATIMGINFO', 'Type the name of the picture in ');
define('_AM_USERINFO_NOIMAGE', 'No picture');
define('_AM_USERINFO_CATNEWTITTLE', 'New category');
define('_AM_USERINFO_CATEMPTY_NOTIFY', "<br><font color=\"#ff0000\">The name of the category can't be empty</font>");
define('_AM_USERINFO_DEMANDERASEcategory', '<font color="#ff0000">Do you really want to delete this category ?</font>');
define('_AM_USERINFO_ERRORERASECAT', "<font color=\"#ff0000\">You can't delete this category, this category is used<br>in the form !</font>");
define('_AM_USERINFO_CAT_MSGERROR', 'Error in the category');
define('_AM_USERINFO_CAT_TITLEERROR', "The title of the category can't be empty.");
// définition des titres dans le modules des valeurs
define('_AM_USERINFO_VAL', 'Value');
define('_AM_USERINFO_TITTLEMODVAL', 'Value modification');
define('_AM_USERINFO_TITTLEADDVAL', 'Add a value');
define('_AM_USERINFO_TITTLEERASEVAL', 'Delete a value');
define('_AM_USERINFO_TITLEVAL', 'Name');
define('_AM_USERINFO_NEWVAL', 'New value');
define('_AM_USERINFO_VIEWELEMENT', 'See the elements');
define('_AM_USERINFO_AFFELEMENT', 'Element :');
define('_AM_USERINFO_VALMODTITTLE', 'Name of the value');
define('_AM_USERINFO_TITTLEADDELEMENT', 'Add an element');
define('_AM_USERINFO_TITTLEADDELEMENT2', 'Add a element in the value : ');
define('_AM_USERINFO_TITTLEERASEELEMENT', 'Delete the element');
define('_AM_USERINFO_TITTLEADDELEMENT', 'Name of the element');
define('_AM_USERINFO_TITTLEVALDEFAULT', 'Default value');
define('_AM_USERINFO_VALEMPTY_NOTIFY', "<br><font color=\"#ff0000\">Name of the value can't be empty</font>");
define('_AM_USERINFO_ELELMENTEMPTY_NOTIFY', "<br><font color=\"#ff0000\">Name of the element can't be emtpy</font>");
define('_AM_USERINFO_VALEMPTY', "<br><font color=\"#ff0000\">Name of an element can't be empty</font>");
define('_AM_USERINFO_DEMANDERASEELEMENT', '<font color="#ff0000">Do you really want to delete this element ?</font>');
define('_AM_USERINFO_DEMANDERASEVALEUR', "<font color=\"#ff0000\">Do you really want to delete this value and all it's element ?</font>");
define('_AM_USERINFO_ERRORERASEVAL', "<font color=\"#ff0000\">You can't delete this field, this value is used <br> in the form!</font>");
define('_AM_USERINFO_VAL_MSGERROR', 'Error in the value');
define('_AM_USERINFO_VAL_TITLEERROR', "The title of the value can't be empty.");
define('_AM_USERINFO_ELE_MSGERROR', 'Error in the element');
define('_AM_USERINFO_ELE_TITLEERROR', "The title of the element can't be empty");
// définition des titres dans le modules du formulaire
define('_AM_USERINFO_TITLEFIELD', 'Field');
define('_AM_USERINFO_NEWFIELD', 'New field');
define('_AM_USERINFO_TITTLEMODFIELD', 'Field modification');
define('_AM_USERINFO_TITTLEFIELDTYPE', 'Type of field');
define('_AM_USERINFO_CHOOSE_A_VALUE', 'Choose a value');
define('_AM_USERINFO_FREEFIELD', 'Free field');
define('_AM_USERINFO_TITTLEADDFIELD', 'Add a field');
define('_AM_USERINFO_FORM_MSGERROR', 'Error in the form');
define('_AM_USERINFO_FIELDNAMEERROR', 'Name of the field is empty');
define('_AM_USERINFO_FIELDTYPEERROR', 'Choose the type of the field');
define('_AM_USERINFO_FIELDVALERROR', 'Choose a value');
define('_AM_USERINFO_FIELDCATERROR', 'Choose a category');
define('_AM_USERINFO_TITTLEERASEFIELD', 'Delete a field');
define('_AM_USERINFO_DEMANDERASEFIELD', 'Do you really want to delete this field ?');
define('_AM_USERINFO_FORMVIEW', 'See the form');
define('_AM_USERINFO_TITTLETEXTSIZE', 'Size : ');
