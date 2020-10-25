<?php
// ------------------------------------------------------------------------- //
// USERINFO module for Xoops : User profile for Xoops   					 //
// Original Author: Alfy													 //
// Author Website : http://www.m-u-g.net									 //
// ------------------------------------------------------------------------- //

define('_AM_USERINFO_LIST_FIELD_1', 'Liste déroulante');
define('_AM_USERINFO_LIST_FIELD_2', 'Boite liste');
define('_AM_USERINFO_LIST_FIELD_3', 'Boutons radio');
define('_AM_USERINFO_LIST_FIELD_4', 'Champ libre (multi-colonne)');
define('_AM_USERINFO_LIST_FIELD_5', 'Champ texte');

// General
define('_AM_USERINFO_CFGUPDATED', 'Configuration mise à jour avec succès!');
define('_AM_USERINFO_CFGERROR', "Soyez sûr d'avoir les droits en écriture!");
define('_AM_USERINFO_SAVE', 'Sauvegarder');
define('_AM_USERINFO_CANCEL', 'Annuler');
define('_AM_USERINFO_YES', 'Oui');
define('_AM_USERINFO_NO', 'Non');
define('_AM_USERINFO_DBUPDATED', 'Base de données modifiée');
define('_AM_USERINFO_DBERROR', 'Base de données non trouvée');
define('_AM_USERINFO_UPDATE', 'Mise à jour de la page');
define('_AM_USERINFO_RETURN', 'Retour');
define('_AM_USERINFO_VALIDATE', 'Valider');
define('_AM_USERINFO_EMPTY', '(vide)');
define('_AM_USERINFO_TITLEACTION', 'Outils');
define('_AM_USERINFO_GENERAL', 'Autres options.');
define('_AM_USERINFO_FORMACTIV', 'Formulaire activé');
define('_AM_USERINFO_FORMINTACTVINFO', 'Texte à afficher lorsque le formulaire est désactivé');
define('_AM_USERINFO_SELMIN', "Taille minimum de la boite 'liste'");
define('_AM_USERINFO_SELMAX', "Taille maximum de la boite 'liste'");
define('_AM_USERINFO_TEXTAREACOLS', "Nombre de colonnes pour le 'champ texte'");
define('_AM_USERINFO_TEXTAREAROWS', "Nombre de lignes pour le 'champ texte'");
define('_AM_USERINFO_FORMTITLE', 'Titre du formulaire');
define('_AM_USERINFO_CONFIG_MSGERROR', 'Erreur dans la configuration');
define('_AM_USERINFO_FORMTITLEERROR', 'Le titre du formulaire ne peut être vide');
define('_AM_USERINFO_SELMINERROR', "La boite 'liste' doit faire minimum 3 lignes");
define('_AM_USERINFO_SELSIZEERROR', "La différence entre la valeur min et max de la boite 'liste' doit être minimum de 3");
define('_AM_USERINFO_TEXTAREACOLSERROR', 'Le champ de texte doit faire minimum 3 colonnes');
define('_AM_USERINFO_TEXTAREAROWSERROR', 'Le champ de texte doit faire minimum 3 lignes');
define('_AM_USERINFO_NBROWBYPAGEERROR', 'Le nombre de ligne doit être compris entre 5 et 50.');
define('_AM_USERINFO_LINESPERPAGE', 'Lignes par page');
define('_AM_USERINFO_BARCOLOR', 'Couleur des barres (statistiques)');
define('_AM_USERINFO_NBROWBYPAGE', 'Nombre de ligne par page (statistiques)');
define('_AM_USERINFO_WAIT', 'Patientez SVP...');

// définition des couleurs
define('_AM_USERINFO_COLOR_AQUA', 'Turquoise');
define('_AM_USERINFO_COLOR_BLUE', 'Bleu');
define('_AM_USERINFO_COLOR_BROWN', 'Marron');
define('_AM_USERINFO_COLOR_DARKGREEN', 'Vert Foncé');
define('_AM_USERINFO_COLOR_GOLD', 'Or');
define('_AM_USERINFO_COLOR_GREEN', 'Vert');
define('_AM_USERINFO_COLOR_GREY', 'Gris');
define('_AM_USERINFO_COLOR_ORANGE', 'Orange');
define('_AM_USERINFO_COLOR_PINK', 'Rose');
define('_AM_USERINFO_COLOR_PURPLE', 'Violet');
define('_AM_USERINFO_COLOR_RED', 'Rouge');
define('_AM_USERINFO_COLOR_YELLOW', 'Jaune');

// définition des titres dans le module de gestion
define('_AM_USERINFO_GENERAL', 'Options générales');
define('_AM_USERINFO_CATEGORIES', 'Gestion des catégories');
define('_AM_USERINFO_VALEURS', 'Gestion des valeurs');
define('_AM_USERINFO_FORM', 'Gestion du formulaire');

