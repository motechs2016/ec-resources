<?php
class dataController extends Spine_SuperController
{
	
	public function main()
	{
		$this->loadModel('filebase-access/college_profile');
	}
	
	public function indexAction()
	{
	}
	
	public function getCollegeProfileAction()
	{
		$college_code	=	$this->getParametersPair('cc');
		$this->cacheOutput('college_profile_'.$college_code);
		
		//This is for sending the output to the registry so the end() method can display
		
		registerOutput($this->getContent($college_code)); 
	}
	
	public function end()
	{
	}
	
	private function getContent($college_code)
	{
		$college_profile_model	=	new college_profile();
		return $college_profile_model->getProfile($college_code);
	}
}