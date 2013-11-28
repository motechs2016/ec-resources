<?php
class homeController extends Spine_SuperController
{
	public function main()
	{
		header('HTTP/1.0 401 Unauthorized');
	}
	
	public function indexAction()
	{
		echo 'here';
	}
}