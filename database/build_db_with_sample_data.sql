/* This builds out our DB schema and then pops in 20 sample match rows to work with */
CREATE TABLE `matches` (
  `matchId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `riotMatchId` int(11) unsigned NOT NULL DEFAULT '0',
  `sumGuessed` int(11) unsigned NOT NULL DEFAULT '0',
  `sumCorrect` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`matchId`),
  KEY `riotMatchId` (`riotMatchId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `userScores` (
  `userScoreId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL DEFAULT '',
  `score` int(128) unsigned NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `questionCount` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userScoreId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
