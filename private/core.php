<?php
require_once 'config.php';

// At this point, all the parameters to initiate a mysqli connection should have been declared
// This is preferably done in the config.php file
$db = new mysqli($db_host, $db_user, $db_pwd, $db_name);
if ($db->connect_errno) {
 // header('Location: 500');
}