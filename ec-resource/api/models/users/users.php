<?php

class users extends	Spine_SuperModel
{
    private $array_of_users;

    //------------------------------------------------------------------------------------
    //setter

    public function setArrayOfUsers($array_of_videos)
    {
        $this->array_of_users = $array_of_users;
    }

    //------------------------------------------------------------------------------------
    //getter

    public function getArrayOfUsers()
    {
        return $this->array_of_users;
    }

    //------------------------------------------------------------------------------------
    
    public function __construct()
    {
    	$this->loadModel('users/user');
    }
    
    //------------------------------------------------------------------------------------

    public function select()
    {
        try
        {
            $pdo_connection = Spine_DB::connection();
            $sql = "SELECT
                            *
                        FROM
                            users";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->execute();
            $results = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);

            foreach($results as $result)
            {
                $user = new user();

                $user->setUserId($result["user_id"]);
                $user->setRoleId($result["role_id"]);
                $user->setFirstname($result["firstname"]);
                $user->setLastname($result["lastname"]);
                $user->setUsername($result["username"]);
                $user->setPassword($result["password"]);
                $user->setEmailAddress($result["email_address"]);
                $user->setContactDetrails($result["contact_details"]);
                $user->setAccessToken($result["access_token"]);
                $this->array_of_users[] = $user;

            }
        }
        catch(PDOException $pdoe)
        {
            throw new Exception($pdoe);
        }
    }
}

?>
