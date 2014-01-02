<?php
require_once 'payment_record.php';

class payment_records extends Spine_SuperModel
{
    private $array_of_payment_records;

    //------------------------------------------------------------------------------------
    //setter

    public function setArrayOfPaymentRecords($array_of_payment_records)
    {
        $this->array_of_payment_records = $array_of_payment_records;
    }

    //------------------------------------------------------------------------------------
    //getter

    public function getArrayOfPaymentRecords()
    {
        return $this->array_of_payment_records;
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
                            payment_records";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->execute();
            $results = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);

            foreach($results as $result)
            {
                $payment_record = new payment_record();

                $payment_record->setPaymnetRecordId($result["paymnet_record_id"]);
                $payment_record->setApplicantId($result["applicant_id"]);
                $payment_record->setAmount($result["amount"]);
                $payment_record->setOrNumber($result["or_number"]);
                $payment_record->setTimestamp($result["timestamp"]);
                $payment_record->setCredits($result["credits"]);
                $this->array_of_payment_records[] = $payment_record;

            }
        }
        catch(PDOException $pdoe)
        {
            throw new Exception($pdoe);
        }
    }
}

?>
