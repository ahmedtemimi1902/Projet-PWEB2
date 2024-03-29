<?php
include '../../sql/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
   header("Location: login.php");
   exit();
}

$user_id = $_SESSION['user_id'];


$result = $conn->query("SELECT * FROM job_offer WHERE employer_id = $user_id");

if ($result->num_rows > 0) {
   while($row = $result->fetch_assoc()) {
      $job_offer_id = $row['id'];
      $job_offer_title = $row['title'];

      echo '<h3>' . $job_offer_title . '</h3>';

      
      $applications = $conn->query("SELECT * FROM job_application WHERE job_offer_id = $job_offer_id");

      if ($applications->num_rows > 0) {
         echo '<ul>';

         while($application = $applications->fetch_assoc()) {
            $applicant_id = $application['applicant_id'];
            $id = $application['id'];
            $status = $application['status'];

            
            $applicant = $conn->query("SELECT * FROM job_seeker WHERE id = $applicant_id")->fetch_assoc();
            $applicant_name = $applicant['first_name'] . ' ' . $applicant['last_name'];
            $applicant_email = $applicant['email'];
            if ($status == 'Pending') {
            

            echo '<li>';
            echo '<strong>Name:</strong> ' . $applicant_name . '<br>';
            echo '<strong>Email:</strong> ' . $applicant_email . '<br>';
            echo '<strong>CV:</strong> <a href="#" data-applicant-id="' . $applicant_id . '" data-page="get-applicant-details.php" class="view-cv">View CV</a><br>';
            echo '<strong>Status:</strong> ' . $status . '<br>';

            
            
               echo '<form method="GET" action="dashboard.php">';
               echo '<input type="hidden" name="id" value="' . $id . '">';
               echo '<input type="submit" name="accept" value="Accept" class="accept-button">';
               echo '<input type="submit" name="reject" value="Reject" class="reject-button">';
               echo '</form>';
            }

            echo '</li>';
         }

         echo '</ul>';
      } else {
         echo 'No applications found for this job offer.';
      }

      echo '<hr>';
   }
} else {
   echo 'No job offers found for this employer.';
}
?>
<!DOCTYPE html>
<html>
<head>
<style>
   .accept-button {
      background: #faf5f5;
	color: #008000;
	border: 1px solid #eee;
	border-radius: 20px;
	box-shadow: 5px 5px 5px #eee;
	text-shadow: none;
}
.accept-button:hover{
   background: #09cc02;
	color: #fff;
	border: 1px solid #eee;
	border-radius: 20px;
	box-shadow: 5px 5px 5px #eee;
	text-shadow: none;
}

.reject-button {
   background: #faf5f5;
	color: #ff0000;
	border: 1px solid #eee;
	border-radius: 20px;
	box-shadow: 5px 5px 5px #eee;
	text-shadow: none;
}
.reject-button:hover{
   background: #f20202;
	color: #fff;
	border: 1px solid #eee;
	border-radius: 20px;
	box-shadow: 5px 5px 5px #eee;
	text-shadow: none;}
   .view-cv {
  display: inline-block;
  background-color: #007bff;
  color: #fff;
  border: none;
  padding: 6px 12px;
  text-align: center;
  text-decoration: none;
  font-size: 14px;
  cursor: pointer;
  border-radius: 4px;
  box-shadow: 5px 5px 5px #eee;

}

.view-cv:hover {
  background-color: #0069d9;
}


</style>
</head>
<body>
  
</body>
</html>