<?php
class payment_record extends Spine_SuperModel
{
    public $payment_record_id;
    public $applicant_id;
    public $amount;
    public $or_number;
    public $timestamp;
    public $credits;

    //------------------------------------------------------------------------------------
    //setter

    public function setpaymentRecordId($payment_record_id)
    {
        $this->payment_record_id = $payment_record_id;
    }

    public function setApplicantId($applicant_id)
    {
        $this->applicant_id = $applicant_id;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setOrNumber($or_number)
    {
        $this->or_number = $or_number;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function setCredits($credits)
    {
        $this->credits = $credits;
    }

    //------------------------------------------------------------------------------------
    //getter

    public function getpaymentRecordId()
    {
        return $this->payment_record_id;
    }

    public function getApplicantId()
    {
        return $this->applicant_id;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getOrNumber()
    {
        return $this->or_number;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getCredits()
    {
        return $this->credits;
    }

    //------------------------------------------------------------------------------------

    public function insert()
    {
        try
        {
            $pdo_connection = Spine_DB::connection();
            $sql = "INSERT INTO
                        payment_records
                        (
                            applicant_id,
                            amount,
                            or_number,
                            timestamp,
                            credits
                        )
                    VALUES
                        (
                            :applicant_id,
                            :amount,
                            :or_number,
                            :timestamp,
                            :credits
                        )";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":applicant_id", $this->applicant_id, PDO::PARAM_INT);
            $pdo_statement->bindParam(":amount", $this->amount, PDO::PARAM_STR);
            $pdo_statement->bindParam(":or_number", $this->or_number, PDO::PARAM_STR);
            $pdo_statement->bindParam(":timestamp", $this->timestamp, PDO::PARAM_INT);
            $pdo_statement->bindParam(":credits", $this->credits, PDO::PARAM_INT);
            $pdo_statement->execute();

            $this->payment_record_id = $pdo_connection->lastInsertId();

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
                            payment_records
                        WHERE
                            payment_record_id = :payment_record_id";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":payment_record_id", $this->payment_record_id, PDO::PARAM_INT);
            $pdo_statement->execute();
            $result = $pdo_statement->fetch(PDO::FETCH_ASSOC);

            $this->payment_record_id = $result["payment_record_id"];
            $this->applicant_id = $result["applicant_id"];
            $this->amount = $result["amount"];
            $this->or_number = $result["or_number"];
            $this->timestamp = $result["timestamp"];
            $this->credits = $result["credits"];
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
                        payment_records
                    SET
                        applicant_id = :applicant_id,
                        amount = :amount,
                        or_number = :or_number,
                        timestamp = :timestamp,
                        credits = :credits 
                    WHERE
                        payment_record_id = :payment_record_id";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":payment_record_id", $this->payment_record_id, PDO::PARAM_INT);
            $pdo_statement->bindParam(":applicant_id", $this->applicant_id, PDO::PARAM_INT);
            $pdo_statement->bindParam(":amount", $this->amount, PDO::PARAM_STR);
            $pdo_statement->bindParam(":or_number", $this->or_number, PDO::PARAM_STR);
            $pdo_statement->bindParam(":timestamp", $this->timestamp, PDO::PARAM_INT);
            $pdo_statement->bindParam(":credits", $this->credits, PDO::PARAM_INT);
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
                            payment_records
                        WHERE
                            payment_record_id = :payment_record_id";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":payment_record_id", $this->payment_record_id, PDO::PARAM_INT);
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
                            payment_records
                        SET
                            $column = :$column
                        WHERE
                            payment_record_id = :payment_record_id";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->bindParam(":payment_record_id", $this->payment_record_id, PDO::PARAM_INT);
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
