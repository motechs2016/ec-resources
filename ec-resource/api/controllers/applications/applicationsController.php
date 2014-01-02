<?php
class applicationsController extends Spine_SuperController
{
	
	public function main()
	{
		$this->loadModel('applications/application_form');
		
		if (empty($_POST))
		{
			header('HTTP/1.0 400 Bad Request');
			die('Missing data in $_POST');
		}
	}
	
	//------------------------------------------------------------------------------------
	
	public function getApplicationInfoAction()
	{
		$applicant_id	=	$_POST['applicant_id'];
		$output			=	output($this->getApplicationInfo($applicant_id));

		if (!empty($output))
			$this->setHeaders('HTTP/1.0 200 OK');
		else
			$this->setHeaders('HTTP/1.0 404 Page Not Found');
			
		$this->displayPhtml('content', 'main/content', array('output' => $output)); //to send the output to a blank template
	}
	
	//------------------------------------------------------------------------------------
	
	public function updateApplicationInfoAction()
	{
		$applicant_id	=	$_POST['applicant_id'];
		$column			=	$_POST['column'];
		$value			=	$_POST['value'];
		
		$output	=	$this->updateApplicantInfo($applicant_id, $column, $value);
		
		if ($output)
		{
			$this->setHeaders('HTTP/1.0 200 OK');
			$output	=	'Updated successfully \n applicant_id = '.$applicant_id.'\n column'.$column;
		}
		else
			$this->setHeaders('HTTP/1.0 404 Page Not Found');
			
		$this->displayPhtml('content', 'main/content', array('output' => $output)); //to send the output to a blank template
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
	
	private function getApplicationInfo($applicant_id)
	{
		$application_form				=	new application_form();
		$application_form->applicant_id	=	$applicant_id;
		
		return	$application_form->select();
	}
	
	//------------------------------------------------------------------------------------
	
	private function updateApplicantInfo($applicant_id, $column, $value)
	{
		$application_form				=	new application_form();
		$application_form->applicant_id	=	$applicant_id;
		$application_form->column		=	$column;
		$application_form->value		=	$value;
		
		return	$application_form->update();
	}
	
}