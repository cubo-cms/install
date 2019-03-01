<?php
namespace Cubo;

defined('__CUBO__') || new \Exception("No use starting a class without an include");

class Plugin extends Model {
	// Definition of Plugin model
	public static function getDefinition() {
		return [
			['#'=>1,'name'=>'template'],
			['#'=>2,'name'=>'head'],
			['#'=>3,'name'=>'module'],
			['#'=>4,'name'=>'content'],
			['#'=>5,'name'=>'message']
		];
	}
	
	// Retrieve set of records from the model
	public static function getAll($columns = "`#`,`accesslevel`,`name`,`status`",$filter = "`status`=".STATUS_PUBLISHED,$order = "`#`") {
		return self::getDefinition();
	}
}
?>