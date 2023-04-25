<?php
include '../../sql/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

echo "<h1>List of Potential Employees From Best To Worst Matching Score</h1>";

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM job_seeker ORDER BY id DESC");



$sql1 = "SELECT * FROM job_seeker";
$result1 = $conn->query($sql1);
echo "<table class='job-offers' id='myTable'>";
echo "<tr>";
echo "<th>First Name</th>";
echo "<th>Last Name</th>";
echo "<th onclick='sortTable(2)'>Score</th>";
echo "<th>Contact</th>";


echo " </tr>";

while ($row1 = $result1->fetch_assoc()) {

    
    $sql2 = "SELECT * FROM resume WHERE id = " . $row1['id'];
    $result2 = $conn->query($sql2);

    
    if ($result2->num_rows > 0) {
        $row2 = $result2->fetch_assoc();
        
        $sql3 = "SELECT * FROM job_offer WHERE id = " .  $_GET['ido']; ;
        $result3 = $conn->query($sql3);

        
        if ($result3->num_rows > 0) {
            $row3 = $result3->fetch_assoc();

            
            $skills_score = 0;
            $experience_score = 0;
            $diploma_match = 0;
            $score = 0;

            
            $job_offer_skills = explode(',', $row3['skills']);
            foreach ($job_offer_skills as $job_offer_skill) {
                if (stripos($row2['Competence'], $job_offer_skill) !== false) {
                    $skills_score += 5;
                }
            }


            
            if ($row2['Experience'] >= $row3['experience']) {
                $experience_score = ($row2['Experience'] - $row3['experience']) * 2;
            }

            

            $job_offer_diplomas = explode(',', $row3['diploma']);
            foreach ($job_offer_diplomas as $job_offer_diploma) {
                if (stripos($row2['Diploma'], $job_offer_diploma) !== false) {
                    $diploma_match = 1;
                }
            }

            
            $score = ($skills_score + $experience_score) * $diploma_match;

            
            echo "<tr>";
            echo "<td>" . $row1['first_name'] . "</td>";
            echo "<td>" . $row1['last_name'] . "</td>";
            echo "<td>" . $score . "</td>";
            echo '<td><a href="#" data-applicant-id="' . $row1['id'] . '" class="view-cv" data-page="get-applicant-details.php">Contact Details</a></td>';
            echo "</tr>";
        }
    }
}
echo "</table>";

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

