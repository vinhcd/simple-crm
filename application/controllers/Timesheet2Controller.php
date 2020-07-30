<?php
require_once 'MyZendControllerAction.php';

class Timesheet2Controller extends MyZendControllerAction{

	public function init()
	{
		//$admin= Zend_Registry::get('admin');
		
	

		
	}

 public function index2Action(){
    echo Zend_Version::getLatest();
 }
	
	
public function cut_string($str, $n_chars, $crop_str = '') {
$buff = strip_tags($str);
if (mb_strlen($buff) > $n_chars) {
	$cut_index = mb_strpos($buff, ' ', $n_chars);
	$buff = mb_substr($buff, 0, ($cut_index === false ? $n_chars : $cut_index + 1), "UTF-8") . $crop_str;
}
return $buff;
}



	
  public function indexAction(){
		ini_set('display_errors', 1);
		
echo mb_substr("Global Memberに送る",0,100,'UTF-8');die;

		/*$config = array(
			'ssl' => 'ssl',
		 	'port' => '465',
		'auth' => 'login',
		'username' => 'AKIATU6BCEZC3AJK2SNV',
		'password' => 'BNg3/GdpQwoMiygGYddNvrk7cUeto3AnHIge1ebFqUyB'
		);
		
		$transport = new Zend_Mail_Transport_Smtp('	
email-smtp.us-east-1.amazonaws.com', $config);
		

		$mail = new Zend_Mail('utf-8');
        $mail->addTo("baonq@neoscorp.vn");
        $mail->setSubject('Welcome');
        $mail->setFrom('baonq@neoscorp.vn', 'baonq@neoscorp.vn');
        $mail->setBodyText("xxxxxxxxxxxxxxxxx");
        $sent = true;

        // Send the email
        try {
            $mail->send($transport);
        } catch (Exception $e) {
            echo "<pre>";
            print_r($e);

        }
		*/
		
		
	$host = 'email-smtp.us-east-1.amazonaws.com';
	$config = array(
		'auth'     => 'login',
		'username' => 'AKIATU6BCEZC3AJK2SNV',
		'password' => 'BNg3/GdpQwoMiygGYddNvrk7cUeto3AnHIge1ebFqUyB',
		'ssl'      => 'tls',
		'port'     => 587,
	);
	
	$tr = new Zend_Mail_Transport_Smtp($host, $config);
	Zend_Mail::setDefaultTransport($tr);


	$mail = new Zend_Mail('utf-8');
	$mail->addTo("baonq@neoscorp.vn");
	$mail->setSubject('Welcome');
	$mail->setFrom('neos.timesheet@gmail.com', 'neos.timesheet@gmail.com');
	$mail->setBodyText("xxxxxxxxxxxxxxxxx");
	$sent = true;

	// Send the email
	try {
		$mail->send($tr);
	} catch (Exception $e) {
		echo "<pre>";
		print_r($e);

	}


		
		die("11111111111");
	
  }  





  
}