<?php
/**
* @package managementtodo
*/

namespace Inc;

final class Init
{
	
	private static function get_services(){
		return [
			Pages\Admin::class,
			Basic\Enqueue::class,
			Basic\SettingLinks::class,
			Basic\Model::class
		];
	}

	public static function register_services(){
		foreach( self::get_services() as $class){
			$service = self::instantiate( $class );
			if( method_exists($service, 'register') ){
				$service->register();
			}
		}
	}

	private static function instantiate( $class ){
		$service = new $class();
		return $service;
	}
}