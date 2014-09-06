-- Create syntax for 'players'
-- Many stats, much wow.

CREATE TABLE `players` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`uuid` varchar(2500) NOT NULL DEFAULT '',
`name` varchar(25) NOT NULL DEFAULT '',
`p_kills` bigint(20) NOT NULL DEFAULT '0',
`m_kills` bigint(20) NOT NULL DEFAULT '0',
`breaks` bigint(20) NOT NULL DEFAULT '0',
`last_seen` datetime NOT NULL,
`is_op` enum('yes', 'no') NOT NULL DEFAULT 'no',
`is_banned` enum('yes', 'no') NOT NULL DEFAULT 'no',
`last_gamemode` int(2) NOT NULL DEFAULT '10',
`jumps` bigint(20) NOT NULL DEFAULT '0',
`deaths` bigint(20) NOT NULL DEFAULT '0',
`sword_swings` bigint(20) NOT NULL DEFAULT '0',
`diamonds_found` bigint(20) NOT NULL DEFAULT '0',
`enchantments` bigint(20) NOT NULL DEFAULT '0',
`blocks_placed` bigint(20) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
