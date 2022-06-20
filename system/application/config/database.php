<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('error_reporting', E_STRICT);
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the "Database Connection"
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the "default" group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = "default";
$active_record = TRUE;

$db['default']['hostname'] = "172.25.150.27";
$db['default']['username'] = "root";
$db['default']['password'] = "dcrsv01p@bri2022";
$db['default']['database'] = "collection_bri";
$db['default']['dbdriver'] = "mysql";
$db['default']['dbprefix'] = "";
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";
/*
$db['sby']['hostname'] = "localhost";
$db['sby']['username'] = "root";
$db['sby']['password'] = "password01";
$db['sby']['database'] = "adira_collection_sby";
$db['sby']['dbdriver'] = "mysql";
$db['sby']['dbprefix'] = "";
$db['sby']['pconnect'] = TRUE;
$db['sby']['db_debug'] = FALSE;
$db['sby']['cache_on'] = FALSE;
$db['sby']['cachedir'] = "";
$db['sby']['char_set'] = "utf8";
$db['sby']['dbcollat'] = "utf8_general_ci";


$db['ems']['hostname'] = "172.25.116.71";
$db['ems']['username'] = "monitor";
$db['ems']['password'] = "@m0n1t0rADIRA";
$db['ems']['database'] = "ems";
$db['ems']['dbdriver'] = "mysql";
$db['ems']['dbprefix'] = "";
$db['ems']['pconnect'] = TRUE;
$db['ems']['db_debug'] = FALSE;
$db['ems']['cache_on'] = FALSE;
$db['ems']['cachedir'] = "";
$db['ems']['char_set'] = "utf8";
$db['ems']['dbcollat'] = "utf8_general_ci";

$db['db_vb']['hostname'] = "10.14.14.10";//172.25.55.230
$db['db_vb']['username'] = "app";
$db['db_vb']['password'] = "v4Ld01ntL";
$db['db_vb']['database'] = "ems";
$db['db_vb']['dbdriver'] = "mysql";
$db['db_vb']['dbprefix'] = "";
$db['db_vb']['pconnect'] = TRUE;
$db['db_vb']['db_debug'] = FALSE;
$db['db_vb']['cache_on'] = FALSE;
$db['db_vb']['cachedir'] = "";
$db['db_vb']['char_set'] = "utf8";
$db['db_vb']['dbcollat'] = "utf8_general_ci";

$db['vb_blast']['hostname'] = "10.14.14.10";//172.25.55.230
$db['vb_blast']['username'] = "data";
$db['vb_blast']['password'] = "12345";
$db['vb_blast']['database'] = "ems";
$db['vb_blast']['dbdriver'] = "mysql";
$db['vb_blast']['dbprefix'] = "";
$db['vb_blast']['pconnect'] = TRUE;
$db['vb_blast']['db_debug'] = FALSE;
$db['vb_blast']['cache_on'] = FALSE;
$db['vb_blast']['cachedir'] = "";
$db['vb_blast']['char_set'] = "utf8";
$db['vb_blast']['dbcollat'] = "utf8_general_ci";

$db['dbadira1']['hostname'] = "10.14.14.11";//172.25.55.231
$db['dbadira1']['username'] = "usr1";
$db['dbadira1']['password'] = "callcenter";
$db['dbadira1']['database'] = "adira_new";
$db['dbadira1']['dbdriver'] = "mysql";
$db['dbadira1']['dbprefix'] = "";
$db['dbadira1']['pconnect'] = TRUE;
$db['dbadira1']['db_debug'] = FALSE;
$db['dbadira1']['cache_on'] = FALSE;
$db['dbadira1']['cachedir'] = "";
$db['dbadira1']['char_set'] = "utf8";
$db['dbadira1']['dbcollat'] = "utf8_general_ci";

$db['blast']['hostname'] = "10.14.14.10";//172.25.55.230
$db['blast']['username'] = "root";
$db['blast']['password'] = "1234567";
$db['blast']['database'] = "ems";
$db['blast']['dbdriver'] = "mysql";
$db['blast']['dbprefix'] = "";
$db['blast']['pconnect'] = TRUE;
$db['blast']['db_debug'] = FALSE;
$db['blast']['cache_on'] = FALSE;
$db['blast']['cachedir'] = "";
$db['blast']['char_set'] = "utf8";
$db['blast']['dbcollat'] = "utf8_general_ci";

$db['vb_blast']['hostname'] = "10.14.14.10";//172.25.55.230
$db['vb_blast']['username'] = "blast";
$db['vb_blast']['password'] = "12345678";
$db['vb_blast']['database'] = "ems";
$db['vb_blast']['dbdriver'] = "mysql";
$db['vb_blast']['dbprefix'] = "";
$db['vb_blast']['pconnect'] = TRUE;
$db['vb_blast']['db_debug'] = FALSE;
$db['vb_blast']['cache_on'] = FALSE;
$db['vb_blast']['cachedir'] = "";
$db['vb_blast']['char_set'] = "utf8";
$db['vb_blast']['dbcollat'] = "utf8_general_ci";
*/
/* End of file database.php */
/* Location: ./system/application/config/database.php */
