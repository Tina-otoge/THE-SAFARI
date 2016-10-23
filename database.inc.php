<?php
/* get_item ( (any) item, (string) table, (string) table) => (array)
 * Fetch an $item matching in $col in $table
 */
function get_item ($item, $table, $col) {
  global $db;
  if ($stmt = $db->prepare('SELECT * FROM '.$table.' WHERE '.$col.' = :item')) {
    $stmt->bindValue(':item',$item,PDO::PARAM_STR);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res;
  }
}

/* update_post ( (array) array, (any) item, (string) table, (string) col) => (void) */
function update_item ($array, $item, $table, $col) {
  global $db;
  // prev = $item without $array implanted
  $prev = get_item($item,$table,$col);
  // new  = prev without $array implanted
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
function array_items ($table, $limit, $offset=0) {
  global $db;
  $stmt = $db->prepare('SELECT * FROM '.$table.' LIMIT :offset,:limit');
  $stmt->bindValue(':offset',$offset,PDO::PARAM_INT);
  $stmt->bindValue(':limit',$limit,PDO::PARAM_INT);
  $stmt->execute();
  $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $res;
}

/* delete_item ( (any) item, (string) table, (string) col ) => (void) */
function delete_item($item, $table, $col) {
  global $db;
  $stmt = $db->prepare('DELETE FROM `posts` WHERE `'.$table.'`.`'.$col.'` = ?');
  $stmt->bind_param('s',$item);
  $stmt->execute(); $stmt->close();
}