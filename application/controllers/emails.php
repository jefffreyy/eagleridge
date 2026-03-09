<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;
use Mailgun\Mailgun;
require_once 'vendor/autoload.php';

class emails extends CI_Controller {
    function send2(){
        # Instantiate the client.
        $mgClient = Mailgun::create('b211923531c27be4274bd09815bf6275-5e3f36f5-22389f7e');
        try{
        $domain = "sandboxf58f83783947462eab83fa5a9d5dff4a.mailgun.org";
        // # Make the call to the client.
        $result = $mgClient->messages()->send($domain,
        	array('from'    => 'Mailgun Sandbox <postmaster@sandboxf58f83783947462eab83fa5a9d5dff4a.mailgun.org>',
        		  'to'      => 'Kevin Del Rosario Evaristo <evaristo.kevin@technos-systems.com>',
        		  'subject' => 'Hello Kevin Del Rosario Evaristo',
        		  'text'    => 'Congratulations Kevin Del Rosario Evaristo, you just sent an email with Mailgun!  You are truly awesome! '
                  )
                );
        echo '<pre>';
        var_dump($result);
            // if ($result->http_response_code !== 200) {
            //     echo "Email sending failed. Error: " . $result->http_response_body->message;
            // } else {
            //     echo "Email sent successfully!";
            // }
        }catch (\Exception $e) {
            // Handle exceptions or errors
            echo "An error occurred: " . $e->getMessage();
        }

    }
    function send(){
        $mail = new PHPMailer(true);
        $mail->isSMTP();
		$mail->Host = 'localhost';
		$mail->Port = 25;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = false;
		$mail->Username="no-reply@eyebox.app";
		$mail->Password="Technos@123";
		$mail->IsSendmail();
		$mail->From="no-reply@eyebox.app";
		$mail->FromName="Technos";
		$mail->AddAddress('aldrinlobis1@gmail.com');
		$mail->Subject="Request Status";
		$mail->WordWrap;
		$mail->MsgHTML("<p>Hello EMail<p>");
		$mail->IsHTML();
		if($mail->Send()){
		    echo 'Message sent';
		}else{
		    echo  $mail->ErrorInfo;
		}
// 		$mail->SMTPSecure = "tls";
// 		$mail->SMTPSecure = 'ssl';
    }
    function test_email(){
        $this->load->view('test_email');
    }
    function send_mail(){
        $from='no-reply@eyebox.app';
        $to="aldrinlobis1@gmail.com";
        $subject="TestEmail";
        $message="PHP mail works fine.";
        $headers="From:".$from;
        if(mail($to,$subject,$message,$headers)){
            echo "The email was sent";
        }else{
            echo "Errors";
        }
    }
	public function index()
	{
		
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 25;
// 		$mail->SMTPSecure = "tls";
// 		$mail->SMTPSecure = 'ssl';
		$mail->SMTPAuth = false;
		$mail->AuthType = 'XOAUTH2';
		$email          = 'aldrinlobis1@gmail.com'; // the email used to register google app
		$clientId       = '957746875312-ggvgsvovj8gm6ut1ktfiqnhkqf0navgq.apps.googleusercontent.com';
		$clientSecret   = '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';
		$refreshToken   ='1//0gZlha7mrCVPvCgYIARAAGBASNwF-L9IrP4YCEut7LDML8pr5gT34wfWpxAhuyzWFHUYiH-jcH91IHGYVbIaDnoQ3PlbkhNoHvP4';
		//Create a new OAuth2 provider instance
		$provider = new Google(
			[
				'clientId' => $clientId,
				'clientSecret' => $clientSecret,
			]
		);

		//Pass the OAuth provider instance to PHPMailer
		$mail->setOAuth(
			new OAuth(
				[
					'provider' => $provider,
					'clientId' => $clientId,
					'clientSecret' => $clientSecret,
					'refreshToken' => $refreshToken,
					'userName' => $email,
				]
			)
		);
		$content="<p>Dear Aldrin,</p>

		<p>We hope this email finds you well. At Technos, we strive to provide valuable content and updates that matter to you.</p>

		<h2>In this week's newsletter:</h2>
		<ol>
			<li><strong>Exclusive Tips:</strong> Discover expert tips on improving productivity.</li>
			<li><strong>Featured Article:</strong> Our latest article on [relevant topic].</li>
			<li><strong>Upcoming Events:</strong> Don't miss out on our upcoming webinars or events.</li>
		</ol>

		<p>[Optional Personalized Content or Recommendations]</p>

		<p>We value your time and privacy. You can manage your email preferences or unsubscribe at any time using the links below.</p>

		<p>Thank you for being a part of our community!</p>

		<p>Best Regards,<br>
			Aldrin<br>
			Junior Web<br>
			091253648372
		</p>";
		$mail->setFrom($email, 'Aldrin');
		$mail->addAddress('aldrinlobis12@gmail.com', 'Aldrin');
		$mail->isHTML(true);
		$mail->Subject = 'Your Weekly Newsletter from Technos';
		$mail->Body = $content;

		//send the message, check for errors
		if (!$mail->Send()) {
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Message sent!';
		}

    }
    function send3(){
        $mail = new PHPMailer();
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.mailgun.org';                     // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'postmaster@sandboxf58f83783947462eab83fa5a9d5dff4a.mailgun.org';   // SMTP username
        $mail->Password = 'secret';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable encryption, only 'tls' is accepted
        
        $mail->From = 'YOU@sandboxf58f83783947462eab83fa5a9d5dff4a.mailgun.org';
        $mail->FromName = 'Mailer';
        $mail->addAddress('aldrinlobis1@gmail.com');                 // Add a recipient
        
        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        
        $mail->Subject = 'Hello';
        $mail->Body    = 'Testing some Mailgun awesomness';
        
        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }
    // Example function to send an email using Gmail API
    function send_email_via_api() {
        // // Fetch OAuth token
        // $access_token = 'ya29.a0AfB_byD6Yzu0xNHnsJGLtlY2TIkOL2OCyL7zcCMUSXmbHeuK0g1XIX_wxKcI2czwjDXh7w8o_H6PRP64mKryWxqzJQZMvh_WRu3aIzWySshj_V-E_E3B1u_TOE3SlE8DEzoaGntznfWQEbwXhabmKf0C7bb9NEn90c9FaCgYKATMSARMSFQHGX2Mi9NKESygmDKIS-GK20PL9KA0171'; // Replace with your access token
    
        // // Construct the email content
        // $email_content = "From: aldrinlobis1@gmail.com\r\nTo: aldrinlobis12@gmail.com\r\nSubject: Test Subject\r\n\r\nTest email body";
    
        // // Base64 encode the email content
        // $base64EncodedEmail = rtrim(strtr(base64_encode($email_content), '+/', '-_'), '=');
    
        // // Gmail API endpoint to send email
        // $url = 'https://www.googleapis.com/gmail/v1/users/me/messages/send';
    
        // // Construct headers with authorization
        // $headers = [
        //     'Authorization: Bearer ' . $access_token,
        //     'Content-Type: application/json'
        // ];
    
        // // Construct the request body
        // $data = [
        //     'raw' => $base64EncodedEmail
        // ];
    
        // // Convert data to JSON
        // $postData = json_encode($data);
    
        // // Initialize cURL session
        // $ch = curl_init();
    
        // // Set cURL options
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // // Execute cURL request
        // $response = curl_exec($ch);
    
        // // Close cURL session
        // curl_close($ch);
    
        // // Process the response
        // var_dump($response); // Handle the response as per your requirements
        // Assuming $refreshToken contains your refresh token
        // Make sure to replace 'YOUR_CLIENT_ID' and 'YOUR_CLIENT_SECRET' with your actual values
        $postData = [
            'client_id' => '957746875312-ggvgsvovj8gm6ut1ktfiqnhkqf0navgq.apps.googleusercontent.com',
            'client_secret' => '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',
            'refresh_token' => '1//0gZlha7mrCVPvCgYIARAAGBASNwF-L9IrP4YCEut7LDML8pr5gT34wfWpxAhuyzWFHUYiH-jcH91IHGYVbIaDnoQ3PlbkhNoHvP4',
            'grant_type' => 'refresh_token'
        ];
        

        $url = 'https://oauth2.googleapis.com/token';
        
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        echo '<pre>';
        var_dump($ch);
        $response = curl_exec($ch);
        curl_close($ch);

        $newTokenData = json_decode($response, true);
        
        if (isset($newTokenData['access_token'])) {
            // Use the new access token for your API request
            $newAccessToken = $newTokenData['access_token'];
        } else {
            // Handle the case where you couldn't obtain a new token (e.g., log the error, retry later, etc.)
            echo "Failed to obtain a new access token.";
        }

    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */