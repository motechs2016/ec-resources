<?php
require_once 'event.php';

class events extends Spine_SuperModel
{
    private $array_of_events;

    //------------------------------------------------------------------------------------
    //setter

    public function setArrayOfEvents($array_of_events)
    {
        $this->array_of_events = $array_of_events;
    }

    //------------------------------------------------------------------------------------
    //getter

    public function getArrayOfEvents()
    {
        return $this->array_of_events;
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
                            events";

            $pdo_statement = $pdo_connection->prepare($sql);
            $pdo_statement->execute();
            $results = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);

            foreach($results as $result)
            {
                $event = new event();

                $event->setEventId($result["event_id"]);
                $event->setUserId($result["user_id"]);
                $event->setEventTitle($result["event_title"]);
                $event->setEventDescription($result["event_description"]);
                $event->setStartDate($result["start_date"]);
                $event->setEndDate($result["end_date"]);
                $event->setApplicantId($result["applicant_id"]);
                $this->array_of_events[] = $event;

            }
        }
        catch(PDOException $pdoe)
        {
            throw new Exception($pdoe);
        }
    }
}

?>
