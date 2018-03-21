CREATE TABLE CMS_SETTINGS (
  ID     BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  SKEY   VARCHAR(250)        NOT NULL DEFAULT '',
  SVALUE LONGTEXT
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE CMS_USERS (
  ID                BIGINT(20)   NOT NULL    AUTO_INCREMENT PRIMARY KEY,
  NAME              VARCHAR(250) NOT NULL    DEFAULT '',
  PASSWORD          VARCHAR(255) NOT NULL,
  FIRST_NAME        VARCHAR(250) NOT NULL    DEFAULT '',
  LAST_NAME         VARCHAR(250) NOT NULL    DEFAULT '',
  EMAIL             VARCHAR(100)             DEFAULT '',
  PHONE             VARCHAR(30)              DEFAULT '',
  LINK              VARCHAR(250)             DEFAULT '',
  GENDER            VARCHAR(50)              DEFAULT '',
  PICTURE           LONGBLOB,
  PICTURE_PATH      VARCHAR(255),
  USER_STATUS       INT(11)      NOT NULL    DEFAULT 0,
  ACTIVATION_DATE   DATETIME     NOT NULL,
  MODIFICATION_DATE TIMESTAMP    NOT NULL    DEFAULT CURRENT_TIMESTAMP
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE CMS_USER_META (
  ID         BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  USER_ID    BIGINT(20)          NOT NULL DEFAULT 0,
  META_KEY   VARCHAR(255)                 DEFAULT NULL,
  META_VALUE LONGTEXT,
  FOREIGN KEY (USER_ID) REFERENCES CMS_USERS (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE CMS_USER_META
  ADD INDEX USER_IND (USER_ID);

CREATE TABLE CMS_POSTS (
  ID                BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  TITLE             VARCHAR(255),
  FRIENDLY_TITLE    VARCHAR(255),
  ACTIVATION_DATE   DATETIME            NOT NULL,
  MODIFICATION_DATE TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
  STATE             INT(11)                      DEFAULT 0,
  USER_ID           BIGINT(20),
  FOREIGN KEY (USER_ID) REFERENCES CMS_USERS (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE CMS_POSTS
  ADD INDEX USER_P_IND (USER_ID);

CREATE TABLE CMS_POST_DETAILS (
  ID         BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  POST_ID    BIGINT(20) UNSIGNED NOT NULL,
  SEQUENCE   INT,
  TEXT       LONGTEXT,
  IMAGE_PATH VARCHAR(255),
  IMAGE      LONGBLOB,
  FOREIGN KEY (POST_ID) REFERENCES CMS_POSTS (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE CMS_POST_DETAILS
  ADD INDEX POST_IND (POST_ID);


CREATE TABLE CMS_COMMENTS (
  ID      BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  COMMENT LONGTEXT,
  DATE    TIMESTAMP                    DEFAULT CURRENT_TIMESTAMP,
  STATE   INT(11)                      DEFAULT 0,
  USER_ID BIGINT(20),
  POST_ID BIGINT(20) UNSIGNED,
  FOREIGN KEY (POST_ID) REFERENCES CMS_POSTS (ID)
    ON DELETE CASCADE,
  FOREIGN KEY (USER_ID) REFERENCES CMS_USERS (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE CMS_COMMENTS
  ADD INDEX POST_C_IND (POST_ID);

ALTER TABLE CMS_COMMENTS
  ADD INDEX USER_C_IND (USER_ID);


CREATE TABLE CMS_USER_GROUPS (
  ID     BIGINT(20) NOT NULL    AUTO_INCREMENT PRIMARY KEY,
  NAME   VARCHAR(255)           DEFAULT NULL,
  STATUS INT(11)    NOT NULL    DEFAULT 0
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE CMS_USER_GROUPS_META (
  ID         BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  GROUP_ID   BIGINT(20) NOT NULL,
  META_KEY   VARCHAR(255)        DEFAULT NULL,
  META_VALUE LONGTEXT,
  FOREIGN KEY (GROUP_ID) REFERENCES CMS_USER_GROUPS (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE CMS_USER_GROUPS_META
  ADD INDEX GROUP_IND (GROUP_ID);

CREATE TABLE CMS_UGR_ASSOC (
  USER_ID  BIGINT(20) NOT NULL,
  GROUP_ID BIGINT(20) NOT NULL,
  PRIMARY KEY (USER_ID, GROUP_ID),
  FOREIGN KEY (USER_ID) REFERENCES CMS_USERS (ID)
    ON DELETE CASCADE,
  FOREIGN KEY (GROUP_ID) REFERENCES CMS_USER_GROUPS (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE CMS_ACCESS_RIGHTS (
  ID   BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  NAME VARCHAR(255)        DEFAULT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE CMS_ACCESS_RIGHTS_META (
  ID         BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ACCESS_ID  BIGINT(20) NOT NULL,
  META_KEY   VARCHAR(255)        DEFAULT NULL,
  META_VALUE LONGTEXT,
  FOREIGN KEY (ACCESS_ID) REFERENCES CMS_ACCESS_RIGHTS (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE CMS_ACCESS_RIGHTS_META
  ADD INDEX ACC_IND (ACCESS_ID);

CREATE TABLE CMS_ACR_ASSOC (
  ACC_ID   BIGINT(20) NOT NULL,
  USER_ID  BIGINT(20) DEFAULT NULL,
  GROUP_ID BIGINT(20) DEFAULT NULL,
  #   PRIMARY KEY (ACC_ID, USER_ID, GROUP_ID),
  FOREIGN KEY (ACC_ID) REFERENCES CMS_ACCESS_RIGHTS (ID)
    ON DELETE CASCADE,
  FOREIGN KEY (USER_ID) REFERENCES CMS_USERS (ID)
    ON DELETE CASCADE,
  FOREIGN KEY (GROUP_ID) REFERENCES CMS_USER_GROUPS (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO CMS_USERS (NAME, PASSWORD, FIRST_NAME, LAST_NAME, EMAIL, PHONE, LINK, GENDER, PICTURE, USER_STATUS, ACTIVATION_DATE)
VALUES
  ('admin', '$2y$10$6g91rGCWuZ9zbiJV2YDzeOgmxlyCKauJejWUVJtWPJirKngbSeyVu', 'admin', 'admin', 'admin@admin.gr', '',
            '', '', '', 1, NOW());

INSERT INTO CMS_USER_GROUPS (NAME, STATUS) VALUES ('admin', 1);
INSERT INTO CMS_USER_GROUPS_META (GROUP_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Admin users of system');

INSERT INTO CMS_USER_GROUPS (NAME, STATUS) VALUES ('super-user', 1);
INSERT INTO CMS_USER_GROUPS_META (GROUP_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Super users has advanced access to the system');

INSERT INTO CMS_USER_GROUPS (NAME, STATUS) VALUES ('editor', 1);
INSERT INTO CMS_USER_GROUPS_META (GROUP_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Editor can create and edit content');

INSERT INTO CMS_USER_GROUPS (NAME, STATUS) VALUES ('viewer', 1);
INSERT INTO CMS_USER_GROUPS_META (GROUP_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Viewer is just visiting the site');

INSERT INTO CMS_UGR_ASSOC (USER_ID, GROUP_ID) VALUES ((SELECT ID
                                                      FROM CMS_USERS
                                                      WHERE NAME = 'admin'), ((SELECT ID
                                                                               FROM CMS_USER_GROUPS
                                                                               WHERE NAME = 'admin')));

INSERT INTO CMS_ACCESS_RIGHTS (NAME) VALUES ('ALL');
INSERT INTO CMS_ACCESS_RIGHTS_META (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to all features of system');
INSERT INTO CMS_ACCESS_RIGHTS (NAME) VALUES ('PAGES_SECTION');
INSERT INTO CMS_ACCESS_RIGHTS_META (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to pages section');
INSERT INTO CMS_ACCESS_RIGHTS (NAME) VALUES ('POSTS_SECTION');
INSERT INTO CMS_ACCESS_RIGHTS_META (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to posts section');
INSERT INTO CMS_ACCESS_RIGHTS (NAME) VALUES ('USER_SECTION');
INSERT INTO CMS_ACCESS_RIGHTS_META (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to user section');
INSERT INTO CMS_ACCESS_RIGHTS (NAME) VALUES ('SETTINGS_SECTION');
INSERT INTO CMS_ACCESS_RIGHTS_META (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to settings section');

INSERT INTO CMS_ACR_ASSOC (ACC_ID, GROUP_ID) VALUES ((SELECT ID
                                                     FROM CMS_ACCESS_RIGHTS
                                                     WHERE NAME = 'ALL'), ((SELECT ID
                                                                            FROM
                                                                              CMS_USER_GROUPS
                                                                            WHERE
                                                                              NAME =
                                                                              'admin')));

INSERT INTO CMS_ACR_ASSOC (ACC_ID, GROUP_ID) VALUES ((SELECT ID
                                                     FROM CMS_ACCESS_RIGHTS
                                                     WHERE NAME = 'POSTS_SECTION'), ((SELECT ID
                                                                                      FROM
                                                                                        CMS_USER_GROUPS
                                                                                      WHERE
                                                                                        NAME =
                                                                                        'editor')));

CREATE TABLE CMS_VISITORS (
  ID              BIGINT(20)   NOT NULL    AUTO_INCREMENT PRIMARY KEY,
  FB_ID           VARCHAR(50)  NOT NULL,
  FIRST_NAME      VARCHAR(250) NOT NULL    DEFAULT '',
  LAST_NAME       VARCHAR(250) NOT NULL    DEFAULT '',
  EMAIL           VARCHAR(100)             DEFAULT '',
  USER_STATUS     INT(11)      NOT NULL    DEFAULT 1,
  INSERTION_DATE  DATETIME,
  LAST_LOGIN_DATE DATETIME
);

INSERT INTO CMS_SETTINGS (SKEY, SVALUE) VALUES ('blog.enabled', 'off');
INSERT INTO CMS_SETTINGS (SKEY, SVALUE) VALUES ('blog.style', 'grid');
INSERT INTO CMS_SETTINGS (SKEY, SVALUE)
VALUES ('email.addresses', 'pkasfiki@gmail.com;info@fitnesshousebypenny.gr;natsaros@hotmail.com');