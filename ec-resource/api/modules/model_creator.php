<?php
/*
 * @author Raymart Marasigan
 * @data 11/2/2013
 * 
 * This class will generate a singular and plural model
 * 
 * @params properties = properties of your singular class
 * @params class_name = class name of your singular class
 * @params comment line = the comment line
 * @params table = table of the database
 * @params plural_properties = properties of your plural class
 * @params plural_class_name = class name of your plural class
 */

class modelGenerator
{
	public $properties = array(
		"video_id" 	  => "INT",
		"embed_text" => "STR",
		"date_created"    => "STR",
		"user_id"   => "INT"
	);
	
	public $class_name = "teleworker_video";
	public $table = "teleworker_videos";
	public $plural_properties = array(
		"array_of_videos" => "STR"
	);	
	public $plural_class_name = "teleworker_videos";
	
	public $comment_line = "//------------------------------------------------------------------------------------";
	public $tab = "    ";
	//-------------------------------------------------------------------------------------------------------------------------------------
	
	public function generatePluralClass()
	{
		$content = "<?php".PHP_EOL;
		$content .= "require_once '{$this->class_name}.php';".PHP_EOL.PHP_EOL;
		$content .= "class {$this->plural_class_name} extends	Spine_SuperModel".PHP_EOL;
		$content .= "{".PHP_EOL;
		
		$content .= $this->generatePluralVariableDeclaration();
		$content .= $this->generatePluralSetter();
		$content .= $this->generatePluralGetter();
		$content .= $this->generatePluralSelectStatement();
		
		$content .= "}".PHP_EOL;
		$content .= PHP_EOL."?>".PHP_EOL;
		
		file_put_contents("{$this->plural_class_name}.php", $content);
	}

	public function generatePluralSetter()
	{
		//setter
		$setter = PHP_EOL;
		$setter .= $this->tab.$this->comment_line.PHP_EOL;
		$setter .= $this->tab."//setter".PHP_EOL;
	
		foreach($this->plural_properties as $property => $data_type)
		{
			$setter .= PHP_EOL;
			$setter .= $this->tab."public function set".$this->buildCamelString($property).'($'.$property.')'.PHP_EOL;
			$setter .= $this->tab."{".PHP_EOL;
			$setter .= $this->tab.$this->tab.'$this->'.$property." = ".'$'.$property.";".PHP_EOL;
			$setter .= $this->tab."}".PHP_EOL;
		}
	
		return $setter;
	}
	
	public function generatePluralGetter()
	{
		//getter
		$getter = PHP_EOL;
		$getter .= $this->tab.$this->comment_line.PHP_EOL;
		$getter .= $this->tab."//getter".PHP_EOL;
	
		foreach($this->plural_properties as $property => $data_type)
		{
		    $getter .= PHP_EOL;
			$getter .= $this->tab."public function get".$this->buildCamelString($property).'()'.PHP_EOL;
			$getter .= $this->tab."{".PHP_EOL;
			$getter .= $this->tab.$this->tab.'return $this->'.$property.";".PHP_EOL;
			$getter .= $this->tab."}".PHP_EOL;
		}
	
		return $getter;
	}
	
	private function generatePluralVariableDeclaration()
	{
		$variables = "";	
		foreach($this->plural_properties as $property => $data_type)
			$variables .= $this->tab.'private $'.$property.';'.PHP_EOL;

		return $variables;
	}
	
	public function generatePluralSelectStatement()
	{
		$data_type   = reset($this->plural_properties); // First Element's Value
		$firs_properties = key($this->plural_properties);
		
		$select = PHP_EOL;
		$select .= $this->tab.$this->comment_line.PHP_EOL;
		$select .= PHP_EOL;
	
		$select .= $this->tab."public function select()".PHP_EOL;
		$select .= $this->tab."{".PHP_EOL;
		$select .= $this->tabs(2)."try".PHP_EOL;
		$select .= $this->tabs(2)."{".PHP_EOL;
	
		$select .= $this->tabs(3).'$pdo_connection = Spine_DB::connection();'.PHP_EOL;
		$select .= $this->tabs(3).'$sql = "SELECT'.PHP_EOL;
		$select .= $this->tabs(7).'*'.PHP_EOL;
		$select .= $this->tabs(6)."FROM".PHP_EOL;
		$select .= $this->tabs(7).$this->table.'";'.PHP_EOL;
	
		$select .= PHP_EOL.$this->tabs(3).'$pdo_statement = $pdo_connection->prepare($sql);'.PHP_EOL;
		$select .= $this->tabs(3).'$pdo_statement->execute();'.PHP_EOL;
		$select .= $this->tabs(3).'$results = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);'.PHP_EOL;
		$select .= PHP_EOL;
	
		$select .= $this->tabs(3).'foreach($results as $result)'.PHP_EOL;
		$select .= $this->tabs(3)."{".PHP_EOL;
		$select .= $this->tabs(4).'$'.$this->class_name." = new {$this->class_name}();".PHP_EOL.PHP_EOL;
		
		foreach($this->properties as $property => $data_type)
			$select .= $this->tabs(4).'$'.$this->class_name."->set".$this->buildCamelString($property).'($result["'.$property.'"]);'.PHP_EOL;
		
		$select .= $this->tabs(4).'$this->'.$firs_properties."[] = ".'$'."{$this->class_name};".PHP_EOL.PHP_EOL;

		$select .= $this->tabs(3)."}".PHP_EOL;
		$select .= $this->tab.$this->tab."}".PHP_EOL;
		$select .= $this->tabs(2).'catch(PDOException $pdoe)'.PHP_EOL;
		$select .= $this->tabs(2)."{".PHP_EOL;
		$select .= $this->tabs(3).'throw new Exception($pdoe);'.PHP_EOL;
		$select .= $this->tabs(2)."}".PHP_EOL;
	
		$select .= $this->tab."}".PHP_EOL;
	
		return $select;
	}
	
	
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	
	public function generateSingularClass()
	{
		$content = "<?php".PHP_EOL;
		$content .= "class {$this->plural_class_name} extends	Spine_SuperModel".PHP_EOL;
		$content .= "{".PHP_EOL;
		
		$content .= $this->generateVariableDeclaration();
		$content .= $this->generateSetter();
		$content .= $this->generateGetter();
		$content .= $this->generateInsertStatement();
		$content .= $this->generateSelectStatement();
		$content .= $this->generateUpdateStatement();
		$content .= $this->generateDeleteStatement();
		$content .= $this->generateUpdateOneColumn();
		
		$content .= "}".PHP_EOL;
		$content .= PHP_EOL."?>".PHP_EOL;
		
		file_put_contents("{$this->class_name}.php", $content);
	
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	
	private function generateVariableDeclaration()
	{
	
		//declare the variable here
		$tab = "    ";
		$variables = "";
		foreach($this->properties as $property => $data_type)
			$variables .= $tab.'private $'.$property.';'.PHP_EOL;
		
		return $variables;
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------------	
   
   public function generateSetter()
   {
   		//getter
		$setter = PHP_EOL;
		$setter .= $this->tab.$this->comment_line.PHP_EOL;
		$setter .= $this->tab."//setter".PHP_EOL;
		
		foreach($this->properties as $property => $data_type)
		{
		    $setter .= PHP_EOL;
			$setter .= $this->tab."public function set".$this->buildCamelString($property).'($'.$property.')'.PHP_EOL;
			$setter .= $this->tab."{".PHP_EOL;
			$setter .= $this->tab.$this->tab.'$this->'.$property." = ".'$'.$property.";".PHP_EOL;
			$setter .= $this->tab."}".PHP_EOL;
		}
		
		return $setter;
   }
   
   	//-------------------------------------------------------------------------------------------------------------------------------------	
   
   public function generateGetter()
   {
   		//getter
		$getter = PHP_EOL;
		$getter .= $this->tab.$this->comment_line.PHP_EOL;
		$getter .= $this->tab."//getter".PHP_EOL;
		
		foreach($this->properties as $property => $data_type)
		{
		    $getter .= PHP_EOL;
			$getter .= $this->tab."public function get".$this->buildCamelString($property).'()'.PHP_EOL;
			$getter .= $this->tab."{".PHP_EOL;
			$getter .= $this->tab.$this->tab.'return $this->'.$property.";".PHP_EOL;
			$getter .= $this->tab."}".PHP_EOL;
		}
		
		return $getter;
   }
   
   public function generateSelectStatement()
   {
        $data_type   = reset($this->properties); // First Element's Value
		$primary_key = key($this->properties);
		
	
	    $select = PHP_EOL;
		$select .= $this->tab.$this->comment_line.PHP_EOL;
		$select .= PHP_EOL;
		
		$select .= $this->tab."public function select()".PHP_EOL;
		$select .= $this->tab."{".PHP_EOL;
		$select .= $this->tabs(2)."try".PHP_EOL;
		$select .= $this->tabs(2)."{".PHP_EOL;
		
		$select .= $this->tabs(3).'$pdo_connection = Spine_DB::connection();'.PHP_EOL;
		$select .= $this->tabs(3).'$sql = "SELECT'.PHP_EOL;
		$select .= $this->tabs(7).'*'.PHP_EOL;
		$select .= $this->tabs(6)."FROM".PHP_EOL;
		$select .= $this->tabs(7).$this->table."".PHP_EOL;
		$select .= $this->tabs(6)."WHERE".PHP_EOL;
		$select .= $this->tabs(7).$primary_key." = :".$primary_key.'";'.PHP_EOL;
		
		$select .= PHP_EOL.$this->tabs(3).'$pdo_statement = $pdo_connection->prepare($sql);'.PHP_EOL;
		$select .= $this->tabs(3).'$pdo_statement->bindParam(":'.$primary_key.'", $this->'.$primary_key.', PDO::PARAM_'.$data_type.');'.PHP_EOL;
		$select .= $this->tabs(3).'$pdo_statement->execute();'.PHP_EOL;
		$select .= $this->tabs(3).'$result = $pdo_statement->fetch(PDO::FETCH_ASSOC);'.PHP_EOL;
		$select .= PHP_EOL;
		
		foreach($this->properties as $property => $data_type)
		{
			$select .= $this->tabs(3).'$this->'.$property.' = $result["'.$property.'"];'.PHP_EOL;
		}
		
		$select .= $this->tab.$this->tab."}".PHP_EOL;
		$select .= $this->tabs(2).'catch(PDOException $pdoe)'.PHP_EOL;
		$select .= $this->tabs(2)."{".PHP_EOL;
		$select .= $this->tabs(3).'throw new Exception($pdoe);'.PHP_EOL;
		$select .= $this->tabs(2)."}".PHP_EOL;
		
		$select .= $this->tab."}".PHP_EOL;
		
		return $select;
   }
	
  //---------------------------------------------------------------------------------------------------------------------	
	
   public function generateUpdateStatement()
   {
        $data_type   = reset($this->properties); // First Element's Value
		$primary_key = key($this->properties);
		$last_key = key( array_slice( $this->properties, -1, 1, TRUE ) );
				
	    $update = PHP_EOL;
		$update .= $this->tab.$this->comment_line.PHP_EOL;
		$update .= PHP_EOL;
		
		$update .= $this->tab."public function update()".PHP_EOL;
		$update .= $this->tab."{".PHP_EOL;
		$update .= $this->tabs(2)."try".PHP_EOL;
		$update .= $this->tabs(2)."{".PHP_EOL;
		
		$update .= $this->tabs(3).'$pdo_connection = starfishDatabase::getConnection();'.PHP_EOL;
		$update .= $this->tabs(3).'$sql = "UPDATE'.PHP_EOL;
		$update .= $this->tabs(6).$this->table.PHP_EOL;
		$update .= $this->tabs(5)."SET".PHP_EOL;

		$bind_params = "";
		foreach($this->properties as $property => $data_type)	
		{
			if($property != $primary_key)
			{
				if($property == $last_key)
					$update .= $this->tabs(6)."$property = :$property ".PHP_EOL;
				else			
					$update .= $this->tabs(6)."$property = :$property,".PHP_EOL;
			}
			
			$bind_params .= $this->tabs(3).'$pdo_statement->bindParam(":'.$property.'", $this->'.$property.', PDO::PARAM_'.$data_type.');'.PHP_EOL;
		}
		
		$update .= $this->tabs(5)."WHERE".PHP_EOL;
		$update .= $this->tabs(6).$primary_key." = :".$primary_key.'";'.PHP_EOL;
		
		$update .= PHP_EOL.$this->tabs(3).'$pdo_statement = $pdo_connection->prepare($sql);'.PHP_EOL;
		
 		$update .= $bind_params;
		$update .= $this->tabs(3).'$pdo_statement->execute();'.PHP_EOL;
		$update .= PHP_EOL;
		
		$update .= $this->tab.$this->tab."}".PHP_EOL;
		$update .= $this->tabs(2).'catch(PDOException $pdoe)'.PHP_EOL;
		$update .= $this->tabs(2)."{".PHP_EOL;
		$update .= $this->tabs(3).'throw new Exception($pdoe);'.PHP_EOL;
		$update .= $this->tabs(2)."}".PHP_EOL;
		
		$update .= $this->tab."}".PHP_EOL;
		
		return $update;
   }
	
   //---------------------------------------------------------------------------------------------------------------------	
	
   public function generateDeleteStatement()
   {
   		$data_type   = reset($this->properties); // First Element's Value
   		$primary_key = key($this->properties);
   	
   		$delete = PHP_EOL;
   		$delete .= $this->tab.$this->comment_line.PHP_EOL;
   		$delete .= PHP_EOL;
   	
   		$delete .= $this->tab."public function delete()".PHP_EOL;
   		$delete .= $this->tab."{".PHP_EOL;
   		$delete .= $this->tabs(2)."try".PHP_EOL;
   		$delete .= $this->tabs(2)."{".PHP_EOL;
   	
   		$delete .= $this->tabs(3).'$pdo_connection = starfishDatabase::getConnection();'.PHP_EOL;
   		$delete .= $this->tabs(3).'$sql = "DELETE FROM'.PHP_EOL;
   		$delete .= $this->tabs(7).$this->table."".PHP_EOL;
   		$delete .= $this->tabs(6)."WHERE".PHP_EOL;
   		$delete .= $this->tabs(7).$primary_key." = :".$primary_key.'";'.PHP_EOL;
   	
   		$delete .= PHP_EOL.$this->tabs(3).'$pdo_statement = $pdo_connection->prepare($sql);'.PHP_EOL;
   		$delete .= $this->tabs(3).'$pdo_statement->bindParam(":'.$primary_key.'", $this->'.$primary_key.', PDO::PARAM_'.$data_type.');'.PHP_EOL;
   		$delete .= $this->tabs(3).'$pdo_statement->execute();'.PHP_EOL;
   		$delete .= PHP_EOL;
   	
   		$delete .= $this->tab.$this->tab."}".PHP_EOL;
   		$delete .= $this->tabs(2).'catch(PDOException $pdoe)'.PHP_EOL;
   		$delete .= $this->tabs(2)."{".PHP_EOL;
   		$delete .= $this->tabs(3).'throw new Exception($pdoe);'.PHP_EOL;
   		$delete .= $this->tabs(2)."}".PHP_EOL;
   	
   		$delete .= $this->tab."}".PHP_EOL;
   	
   		return $delete;
   }
	
   //---------------------------------------------------------------------------------------------------------------------	

   public function generateUpdateOneColumn()
   {
   	
	   	$data_type   = reset($this->properties); // First Element's Value
	   	$primary_key = key($this->properties);
	   	
	   	$statement = PHP_EOL;
	   	$statement .= $this->tab.$this->comment_line.PHP_EOL;
	   	$statement .= PHP_EOL;
	   	
	   	$statement .= $this->tab.'public function updateOneColumn($column, $value)'.PHP_EOL;
	   	$statement .= $this->tab."{".PHP_EOL;
	   	$statement .= $this->tabs(2)."try".PHP_EOL;
	   	$statement .= $this->tabs(2)."{".PHP_EOL;
	   	
	   	$statement .= $this->tabs(3).'$pdo_connection = starfishDatabase::getConnection();'.PHP_EOL;
	   	$statement .= $this->tabs(3).'$sql = "UPDATE'.PHP_EOL;
	   	$statement .= $this->tabs(7).$this->table."".PHP_EOL;
	   	$statement .= $this->tabs(6)."SET".PHP_EOL;
	   	$statement .= $this->tabs(7).'$column = :$column'.PHP_EOL;
	   	$statement .= $this->tabs(6)."WHERE".PHP_EOL;
	   	$statement .= $this->tabs(7).$primary_key." = :".$primary_key.'";'.PHP_EOL;
	   	 
	   	
	   	$statement .= PHP_EOL.$this->tabs(3).'$pdo_statement = $pdo_connection->prepare($sql);'.PHP_EOL;
	   	$statement .= $this->tabs(3).'$pdo_statement->bindParam(":'.$primary_key.'", $this->'.$primary_key.', PDO::PARAM_'.$data_type.');'.PHP_EOL;
	   	$statement .= $this->tabs(3).'$pdo_statement->bindParam(":$column", $value, PDO::PARAM_'.$data_type.');'.PHP_EOL;
	   	$statement .= $this->tabs(3).'$pdo_statement->execute();'.PHP_EOL;
	   	$statement .= PHP_EOL;
	   	
	   	$statement .= $this->tab.$this->tab."}".PHP_EOL;
	   	$statement .= $this->tabs(2).'catch(PDOException $pdoe)'.PHP_EOL;
	   	$statement .= $this->tabs(2)."{".PHP_EOL;
	   	$statement .= $this->tabs(3).'throw new Exception($pdoe);'.PHP_EOL;
	   	$statement .= $this->tabs(2)."}".PHP_EOL;
	   	
	   	$statement .= $this->tab."}".PHP_EOL;
	   	
	   	return $statement;
   }
   
   
   public function generateInsertStatement()
   {
	   	$data_type   = reset($this->properties); // First Element's Value
		$primary_key = key($this->properties);
		$last_key = key( array_slice( $this->properties, -1, 1, TRUE ) );
				
	    $insert = PHP_EOL;
		$insert .= $this->tab.$this->comment_line.PHP_EOL;
		$insert .= PHP_EOL;
		
		$insert .= $this->tab."public function insert()".PHP_EOL;
		$insert .= $this->tab."{".PHP_EOL;
		$insert .= $this->tabs(2)."try".PHP_EOL;
		$insert .= $this->tabs(2)."{".PHP_EOL;
		
		$insert .= $this->tabs(3).'$pdo_connection = starfishDatabase::getConnection();'.PHP_EOL;
		$insert .= $this->tabs(3).'$sql = "INSERT INTO'.PHP_EOL;
		$insert .= $this->tabs(6).$this->table.PHP_EOL;
		$insert .= $this->tabs(6)."(".PHP_EOL;

		$bind_params = "";
		$values = "";
		foreach($this->properties as $property => $data_type)	
		{
			if($property != $primary_key)
			{
				$bind_params .= $this->tabs(3).'$pdo_statement->bindParam(":'.$property.'", $this->'.$property.', PDO::PARAM_'.$data_type.');'.PHP_EOL;
				
				if($property == $last_key)
				{
					$insert .= $this->tabs(7)."$property".PHP_EOL;
					$values .= $this->tabs(7).":$property".PHP_EOL;
				}
				else
				{
					$insert .= $this->tabs(7)."$property,".PHP_EOL;
					$values .= $this->tabs(7).":$property,".PHP_EOL;
				}			
			}
		}
		
		$insert .= $this->tabs(6).")".PHP_EOL;
		$insert .= $this->tabs(5)."VALUES".PHP_EOL;
		$insert .= $this->tabs(6)."(".PHP_EOL;
		$insert .= $values;
		$insert .= $this->tabs(6).')";'.PHP_EOL;
		
		
		$insert .= PHP_EOL.$this->tabs(3).'$pdo_statement = $pdo_connection->prepare($sql);'.PHP_EOL;
		
 		$insert .= $bind_params;
		$insert .= $this->tabs(3).'$pdo_statement->execute();'.PHP_EOL;
		$insert .= PHP_EOL;
		$insert .= $this->tabs(3).'$this->'.$primary_key.' = $pdo_connection->lastInsertId();'.PHP_EOL;
		$insert .= PHP_EOL;
		
		$insert .= $this->tab.$this->tab."}".PHP_EOL;
		$insert .= $this->tabs(2).'catch(PDOException $pdoe)'.PHP_EOL;
		$insert .= $this->tabs(2)."{".PHP_EOL;
		$insert .= $this->tabs(3).'throw new Exception($pdoe);'.PHP_EOL;
		$insert .= $this->tabs(2)."}".PHP_EOL;
		
		$insert .= $this->tab."}".PHP_EOL;
		
		return $insert;
   }
   
   //-------------------------------------------------------------------------------------------------------------------------------------
	
	//camel string
	private function buildCamelString($string)
	{
		$string =  explode("_", $string);

		$camel_string = "";
		for($i=0; $i<count($string); $i++)
		{
			$camel_string .= ucfirst($string[$i]);
		}
		
		return $camel_string;
	}
	
    //-------------------------------------------------------------------------------------------------------------------------------------
	
	private function tabs($times)
	{
		$tabs = "";
		for($i=0; $i<$times; $i++)
			$tabs .= $this->tab;
			
		return $tabs;
	}
	
	
	private function lb($times)
	{
		$lb = "";
		for($i=0; $i<$times; $i++)
			$lb .= PHP_EOL;
			
		return $lb;
	}
	
	
}



$generator = new modelGenerator();
$generator->generateSingularClass();
$generator->generatePluralClass();







?>