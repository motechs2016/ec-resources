<?php
class dataController extends Spine_SuperController
{
	
	public function main()
	{
		$this->loadModel('filebase-access/college_profile');
		$this->loadModule('filebase_json_handler');
		
		if (empty($_POST))
		{
			header('HTTP/1.0 400 Bad Request');
			die('Missing data in $_POST');
		}
	}
	
	//------------------------------------------------------------------------------------
	
	public function indexAction()
	{
	}
	
	//------------------------------------------------------------------------------------
	
	public function getCollegeProfileAction()
	{
		$college_code	=	$_POST['college_code'];
		//$this->cacheOutput('college_profile_'.$college_code);
		
		$output	=	output($this->getCollegeProfileContent($college_code));
		
		if (!empty($output))
			$this->setHeaders('HTTP/1.0 200 OK');
		else
			$this->setHeaders('HTTP/1.0 404 Page Not Found');
			
		$this->displayPhtml('content', 'main/content', array('output' => $output)); //to send the output to a blank template
	}
	
	//------------------------------------------------------------------------------------
	
	public function getCollegesListAction()
	{
		//$this->cacheOutput('college_listing');
		
		$json_college		=	new filebaseJsonHandler();
		$json_college->path	=	COLLEGES_DATA;
		
		$output	=	$json_college->selectAll('info.colleges');

		$this->setHeaders('HTTP/1.0 200 OK');
		
		$this->displayPhtml('content', 'main/content', array('output' => $output));
	}
	
	//-----------------------------------------------------------------------------------
	
	public function getZipcodesAction()
	{
		//$this->cacheOutput('info.zipcodes');
		$this->setHeaders('HTTP/1.0 200 OK');
		$this->displayPhtml('content', 'main/content', array('output' => $this->getZipcodes()));
	}
	
	//-----------------------------------------------------------------------------------
	
	public function end()
	{
	}
	
	//------------------------------------------------------------------------------------
	
	private function getCollegeProfileContent($college_code)
	{
		$college_profile_model	=	new college_profile();
		return $college_profile_model->getProfile($college_code);
	}
	
	//------------------------------------------------------------------------------------
	
	private function getZipcodes()
	{
		$json_college		=	new filebaseJsonHandler();
		$json_college->path	=	COLLEGES_DATA;
		
		return	$json_college->selectAll('info.zipcodes');
	}
	
	//------------------------------------------------------------------------------------
	
}