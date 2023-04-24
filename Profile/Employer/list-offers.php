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
        <td><a href="dashboard.php?delete_id=<?php echo $row['id']; ?>"
                onclick="return confirm('Are you sure you want to delete this job offer?')">Delete</a></td>
    </tr>
    <?php
        }
    }
    ?>
</table>