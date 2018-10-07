<?php

$db_name = "dbname";
$mysql_username = "username";
$server_name = "servername";
$mysql_password = "password";
$result = "false";

if($_POST){
   
    $connection = mysqli_connect($server_name, $mysql_username,$mysql_password, $db_name);

    if($connection){
        //echo "Success: ";
    }else{
        die("false");
    }
 
    $cap = $_POST['cap'];
    $name = $_POST['name'];
    $college = $_POST['college'];
    $year = $_POST['year'];
    $email = $_POST['email'];
    $contact = $_POST['phone'];
    $convoid = $_POST['convid'];
  
  	
  
  
  
    
    $insert_query = "INSERT INTO `payments` (  `name`,  `email`,  `contact`, `college`, `year`, `convoid`, `cap`) VALUES (  '$name', '$email','$contact','$college', '$year', '$convoid',  '$cap')";
    
    if($connection->query($insert_query) === TRUE){
        
        error_reporting(E_ALL);
        require("class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->IsSMTP(); // set mailer to use SMTP
        
        $mail->SMTPAuth = true;
        $mail->From = "server email";//e.x.,   info@convolutionrgpv.in
        $mail->FromName = "from name"; // convolution
        $mail->Host = "host name";// specify smtp server e.x., smtp.convolutionrgpv.in
        $mail->SMTPSecure= "TLS"; // Used instead of TLS when only POP mail is selected
        $mail->Username = "same as server email 'from'"; // SMTP username
        $mail->Password = "server email password"; // SMTP password (Keep all this info in some config file)
        $mail->Port="587"; //differs as per hosting server
        $mail->AddAddress($Email,$Name); //replace myname and mypassword to yours //replace myname and mypassword to yours
        $mail->AddReplyTo("reply to email", "Team Convolution RGPV"); //support@xyz.com
        $mail->WordWrap = 50; // set word wrap
        
        $mail->IsHTML(true); // set email format to HTML
        $mail->Subject = 'Registration Successful | Convolution RGPV';
        
          
          
          $mail->Body = "
    <html>
    <head>
      <meta charset='UTF-8'>
      <title>Confirmation Mail</title>
    </head>
    <body>
    <p>Greetings!!</p>
    <p>Hello " . $Name. ",</p>
    <p>Thank You for registering for the Smart Cities Hackathon Competition. 
    Your Registration was successful. Your Team ID is :<b> " .$refcode . "</b>. We wish you have a great time at Convolution RGPV ,RGTU's first ever Annual Techfest scheduled to be organised during <strong>February 18- February 20, 2018</strong>. </p>		    
    <p>Wishing you all the best!!</p>
    <p>Regards,</p>
    <p>Team Convolution RGPV.</p>
    </body>
    </html>";
        
        
         
         if($mail->Send())
        { $flag=3;
         }else{ 'Mail Not Sent';
        }
    
    mysqli_close($connection);
}else{
    
    echo "false";
    
}
}

?>