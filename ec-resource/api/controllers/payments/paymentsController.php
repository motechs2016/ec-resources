<?php
class paymentsController extends Spine_SuperController
{
	public function main()
	{
		$this->loadModel('payment_records/payment_record');
	}
	
	//------------------------------------------------------------------------------------
	
	public function indexAction()
	{
		
	}
	
	//------------------------------------------------------------------------------------
	
	public function payAction()
	{
		if (!empty($_POST))
		{
			$payment_record	=	new payment_record();
			
			$payment_record->applicant_id	=	$_POST['applicant_id'];
			$payment_record->amount			=	$_POST['amount'];
			$payment_record->or_number		=	$_POST['or_number'];
			$payment_record->timestamp		=	$_POST['timestamp'];
			$payment_record->credits		=	$_POST['credits'];
			
			$payment_record->insert();
			
			if ($payment_record->payment_record_id)
			{
				$this->setHeaders('HTTP/1.0 200 OK');
				$this->displayPhtml('content', 'main/content', array('output' => output(array('payment_record_id' => $payment_record->payment_record_id))));
			}
			else 
			{
				$this->setHeaders('HTTP/1.0 400 Bad Request');
				$this->displayPhtml('content', 'main/content', array('output' => output('Bad Request')));
			}
		}
		else 
		{
				$this->setHeaders('HTTP/1.0 400 Bad Request');
				$this->displayPhtml('content', 'main/content', array('output' => output('Bad Request')));
		}
	}
	
	//------------------------------------------------------------------------------------
	
	public function updateAction()
	{
		if (!empty($_POST))
		{
			$payment_record	=	new payment_record();
			
			$payment_record->applicant_id	=	$_POST['applicant_id'];
			$payment_record->amount			=	$_POST['amount'];
			$payment_record->or_number		=	$_POST['or_number'];
			$payment_record->timestamp		=	$_POST['timestamp'];
			$payment_record->credits		=	$_POST['credits'];
			
			$payment_record->insert();
			
			if ($payment_record->payment_record_id)
			{
				$this->setHeaders('HTTP/1.0 200 OK');
				$this->displayPhtml('content', 'main/content', array('output' => output(array('payment_record_id' => $payment_record->payment_record_id))));
			}
			else 
			{
				$this->setHeaders('HTTP/1.0 400 Bad Request');
				$this->displayPhtml('content', 'main/content', array('output' => output('Bad Request')));
			}
		}
		else 
		{
				$this->setHeaders('HTTP/1.0 400 Bad Request');
				$this->displayPhtml('content', 'main/content', array('output' => output('Bad Request')));
		}
	}
	
	//------------------------------------------------------------------------------------
	
	public function singleItemUpdateAction()
	{
		if (!empty($_POST))
		{
			$payment_record	=	new payment_record();
			
			$payment_record->applicant_id		=	$_POST['applicant_id'];
			
			$payment_record->updateOneColumn($_POST['section'], $_POST['value']);
			
			$this->setHeaders('HTTP/1.0 200 OK');
			$this->displayPhtml('content', 'main/content', array('output' => output('Update Successful')));
		}
		else 
		{
				$this->setHeaders('HTTP/1.0 400 Bad Request');
				$this->displayPhtml('content', 'main/content', array('output' => output('Bad Request')));
		}
	}
	
	//------------------------------------------------------------------------------------
	
	public function end()
	{
		
	}
}