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

INSERT INTO `ak_users` (`ID`, `name`, `password`, `first_name`, `last_name`, `email`, `phone`, `link`, `gender`, `picture`, `user_status`, 'is_admin', `activation_date`, `modification_date`)
VALUES
  (1, 'admin', '$2y$10$6g91rGCWuZ9zbiJV2YDzeOgmxlyCKauJejWUVJtWPJirKngbSeyVu', 'admin', 'admin', 'admin@admin.gr', '',
      '', '', '', 1, 1, '2016-10-16 00:00:00', '2016-10-16 00:00:00');