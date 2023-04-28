<?php
include '../../sql/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
echo "<h1>List of Job Offers Suited to your Resume</h1>";
$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM job_offer ORDER BY id DESC");
echo "<table class='job-offers' id='myTable'>";
echo "<tr>";
echo "<th>Company</th>";
echo "<th>Title</th>";
echo "<th>Description</th>";
echo "<th>Diploma</th>";
echo "<th>Skills</th>";
echo "<th>Experience</th>";
echo "<th>Salary</th>";
echo "<th>Score</th>";
echo "<th>Action</th>";
echo " </tr>";

$sql1 = "SELECT * FROM job_offer";
$result1 = $conn->query($sql1);

while ($row1 = $result1->fetch_assoc()) {
    
    $sql2 = "SELECT * FROM resume WHERE id = ".$user_id;
    $result2 = $conn->query($sql2);
    
    if ($result2->num_rows > 0) {
        $row2 = $result2->fetch_assoc();
        
        $sql3 = "SELECT * FROM job_seeker WHERE id = ".$user_id ;
        $result3 = $conn->query($sql3);

        if ($result3->num_rows > 0) {
            $row3 = $result3->fetch_assoc();
            
            $skills_score = 0;
            $salaire_score = intval($row1['salary']/100);
            $diploma_match = 0;
            $score = 0;

            
            $job_offer_skills = explode(',', $row2['Competence']);
            foreach ($job_offer_skills as $job_offer_skill) {
                if (stripos($row1['skills'], $job_offer_skill) !== false) {
                    $skills_score += 5;
                }
            }



            

            $job_offer_diplomas = explode(',', $row2['Diploma']);
            foreach ($job_offer_diplomas as $job_offer_diploma) {
                if (stripos($row1['diploma'], $job_offer_diploma) !== false) {
                    $diploma_match = 1;
                }
            }

            
            $score = ($skills_score + $salaire_score) * $diploma_match;

            
            echo "<tr>";
            echo "<td>" . $row1['company'] . "</td>";
            echo "<td>" . $row1['title'] . "</td>";
            echo "<td>" . $row1['description'] . "</td>";
            echo "<td>" . $row1['diploma'] . "</td>";
            echo "<td>" . $row1['skills'] . "</td>";
            echo "<td>" . $row1['experience'] . "</td>";
            echo "<td>" . $row1['salary'] . "</td>";
            echo "<td>" . $score . "</td>";
            


            $query = "SELECT * FROM job_application WHERE applicant_id = $user_id AND job_offer_id = ".  $row1['id'];
                $resultt = mysqli_query($conn, $query);
                if (mysqli_num_rows($resultt) > 0) {
                    echo '<td><button disabled>Already applied</button></td>';
                } else {
                    echo '<td><a href="dashboard.php?apply_id=' . $row1['id'] . '" >Apply</a></td>';
                }
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
    .job-offers button {
        display: inline-block;
        padding: 8px 16px;
        background-color: red;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
    }
</style>
