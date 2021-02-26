<?php


/**
 * @param string $className
 */
function autoload(string $className): void {

	$file = str_replace('\\', '/', dirname(__DIR__) . '/' . $className . '.php');

	if(file_exists($file)) {
		require_once($file);
	}

}

spl_autoload_register('autoload');