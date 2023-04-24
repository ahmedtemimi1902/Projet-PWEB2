<?php

include '../sql/config.php';

if (isset($_POST['submit'])) {

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $registrationType = $_POST['registration-type'];

      if ($registrationType === 'job-seeker') {
         // Extract data from the POST request
         $idNumber = $_POST['id-number'];
         $firstName = $_POST['first-name'];
         $lastName = $_POST['last-name'];
         $username = $_POST['name'];
         $email = $_POST['email'];
         $password = $_POST['password'];
         $confirmPassword = $_POST['cpassword'];

         // Check if the passwords match
         if ($password !== $confirmPassword) {
            echo 'Error: Passwords do not match.';
            exit();
         }

         // Check if the username or email already exists
         $query = "SELECT * FROM job_seeker WHERE username = '$username' OR email = '$email'";
         $result = mysqli_query($conn, $query);

         if (mysqli_num_rows($result) > 0) {
            echo 'Error: Username or email already exists.';
            exit();
         }

         // Upload image to server
         if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = $_FILES['image']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            $uploadFileDir = '../images/job_seekers/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
               // Insert data into the job_seeker table
               $query = "INSERT INTO job_seeker (id_number, first_name, last_name, username, email, password, image) 
                      VALUES ('$idNumber', '$firstName', '$lastName', '$username', '$email', '$password', '$newFileName')";

               // Execute the query and handle any errors
               if (mysqli_query($conn, $query)) {
                  echo 'Registration successful!';
               } else {
                  echo 'Error: ' . mysqli_error($conn);
               }
            } else {
               echo 'Error: Failed to move uploaded file.';
            }
         } else {
            echo 'Error: No file was uploaded.';
         }
      } else if ($registrationType === 'employer') {
         // Extract data from the POST request
         $companyName = $_POST['company-name'];
         $supervisorFirstName = $_POST['supervisor-first-name'];
         $supervisorLastName = $_POST['supervisor-last-name'];
         $supervisorEmail = $_POST['supervisor-email'];
         $irsCode = $_POST['irs-code'];
         $username = $_POST['name'];
         $password = $_POST['password'];
         $confirmPassword = $_POST['cpassword'];

         // Check if the passwords match
         if ($password !== $confirmPassword) {
            echo 'Error: Passwords do not match.';
            exit();
         }

         // Check if the username or email already exists
         $query = "SELECT * FROM employer WHERE username = '$username' OR supervisor_email = '$supervisorEmail'";
         $result = mysqli_query($conn, $query);
         if (mysqli_num_rows($result) > 0) {
            echo 'Error: Username or email already exists.';
            exit();
         }
         if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = $_FILES['image']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            $uploadFileDir = '../images/employers/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
               // Insert data into the employer table
               $query = "INSERT INTO employer (company_name, supervisor_first_name, supervisor_last_name, supervisor_email, irs_code, username, password,image) 
                 VALUES ('$companyName', '$supervisorFirstName', '$supervisorLastName', '$supervisorEmail', '$irsCode', '$username', '$password','$newFileName')";

               // Execute the query and handle any errors
               if (mysqli_query($conn, $query)) {
                  echo 'Registration successful!';
               } else {
                  echo 'Error: ' . mysqli_error($conn);
               }
            } else {
               echo 'Error: Failed to move uploaded file.';
            }
         } else {
            echo 'Error: No file was uploaded.';
         }
      } else {
         echo 'Error: Invalid registration type.';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>

<body>

   <div class="form-container">

      <form action="" method="post" enctype="multipart/form-data">
         <h3>register now</h3>
         <?php
         if (isset($message)) {
            foreach ($message as $message) {
               echo '<div class="message">' . $message . '</div>';
            }
         }
         ?>

         <label for="registration-type">Select your registration type:</label>
         <select id="registration-type" name="registration-type">
            <option value="None">None</option>
            <option value="job-seeker">Job Seeker</option>
            <option value="employer">Employer</option>
         </select>

         <div id="job-seeker-form">
            <input type="text" name="id-number" placeholder="enter ID number" class="box" required >
            <input type="text" name="first-name" placeholder="enter first name" class="box" required disabled>
            <input type="text" name="last-name" placeholder="enter last name" class="box" required disabled>
            <input type="text" name="name" placeholder="enter username" class="box" required disabled>
            <input type="email" name="email" placeholder="enter email" class="box" required disabled>
            <input type="password" name="password" placeholder="enter password" class="box" required disabled>
            <input type="password" name="cpassword" placeholder="confirm password" class="box" required disabled>
            <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
            <input type="submit" name="submit" value="register now" class="btn">
         </div>

         <div id="employer-form">
            <input type="text" name="company-name" placeholder="enter company name" class="box" required disabled>
            <input type="text" name="supervisor-first-name" placeholder="enter supervisor first name" class="box"
               required disabled>
            <input type="text" name="supervisor-last-name" placeholder="enter supervisor last name" class="box" required
               disabled>
            <input type="email" name="supervisor-email" placeholder="enter supervisor email" class="box" required
               disabled>
            <input type="text" name="irs-code" placeholder="enter IRS code" class="box" required disabled>
            <input type="text" name="name" placeholder="enter username" class="box" required disabled>
            <input type="password" name="password" placeholder="enter password" class="box" required disabled>
            <input type="password" name="cpassword" placeholder="confirm password" class="box" required disabled>
            <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
            <input type="submit" name="submit" value="register now" class="btn">
         </div>

         <script>
            const registrationType = document.getElementById('registration-type');
            const jobSeekerForm = document.getElementById('job-seeker-form');
            const employerForm = document.getElementById('employer-form');

            // Hide the forms initially
            jobSeekerForm.style.display = 'none';
            employerForm.style.display = 'none';

            registrationType.addEventListener('change', (event) => {
               const selectedType = event.target.value;
               if (selectedType === 'job-seeker') {
                  jobSeekerForm.style.display = 'block';
                  employerForm.style.display = 'none';
               } else if (selectedType === 'employer') {
                  jobSeekerForm.style.display = 'none';
                  employerForm.style.display = 'block';
               } else if (selectedType === 'None') {
                  jobSeekerForm.style.display = 'none';
                  employerForm.style.display = 'none';
               }
            });
            registrationType.addEventListener('change', (event) => {
               const selectedType = event.target.value;
               if (selectedType === 'job-seeker') {
                  document.querySelectorAll('#employer-form input').forEach(input => {
                     input.setAttribute('disabled', true);
                  });
                  document.querySelectorAll('#job-seeker-form input').forEach(input => {
                    input.removeAttribute('disabled');
                  });
               } else if (selectedType === 'employer') {
                  document.querySelectorAll('#job-seeker-form input').forEach(input => {
                     input.setAttribute('disabled', true);
                  });
                  document.querySelectorAll('#employer-form input').forEach(input => {
                     input.removeAttribute('disabled');
                  });
               } else if (selectedType === 'None') {
                  // Disable both forms
                  document.querySelectorAll('#job-seeker input, #employer input').forEach(input => {
                     input.setAttribute('disabled', true);
                  });
               }
            });





         </script>
         <p>already have an account? <a href="../Login/login.php">login now</a></p>
      </form>

   </div>

</body>

</html>