// définition des titres dans le module des catégories
define('_AM_USERINFO_TITLECAT', 'Catégories');
define('_AM_USERINFO_CAT', 'Catégorie : ');
define('_AM_USERINFO_TITTLEMODCAT', "Modification d'une catégorie");
define('_AM_USERINFO_CATERASE', 'Effacer la catégorie');
define('_AM_USERINFO_CATMODIF', 'Modifier la catégorie');
define('_AM_USERINFO_TITLEORD', "Ordre d'affichage");
define('_AM_USERINFO_CATUP', 'Monter');
define('_AM_USERINFO_CATDOWN', 'Descendre');
define('_AM_USERINFO_CATMODTITTLE', 'Titre');
define('_AM_USERINFO_COMMENT', 'Commentaires');
define('_AM_USERINFO_CATMODIMG', 'Image');
define('_AM_USERINFO_CATIMGINFO', "Indiquer le nom de l'image se trouvant dans ");
define('_AM_USERINFO_NOIMAGE', "Pas d'image définie");
define('_AM_USERINFO_CATNEWTITTLE', 'Nouvelle catégorie');
define('_AM_USERINFO_CATEMPTY_NOTIFY', '<br><font color="#ff0000">ATTENTION !, nom de catégorie vide</font>');
define('_AM_USERINFO_DEMANDERASECATEGORIE', '<font color="#ff0000">Voulez vous vraiment effacer la catégorie ?</font>');
define('_AM_USERINFO_ERRORERASECAT', "<font color=\"#ff0000\">Vous ne pouvez pas effacer cette catégorie car elle est en cours d'utilisation<br>dans le formulaire !</font>");
define('_AM_USERINFO_CAT_MSGERROR', 'Erreur dans la catégorie');
define('_AM_USERINFO_CAT_TITLEERROR', 'Le titre de la catégorie ne peut être vide.');

// définition des titres dans le modules des valeurs
define('_AM_USERINFO_VAL', 'Valeur');
define('_AM_USERINFO_TITTLEMODVAL', "Modification d'une valeur");
define('_AM_USERINFO_TITTLEADDVAL', 'Ajouter une valeur');
define('_AM_USERINFO_TITTLEERASEVAL', 'Effacer une valeur');
define('_AM_USERINFO_TITLEVAL', 'Nom');
define('_AM_USERINFO_NEWVAL', 'Nouvelle valeur');
define('_AM_USERINFO_VIEWELEMENT', 'Afficher les éléments');
define('_AM_USERINFO_AFFELEMENT', 'Elément :');
define('_AM_USERINFO_VALMODTITTLE', 'Nom de la valeur');
define('_AM_USERINFO_TITTLEADDELEMENT', 'Ajouter un élément');
define('_AM_USERINFO_TITTLEADDELEMENT2', 'Ajouter un élément dans la valeur : ');
define('_AM_USERINFO_TITTLEERASEELEMENT', "Effacer l'élément");
define('_AM_USERINFO_TITTLEADDELEMENT', "Nom de l'élément");
define('_AM_USERINFO_TITTLEVALDEFAULT', 'Valeur par défaut');
define('_AM_USERINFO_VALEMPTY_NOTIFY', '<br><font color="#ff0000">ATTENTION !, nom de valeur vide</font>');
define('_AM_USERINFO_ELELMENTEMPTY_NOTIFY', "<br><font color=\"#ff0000\">ATTENTION !, nom de l'élément vide</font>");
define('_AM_USERINFO_VALEMPTY', "<br><font color=\"#ff0000\">ATTENTION !, un nom d'élément est vide</font>");
define('_AM_USERINFO_DEMANDERASEELEMENT', "<font color=\"#ff0000\">Voulez vous vraiment effacer l'élèment ?</font>");
define('_AM_USERINFO_DEMANDERASEVALEUR', '<font color="#ff0000">Voulez vous vraiment effacer la valeur et tous ses élèment ?</font>');
define('_AM_USERINFO_ERRORERASEVAL', "<font color=\"#ff0000\">Vous ne pouvez pas effacer ce champ car il est en cours d'utilisation<br>dans le formulaire !</font>");
define('_AM_USERINFO_VAL_MSGERROR', 'Erreur dans la valeur');
define('_AM_USERINFO_VAL_TITLEERROR', 'Le titre de la valeur ne peut être vide.');
define('_AM_USERINFO_ELE_MSGERROR', "Erreur dans l'élément");
define('_AM_USERINFO_ELE_TITLEERROR', "Le titre de l'élément ne peut être vide");

// définition des titres dans le modules du formulaire
define('_AM_USERINFO_TITLEFIELD', 'Champ');
define('_AM_USERINFO_NEWFIELD', 'Nouveau champ');
define('_AM_USERINFO_TITTLEMODFIELD', "Modification d'un champ");
define('_AM_USERINFO_TITTLEFIELDTYPE', 'Type de champ');
define('_AM_USERINFO_CHOOSE_A_VALUE', 'Choisissez une valeur');
define('_AM_USERINFO_FREEFIELD', 'Champ libre');
define('_AM_USERINFO_TITTLEADDFIELD', 'Ajouter un champ');
define('_AM_USERINFO_FORM_MSGERROR', 'Erreur dans le formulaire');
define('_AM_USERINFO_FIELDNAMEERROR', 'Nom du champ vide');
define('_AM_USERINFO_FIELDTYPEERROR', 'Choisissez un type de champ');
define('_AM_USERINFO_FIELDVALERROR', 'Choisissez une valeur');
define('_AM_USERINFO_FIELDCATERROR', 'Choisissez une catégorie');
define('_AM_USERINFO_TITTLEERASEFIELD', "Suppression d'un champ");
define('_AM_USERINFO_DEMANDERASEFIELD', 'Voulez vraiment supprimer ce champ ?');
define('_AM_USERINFO_FORMVIEW', 'Vue du formulaire');
define('_AM_USERINFO_TITTLETEXTSIZE', 'Taille : ');
