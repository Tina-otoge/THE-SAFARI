<?php
/* login ( (string) user, (string) password) => (bool) */
function login ($user, $password) {
  return hash($password) == get_user($user)['hpw'];
}
create_cookie ($id) {
  
}