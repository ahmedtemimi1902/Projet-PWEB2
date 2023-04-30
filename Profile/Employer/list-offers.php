<?php
include '../../sql/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM job_offer WHERE employer_id = $user_id ORDER BY id DESC");

?>

<h1>List of Job Offers</h1>

<style>
    .job-offers {
  width: 100%;
  border-collapse: collapse;
  margin: 16px 0;
  padding: 16px;
  background-color: #f8f8f8;
  border: none; /* Remove default border */
  box-shadow: 0 0 4px rgba(0, 0, 0, 0.1); /* Use box-shadow for border effect */
  border: 2px solid #6c5ce7; /* Use a solid border style and a custom color */


}

.job-offers tbody tr:nth-child(even) {
  background-color: #fff;
}

.job-offers tbody tr:nth-child(odd) {
  background-color: #f2f2f2;
}


.job-offers th {
  font-weight: bold;
  background-color: #666;
  border: 1px solid #ccc;
  padding: 12px;
  text-align: center;
  text-transform: uppercase;
  color: #fff;
}

.job-offers td {
  border: 1px solid #ccc;
  padding: 12px;
  text-align: center;
  color: #333;
}
.job-offers tbody tr:hover {
  background-color: #eee;
}


    

    .job-offers tbody tr:nth-child(even) {
        background-color: #f5f5f5;
    }

    .job-offers a {
  display: inline-block;
  padding: 12px 24px;
  background-color: #ff6600;
  color: #fff;
  text-decoration: none;
  border-radius: 4px;
  transition: background-color 0.2s ease;
}

.job-offers a:hover {
  background-color: #e55d00;
}


    
</style>

<table class="job-offers">

    <?php
    if ($result->num_rows == 0) {
        echo "No job offers found";
    } else {
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Description</th>";
        echo "<th>Diploma</th>";
        echo "<th>Skills</th>";
        echo "<th>Experience</th>";
        echo "<th>Salary</th>";
        echo "<th>Delete</th>";
        echo "<th>View Potential Candidates</th>";
        echo " </tr>";

        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
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
                <td><a href="dashboard.php?delete_id=<?php echo $row['id']; ?>">Delete</a></td>
                <td> <a href="#" class="view-app" data-page="list-relevant-applications.php" data-applicant-id="<?php echo $row['id']; ?>">View</a></td>
            </tr>
            <?php
        }
    }
    ?>
</table>
