<?php
class applicantsController extends Spine_SuperController
{
	
	public function main()
	{
		$this->loadModel('applications/application_form');
		$this->loadModel('applications/applicant');

		if (empty($_POST))
		{
			header('HTTP/1.0 400 Bad Request');
			die('Missing data in $_POST');
		}
	}
	
//------------------------------------------------------------------------------------
	
	public function indexAction()
	{
		$user_details	=	'Invalid Access';
		$this->setHeaders('HTTP/1.0 401 Unauthorized');
		output($user_details);
	}
	
//------------------------------------------------------------------------------------------
	
	public function addAction()
	{
		if (!empty($_POST))
		{
			//$students = new students();
			//$checker = $students->checkIfExists($_POST["or_number"]);
			$checker	=	0;
			
			$application_form	=	new application_form();
			
			$application_form->section		=	$_POST['section'];
			$application_form->value		=	$_POST['value'];	
			$application_form->insert();
				
			$this->setHeaders('HTTP/1.0 200 OK');
			$this->displayPhtml('content', 'main/content', array('output' => output(array('applicant_id' => $application_form->applicant_id))));
		}
	}
	

//------------------------------------------------------------------------------------

	public function updateAction()
	{
		$application_form	=	new application_form();
		
		if (!empty($_POST))
		{
			$application_form->applicant_id	=	$_POST['application_id'];
			$application_form->section		=	$_POST['section'];
			$application_form->value		=	$_POST['value'];
			
			$application_form->update();
			
			$this->setHeaders('HTTP/1.0 200 OK');
			$this->displayPhtml('content', 'main/content', array('output' => output("added")));
		}
	}

//------------------------------------------------------------------------------------	
	
	public function end()
	{
	}
	
//------------------------------------------------------------------------------------
	
}