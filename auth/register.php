<?php
$emailEntry = $_POST["email"];
$passwordEntry = $_POST["password"];
$servername = "localhost";
$username = "root";
$key = "abobus";
$method = 'AES-256-CBC';

try {
  $conn = new mysqli($servername, $username, "", "tida");
  $sql = "SELECT idusers, email, password FROM users WHERE email = '" . $emailEntry . "'";
  $result = $conn->query($sql);
  $encryptedPassword = openssl_encrypt($passwordEntry, $method, $key, 0, '');


  if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
      echo '<script>';
      echo 'alert("Konto z podanym emailem już istnieje!");';
      //echo 'alert("'.$encryptedPassword.'");';
      echo 'window.location.href = "register.html";';
      echo '</script>';
    }
  } else {
    $query = "INSERT INTO users (email,password) VALUES ('" . $emailEntry . "','" . $encryptedPassword . "')";
    $conn->query($query);
    header("Location: login.html");
  }

  mysqli_close($conn);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
