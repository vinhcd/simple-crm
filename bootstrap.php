<?php
//error_reporting(E_ALL);  
//ini_set('display_startup_errors', 1);  
ini_set('display_errors', 1); 

define('APP_BASE_PATH',       dirname(__FILE__));
define('SMARTY_TEMPLATE_DIR', APP_BASE_PATH. '/application/views/scripts');
define('SMARTY_CONFIG_DIR',   APP_BASE_PATH. '/application/views/common');
define('SMARTY_COMPILE_DIR',  APP_BASE_PATH. '/temp/templates_c');
define('SMARTY_CACHE_DIR',    APP_BASE_PATH. '/temp/cache');
define('SMARTY_EXTENSION',    'tpl');

//var_dump($_SERVER);
define('JSVERSION',1);
define('DOMAIN',$_SERVER["HTTP_HOST"]);
define('DOMAIN_MEDIA',$_SERVER["HTTP_HOST"]);

//set_include_path(get_include_path(). PATH_SEPARATOR. realpath(APP_BASE_PATH. '/library'));

//set_include_path(
//               get_include_path(). PATH_SEPARATOR. realpath(APP_BASE_PATH. '/library')
//               );


set_include_path(realpath(APP_BASE_PATH. '/library') . PATH_SEPARATOR
				.realpath(APP_BASE_PATH. '/application/models') . PATH_SEPARATOR
               . get_include_path());
			   
			   
//echo realpath(APP_BASE_PATH. '/library');
//echo get_include_path(). PATH_SEPARATOR. realpath(APP_BASE_PATH. '/library';

date_default_timezone_set('Asia/Bangkok');
require_once 'Zend/Controller/Front.php';
require_once 'Zend/Loader.php';
require_once 'Zend/Version.php';
Zend_Loader::loadClass('Zend_Registry');

require("config.inc.php");
require("Database.class.php");	


require_once 'Zend/Session.php';

$sessionConfig = array(
    'use_only_cookies' => 'off',
    'use_trans_sid'    => '0',
	'cookie_lifetime'    => 864000,
	'gc_maxlifetime'    => 864000
);

$session = Zend_Session::setOptions($sessionConfig);
Zend_Session::start(); 



$admin = new Zend_Session_Namespace('admin');
Zend_Registry::set('admin', $admin );
if ($admin->staff_id!='004'){
//echo "Maintaining";die;
}

$front	= Zend_Controller_Front::getInstance();
$front->setControllerDirectory(APP_BASE_PATH. '/application/controllers');


$front->setParam('noViewRenderer', true);  //Smartyを使うので標準view機構を使用しない
$front->dispatch();