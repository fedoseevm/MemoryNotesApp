<?php 
//include 'login.js';
$emailEntry = $_POST["email"];
$passwordEntry = $_POST["password"];
$servername = "localhost";
$username = "root";
$key = "abobus";
$method = 'AES-256-CBC';

try 
{
  $encryptedPassword = openssl_encrypt($passwordEntry, $method, $key, 0,'');
    $conn = new mysqli($servername, $username, "", "tida");
  $sql = "SELECT email, password FROM users WHERE email = '".$emailEntry."' AND password = '".$encryptedPassword."'";
$result = $conn->query($sql);



if ($result->num_rows > 0) 
 {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    //echo "Respect";
    header("Location: ../index.html");
  }
} else {
  echo '<script>';
echo 'alert("Podaj poprawny email i hasło");';
echo 'window.location.href = "login.html";';
echo '</script>';
//header("Location: login.html");
  }
  mysqli_close($conn);
} 
catch(PDOException $e) 
{
  echo "Connection failed: " . $e->getMessage();
}
?>