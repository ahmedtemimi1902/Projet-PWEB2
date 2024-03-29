<?php

include '../../sql/config.php';
session_start();
$user_id = $_SESSION['user_id'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>

</head>

<body>

   <div class="update-profile">

      <?php
      $select = mysqli_query($conn, "SELECT * FROM `employer` WHERE id = '$user_id'") or die('query failed');
      if (mysqli_num_rows($select) > 0) {
         $fetch = mysqli_fetch_assoc($select);
      }
      ?>
      <style>
         form {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 50px;
}

.message {
  color: #ff6b6b;
  font-size: 14px;
  margin-top: 10px;
}

.flex {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
  width: 100%;
}

.inputBox {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  margin: 10px;
}

.box {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-top: 5px;
  width: 300px;
}

input[type="email"],
input[type="password"] {
  margin-top: 15px;
  border: none;
  background-color: #f7f7f7;
  padding: 10px;
  border-radius: 5px;
  font-size: 16px;
  color: #4a4a4a;
}

input[type="email"]:focus,
input[type="password"]:focus {
  outline: none;
  box-shadow: 0px 0px 3px #62bffc;
}

.btn {
  background-color: #62bffc;
  border: none;
  color: white;
  padding: 10px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  border-radius: 5px;
  margin-top: 20px;
  cursor: pointer;
  transition: all 0.3s ease-in-out;
}

.btn:hover {
  background-color: #4797b2;
}

.delete-btn {
  background-color: #ff6b6b;
  border: none;
  color: white;
  padding: 10px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  border-radius: 5px;
  margin-top: 20px;
  cursor: pointer;
  transition: all 0.3s ease-in-out;
}

.delete-btn:hover {
  background-color: #d15050;
}

      </style>
      <form action="dashboard.php" method="POST" enctype="multipart/form-data">
         <?php
         if ($fetch['image'] == '') {
            echo '<img src="images/default-avatar.png">';
         } else {
            echo '<img src="../../images/employers/' . $fetch['image'] . '">';
         }
         if (isset($message)) {
            foreach ($message as $message) {
               echo '<div class="message">' . $message . '</div>';
            }
         }
         ?>
         <div class="flex">
            <div class="inputBox">
               <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
               <span>old password :</span>
               <input type="password" name="update_pass" placeholder="enter previous password" class="box">
               <span>new password :</span>
               <input type="password" name="new_pass" placeholder="enter new password" class="box">
               <span>confirm password :</span>
               <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
               <span>update your pic :</span>
               <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
            </div>
         </div>
         <input type="submit" value="update profile" name="update_profile" class="btn">
         <a href="dashboard.php" class="back-btn">go back</a>
      </form>

   </div>

</body>

</html>