<?php
include '../../sql/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM job_seeker ORDER BY id DESC");

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
</style>

<table class="job-offers">

    <?php
   if ($result->num_rows == 0) {
    echo "No job offers found";
    } else {
        echo "<tr>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Action</th>";
        echo " </tr>";

        while ($row = $result->fetch_assoc()) {
            ?>
    <tr>
        <td>
            <?php echo $row['first_name']; ?>
        </td>
        <td>
            <?php echo $row['last_name']; ?>
        </td>
        <td><a href="#" data-applicant-id="<?php echo $row['id']; ?>" class="view-cv" data-page="get-applicant-details.php">Contact Details</a></td>
    </tr>
    <?php
        }
    }
    ?>
</table>
