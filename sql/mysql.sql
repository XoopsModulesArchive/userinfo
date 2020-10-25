CREATE TABLE userinfo_cat (
    idcat  SMALLINT(6) NOT NULL AUTO_INCREMENT,
    affcat SMALLINT(6) NOT NULL DEFAULT '0',
    nomcat TEXT        NOT NULL,
    comcat TEXT        NOT NULL,
    imgcat TEXT        NOT NULL,
    PRIMARY KEY (idcat)
)
    ENGINE = ISAM;

CREATE TABLE userinfo_form (
    idfield        SMALLINT(6) NOT NULL AUTO_INCREMENT,
    idcat          SMALLINT(6) NOT NULL DEFAULT '0',
    idval          SMALLINT(6) NOT NULL DEFAULT '0',
    valdefaut      SMALLINT(6) NOT NULL DEFAULT '0',
    valdefauttexte TEXT        NOT NULL,
    fieldtype      SMALLINT(2) NOT NULL DEFAULT '0',
    fieldname      TEXT        NOT NULL,
    PRIMARY KEY (idfield),
    KEY idcat (idcat, idval)
)
    ENGINE = ISAM;

CREATE TABLE userinfo_user (
    uid         TINYINT(4) NOT NULL DEFAULT '0',
    idfield     TINYINT(4) NOT NULL DEFAULT '0',
    valeur      TINYINT(4) NOT NULL DEFAULT '0',
    valeurtexte TEXT       NOT NULL
)
    ENGINE = ISAM;

CREATE TABLE userinfo_val (
    idval  SMALLINT(6) NOT NULL DEFAULT '0',
    nomval TEXT        NOT NULL,
    numval TINYINT(6)  NOT NULL DEFAULT '0',
    valeur TEXT        NOT NULL,
    KEY idval (idval)
)
    ENGINE = ISAM;

INSERT INTO userinfo_val
VALUES (0, 'Free', -1, 'Never erase !!');
