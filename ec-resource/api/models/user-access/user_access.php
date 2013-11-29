<?php

/**
 * 
 * @author Raymond
 *
 */

class user_access extends Spine_SuperModel
{
	private	$user_id;
	
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('users/user');
	}
	
	//------------------------------------------------------------------------------------
	
	public function generateToken()
	{
		$charlist	=	'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_-!@#$%^&*';
		return sha1(strtotime(time()).substr(str_shuffle($charlist), 0, 10).$this->user_id);
	}
	
	//------------------------------------------------------------------------------------
	
	public function saveTokenToDatabase()
	{
		$token			=	$this->generateToken();
	    $user			=	new	user();
	    $user->setUserId($this->user_id);
	            
	    $user->updateOneColumn('access_token', $token);
	   return	$token;
	}
	
	//------------------------------------------------------------------------------------
	
	public function fetchToken()
	{
	}
	
	//------------------------------------------------------------------------------------
	
	public function fetchCredentials()
	{
	}
	
	//------------------------------------------------------------------------------------
	
	public function validateToken($credentials)
	{
		try
        {
            $pdo_connection = Spine_DB::connection();
            $sql = "SELECT
                            *
                        FROM
                            users
                        WHERE
                            user_id = :user_id
                        AND
                        	username = :username
                        AND
                        	password = :password
                        AND
                        	access_token = :access_token
                            ";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":user_id", $credentials['user_id'], PDO::PARAM_INT);
            $pdo_statement->bindParam(":username", $credentials['username'], PDO::PARAM_STR);
            $pdo_statement->bindParam(":password", $credentials['password'], PDO::PARAM_STR);
            $pdo_statement->bindParam(":access_token", $credentials['access_token'], PDO::PARAM_STR);
            $pdo_statement->execute();
            
            $result 		= $pdo_statement->fetch(PDO::FETCH_ASSOC);
            $this->user_id	=	$result['user_id'];
            
            if ($result)
            	return	$result;
            return	FALSE;
        }
        catch(PDOException $pdoe)
        {
            throw new Exception($pdoe);
        }
	}
	
	//------------------------------------------------------------------------------------
	
	public function login($username, $password)
    {
		try
        {
            $pdo_connection = Spine_DB::connection();
            $sql = "SELECT
                            *
                        FROM
                            users
                        WHERE
                            username = :username
                        AND
                            password = :password";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":username", $username, PDO::PARAM_STR);
            $pdo_statement->bindParam(":password", $password, PDO::PARAM_STR);
            $pdo_statement->execute();
            
            $result 		= $pdo_statement->fetch(PDO::FETCH_ASSOC);
            
            if ($result != NULL)
            {
            	$this->user_id			=	$result['user_id'];
	            $result['access_token']	=	$this->saveTokenToDatabase();
	
	            return	$result;
            }
            
            return	FALSE;
            
			
        }
        catch(PDOException $pdoe)
        {
            throw new Exception($pdoe);
        }
    }
    
    //------------------------------------------------------------------------------------
    
    public function flushToken()
    {
    	$user	=	new	user();
    	$user->setUserId($this->user_id);
	    $user->updateOneColumn('access_token', '');
    }
	
}