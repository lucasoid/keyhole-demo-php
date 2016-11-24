<?php
if(file_exists('bootstrap.env.php')) {
	include('bootstrap.env.php');
}
else {
	
include_once('vendor/autoload.php');

define('DBNAME', '***');
define('USER', '***');
define('PASSWORD', '***');
define('HOST', '***');
define('DRIVER', '***'); //e.g., pdo_mysql
define('TABLE_PREFIX', 'keyhole_');

$config = new \Doctrine\DBAL\Configuration();

$connectionParams = array(
	'dbname'=>DBNAME,
	'user'=>USER,
	'password'=>PASSWORD,
	'host'=>HOST,
	'driver'=>DRIVER,
);

$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

$registry = new \Keyhole\Registry\Registry($conn, TABLE_PREFIX); //the registry's constructor will build the registry tables if needed

}