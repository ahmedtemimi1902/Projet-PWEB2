<?php

include '../../sql/config.php';
session_start();

$user_id = $_SESSION['user_id'];



if (!isset($user_id)) {
    header('location:Login/login.php');
}
;
if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location:../../Login/login.php');

}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        $old_pass = $_POST['old_pass'];
        $update_pass = mysqli_real_escape_string($conn, $_POST['update_pass']);
        $new_pass = mysqli_real_escape_string($conn, $_POST['new_pass']);
        $confirm_pass = mysqli_real_escape_string($conn, $_POST['confirm_pass']);

        if (!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)) {
            if ($update_pass != $old_pass) {
                $message[] = 'old password not matched!';
            } elseif ($new_pass != $confirm_pass) {
                $message[] = 'confirm password not matched!';
            } else {
                mysqli_query($conn, "UPDATE `Employer` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
                $message[] = 'password updated successfully!';
            }
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

            $uploadFileDir = '../../images/employers/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Insert data into the job_seeker table
                $query = "UPDATE `Employer` SET image = '$newFileName' WHERE id = '$user_id'";

                // Execute the query and handle any errors
                if (mysqli_query($conn, $query)) {
                    echo 'Registration successful!';
                    header('location:dashboard.php');
                } else {
                    echo 'Error: ' . mysqli_error($conn);
                }
            } else {
                echo 'Error: Failed to move uploaded file.';
            }
        } else {
            echo 'Error: No file was uploaded.';
        }


    }
}

if (isset($_GET['id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['id']);
    $delete = mysqli_query($conn, "DELETE FROM job_application WHERE id = $delete_id");

    if ($delete) {
        header('location:dashboard.php');
    } else {
        echo '<div class="error">Error in deleting job offer!</div>';
        echo mysqli_error($conn);
    }
}

if (isset($_GET['id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['id']);
    $delete = mysqli_query($conn, "DELETE FROM job_application WHERE id = $delete_id");

    if ($delete) {
        header('location:dashboard.php');
    } else {
        echo '<div class="error">Error in deleting job offer!</div>';
        echo mysqli_error($conn);
    }
}


if (isset($_GET['delete_id'])) {

    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $delete = mysqli_query($conn, "DELETE FROM job_offer WHERE id = $delete_id");

    if ($delete) {
        mysqli_query($conn, "DELETE FROM job_application WHERE job_offer_id = $delete_id");
        header('location:dashboard.php');
    } else {
        echo '<div class="error">Error in deleting job offer!</div>';
        echo mysqli_error($conn);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_offer'])) {

        $company = "";
        $result = $conn->query("SELECT * FROM employer WHERE id = $user_id");
        if ($row = $result->fetch_assoc()) {
            $company = $row["company_name"];
        }
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $diploma = mysqli_real_escape_string($conn, $_POST['diploma']);
        $skills = implode(',', $_POST['skills']);
        $experience = mysqli_real_escape_string($conn, $_POST['experience']);
        $salary = mysqli_real_escape_string($conn, $_POST['salary']);

        $employer_id = $_SESSION['user_id'];

        $insert = mysqli_query($conn, "INSERT INTO `job_offer` (`company`,`title`, `description`, `diploma`, `skills`, `experience`, `salary`, `employer_id`) VALUES ('$company','$title', '$description', '$diploma', '$skills', '$experience', '$salary', '$employer_id')");

        if ($insert) {

            header('location:dashboard.php');
            echo '<div class="success">Job offer added successfully!</div>';
        } else {
            echo '<div class="error">Error in adding job offer!</div>';
            echo mysqli_error($conn);
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Employer Dashboard</title>
    <link rel="stylesheet" type="text/css" href="dashboard-style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="profile">
                <?php
                $result = $conn->query("SELECT * FROM employer WHERE id = $user_id");
                if ($row = $result->fetch_assoc()) {
                    echo '<div class="profile">';
                    echo '<img src="../../images/employers/' . $row['image'] . '" alt="User Profile">';
                    echo '<span>Welcome, ' . $row['supervisor_first_name'] . ' ' . $row['supervisor_last_name'] . '</span>';
                    echo '</div>';
                }

                ?>
            </div>
        </div>

    </div>
    <div class="content">
        <div class="menu">
            <ul>
                <li><a href="#" class="menu-link" data-page="add-offer.php">Add Job Offer</a></li>
                <li><a href="#" class="menu-link" data-page="list-offers.php">List Job Offers</a></li>
                <li><a href="#" class="menu-app" data-page="list-applications.php">List Job Applications</a></li>
                <li><a href="#" class="menu-link" data-page="list-relevant-applications.php">List Relevant Job Applications</a></li>
                <li><a href="#" class="menu-link" data-page="update_profile.php">Update Profile</a></li>
                <li><a href="dashboard.php?logout=<?php echo $user_id; ?>" class="logout-btn">logout</a></li>

            </ul>
        </div>
        <div class="main-content" id="main-content">
            <h1>Welcome to your Employer Dashboard</h1>
            <p>Here, you can manage your job offers and view applications from job seekers.</p>
            <p>Select one of the menu options on the left to get started.</p>
        </div>
    </div>
    </div>
    <script>
        const links = document.querySelectorAll('.menu-link');
        const contentDiv = document.querySelector('#main-content');

        links.forEach((link) => {
            link.addEventListener('click', (event) => {
                event.preventDefault();
                const page = event.target.dataset.page;
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        contentDiv.innerHTML = xhr.responseText;
                    }
                }
                xhr.open('GET', page, true);
                xhr.send();
            });
        });
    </script>



    <script>
        const link = document.querySelector('a.menu-app[data-page="list-applications.php"]');
        link.addEventListener('click', (event) => {

            event.preventDefault();
            const page = event.target.dataset.page;
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    contentDiv.innerHTML = xhr.responseText;
                    xhr.removeEventListener('load', onLoaded);
                    const linke = document.querySelectorAll('a.view-cv');
                    linke.forEach((link) => {
                        link.addEventListener('click', (event) => {
                            event.preventDefault();
                            const page = event.target.dataset.page;
                            const id = link.getAttribute('data-applicant-id');
                            const xhr = new XMLHttpRequest();
                            xhr.onreadystatechange = function () {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    contentDiv.innerHTML = xhr.responseText;
                                }
                            }
                            xhr.open('GET', `${page}?id=${id}`, true);
                            xhr.send();
                        });
                    });
                }
            }
            const onLoaded = () => {
                // Handle loading state
            };
            xhr.addEventListener('load', onLoaded);
            xhr.open('GET', page, true);
            xhr.send();
        });


    </script>



</body>

</html>