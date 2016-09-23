<?php
require_once 'config.php';

// At this point, all the parameters to initiate a mysqli connection should have been declared
// This is preferably done in the config.php file
$db = new mysqli($db_host, $db_user, $db_pwd, $db_name);
if ($db->connect_errno) {
 // header('Location: 500');
}

function array_posts ($limit, $offset=0, $query=false) {
  global $db;
  $query = $query ? $query : 'SELECT id, name, url, author_id, contributors_id, posting_time, updating_time, synopsis, has_preview, tags_id FROM posts';
  $query .= ' LIMIT '.$offset.','.$limit;
  $res = $db->query($query);
  $row = $res->fetch_all(MYSQLI_ASSOC);
  $res->free();
  return $row;
}