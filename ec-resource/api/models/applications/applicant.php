<?php

class applicant extends	Spine_SuperModel
{
	public $student_id;
    public $student_details;
    public $email;
    public $or_number;
    
	public function __construct()
	{
		parent::__construct();
	}
    
//------------------------------------------------------------------------------------

    public function checkIfExists($or_number)
    {
        try
        {
            $pdo_connection = Spine_DB::connection();
            $sql = "SELECT
                        COUNT(student_id) as count
                    FROM
                        students
            		WHERE
            			or_number = :or_number";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":or_number", $or_number, PDO::PARAM_STR);
            $pdo_statement->execute();
            $result = $pdo_statement->fetch(PDO::FETCH_ASSOC);
            return $result["count"];
        }
        catch(PDOException $pdoe)
        {
            throw new Exception($pdoe);
        }
    }
    
//------------------------------------------------------------------------------------

    public function insert()
    {
        try
        {
            $pdo_connection = Spine_DB::connection();
            $sql = "INSERT INTO
            			students
            		(
            			student_details,
            			email,
            			or_number
            		) VALUES (
            			:student_details,
            			:email,
            			:or_number
            		)";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":student_details", $this->student_details, PDO::PARAM_STR);
            $pdo_statement->bindParam(":email", $this->email, PDO::PARAM_STR);
            $pdo_statement->bindParam(":or_number", $this->or_number, PDO::PARAM_STR);
            $pdo_statement->execute();
        }
        catch(PDOException $pdoe)
        {
            throw new Exception($pdoe);
        }
    }
}

?>
