<?php
// Creates the database object
$db = new PDO('sqlite:sqlite.db');

// Initial tables
$db->exec('
  CREATE TABLE IF NOT EXISTS `posts` (
    `id` int NOT NULL,
    `name` tinytext NOT NULL,
    `url` tinytext NOT NULL,
    `author_id` UNSIGNED int(10) NOT NULL,
    `contributors_id` tinytext NULL,
    `posting_time` datetime NOT NULL,
    `updating_time` datetime NULL,
    `content` mediumtext NOT NULL,
    `synopsis` varchar(1024) NULL,
    `has_preview` tinyint(1) NOT NULL DEFAULT \'0\',
    `tags_id` text NULL,
    PRIMARY KEY (`id`)
  );
  CREATE TABLE IF NOT EXISTS `ranks` (
    `id` int NOT NULL,
    `name` varchar(32) NOT NULL,
    `definition` text NULL,
    `preview` varchar(140) NULL,
    PRIMARY KEY (`id`)
  );
  CREATE TABLE IF NOT EXISTS `tags` (
    `id` int NOT NULL,
    `name` varchar(32) NOT NULL,
    `definition` text NULL,
    `preview` varchar(140) NULL,
    PRIMARY KEY (`id`)
  );
  CREATE TABLE IF NOT EXISTS `users` (
    `id` int NOT NULL,
    `name` varchar(32) NOT NULL,
    `rank_id` int(11) NOT NULL,
    `short_bio` varchar(500) NULL,
    PRIMARY KEY (`id`)
  );
');