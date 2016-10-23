<?php
/* The aliases file is made to simplify the process of calling functions by defining
 * pre-filled functions which are shorter to call. For example, if you want to get
 * the data from the post i_love_flowers, instead of invoking get_item like this :
 * $mydata = get_item('i_love_flowers','posts','url'); you can invoke it like that :
 * $mydata = get_post('i_love_flowers'), which is way simpler and shorter.
 */

/* Call get_item in table `posts` in column 'url' by default */
function get_post($item,$col='url') {
  return get_item ($item,'posts',$col);
}

/* Call update_item in table `posts` in column 'url' by default */
function update_post($array,$item,$col='url') {
  return update_item ($array,$item,'posts',$col);
}

/* Call array_items in table `posts` in pre-filled columns, you will usually just want
 * to change the limit and eventually the offset. Example
 * $mydata = array_posts(5) : the 5 first posts
 * $mydata = array_posts(10,5) : the 10 posts following the 5th post
 */
function array_posts(
  $limit,
  $offset=0,
  $cols=
    'id,
    name,
    url,
    author_id,
    contributors_id,
    posting_time,
    updating_time,
    synopsis,
    has_preview,
    tags_id'
) {
  return array_items ('posts',$cols,$limit,$offset);
}

function delete_post($item,$col='url') {
  return delete_item ($item, 'posts', $col);
}