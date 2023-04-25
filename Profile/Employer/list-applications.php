<?php
include '../../sql/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
   header("Location: login.php");
   exit();
}

$user_id = $_SESSION['user_id'];

// Get all job offers created by this employer
$result = $conn->query("SELECT * FROM job_offer WHERE employer_id = $user_id");

if ($result->num_rows > 0) {
   while($row = $result->fetch_assoc()) {
      $job_offer_id = $row['id'];
      $job_offer_title = $row['title'];

      echo '<h3>' . $job_offer_title . '</h3>';

      // Get all applications related to this job offer
      $applications = $conn->query("SELECT * FROM job_application WHERE job_offer_id = $job_offer_id");

      if ($applications->num_rows > 0) {
         echo '<ul>';

         while($application = $applications->fetch_assoc()) {
            $applicant_id = $application['applicant_id'];
            $id = $application['id'];
            $status = $application['status'];

            // Get applicant's details
            $applicant = $conn->query("SELECT * FROM job_seeker WHERE id = $applicant_id")->fetch_assoc();
            $applicant_name = $applicant['first_name'] . ' ' . $applicant['last_name'];
            $applicant_email = $applicant['email'];
            if ($status == 'Pending') {
            

            echo '<li>';
            echo '<strong>Name:</strong> ' . $applicant_name . '<br>';
            echo '<strong>Email:</strong> ' . $applicant_email . '<br>';
            echo '<strong>CV:</strong> <a href="#" data-applicant-id="' . $applicant_id . '" data-page="get-applicant-details.php" class="view-cv">View CV</a><br>';
            echo '<strong>Status:</strong> ' . $status . '<br>';

            // Add accept and reject buttons for pending applications
            
               echo '<form method="GET" action="dashboard.php">';
               echo '<input type="hidden" name="id" value="' . $id . '">';
               echo '<input type="submit" name="accept" value="Accept">';
               echo '<input type="submit" name="reject" value="Reject">';
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
