<?php
include '../../sql/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM job_offer ORDER BY id DESC");



?>

<h1>List of Job Offers</h1>

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

<table class="job-offers">

    <?php
    if ($result->num_rows == 0) {
        echo "No job offers found";
    } else {
        echo "<tr>";
        echo "<th>Company</th>";
        echo "<th>Title</th>";
        echo "<th>Description</th>";
        echo "<th>Diploma</th>";
        echo "<th>Skills</th>";
        echo "<th>Experience</th>";
        echo "<th>Salary</th>";
        echo "<th>Action</th>";
        echo " </tr>";


        while ($row = $result->fetch_assoc()) {
            ?>
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
                <?php
                $job_id = $row['id'];
                $query = "SELECT * FROM job_application WHERE applicant_id = $user_id AND job_offer_id = $job_id";
                $resultt = mysqli_query($conn, $query);
                if (mysqli_num_rows($resultt) > 0) {
                    echo '<td><button disabled>Already applied</button></td>';
                } else {
                    echo '<td><a href="dashboard.php?apply_id=' . $row['id'] . '" >Apply</a></td>';
                }
                ?>
            </tr>
            <?php
        }
    }
    ?>
</table>