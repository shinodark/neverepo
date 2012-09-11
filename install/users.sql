
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `mail` varchar(32) NOT NULL,
  `website` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `location` varchar(32) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

