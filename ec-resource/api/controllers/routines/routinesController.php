<?php
class routinesController extends Spine_SuperController
{
	
	public function main()
	{
		if ( $_POST['s'] )
		{
			if ( $_POST['s'] !== SECURITY_KEY )
				header('HTTP/1.0 401 Unauthorized');
				
			$this->loadModel('ec-routines/college_profile');
		}
		else
		{
			header('HTTP/1.0 401 Unauthorized');
		}
	}
	
	public function indexAction()
	{
	}
}