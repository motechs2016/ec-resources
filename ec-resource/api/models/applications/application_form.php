<?php

class application_form extends Spine_SuperModel
{
	public $applicant_id;
	public $section;
	public $value;
	public $column;
	
	public function select()
	{
		try
		{
			$connection	=	Spine_DB::connection();
			$sql	=	"SELECT
							*
						FROM
							application_forms
						WHERE 
							applicant_id = :applicant_id			
			";
				
			$statement	=	$connection->prepare($sql);
			$statement->bindParam(":applicant_id", $this->applicant_id, PDO::FETCH_ASSOC);
			$statement->execute();
			return $statement->fetch(PDO::FETCH_ASSOC);	
		}
		catch (PDOException $e)
		{
			throw new Exception($e);
			die();
		}
	}
	
	//---------------------------------------------------------------------------------------
	
	public function insert()
	{
		try
		{
			$connection	=	Spine_DB::connection();
			$sql	=	"
					INSERT INTO
						application_forms
						(
							`$this->section`
						)
					VALUES
						(
							:value
						)
			";
			$statement	=	$connection->prepare($sql);
			$statement->bindParam(":value", $this->value, PDO::PARAM_STR);
			$statement->execute();
			
			$this->applicant_id	=	$connection->lastInsertId();
		}
		catch (PDOException $e)
		{
			throw new Exception($e);
			die();
		}
	}
	//---------------------------------------------------------------------------------------
	
	public function update()
	{
		try
		{
			$connection	=	Spine_DB::connection();
			$sql	= "
					UPDATE 
						application_forms
					SET 
						$this->column = :value
			";
				
			$statement	=	$connection->prepare($sql);
			$statement->bindParam(":value", $this->value, PDO::PARAM_STR);
			$status	=	$statement->execute();
			
			if ($status === TRUE)
				return TRUE;
			else
				return	$status;
		}
		catch (PDOException $e)
		{
			throw new Exception($e);
			die();
		}
	}
	
	//---------------------------------------------------------------------------------------
}