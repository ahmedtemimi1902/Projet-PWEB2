<?php

include '../../sql/config.php';
session_start();
$user_id = $_SESSION['user_id'];

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




$competence_field = 'Competence'; // replace with the name of the "competence" field in your table
$sql = "SELECT $competence_field FROM resume WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$competence_values = $row[$competence_field];
// Step 2: Convert comma-separated values into an array
$competence_array = explode(',', $competence_values);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update resume</title>

    <!-- custom css file link  -->

</head>

<body>

    <div class="update-resume">

        <?php
        $select = mysqli_query($conn, "SELECT * FROM `resume` WHERE id = '$user_id'") or die('query failed');
        if (mysqli_num_rows($select) > 0) {
            $fetch = mysqli_fetch_assoc($select);
        }
        ?>

        <form action="dashboard.php" method="post" enctype="multipart/form-data">
            <?php
            if (isset($messagee)) {
                foreach ($messagee as $message) {
                    echo '<div class="message">' . $message . '</div>';
                }
            }
            ?>

            <fieldset>

                <legend>informations générales </legend>

                <label for="prenom">Prénom :</label>
                <input type="text" name="prenom" id="prenom" placeholder="prénom" size="30" maxlength="40"
                    value="<?php echo $fetch['FirstN']; ?>">
                <label for="nom">Nom:</label>
                <input type="text" name="nom" id="nom" placeholder="nom" size="30" maxlength="40"
                    value="<?php echo $fetch['LastN']; ?>">
                <label for="phone">Phone:</label>
                <input type="text" name="Phone" id="phone" placeholder="phone number" size="30" maxlength="40"
                    value="<?php echo $fetch['Phone']; ?>">
                <label for="dateNaissance"> date de naissance :</label>
                <input type="date" name="dateNaissance" id="dateNaissance" value="<?php echo $fetch['Birthday']; ?>">
                <br>
                <div id=infoGen>
                    <div>
                        <label for="adresse"> adresse :</label><br>
                        <textarea name="Adress" id="Adress" rows="1" cols="30"><?php echo $fetch['Adress']; ?></textarea>
                    </div>
                    <div>
                        <fieldset id="civil">
                            <label for="marital_status">Marital Status:</label>
                            <input type="radio" id="married" name="marital_status" value="married" <?php if ($marital_status == 'married')
                                echo 'checked'; ?>>
                            <label for="married">Married</label>
                            <input type="radio" id="single" name="marital_status" value="single" <?php if ($marital_status == 'single')
                                echo 'checked'; ?>>
                            <label for="single">Single</label>
                        </fieldset>
                    </div>
                </div>

            </fieldset>

            <fieldset>
                <legend>cursus et compétences </legend>
                <div id="cursus">
                    <div>
                        <label for="competences">compétences </label><br>
                        <?php
                        // Step 4: Generate select form options with selected attribute for matching values
                        $languages = [
                            'English' => 'Language',
                            'French' => 'Language',
                            'German' => 'Language',
                            'Spanish' => 'Language',
                            'JavaScript' => 'Programming',
                            'Python' => 'Programming',
                            'Ruby' => 'Programming',
                            'PHP' => 'Programming'
                        ]; // replace with your own list of options and categories
                        $categories = array_unique(array_values($languages)); // get unique category names
                        echo '<select name="competence[]" multiple size="' . 10 . '">';
                        foreach ($categories as $category) {
                            echo "<optgroup label=\"$category\">";
                            foreach ($languages as $language => $cat) {
                                if ($cat == $category) {
                                    $selected = in_array($language, $competence_array) ? 'selected' : '';
                                    echo "<option value=\"$language\" $selected>$language</option>";
                                }
                            }
                            echo "</optgroup>";
                        }
                        echo '</select>';
                        ?> <br> <br>

                        <label for="university">University:</label>
                        <select id="university" name="university">
                            <option value="">--Select University--</option>
                            <option value="University of ABC" <?php if ($university == 'University of ABC')
                                echo 'selected'; ?>>University of ABC</option>
                            <option value="University of XYZ" <?php if ($university == 'University of XYZ')
                                echo 'selected'; ?>>University of XYZ</option>
                            <option value="Other" <?php if ($university == 'Other')
                                echo 'selected'; ?>>Other</option>
                        </select>
                    </div>

                    <div>
                        Cochez vos diplomes :<br>
                        <?php
                        // Step 4: Generate select form options with selected attribute for matching values
                        $diplomas = [
                            'High School Diploma',
                            'Associate Degree',
                            'Bachelor Degree',
                            'Master Degree',
                            'Doctoral Degree'
                        ]; // replace with your own list of options
                        
                        echo '<select name="Diploma[]" multiple>';
                        foreach ($diplomas as $diploma) {
                            $selected = in_array($diploma, $diploma_array) ? 'selected' : '';
                            echo "<option value=\"$diploma\" $selected>$diploma</option>";
                        }
                        echo '</select>';
                        ?>
                        <div>
                        <label for="Experience">Années d'Experience :</label>
                <input type="number" name="Experience" id="experience" placeholder="Année d'experience" size="30" maxlength="40"
                    value="<?php echo $fetch['Experience']; ?>">
                    </div>
                    </div>
                </div>
                <input type="submit" value="update resume" name="update_resume" class="btn">
                <a href="../home.php" class="delete-btn">go back</a>
            </fieldset>

        </form>

    </div>

</body>

</html>