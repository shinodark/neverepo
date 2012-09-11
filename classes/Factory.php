<?php
function InsertUser($user) {
     $db = new Connection();
	 $db->Connect();
     $query = sprintf("INSERT INTO `users` (`id`, `name`, `username`, `mail`, `website`, `password`, `location`, `registration_date`) VALUES
     (%d, '%s', '%s', '%s', '%s', '%s', '%s', null);", $user->getId(),$user->getName(),$user->getUsername(),$user->getMail(),$user->getWebsite(),$user->getPassword(), $user->getLocation());
     $db->Query($query);
     $db->Close();
}
?>