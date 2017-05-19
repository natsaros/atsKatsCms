INSERT INTO AK_USERS (NAME, PASSWORD, FIRST_NAME, LAST_NAME, EMAIL, PHONE, LINK, GENDER, PICTURE, USER_STATUS, IS_ADMIN, ACTIVATION_DATE)
VALUES
  ('admin', '$2y$10$6g91rGCWuZ9zbiJV2YDzeOgmxlyCKauJejWUVJtWPJirKngbSeyVu', 'admin', 'admin', 'admin@admin.gr', '',
            '', '', '', 1, 1, CURRENT_TIMESTAMP);

INSERT INTO AK_USER_GROUPS (NAME) VALUES ('admin');
INSERT INTO AK_USER_GROUPS_META (GROUP_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Admin users of system');

INSERT INTO AK_USER_GROUPS (NAME) VALUES ('editor');
INSERT INTO AK_USER_GROUPS_META (GROUP_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Editor can create and edit content');

INSERT INTO AK_USER_GROUPS (NAME) VALUES ('viewer');
INSERT INTO AK_USER_GROUPS_META (GROUP_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Viewer is just visiting the site');

INSERT INTO AK_UGR_ASSOC (USER_ID, GROUP_ID) VALUES ((SELECT ID
                                                      FROM AK_USERS
                                                      WHERE NAME = 'admin'), ((SELECT ID
                                                                               FROM AK_USER_GROUPS
                                                                               WHERE NAME = 'admin')));

INSERT INTO AK_ACCESS_RIGHTS (NAME) VALUES ('ALL');
INSERT INTO AK_ACCESS_RIGHTS_META (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to all features of system');
INSERT INTO AK_ACCESS_RIGHTS (NAME) VALUES ('PAGES_SECTION');
INSERT INTO AK_ACCESS_RIGHTS_META (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to pages section');
INSERT INTO AK_ACCESS_RIGHTS (NAME) VALUES ('POSTS_SECTION');
INSERT INTO AK_ACCESS_RIGHTS_META (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to posts section');
INSERT INTO AK_ACCESS_RIGHTS (NAME) VALUES ('USER_SECTION');
INSERT INTO AK_ACCESS_RIGHTS_META (ACCESS_ID, META_KEY, META_VALUE)
VALUES (last_insert_id(), 'description', 'Access to user section');

INSERT INTO AK_ACR_ASSOC (ACC_ID, USER_ID, GROUP_ID) VALUES ((SELECT ID
                                                              FROM AK_ACCESS_RIGHTS
                                                              WHERE NAME = 'ALL'), (SELECT ID
                                                                                    FROM AK_USERS
                                                                                    WHERE NAME = 'admin'), ((SELECT ID
                                                                                                             FROM
                                                                                                               AK_USER_GROUPS
                                                                                                             WHERE
                                                                                                               NAME =
                                                                                                               'admin')));

