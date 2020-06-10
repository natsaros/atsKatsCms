CREATE TABLE cms_settings (
  ID     BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  SKEY   VARCHAR(250)        NOT NULL DEFAULT '',
  SVALUE LONGTEXT
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE cms_users (
  ID                    BIGINT(20)   NOT NULL    AUTO_INCREMENT PRIMARY KEY,
  NAME                  VARCHAR(250) NOT NULL    DEFAULT '',
  PASSWORD              VARCHAR(255) NOT NULL,
  FIRST_NAME            VARCHAR(250) NOT NULL    DEFAULT '',
  LAST_NAME             VARCHAR(250) NOT NULL    DEFAULT '',
  EMAIL                 VARCHAR(100)             DEFAULT '',
  PHONE                 VARCHAR(30)              DEFAULT '',
  LINK                  VARCHAR(250)             DEFAULT '',
  GENDER                VARCHAR(50)              DEFAULT '',
  PICTURE               LONGBLOB,
  PICTURE_PATH          VARCHAR(255),
  USER_STATUS           INT(11)      NOT NULL    DEFAULT 0,
  FORCE_CHANGE_PASSWORD INT(11)      NOT NULL    DEFAULT 0,
  ACTIVATION_DATE       DATETIME     NOT NULL,
  MODIFICATION_DATE     TIMESTAMP    NOT NULL    DEFAULT CURRENT_TIMESTAMP
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE cms_user_meta (
  ID         BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  USER_ID    BIGINT(20)          NOT NULL DEFAULT 0,
  META_KEY   VARCHAR(255)                 DEFAULT NULL,
  META_VALUE LONGTEXT,
  FOREIGN KEY (USER_ID) REFERENCES cms_users (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE cms_user_meta
  ADD INDEX USER_IND (USER_ID);

CREATE TABLE cms_posts (
  ID                BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  TITLE             VARCHAR(255),
  FRIENDLY_TITLE    VARCHAR(255),
  ACTIVATION_DATE   DATETIME            NOT NULL,
  MODIFICATION_DATE TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
  STATE             INT(11)                      DEFAULT 0,
  USER_ID           BIGINT(20),
  FOREIGN KEY (USER_ID) REFERENCES cms_users (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE cms_posts
  ADD INDEX USER_P_IND (USER_ID);

CREATE TABLE cms_post_details (
  ID         BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  POST_ID    BIGINT(20) UNSIGNED NOT NULL,
  SEQUENCE   INT,
  TEXT       LONGTEXT,
  IMAGE_PATH VARCHAR(255),
  IMAGE      LONGBLOB,
  FOREIGN KEY (POST_ID) REFERENCES cms_posts (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE cms_post_details
  ADD INDEX POST_IND (POST_ID);

CREATE TABLE cms_product_categories (
  ID                 BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  TITLE              VARCHAR(255),
  TITLE_EN           VARCHAR(255),
  FRIENDLY_TITLE     VARCHAR(255),
  DESCRIPTION        LONGTEXT,
  DESCRIPTION_EN     LONGTEXT,
  IMAGE_PATH         VARCHAR(255),
  IMAGE              LONGBLOB,
  ACTIVATION_DATE    DATETIME            NOT NULL,
  MODIFICATION_DATE  TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
  STATE              INT(11)                      DEFAULT 0,
  PARENT_CATEGORY    INT(11)                      DEFAULT 0,
  PARENT_CATEGORY_ID BIGINT(20)                   DEFAULT 0,
  USER_ID            BIGINT(20),
  FOREIGN KEY (USER_ID) REFERENCES cms_users (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE cms_product_categories
  ADD INDEX USER_PC_IND (USER_ID);

CREATE TABLE cms_products (
  ID                BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  TITLE             VARCHAR(255),
  TITLE_EN          VARCHAR(255),
  FRIENDLY_TITLE    VARCHAR(255),
  ACTIVATION_DATE   DATETIME            NOT NULL,
  MODIFICATION_DATE TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
  STATE             INT(11)                      DEFAULT 0,
  USER_ID           BIGINT(20),
  FOREIGN KEY (USER_ID) REFERENCES cms_users (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE cms_products
  ADD INDEX USER_PR_IND (USER_ID);

CREATE TABLE cms_product_details (
  ID                            BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  PRODUCT_ID                    BIGINT(20) UNSIGNED NOT NULL,
  CODE                          VARCHAR(20),
  DESCRIPTION                   LONGTEXT,
  DESCRIPTION_EN                LONGTEXT,
  PRODUCT_CATEGORY_ID           BIGINT(20) UNSIGNED NOT NULL,
  SECONDARY_PRODUCT_CATEGORY_ID BIGINT(20) UNSIGNED,
  PRICE                         DECIMAL(10, 2)      NOT NULL,
  OFFER_PRICE                   DECIMAL(10, 2),
  IMAGE_PATH                    VARCHAR(255),
  IMAGE                         LONGBLOB,
  FOREIGN KEY (PRODUCT_ID) REFERENCES cms_products (ID),
  FOREIGN KEY (PRODUCT_CATEGORY_ID) REFERENCES cms_product_categories (ID),
  FOREIGN KEY (SECONDARY_PRODUCT_CATEGORY_ID) REFERENCES cms_product_categories (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE cms_product_details
  ADD INDEX PRODUCT_IND (PRODUCT_ID);

CREATE TABLE cms_comments (
  ID      BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  COMMENT LONGTEXT,
  DATE    TIMESTAMP                    DEFAULT CURRENT_TIMESTAMP,
  STATE   INT(11)                      DEFAULT 0,
  USER_ID BIGINT(20),
  POST_ID BIGINT(20) UNSIGNED,
  FOREIGN KEY (POST_ID) REFERENCES cms_posts (ID)
    ON DELETE CASCADE,
  FOREIGN KEY (USER_ID) REFERENCES cms_users (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE cms_comments
  ADD INDEX POST_C_IND (POST_ID);

ALTER TABLE cms_comments
  ADD INDEX USER_C_IND (USER_ID);

CREATE TABLE cms_user_groups (
  ID     BIGINT(20) NOT NULL    AUTO_INCREMENT PRIMARY KEY,
  NAME   VARCHAR(255)           DEFAULT NULL,
  STATUS INT(11)    NOT NULL    DEFAULT 0
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE cms_user_groups_meta (
  ID         BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  GROUP_ID   BIGINT(20) NOT NULL,
  META_KEY   VARCHAR(255)        DEFAULT NULL,
  META_VALUE LONGTEXT,
  FOREIGN KEY (GROUP_ID) REFERENCES cms_user_groups (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE cms_user_groups_meta
  ADD INDEX GROUP_IND (GROUP_ID);

CREATE TABLE cms_ugr_assoc (
  USER_ID  BIGINT(20) NOT NULL,
  GROUP_ID BIGINT(20) NOT NULL,
  PRIMARY KEY (USER_ID, GROUP_ID),
  FOREIGN KEY (USER_ID) REFERENCES cms_users (ID)
    ON DELETE CASCADE,
  FOREIGN KEY (GROUP_ID) REFERENCES cms_user_groups (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE cms_access_rights (
  ID     BIGINT(20) NOT NULL    AUTO_INCREMENT PRIMARY KEY,
  NAME   VARCHAR(255)           DEFAULT NULL,
  STATUS INT(11)    NOT NULL    DEFAULT 1
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE cms_access_rights_meta (
  ID         BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ACCESS_ID  BIGINT(20) NOT NULL,
  META_KEY   VARCHAR(255)        DEFAULT NULL,
  META_VALUE LONGTEXT,
  FOREIGN KEY (ACCESS_ID) REFERENCES cms_access_rights (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE cms_access_rights_meta
  ADD INDEX ACC_IND (ACCESS_ID);

CREATE TABLE cms_acr_assoc (
  ACC_ID   BIGINT(20) NOT NULL,
  USER_ID  BIGINT(20) DEFAULT NULL,
  GROUP_ID BIGINT(20) DEFAULT NULL,
  #   PRIMARY KEY (ACC_ID, USER_ID, GROUP_ID),
  FOREIGN KEY (ACC_ID) REFERENCES cms_access_rights (ID)
    ON DELETE CASCADE,
  FOREIGN KEY (USER_ID) REFERENCES cms_users (ID)
    ON DELETE CASCADE,
  FOREIGN KEY (GROUP_ID) REFERENCES cms_user_groups (ID)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE cms_newsletter_emails (
  ID                   BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  EMAIL                VARCHAR(255),
  DATE                 TIMESTAMP                    DEFAULT CURRENT_TIMESTAMP,
  UNSUBSCRIPTION_TOKEN VARCHAR(255)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE cms_newsletter_campaigns (
  ID           BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  TITLE        VARCHAR(50),
  MESSAGE      LONGTEXT,
  LINK         VARCHAR(255),
  BUTTON_TEXT  VARCHAR(50),
  USER_ID      BIGINT(20)          NOT NULL DEFAULT 0,
  SENDING_DATE TIMESTAMP                    DEFAULT CURRENT_TIMESTAMP
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE cms_newsletter_campaigns
  ADD INDEX USER_N_IND (USER_ID);

CREATE TABLE cms_promotion (
  ID                     BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  PROMOTED_INSTANCE_TYPE INT(2)                       DEFAULT NULL,
  PROMOTED_INSTANCE_ID   BIGINT(20)                   DEFAULT NULL,
  PROMOTED_FROM          DATETIME,
  PROMOTED_TO            DATETIME,
  PROMOTION_TEXT         VARCHAR(255),
  PROMOTION_TEXT_EN      VARCHAR(255),
  TIMES_SEEN             SMALLINT                     DEFAULT 0,
  PROMOTION_ACTIVATION   DATETIME,
  USER_ID                BIGINT(20),
  PROMOTION_LINK         VARCHAR(255)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO cms_users (NAME, PASSWORD, FIRST_NAME, LAST_NAME, EMAIL, PHONE, LINK, GENDER, PICTURE, USER_STATUS, ACTIVATION_DATE)
VALUES
  ('admin', '$2y$10$6g91rGCWuZ9zbiJV2YDzeOgmxlyCKauJejWUVJtWPJirKngbSeyVu', 'admin', 'admin', 'admin@admin.gr', '',
            '', '', '', 1, NOW());

INSERT INTO cms_user_groups (NAME, STATUS) VALUES ('admin', 1);
INSERT INTO cms_user_groups_meta (GROUP_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Admin users of system');

INSERT INTO cms_user_groups (NAME, STATUS) VALUES ('super-user', 1);
INSERT INTO cms_user_groups_meta (GROUP_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Super users has advanced access to the system');

INSERT INTO cms_user_groups (NAME, STATUS) VALUES ('editor', 1);
INSERT INTO cms_user_groups_meta (GROUP_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Editor can create and edit content');

INSERT INTO cms_user_groups (NAME, STATUS) VALUES ('viewer', 1);
INSERT INTO cms_user_groups_meta (GROUP_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Viewer is just visiting the site');

INSERT INTO cms_ugr_assoc (USER_ID, GROUP_ID) VALUES ((SELECT ID
                                                       FROM cms_users
                                                       WHERE NAME = 'admin'), ((SELECT ID
                                                                                FROM cms_user_groups
                                                                                WHERE NAME = 'admin')));

INSERT INTO cms_access_rights (NAME) VALUES ('ALL');
INSERT INTO cms_access_rights_meta (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to all features of system');

INSERT INTO cms_access_rights (NAME) VALUES ('DASHBOARD_SECTION');
INSERT INTO cms_access_rights_meta (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to dashboard section');

INSERT INTO cms_access_rights (NAME) VALUES ('PAGES_SECTION');
INSERT INTO cms_access_rights_meta (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to pages section');

INSERT INTO cms_access_rights (NAME) VALUES ('POSTS_SECTION');
INSERT INTO cms_access_rights_meta (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to posts section');

INSERT INTO cms_access_rights (NAME) VALUES ('PRODUCTS_SECTION');
INSERT INTO cms_access_rights_meta (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to products section');

INSERT INTO cms_access_rights (NAME) VALUES ('PRODUCT_CATEGORIES_SECTION');
INSERT INTO cms_access_rights_meta (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to product categories section');

INSERT INTO cms_access_rights (NAME) VALUES ('PROMOTIONS_SECTION');
INSERT INTO cms_access_rights_meta (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to promotions section');

INSERT INTO cms_access_rights (NAME) VALUES ('USER_SECTION');
INSERT INTO cms_access_rights_meta (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to user section');

INSERT INTO cms_access_rights (NAME) VALUES ('SETTINGS_SECTION');
INSERT INTO cms_access_rights_meta (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to settings section');

INSERT INTO cms_access_rights (NAME) VALUES ('PROGRAM_SECTION');
INSERT INTO cms_access_rights_meta (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to program section');

INSERT INTO cms_access_rights (NAME) VALUES ('NEWSLETTER_SECTION');
INSERT INTO cms_access_rights_meta (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to newsletter section');

INSERT INTO cms_acr_assoc (ACC_ID, GROUP_ID) VALUES ((SELECT ID
                                                      FROM cms_access_rights
                                                      WHERE NAME = 'ALL'), ((SELECT ID
                                                                             FROM
                                                                               cms_user_groups
                                                                             WHERE
                                                                               NAME =
                                                                               'admin')));

INSERT INTO cms_acr_assoc (ACC_ID, GROUP_ID) VALUES ((SELECT ID
                                                      FROM cms_access_rights
                                                      WHERE NAME = 'POSTS_SECTION'), ((SELECT ID
                                                                                       FROM
                                                                                         cms_user_groups
                                                                                       WHERE
                                                                                         NAME =
                                                                                         'editor')));

CREATE TABLE cms_visitors (
  ID              BIGINT(20)   NOT NULL    AUTO_INCREMENT PRIMARY KEY,
  FB_ID           VARCHAR(50)  NOT NULL,
  FIRST_NAME      VARCHAR(250) NOT NULL    DEFAULT '',
  LAST_NAME       VARCHAR(250) NOT NULL    DEFAULT '',
  EMAIL           VARCHAR(100)             DEFAULT '',
  IMAGE_PATH      VARCHAR(255)             DEFAULT '',
  USER_STATUS     INT(11)      NOT NULL    DEFAULT 1,
  INSERTION_DATE  DATETIME,
  LAST_LOGIN_DATE DATETIME
);

CREATE TABLE cms_lessons (
  ID     BIGINT(20)   NOT NULL    AUTO_INCREMENT PRIMARY KEY,
  LESSON VARCHAR(250) NOT NULL    DEFAULT '',
  STATUS INT(11)      NOT NULL    DEFAULT 1
);

CREATE TABLE cms_events (
  ID          BIGINT(20)   NOT NULL    AUTO_INCREMENT PRIMARY KEY,
  NAME        VARCHAR(250) NOT NULL    DEFAULT '',
  DESCRIPTION LONGTEXT,
  DAY         VARCHAR(250),
  START_TIME  VARCHAR(10),
  END_TIME    VARCHAR(10),
  STATUS      INT(11)      NOT NULL    DEFAULT 0
);

# init lessons

INSERT INTO cms_lessons (LESSON) VALUES ('Pilates equipment');
INSERT INTO cms_lessons (LESSON) VALUES ('Pilates mat');
INSERT INTO cms_lessons (LESSON) VALUES ('Yoga');
INSERT INTO cms_lessons (LESSON) VALUES ('Aerial yoga');
INSERT INTO cms_lessons (LESSON) VALUES ('Fat burn');

# init program

INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'monday', '08:30', '09:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'monday', '09:30', '10:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'monday', '10:30', '11:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'monday', '11:30', '12:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'monday', '13:00', '14:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'monday', '16:00', '17:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'monday', '17:00', '18:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates mat', NULL, 'monday', '18:00', '19:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Fat burn', NULL, 'monday', '19:00', '20:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Yoga', NULL, 'monday', '20:00', '21:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'monday', '21:00', '22:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'tuesday', '08:30', '09:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Yoga', NULL, 'tuesday', '09:00', '10:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'tuesday', '09:30', '10:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates mat', NULL, 'tuesday', '10:30', '11:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'tuesday', '11:30', '12:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'tuesday', '16:00', '17:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'tuesday', '17:00', '18:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'tuesday', '18:00', '19:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates mat', NULL, 'tuesday', '19:00', '20:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'tuesday', '20:00', '21:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'tuesday', '21:00', '22:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'wednesday', '08:30', '09:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'wednesday', '09:30', '10:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Fat burn', NULL, 'wednesday', '10:00', '11:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'wednesday', '10:30', '11:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'wednesday', '13:00', '14:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'wednesday', '16:00', '17:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'wednesday', '17:00', '18:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates mat', NULL, 'wednesday', '18:00', '19:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Fat burn', NULL, 'wednesday', '19:00', '20:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates mat', NULL, 'wednesday', '20:00', '21:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Aerial yoga', NULL, 'wednesday', '20:00', '21:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'wednesday', '21:00', '22:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'thursday', '08:30', '09:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'thursday', '09:30', '10:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates mat', NULL, 'thursday', '10:30', '11:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'thursday', '17:00', '18:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'thursday', '18:00', '19:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Yoga', NULL, 'thursday', '19:00', '20:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'thursday', '20:00', '21:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'thursday', '21:00', '22:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'friday', '08:30', '09:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'friday', '09:30', '10:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'friday', '10:30', '11:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'friday', '11:30', '12:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'friday', '16:00', '17:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'friday', '17:00', '18:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates mat', NULL, 'friday', '19:00', '20:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'friday', '20:00', '21:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'saturday', '10:30', '11:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates equipment', NULL, 'saturday', '11:30', '12:30', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Pilates mat', NULL, 'saturday', '13:00', '14:00', 1);
INSERT INTO cms_events (NAME, DESCRIPTION, DAY, START_TIME, END_TIME, STATUS)
VALUES ('Aerial yoga', NULL, 'saturday', '13:00', '14:00', 1);

INSERT INTO cms_settings (SKEY, SVALUE) VALUES ('blog.enabled', 'off');
INSERT INTO cms_settings (SKEY, SVALUE) VALUES ('blog.style', 'grid');
INSERT INTO cms_settings (SKEY, SVALUE)
VALUES ('email.addresses', 'pkasfiki@gmail.com;info@fitnesshousebypenny.gr;natsaros@hotmail.com');
INSERT INTO cms_settings (SKEY, SVALUE)
VALUES ('maintenance', 'on');