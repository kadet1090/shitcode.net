CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(45) COLLATE utf8_bin NOT NULL,
  `password` varchar(60) COLLATE utf8_bin NOT NULL,
  `created_by` int(11) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `last_access` datetime DEFAULT NULL,
  `access_token` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT 'Used by Yii2',
  `auth_key` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT 'Used by Yii2.',
  `inform` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `created_by_INDEX` (`created_by`),
  CONSTRAINT `CREATED_BY` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` int(10) unsigned DEFAULT NULL,
  `author` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `title` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin,
  `language` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `code` text COLLATE utf8_bin,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `approved_by` int(10) unsigned DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `score` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `author_INDEX` (`author`),
  KEY `language_INDEX` (`language`),
  KEY `approved_by_FOREIGN_idx` (`approved_by`),
  KEY `approved_INDEX` (`approved`),
  CONSTRAINT `approved_by_FOREIGN` FOREIGN KEY (`approved_by`) REFERENCES `admins` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `votes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `snippet_id` int(10) unsigned DEFAULT NULL,
  `ip` int(11) DEFAULT NULL,
  `fingerprint` varchar(80) COLLATE utf8_bin DEFAULT NULL COMMENT 'Some kind of unique user data',
  `vote` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `fingerprint` (`ip`,`fingerprint`,`snippet_id`),
  KEY `snippet_id` (`snippet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `admins` (`id`, `email`, `password`, `created`, `last_access`, `inform`) VALUES ('1', 'admin@shitcode.test', '$2y$13$lD8TcMsnhzrXLuuANx51Gups0AtTyUXDJPbftWs70c4lsMaId7GGm', NOW(), NOW(), '1');