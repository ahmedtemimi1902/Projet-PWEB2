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
        echo $old_pass."eee";
        echo $new_pass;
        echo $confirm_pass;
        if (!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)) {
            if ($update_pass != $old_pass) {
                $message[] = 'old password not matched!';
            } elseif ($new_pass != $confirm_pass) {
                $message[] = 'confirm password not matched!';
            } else {
                mysqli_query($conn, "UPDATE `job_seeker` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
                $message[] = 'password updated successfully!';
            }
        }

        
        if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = $_FILES['image']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            $uploadFileDir = '../../images/job_seekers/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                
                $query = "UPDATE `job_seeker` SET image = '$newFileName' WHERE id = '$user_id'";

                
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


$uni_field = 'University';
$email_field = 'Email';
$status_field = 'Status';
$Exp_field = 'Experience';
$Adr_field = 'Adress';

$sql = "SELECT * FROM resume WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$fetch = mysqli_fetch_assoc($result);
$university = $fetch[$uni_field];
$Email = $fetch[$email_field];
$marital_status = $fetch[$status_field];
$Experience = $fetch[$Exp_field];
$Adress = $fetch[$Adr_field];



$diploma_field = 'Diploma';
$sql = "SELECT $diploma_field FROM resume WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$diploma_values = $row[$diploma_field];
$diploma_array = explode(',', $diploma_values);




$competence_field = 'Competence'; 
$sql = "SELECT $competence_field FROM resume WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$competence_values = $row[$competence_field];

$competence_array = explode(',', $competence_values);


if (isset($_POST['update_resume'])) {
    $new_competence_values = implode(',', $_POST['competence']); 
    if ($new_competence_values != $competence_values) { 
        $sql = "UPDATE resume SET $competence_field = '$new_competence_values' WHERE id = $user_id";
        if (mysqli_query($conn, $sql)) {
            echo "Profile updated successfully";
        } else {
            echo "Error updating profile: " . mysqli_error($conn);
        }
    }
}


if (isset($_POST['update_resume'])) {
    $new_diploma_values = implode(',', $_POST['Diploma']); 
    if ($new_diploma_values != $diploma_values) { 
        $sql = "UPDATE resume SET $diploma_field = '$new_diploma_values' WHERE id = $user_id";
        if (mysqli_query($conn, $sql)) {
            echo "Profile updated successfully";
        } else {
            echo "Error updating profile: " . mysqli_error($conn);
        }
    }
}


if (isset($_POST['update_resume'])) {
    $university = $_POST['university'];

    if (empty($university)) {
        $errors[] = 'Please select your university.';
    } else if ($university == 'Other') {
        $other_university = trim($_POST['other_university']);
        if (empty($other_university)) {
            $errors[] = 'Please specify your university.';
        }
    }


    $FirstN = $_POST['prenom'];
    $LastN = $_POST['nom'];
    echo $_POST['nom'];
    $Birthday = $_POST['dateNaissance'];
    $Experience = $_POST['Experience'];
    $Phone = $_POST['Phone'];
    $university = $_POST['university'];
    $marital_status = $_POST['marital_status'];
    $Adress = $_POST['Adress'];

    $query = "UPDATE resume SET FirstN='$FirstN', LastN='$LastN',Email='$Email',Birthday = '$Birthday',Status = '$marital_status',Adress = '$Adress', Phone='$Phone', university='$university', Experience='$Experience' WHERE id=" . $user_id;

    $result = mysqli_query($conn, $query);

    if ($result) {
        
        $_SESSION['success'] = 'Resume updated successfully.';
    } else {
        
        $_SESSION['error'] = 'Something went wrong. Please try again.';
    }

    header('location: dashboard.php');
    exit();
}


if (isset($_GET['apply_id'])) {

    $apply_id = mysqli_real_escape_string($conn, $_GET['apply_id']);


    $insert = mysqli_query($conn, "INSERT INTO `job_application` (`job_offer_id`,`applicant_id`, `status`) VALUES ('$apply_id','$user_id', 'Pending')");


    if ($insert) {

        header('location:dashboard.php');
        echo '<div class="success">Job offer added successfully!</div>';
    } else {
        echo '<div class="error">Error in adding job offer!</div>';
        echo mysqli_error($conn);
    }

}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Job Seeker Dashboard</title>
    <link rel="stylesheet" type="text/css" href="dashboard-style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="profile">
                <?php
                $result = $conn->query("SELECT * FROM job_seeker WHERE id = $user_id");
                if ($row = $result->fetch_assoc()) {
                    echo '<div class="profile">';
                    echo '<img src="../../images/job_seekers/' . $row['image'] . '" alt="User Profile">';
                    echo '<span>Welcome, ' . $row['first_name'] . ' ' . $row['last_name'] . '</span>';
                    echo '</div>';
                }

                ?>
            </div>
        </div>

    </div>
    <div class="content">
        <div class="menu">
            <ul>
                <li><a href="#" class="menu-link" data-page="resume.php">Resume Update</a></li>
                <li><a href="#" class="menu-res" data-page="list-offers.php">List Job Offers</a></li>
                <li><a href="#" class="menu-app" data-page="list-applications.php">List Job Applications</a></li>
                <li><a href="#" class="menu-link" data-page="view-resume.php">View Resume</a></li>
                <li><a href="#" class="menu-link" data-page="update_profile.php">Update Profile</a></li>
                <li><a href="dashboard.php?logout=<?php echo $user_id; ?>" class="logout-btn">logout</a></li>

            </ul>
        </div>
        <div class="main-content" id="main-content">
            <h1>Welcome to your Job Search Dashboard</h1>
            <p>Here, you can check the available job offers and view your applications.</p>
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



        const links1 = document.querySelectorAll('.menu-res');

        links1.forEach((link) => {
            link.addEventListener('click', (event) => {
                event.preventDefault();
                const page = event.target.dataset.page;
                
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        contentDiv.innerHTML = xhr.responseText;
                        sortTable(7);
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
                
            };
            xhr.addEventListener('load', onLoaded);
            xhr.open('GET', page, true);
            xhr.send();
        });




        function sortTable(columnIndex) {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("myTable");
            switching = true;
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("td")[columnIndex].innerHTML;
                    y = rows[i + 1].getElementsByTagName("td")[columnIndex].innerHTML;
                    if (parseInt(x) < parseInt(y)) {
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }

    </script>



</body>

</html>