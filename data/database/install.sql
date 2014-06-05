CREATE TABLE `allianceclientmessages` (
    `allianceclientmessage_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `created` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
    `alliance_id` BIGINT(20) UNSIGNED NOT NULL,
    `key` VARCHAR(255) NOT NULL,
    `data` TEXT NOT NULL,
    PRIMARY KEY (`allianceclientmessage_id`),
    KEY `alliance_id` (`alliance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
