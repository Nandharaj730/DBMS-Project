<?php
session_start();
  $name = $email = $pass =  "";
  $login_res = $register_res = "";
  $conn = mysqli_connect("localhost", "root" , "", "new-gen");
  if(!$conn){
    echo "<script>alert(" .mysqli_connection_error() .");</script>";
  }
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  if(isset($_POST['signin'])){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $_SESSION['loginemail'] = test_input($_POST['loginemail']);
      $pass = test_input($_POST['loginpass']);
      $hash =md5($pass);
    }
    if($_SESSION['loginemail'] == 'admin@newgen.com' && $hash == 'b4af804009cb036a4ccdc33431ef9ac9'){
      header('location:admin.php');
    }else{
      $sql_login = "CALL login('{$_SESSION['loginemail']}','$hash')";
      $sql_log_res = mysqli_query($conn , $sql_login);
      if(mysqli_num_rows($sql_log_res) == 1){
          $row = mysqli_fetch_assoc($sql_log_res);
          $_SESSION['username'] = $row['Customer_Name'];
          $_SESSION['userid'] = $row['Customer_Id'];
          echo "<script>alert('Logged in successfully...')</script>";
          header("Location: http://localhost/dashboard.php?user=$user");
      }else{
          echo "<script>alert('Username or Password is Incorrect...');</script>";
      }
    }
  }
  if(isset($_POST['signup'])){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = test_input($_POST["name"]);
      $email = test_input($_POST["email"]);
      $pass = test_input($_POST["pass"]);
      $hash = md5($pass);
    }

    $sql_reg = "CALL signup('$name','$email','$hash');";
    if(mysqli_query($conn , $sql_reg)){
      echo "<script>alert('Account created Successfully... ')</script>";
    }else{
      echo "<script>alert('Sorry,Account can't be created!!!');</script>";   
    }
  }
?>