<?php
class events extends Spine_SuperModel
{
    private $event_id;
    private $user_id;
    private $event_title;
    private $event_description;
    private $start_date;
    private $end_date;
    private $applicant_id;

    //------------------------------------------------------------------------------------
    //setter

    public function setEventId($event_id)
    {
        $this->event_id = $event_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setEventTitle($event_title)
    {
        $this->event_title = $event_title;
    }

    public function setEventDescription($event_description)
    {
        $this->event_description = $event_description;
    }

    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    }

    public function setApplicantId($applicant_id)
    {
        $this->applicant_id = $applicant_id;
    }

    //------------------------------------------------------------------------------------
    //getter

    public function getEventId()
    {
        return $this->event_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getEventTitle()
    {
        return $this->event_title;
    }

    public function getEventDescription()
    {
        return $this->event_description;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    public function getApplicantId()
    {
        return $this->applicant_id;
    }

    //------------------------------------------------------------------------------------

    public function insert()
    {
        try
        {
            $pdo_connection = Spine_DB::connection();
            $sql = "INSERT INTO
                        events
                        (
                            user_id,
                            event_title,
                            event_description,
                            start_date,
                            end_date,
                            applicant_id
                        )
                    VALUES
                        (
                            :user_id,
                            :event_title,
                            :event_description,
                            :start_date,
                            :end_date,
                            :applicant_id
                        )";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
            $pdo_statement->bindParam(":event_title", $this->event_title, PDO::PARAM_STR);
            $pdo_statement->bindParam(":event_description", $this->event_description, PDO::PARAM_STR);
            $pdo_statement->bindParam(":start_date", $this->start_date, PDO::PARAM_INT);
            $pdo_statement->bindParam(":end_date", $this->end_date, PDO::PARAM_INT);
            $pdo_statement->bindParam(":applicant_id", $this->applicant_id, PDO::PARAM_INT);
            $pdo_statement->execute();

            $this->event_id = $pdo_connection->lastInsertId();

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
                            events
                        WHERE
                            event_id = :event_id";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":event_id", $this->event_id, PDO::PARAM_INT);
            $pdo_statement->execute();
            $result = $pdo_statement->fetch(PDO::FETCH_ASSOC);

            $this->event_id = $result["event_id"];
            $this->user_id = $result["user_id"];
            $this->event_title = $result["event_title"];
            $this->event_description = $result["event_description"];
            $this->start_date = $result["start_date"];
            $this->end_date = $result["end_date"];
            $this->applicant_id = $result["applicant_id"];
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
                        events
                    SET
                        user_id = :user_id,
                        event_title = :event_title,
                        event_description = :event_description,
                        start_date = :start_date,
                        end_date = :end_date,
                        applicant_id = :applicant_id 
                    WHERE
                        event_id = :event_id";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":event_id", $this->event_id, PDO::PARAM_INT);
            $pdo_statement->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
            $pdo_statement->bindParam(":event_title", $this->event_title, PDO::PARAM_STR);
            $pdo_statement->bindParam(":event_description", $this->event_description, PDO::PARAM_STR);
            $pdo_statement->bindParam(":start_date", $this->start_date, PDO::PARAM_INT);
            $pdo_statement->bindParam(":end_date", $this->end_date, PDO::PARAM_INT);
            $pdo_statement->bindParam(":applicant_id", $this->applicant_id, PDO::PARAM_INT);
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
                            events
                        WHERE
                            event_id = :event_id";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":event_id", $this->event_id, PDO::PARAM_INT);
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
                            events
                        SET
                            $column = :$column
                        WHERE
                            event_id = :event_id";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":event_id", $this->event_id, PDO::PARAM_INT);
            $pdo_statement->bindParam(":$column", $value, PDO::PARAM_INT);
            $pdo_statement->execute();

        }
        catch(PDOException $pdoe)
        {
            throw new Exception($pdoe);
        }
    }
}

?>
