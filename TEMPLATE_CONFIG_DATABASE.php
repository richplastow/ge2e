<?php
//// GE2E //// 0.0.* //// June 2017 //// github.com/richplastow/ge2e ///////////

//// This is the configuration file for connecting to the MySQL database.
//// It should not be placed in a repo, so:
//// 1. Rename this file ‘CONFIG_DATABASE.php’
//// 2. Make sure the line ‘CONFIG_*’ appears in the .gitignore file
//// 3. Then you can safely fill in the details below

//// This script is not a valid endpoint, so must not be loaded directly!
defined('GE2E_ENDPOINT') or exit( header('HTTP/1.0 403 Forbidden') );

$DATABASE_CONFIG = array(
    'dbname'   => 'database name in here, eg my_amazing_database_1'
  , 'host'     => 'could be localhost, or mysql.example.com, or an IP address'
  , 'port'     => 8889 // a number, not a string - sometimes just `null` works
  , 'username' => 'database user in here, eg my_amazing_database_user_1'
  , 'password' => 'add your database user’s password in here'
);

?>
