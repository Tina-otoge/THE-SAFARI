<?php
require_once 'config.inc.php';
require_once 'aliases.inc.php';

// DATABASE CONNECTION
$db = new mysqli($db_host, $db_user, $db_pwd, $db_name);
if ($db->connect_errno) {
 // header('Location: 500');
}

// DATABASE INTERACTIONS
require_once 'database.inc.php';

/* write_post ( (string) name, (string) url, (int) author_id, (string) contributors_id, (string) content, (string) synopsis, (int) has_preview, (string) tags_id) => (void)
 * Call the function with correct arguments to append a blog post to the posts table in the database
 */
function write_post ($name, $url, $author_id, $contributors_id, $content, $synopsis, $has_preview, $tags_id) {
  global $db;
  if ($stmt = $db->prepare('INSERT INTO posts (name, url, author_id, contributors_id, posting_time, content, synopsis, has_preview, tags_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)')) {
    $time = date('Y-m-d h:i:s');
    $url = empty($url) ? construct_url($name) : $url;
    $stmt->bind_param('ssissssis', $name, $url, $author_id, $contributors_id, $time, $content, $synopsis, $has_preview, $tags_id);
    $stmt->execute(); $stmt->close();
  }
}
// AUTH
function add_user($name,$hpw) {
  global $db;
  $stmt = $db->prepare('INSERT INTO `users` (name, hpw) VALUES (?, ?)');
  $stmt->bind_param('ss',$name,$hpw);
  $stmt->execute(); $stmt->close();
}

// TODO
function construct_url($string) {
  // do something
  return $string;
function hash($string) {
  global $secu;
  // if blabla
}
}