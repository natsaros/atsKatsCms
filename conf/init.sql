CREATE TABLE `ak_users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL,
  `first_name` varchar(250) NOT NULL DEFAULT '',
  `last_name` varchar(250) NOT NULL DEFAULT '',
  `email` varchar(100) DEFAULT '',
  `phone` varchar(30) DEFAULT '',
  `link` varchar(250) DEFAULT '',
  `gender` varchar(50) DEFAULT '',
  `picture` varchar(250) DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `activation_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modification_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `ak_users`
  ADD PRIMARY KEY (`ID`);

INSERT INTO `ak_users` (`ID`, `name`, `password`, `first_name`, `last_name`, `email`, `phone`, `link`, `gender`, `picture`, `user_status`, `activation_date`, `modification_date`) VALUES
(1, 'admin', '$2y$10$6g91rGCWuZ9zbiJV2YDzeOgmxlyCKauJejWUVJtWPJirKngbSeyVu', 'admin', 'admin', 'admin@admin.gr', '', '', '', '', 1, '2016-10-16 00:00:00', '2016-10-16 00:00:00');