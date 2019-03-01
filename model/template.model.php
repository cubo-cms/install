<?php
namespace Cubo;

defined('__CUBO__') || new \Exception("No use starting a class without an include");

class Template extends Model {
	// Retrieve a single record from the model
	public static function get($id,$columns = '*',$filter = '1') {
		$item = (object)[];
		$templateFile = __ROOT__.DS.'vendor'.DS.'cubo-cms'.DS.'asset'.DS.'index.php';
		if(file_exists($templateFile))
			$item->body  = file_get_contents($templateFile);
		return $item;
	}
}
