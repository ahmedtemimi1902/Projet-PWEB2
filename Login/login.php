<?php

include '../sql/config.php';
session_start();

if(isset($_POST['submit'])){

  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $pass = mysqli_real_escape_string($conn, $_POST['password']);
  $usertype = $_POST['usertype'];

  if($usertype == 'job_seeker') {
    $select = mysqli_query($conn, "SELECT * FROM `job_seeker` WHERE email = '$email' AND password = '$pass'") or die('query failed');
    $dashboard_url = '../Profile/JobSeeker/dashboard.php';
  } else if($usertype == 'employer') {
    $select = mysqli_query($conn, "SELECT * FROM `employer` WHERE supervisor_email = '$email' AND password = '$pass'") or die('query failed');
    $dashboard_url = '../Profile/Employer/dashboard.php';
  } else {
    $message[] = 'Please select user type!';
    $dashboard_url = '';
  }

  if(mysqli_num_rows($select) > 0){
    $row = mysqli_fetch_assoc($select);
    $_SESSION['user_id'] = $row['id'];
    header('location:'.$dashboard_url);
  } else {
    $message[] = 'Incorrect email or password!';
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<div class="form-container">

<form action="" method="post">
  <h3>Login Now</h3>
  <?php
    if(isset($message)){
      foreach($message as $msg){
        echo '<div class="message">'.$msg.'</div>';
      }
    }
  ?>
  <input type="email" name="email" placeholder="Enter Email" class="box" required>
  <input type="password" name="password" placeholder="Enter Password" class="box" required>
  <select name="usertype" class="box" required>
    <option value="">Select User Type</option>
    <option value="job_seeker">Job Seeker</option>
    <option value="employer">Employer</option>
  </select>
  <input type="submit" name="submit" value="Login Now" class="btn">
  <p>Don't have an account? <a href="../Signup/register.php">Register Now</a></p>
</form>

</div>

</body>
</html>