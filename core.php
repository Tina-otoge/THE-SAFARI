<?php
require_once 'config.php';

// At this point, all the parameters to initiate a mysqli connection should have been declared
// This is preferably done in the config.php file

$db = new mysqli($db_host, $db_user, $db_pwd, $db_name);
if ($db->connect_errno) {
 // header('Location: 500');
}
/* obvious */
function get_item ($item, $table, $col) {
  global $db;
  if ($stmt = $db->prepare('SELECT * FROM '.$table.' WHERE '.$col.' = ?')) {
    $stmt->bind_param('s',$item);
    $stmt->execute();
    $res = $stmt->get_result(); $stmt->close();
    return $res->num_rows === 0 ? false : $res->fetch_assoc();
  }
}

// POSTS
/* array_posts ( (int) limit [, (int) offset, (string) query]) => (array)
 * Fetch $limit posts from database starting from 0 or $offset using a generic
 * or given $query and return them into an array
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
/* get_item ( (any) item [, (string) url] => (array)
 * Fetch a post with $item as a value for $col (url if nothing is passed as a
 * second argument) and return every data from it in an array
 */
function get_post($item,$col='url') { return get_item ($item,$col); }

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
/* update_post ( (array) array, (any) item [, (string) url]) => (void) */
function update_post ($array, $item, $col='url') {
  global $db;
  $prev = get_post($item,$col);
  $new = array_replace($prev,(array_intersect_key($array,$prev)));
  $query = 'UPDATE posts SET ';
  foreach ($new as $key => $value) {
    if (is_int($value)) {
    $query .= '`'.$key.'` = '.$value.', ';
    } else {
    $query .= '`'.$key.'` = \''.$value.'\', ';
    }
  }
  $query = substr($query,0,-2).' WHERE `posts`.`id` = '.$new['id'].'';
  return $db->query($query);
}
/* delete_post ( (any) item [, (string) url]) => (array) */
function delete_post($item, $col='url') {
  global $db;
  $stmt = $db->prepare('DELETE FROM `posts` WHERE `posts`.`'.$col.'` = ?');
  $stmt->bind_param('s',$item);
  $stmt->execute(); $stmt->close();
}

// TODO
function construct_url($string) {
  // do something
  return $string;
}
// AUTH
function add_user($array) {
    global $db;
}