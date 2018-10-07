<?php
$data = $_POST;
$mac_provided = $data['mac'];  // Get the MAC from the POST data
unset($data['mac']);  // Remove the MAC key from the data.

$ver = explode('.', phpversion());
$major = (int) $ver[0];
$minor = (int) $ver[1];

if($major >= 5 and $minor >= 4){
     ksort($data, SORT_STRING | SORT_FLAG_CASE);
}
else{
     uksort($data, 'strcasecmp');
}

// You can get the 'salt' from Instamojo's developers page(make sure to log in first): https://www.instamojo.com/developers
// Pass the 'salt' without the <>.
$mac_calculated = hash_hmac("sha1", implode("|", $data), "<salt>");


if($mac_provided == $mac_calculated){
    echo "MAC is fine";
    // Do something here
    if($data['status'] == "Credit"){
      $payment_id = $data['payment_id'];
      $name=  $data['buyer_name'];
      $contact = $data['buyer_phone'];
      $email= $data['buyer'];
      $request_id= $data['payment_request_id'];
      $status = $data['status'];
      $college = $data['College'];
      $year= $data['Year'];
      $convoid = 'LRH' . rand(1000,1000000);
      
      $servername = "server";
      $username = "username";
      $password = "password";
      $dbname = "dbname";
      

    try {
      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      } 

      $sql = "INSERT INTO labyrinthpay ( name, email, contact,  college, year, convoid, cap)
        VALUES ( '".$name."', '".$email."', '".$contact."','".$college."',  '".$year."', '".$convoid."', 'NULL')";

      if ($conn->query($sql) === TRUE) {
        

      } else {

      }
        

      $conn->close();
      
        /*$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("INSERT INTO webhook (payment_id, name, phone, email, request_id, status, convoid)
        VALUES (:payment_id, :name, :phone, :email, :request_id, :status, :convoid)");
        $stmt->bindParam(':payment_id', $payment_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':request_id', '78989');
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':convoid', $convoid);

        $stmt->execute();
        */

      }
	catch(PDOException $e)
	{
		echo '<p style="text-align:center;font-size:25px;color:white;">Error: ' . $e->getMessage(). '</p>';
	}
	$conn = null;
    }
    else{
       // Payment was unsuccessful, mark it as failed in your database
    }
}
else{
    echo "Invalid MAC passed";
}
?>