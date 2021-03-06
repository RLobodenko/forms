<?php    
if( isset($_POST['submit']) )
{
	$fname=$_POST['fname'];
	$lname="";
	$email=$_POST['email'];
	$subject=$_POST['subject'];
	$message=$_POST['message'];
	$contact_data = array(
		"fname" => $fname,
		"lname" => $lname,
		"email" => $email,
		"subject" => $subject,
		"message" => $message,
		
	);
	
	$ans_hubspot = new ans_hubspot();
	$ans_hubspot->contact_create($contact_data);
    
}
class ans_hubspot{
	private $hapikey = "26fac5ce-48aa-4097-91d0-cc55e7d8bbc0";
	function list_assign_contact($lid, $email){
		(object)$arr = array(
			"email" => array($email)
		);
        $post_json = json_encode($arr);
        $endpoint = 'https://api.hubapi.com/contacts/v1/lists/'.$lid.'/add?hapikey=' . $this->hapikey;
		$this->http($endpoint,$post_json);
	}	
	
	
	function list_create($list_name){
		$arr = array(
		    "name" => $list_name,
		    "dynamic" => false,
		    "filters" => array(
		    	array(
		    		(object)array(
						"operator" => "EQ",
						"value" => "@hubspot",
						"property" => "twitterhandle",
						"type" => "string"
					)
            	)  
		    )
		);
        $post_json = json_encode($arr);
        $endpoint = 'https://api.hubapi.com/contacts/v1/lists?hapikey=' . $this->hapikey;
		$this->http($endpoint,$post_json);
	}
	function contact_create($contact_data){
     $arr = array(
        'properties' => array(
           array(
                'property' => 'subject',
                'value' => $contact_data["subject"]
            ),
            array(
                'property' => 'message',
                'value' => $contact_data["message"]
            ),
			array(
                'property' => 'email',
                'value' => $contact_data["email"]
            ),
			array(
                'property' => 'lastname',
                'value' => $contact_data["lname"]
            ),
            array(
                'property' => 'firstname',
                'value' => $contact_data["fname"]
            )
            
        )
    );
        $post_json = json_encode($arr);
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact?hapikey=' . $this->hapikey;
		$this->http($endpoint,$post_json);
	}
	
	function http($endpoint,$post_json){
        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_POST, true);
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
        @curl_setopt($ch, CURLOPT_URL, $endpoint);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = @curl_exec($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errors = curl_error($ch);
        @curl_close($ch);
        return $response . "<hr>";
       
	}
}
