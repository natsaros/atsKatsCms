CREATE TABLE `ak_settings` (
  `ID`     BIGINT(20) UNSIGNED NOT NULL,
  `skey`   VARCHAR(250)        NOT NULL DEFAULT '',
  `sValue` LONGTEXT
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE `ak_settings`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `ak_settings`
  MODIFY `ID` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;

CREATE TABLE `ak_users` (
  `ID`                BIGINT(20) UNSIGNED NOT NULL,
  `name`              VARCHAR(250)        NOT NULL DEFAULT '',
  `password`          VARCHAR(255)        NOT NULL,
  `first_name`        VARCHAR(250)        NOT NULL DEFAULT '',
  `last_name`         VARCHAR(250)        NOT NULL DEFAULT '',
  `email`             VARCHAR(100)                 DEFAULT '',
  `phone`             VARCHAR(30)                  DEFAULT '',
  `link`              VARCHAR(250)                 DEFAULT '',
  `gender`            VARCHAR(50)                  DEFAULT '',
  `picture`           VARCHAR(250)                 DEFAULT '',
  `user_status`       INT(11)             NOT NULL DEFAULT '0',
  `is_admin`          INT(11)             NOT NULL DEFAULT '0',
  `activation_date`   DATETIME            NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modification_date` DATETIME                     DEFAULT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE `ak_users`
  ADD PRIMARY KEY (`ID`);


CREATE TABLE `ak_user_meta` (
  `ID`         BIGINT(20) UNSIGNED NOT NULL,
  `user_id`    BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key`   VARCHAR(255)                 DEFAULT NULL,
  `meta_value` LONGTEXT
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE `ak_user_meta`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_ind` (`user_id`);

ALTER TABLE `ak_user_meta`
  MODIFY `ID` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `ak_user_meta`
  ADD CONSTRAINT `ak_user_meta_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ak_users` (`ID`)
  ON DELETE CASCADE;

INSERT INTO `ak_users` (`ID`, `name`, `password`, `first_name`, `last_name`, `email`, `phone`, `link`, `gender`, `picture`, `user_status`, 'is_admin', `activation_date`, `modification_date`)
VALUES
  (1, 'admin', '$2y$10$6g91rGCWuZ9zbiJV2YDzeOgmxlyCKauJejWUVJtWPJirKngbSeyVu', 'admin', 'admin', 'admin@admin.gr', '',
      '', '', '', 1, 1, '2016-10-16 00:00:00', '2016-10-16 00:00:00');