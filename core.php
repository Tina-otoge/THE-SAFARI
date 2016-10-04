<?php
require_once 'config.php';
require_once 'aliases.php';

// DATABASE CONNECTION
$db = new mysqli($db_host, $db_user, $db_pwd, $db_name);
if ($db->connect_errno) {
 // header('Location: 500');
}

// DATABASE INTERACTIONS
require_once 'database.php';

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
/* delete_post ( (any) item [, (string) url]) => (array) */
function delete_post($item, $col='url') {
  global $db;
  $stmt = $db->prepare('DELETE FROM `posts` WHERE `posts`.`'.$col(.'` = ?');
  $stmt->bind_param('s',$item);
  $stmt->execute(); $stmt->close();
}

// TODO
function construct_url($string) {
  // do something
  return $string;
}
// AUTH
function add_user($name,$hpw) {
  global $db;
  $stmt = $db->prepare('INSERT INTO `users` (name, hpw) VALUES (?, ?)');
  $stmt->bind_param('ss',$name,$hpw);
  $stmt->execute(); $stmt->close();
}
function encrypt($string) {
  global $secu;
  // if blabla
}