<?php
class eventsController extends Spine_SuperController
{
	public function main()
	{
		if (empty($_POST))
		{
			header('HTTP/1.0 400 Bad Request');
			die('Missing data in $_POST');
		}
	}
	
	//------------------------------------------------------------------------------------
	
	public function listAction()
	{
	}
	
	//------------------------------------------------------------------------------------
	
	public function updateAction()
	{
	}
	
	//------------------------------------------------------------------------------------
	
	public function addAction()
	{
		
	}
	
	//------------------------------------------------------------------------------------
	
	public function end()
	{
	}
	
	//------------------------------------------------------------------------------------
}