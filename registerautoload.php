<?
/**
 *	This is used in the Testing and Validation phase of the mvn test
 */	

define('APPLICATION_PATH', 		realpath(dirname(__FILE__)).'/src/main/php/PostcodeAnywhere');
define('TEST_PATH',				realpath(dirname(__FILE__)).'/src/test/php/PostcodeAnywhere/');
$paths = array(	get_include_path(),
				APPLICATION_PATH,
				realpath(dirname(__FILE__)).'/src/main/php',
				realpath(dirname(__FILE__)).'/target/phpinc',
				'.');
set_include_path(implode(PATH_SEPARATOR, $paths));

require_once 'environments.php';
defined('APPLICATION_ENV')		or define('APPLICATION_ENV', 	ENVIRONMENT_UNIT_TEST);
defined('APPLICATION_PATH') 	or define('APPLICATION_PATH', 	realpath(dirname(__FILE__)).'/src/main/php/PostcodeAnywhere');

require_once "Zend/Loader/Autoloader.php";
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('PHPUnit_');
$autoloader->registerNamespace('Zend_');
$autoloader->registerNamespace('PostcodeAnywhere_');

//PHPUnit_Util_Filter::addDirectoryToWhitelist(TEST_PATH);

