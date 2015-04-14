<?php

/**
 * Autoloads classes belonging to DigiSigner namespace
 */

function digisigner_autoloader($class) {
		
	$path = explode('\\', $class);
	
	$namespace = current($path);
	$class = end($path);
	
	if($namespace == 'DigiSigner') {
		require_once(__DIR__. DIRECTORY_SEPARATOR . $class . '.php');	
	}
}

spl_autoload_register('digisigner_autoloader');