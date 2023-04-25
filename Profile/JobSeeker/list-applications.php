<?php
include '../../sql/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
   header("Location: login.php");
   exit();
}

$user_id = $_SESSION['user_id'];

$result = $conn->query("SELECT * FROM job_application WHERE applicant_id = $user_id");

?>
<table class="job-offers">
<?php
if ($result->num_rows > 0) {
   echo "<tr>";
   echo "<th>Company</th>";
   echo "<th>Title</th>";
   echo "<th>Description</th>";
   echo "<th>Diploma</th>";
   echo "<th>Skills</th>";
   echo "<th>Experience</th>";
   echo "<th>Salary</th>";
   echo "<th>Status</th>";
   echo " </tr>";
   while ($row = $result->fetch_assoc()) {
      $status = $row['status'];
      $query = "SELECT * FROM job_offer WHERE id = " . $row['job_offer_id'];
      $resultt = mysqli_query($conn, $query);
      $row = mysqli_fetch_assoc($resultt);
      if ($row) {
         $job_offer_id = $row['id'];
         $job_offer_title = $row['title'];
         $applicant_id = $user_id;

         $applicant = $conn->query("SELECT * FROM job_seeker WHERE id = $applicant_id")->fetch_assoc();
         $applicant_name = $applicant['first_name'] . ' ' . $applicant['last_name'];
         $applicant_email = $applicant['email'];
         ?>
         <style>
            .job-offers {
               width: 100%;
               border-collapse: collapse;
            }

            .job-offers th {
               font-weight: bold;
               background-color: #f5f5f5;
               border: 1px solid #ccc;
               padding: 8px;
            }

            .job-offers td {
               border: 1px solid #ccc;
               padding: 8px;
               text-align: center;

            }

            .job-offers tbody tr:nth-child(even) {
               background-color: #f5f5f5;
            }

            .job-offers a {
               display: inline-block;
               padding: 8px 16px;
               background-color: #333;
               color: #fff;
               text-decoration: none;
               border-radius: 4px;
            }
         </style>
         

            <tr>
               <td>
                  <?php echo $row['company']; ?>
               </td>
               <td>
                  <?php echo $row['title']; ?>
               </td>
               <td>
                  <?php echo $row['description']; ?>
               </td>
               <td>
                  <?php echo $row['diploma']; ?>
               </td>
               <td>
                  <?php echo $row['skills']; ?>
               </td>
               <td>
                  <?php echo $row['experience']; ?> years
               </td>
               <td>
                  <?php echo $row['salary']; ?> USD
               </td>
               <td style="color: <?php
               if ($status == 'Pending') {
                  echo 'orange';
               } elseif ($status == 'Accepted') {
                  echo 'green';
               } elseif ($status == 'Rejected') {
                  echo 'red';
               }
               ?>">
                  <?php echo $status; ?>
               </td>
            </tr>
            
         <?php

      } else {

      }


   }
} else {
   echo 'No job Applications found , Try Applying in List Job Offers';
}
?>
</table>