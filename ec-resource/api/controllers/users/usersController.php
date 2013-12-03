<?php
class usersController extends Spine_SuperController
{
	
	public function main()
	{
		$this->loadModel('user-access/user_access');
		
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
	
//------------------------------------------------------------------------------------
	
	public function verifyAction()
	{
		if (!empty($_POST))
		{
			$username		=	strip_tags($_POST['username']);
			$password		=	hashPassword(strip_tags($_POST['password']));
			
			$user_access	=	new user_access();
			$user_details	=	$user_access->login($username, $password);
			
			if ($user_details)
			{
				foreach ($user_details as $index => $value)
					$user_details[$index]	=	form_safe_json($value);
					
				$this->setHeaders('HTTP/1.0 202 Accepted');
			}
			else
			{
				$user_details	=	'Invalid Access';
				$this->setHeaders('HTTP/1.0 401 Unauthorized');
			}
			$this->displayPhtml('content', 'main/content', array('output' => output($user_details)));
		}
		else
		{
			$user_details	=	'Invalid Access';
			$this->setHeaders('HTTP/1.0 401 Unauthorized');
			output($user_details);
		}
	}
	
//------------------------------------------------------------------------------------
	
	public function getNewTokenAction()
	{
		if (!empty($_POST))
		{
			$credentials	=	$_POST;
			$user_access	=	new user_access();
			$user_details	=	$user_access->validateToken($credentials);
			
			$user_details['access_token']	=	$user_access->saveTokenToDatabase();
			
			if ($user_details)
			{
				$this->setHeaders('HTTP/1.0 201 Created');
			}
			else
			{
				$user_details	=	'Invalid Access';
				$this->setHeaders('HTTP/1.0 401 Unauthorized');
			}
			
			output($user_details); //to send the output to a blank template
		}
		else
		{
			$user_details	=	'Invalid Access';
			$this->setHeaders('HTTP/1.0 401 Unauthorized');
			output($user_details);
		}
	}
	
//------------------------------------------------------------------------------------
	
	public function validateTokenAction()
	{
		if (!empty($_POST))
		{
			$credentials	=	$_POST;
			$user_access	=	new user_access();
			$user_details	=	$user_access->validateToken($credentials);
			
			if ($user_details)
			{
				$this->setHeaders('HTTP/1.0 202 Accepted');
			}
			else
			{
				$user_details	=	'Invalid Access';
				$this->setHeaders('HTTP/1.0 401 Unauthorized');
			}
			
			//output($user_details); //to send the output to a blank template
			$this->displayPhtml('content', 'main/content', array('output' => output($user_details)));
		}
		else
		{
			$user_details	=	'Invalid Access';
			$this->setHeaders('HTTP/1.0 401 Unauthorized');
			output($user_details);
		}
	}
	
//------------------------------------------------------------------------------------
	
	public function flushTokenAction()
	{
		if (!empty($_POST))
		{
			$credentials	=	$_POST;
			$user_access	=	new user_access();
			$user_details	=	$user_access->validateToken($credentials);
			
			if ($user_details)
			{
				$user_access->flushToken();
				$this->setHeaders('HTTP/1.0 201 Created');
				$user_details	=	'Token flushed';
			}
			else
			{
				$user_details	=	'Invalid Access';
				$this->setHeaders('HTTP/1.0 401 Unauthorized');
			}
			
			$this->displayPhtml('content', 'main/content', array('output' => output($user_details))); //to send the output to a blank template
		}
	}
	
//------------------------------------------------------------------------------------

	public function updateProfileAction()
	{
		if (!empty($_POST))
		{
			$this->loadModel('user/user');
			
			$credentials	=	$_POST;
			$user			=	new user();
			
			$user->setUserId($_POST['user_id']);
			$user->setUsername($_POST['username']);
			$user->setRoleId($_POST['role_id']);
			$user->setEmailAddress($_POST['email_address']);
			$user->setFirstname($_POST['firstname']);
			$user->setLastname($_POST['lastname']);
			$user->setContactDetails($_POST['contact_details']);
			$user->setPassword($_POST['password']);
			$user->setPhoto($_POST['photo']);
			$user->setAccessToken($_POST['access_token']);
			
			$user->update();
			
			$user_id	=	$user->getUserId();
			
			if ($user_id)
			{
				$this->setHeaders('HTTP/1.0 200 OK');
				$user_details	=	'User profile updated.';
			}
			else
			{
				$user_details	=	'Invalid Access';
				$this->setHeaders('HTTP/1.0 401 Unauthorized');
			}
			
			$this->displayPhtml('content', 'main/content', array('output' => output($user_details))); //to send the output to a blank template
		}
	}
	

//------------------------------------------------------------------------------------

	public function end()
	{
	}
	
//------------------------------------------------------------------------------------
	
}