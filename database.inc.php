<?php
/* get_item ( (any) item, (string) table, (string) table) => (array)
 * Fetch an $item matching in $col in $table
 */
function get_item ($item, $table, $col) {
  global $db;
  if ($stmt = $db->prepare('SELECT * FROM '.$table.' WHERE '.$col.' = ?')) {
    $stmt->bind_param('s',$item);
    $stmt->execute();
    $res = $stmt->get_result(); $stmt->close();
    return $res->num_rows === 0 ? false : $res->fetch_assoc();
  }
}

/* update_post ( (array) array, (any) item, (string) table, (string) col) => (void) */
function update_item ($array, $item, $table, $col) {
  global $db;
  $prev = get_item($item,$col);
  $new = array_replace($prev,(array_intersect_key($array,$prev)));
  $query = 'UPDATE `'.$table.'` SET ';
  foreach ($new as $key => $value) {
    if (is_int($value)) {
    $query .= '`'.$key.'` = '.$value.', ';
    } else {
    $query .= '`'.$key.'` = \''.$value.'\', ';
    }
  }
  $query = substr($query,0,-2).' WHERE `'.$table.'`.`id` = '.$new['id'].'';
  return $db->query($query);
}

/* array_items ( (string) table, (string) cols, (int) limit [, (int) offset]) => (array)
 * Fetch $limit items from database in $table starting from 0 or $offset using and
 * returning their data from $cols
 */
function array_items ($table, $cols, $limit, $offset=0) {
  global $db;
  $query = 'SELECT '.$cols.' FROM '.$table;
  $query .= ' LIMIT '.$offset.','.$limit;
  $res = $db->query($query);
  $row = $res->fetch_all(MYSQLI_ASSOC);
  $res->free();
  return $row;
}

/* delete_item ( (any) item, (string) table, (string) col ) => (void) */
function delete_item($item, $table, $col) {
  global $db;
  $stmt = $db->prepare('DELETE FROM `posts` WHERE `'$table'`.`'.$col.'` = ?');
  $stmt->bind_param('s',$item);
  $stmt->execute(); $stmt->close();
}