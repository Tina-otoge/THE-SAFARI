<?php
require_once 'config.php';

// At this point, all the parameters to initiate a mysqli connection should have been declared
// This is preferably done in the config.php file

$db = new mysqli($db_host, $db_user, $db_pwd, $db_name);
if ($db->connect_errno) {
 // header('Location: 500');
}

// POSTS
/* array_posts ( (int) limit [, (int) offset, (string) query]) => (array)
 * Fetch $limit posts from database starting from 0 or $offset using a generic
 * or given $query and return them into an array.
 */
function array_posts ($limit, $offset=0, $query='') {
  global $db;
  $query = !empty($query) ? $query : 'SELECT id, name, url, author_id, contributors_id, posting_time, updating_time, synopsis, has_preview, tags_id FROM posts';
  $query .= ' LIMIT '.$offset.','.$limit;
  $res = $db->query($query);
  $row = $res->fetch_all(MYSQLI_ASSOC);
  $res->free();
  return $row;
}
/* get_post ( (any) item [, (string) url]) => (array)
 * Fetch a post with $item as a value for $col (url if nothing is passed as a
 * second argument) and return every data from it in an array.
 */
function get_post ($item, $col='url') {
  global $db;
  if ($stmt = $db->prepare('SELECT * FROM posts WHERE '.$col.' = ?')) {
    $stmt->bind_param('s',$item);
    $stmt->execute();
    $res = $stmt->get_result(); $stmt->close();
    return $res->num_rows === 0 ? false : $res->fetch_assoc();
  }
  
}