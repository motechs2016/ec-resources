<?php
class user extends	Spine_SuperModel
{
    private $user_id;
    private $role_id;
    private $firstname;
    private $lastname;
    private $username;
    private $password;
    private $email_address;
    private $contact_details;
    private $access_token;

    //------------------------------------------------------------------------------------
    //setter

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setEmailAddress($email_address)
    {
        $this->email_address = $email_address;
    }

    public function setContactDetrails($contact_details)
    {
        $this->contact_details = $contact_details;
    }

    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    //------------------------------------------------------------------------------------
    //getter

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getEmailAddress()
    {
        return $this->email_address;
    }

    public function getContactDetrails()
    {
        return $this->contact_details;
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    //------------------------------------------------------------------------------------

    public function insert()
    {
        try
        {
            $pdo_connection = Spine_DB::connection();
            $sql = "INSERT INTO
                        users
                        (
                            role_id,
                            firstname,
                            lastname,
                            username,
                            password,
                            email_address,
                            contact_details,
                            access_token
                        )
                    VALUES
                        (
                            :role_id,
                            :firstname,
                            :lastname,
                            :username,
                            :password,
                            :email_address,
                            :contact_details,
                            :access_token
                        )";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":role_id", $this->role_id, PDO::PARAM_STR);
            $pdo_statement->bindParam(":firstname", $this->firstname, PDO::PARAM_STR);
            $pdo_statement->bindParam(":lastname", $this->lastname, PDO::PARAM_STR);
            $pdo_statement->bindParam(":username", $this->username, PDO::PARAM_STR);
            $pdo_statement->bindParam(":password", $this->password, PDO::PARAM_STR);
            $pdo_statement->bindParam(":email_address", $this->email_address, PDO::PARAM_STR);
            $pdo_statement->bindParam(":contact_details", $this->contact_details, PDO::PARAM_STR);
            $pdo_statement->bindParam(":access_token", $this->access_token, PDO::PARAM_STR);
            $pdo_statement->execute();

            $this->user_id = $pdo_connection->lastInsertId();

        }
        catch(PDOException $pdoe)
        {
            throw new Exception($pdoe);
        }
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
                            users
                        WHERE
                            user_id = :user_id";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
            $pdo_statement->execute();
            $result = $pdo_statement->fetch(PDO::FETCH_ASSOC);

            $this->user_id = $result["user_id"];
            $this->role_id = $result["role_id"];
            $this->firstname = $result["firstname"];
            $this->lastname = $result["lastname"];
            $this->username = $result["username"];
            $this->password = $result["password"];
            $this->email_address = $result["email_address"];
            $this->contact_details = $result["contact_details"];
            $this->access_token = $result["access_token"];
        }
        catch(PDOException $pdoe)
        {
            throw new Exception($pdoe);
        }
    }

    //------------------------------------------------------------------------------------

    public function update()
    {
        try
        {
            $pdo_connection = Spine_DB::connection();
            $sql = "UPDATE
                        users
                    SET
                        role_id = :role_id,
                        firstname = :firstname,
                        lastname = :lastname,
                        username = :username,
                        password = :password,
                        email_address = :email_address,
                        contact_details = :contact_details,
                        access_token = :access_token 
                    WHERE
                        user_id = :user_id";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
            $pdo_statement->bindParam(":role_id", $this->role_id, PDO::PARAM_STR);
            $pdo_statement->bindParam(":firstname", $this->firstname, PDO::PARAM_STR);
            $pdo_statement->bindParam(":lastname", $this->lastname, PDO::PARAM_STR);
            $pdo_statement->bindParam(":username", $this->username, PDO::PARAM_STR);
            $pdo_statement->bindParam(":password", $this->password, PDO::PARAM_STR);
            $pdo_statement->bindParam(":email_address", $this->email_address, PDO::PARAM_STR);
            $pdo_statement->bindParam(":contact_details", $this->contact_details, PDO::PARAM_STR);
            $pdo_statement->bindParam(":access_token", $this->access_token, PDO::PARAM_STR);
            $pdo_statement->execute();

        }
        catch(PDOException $pdoe)
        {
            throw new Exception($pdoe);
        }
    }

    //------------------------------------------------------------------------------------

    public function delete()
    {
        try
        {
            $pdo_connection = Spine_DB::connection();
            $sql = "DELETE FROM
                            users
                        WHERE
                            user_id = :user_id";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
            $pdo_statement->execute();

        }
        catch(PDOException $pdoe)
        {
            throw new Exception($pdoe);
        }
    }

    //------------------------------------------------------------------------------------

    public function updateOneColumn($column, $value)
    {
        try
        {
            $pdo_connection = Spine_DB::connection();
            $sql = "UPDATE
                            users
                        SET
                            $column = :$column
                        WHERE
                            user_id = :user_id";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
            $pdo_statement->bindParam(":$column", $value, PDO::PARAM_INT);
            $pdo_statement->execute();

        }
        catch(PDOException $pdoe)
        {
            throw new Exception($pdoe);
        }
    }
    
    //------------------------------------------------------------------------------------
    
	public function login()
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
            $pdo_statement->bindParam(":username", $this->username, PDO::PARAM_STR);
            $pdo_statement->bindParam(":password", $this->password, PDO::PARAM_STR);
            $pdo_statement->execute();
            $result = $pdo_statement->fetch(PDO::FETCH_ASSOC);

            $this->user_id 			= $result["user_id"];
            $this->role_id 			= $result["role_id"];
            $this->firstname 		= $result["firstname"];
            $this->lastname 		= $result["lastname"];
            $this->username 		= $result["username"];
            $this->password 		= $result["password"];
            $this->email_address 	= $result["email_address"];
            $this->contact_details	= $result["contact_details"];
            $this->access_token		= $result["access_token"];
        }
        catch(PDOException $pdoe)
        {
            throw new Exception($pdoe);
        }
    }
    
    //------------------------------------------------------------------------------------
    
    
}

?>
