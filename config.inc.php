<?php
// DATABASE
$db_host = 'localhost';
$db_name = 'safari';
$db_user = 'root';
$db_pwd = '';

// PASSWORDS SECURITY
// Warning : This session is very commented.
/* You should leave this to true. It generates a random hash salt and stores it
 * in a physical file, this way, every THE SAFARI system will have a different
 * and unique salt, which isn't stealable from the database.
 * (Of course this can be used alongside other security methods)
 */
$secu['hash_generate_salt_file'] = true;

/* Useful if you doesn't trust my algorithm and want to use your own
 * (This won't create a file, it will use the existent one in /hash_salt)
 */
$secu['hash_use_salt_file'] = true;

/* This salt will be mixed in the hashing of the users password.
 * This isn't more efficient than the generated salt file, but it's useful if
 * you want a little more or doesn't want to a salt file at all.
 * ***
 * Don't hesitate to put something weird, long, short, special characters,
 * basically anything. But please, don't leave it default.
 * Leave an empty string '' if you do not want to use the bonus salt.
 */
$secu['hash_bonus_salt'] = 'Following @skielred on Twitter changed my life';