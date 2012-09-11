CREATE TABLE IF NOT EXISTS `sets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `author` varchar(32) NOT NULL,
  `description` varchar(32) NOT NULL,
  `num` int(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

