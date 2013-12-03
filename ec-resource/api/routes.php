<?php
/**
 * 
 * Routing configuration file utilizing routes class
 * $routes property is use to set the routing configuration
 * If the user wants to utilize the normal routing i.e. by traversing through the folders in controllers
 * set the return value of getRoutes method to FALSE
 */

class routes extends Spine_RouteAbstract
{
//------------------------------------------------------------------------------------
	private $routes = array (
	
	'data-resources'	=>	array( 
			'_name'		=> 'data'
			),
	'data-mining'		=>	array( 
			'_name'		=> 'datamining'
			),
	'events'			=>	array( 
			'_name'		=> 'events'
			),
	'home'				=>	array( 
			'_name'		=> 'home'
			),
	'routines'			=>	array(
			'_name'		=>	'routines'
		),
	'user-access'			=>	array(
			'_name'		=>	'users'
		),
	'_default'			=>	'home'
	);

//------------------------------------------------------------------------------------
	
	public function getRoutes()
	{
		return $this->routes;
	}
}
