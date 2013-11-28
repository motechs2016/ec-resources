<?php

/**
 * mainController is called before any controller as requested by clients is called
 * Rendering of global elements can be done here so the developer doesn't have to repeat the process
 */
	
class mainController extends Spine_SuperController implements Spine_MainInterface
{
	
	/**
	*
	* Before any action methods is fired in the the requested controller SPINE calls for main() method first
	* After the action method is invoked SPINE will then call end()
	* So for every invoked controller whether it is a main controller or a normal controller SPINE will call main() at the beginning and end() at the end
	*
	*/
	
	public function main()
	{
		header("X-Robots-Tag: noindex", TRUE); //To avoid being indexed by search engines
		$this->checkAccessCode();
		
		$this->loadModel('user-access/user_access');
		$this->loadModel('users/user');
	}
	
	//------------------------------------------------------------------------------------
	
	public function end()
	{
		//$this->setHeaders("Cache-Control: public");
		//$this->setHeaders("Expires: Sat, 26 Jul 2016 05:00:00 GMT");
		 //to avoid sending templates
		 //exit;
		 
		$this->displayPhtml('main_phtml', 'main/main');
	}
	
	//------------------------------------------------------------------------------------
	
	private function checkAccessCode()
	{
		$ac	=	$this->getParametersPair('ac');

		if ($ac !== ACCESS_CODE)
		{
			header('HTTP/1.0 401 Unauthorized');
			print	'Unauthorized Access';
			die;
		}
	}
}