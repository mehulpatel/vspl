CREATE TABLE IF NOT EXISTS `audit_entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` varchar(100) NOT NULL,
  `model_name` varchar(100) NOT NULL,
  `operation` varchar(100) NOT NULL,
  `field_name` varchar(100) NOT NULL,
  `old_value` text,
  `new_value` text NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `ip` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `operation` (`operation`),
  KEY `user_id` (`user_id`),
  KEY `ip` (`ip`),
  KEY `model_name` (`model_name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
