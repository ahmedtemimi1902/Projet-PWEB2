<?php
include '../../sql/config.php';
session_start();

$user_id = $_SESSION['user_id'];

    $applicantId = $user_id;
   
    // Get the applicant details from the database
    $applicant = $conn->query("SELECT * FROM resume WHERE id = $applicantId")->fetch_assoc();
      
    // Generate the HTML code for the applicant details
    $html = '<h2>' . $applicant['FirstN'] . ' ' . $applicant['LastN'] . '</h2>';
    $html .= '<p><strong>Email:</strong> ' . $applicant['Email'] . '</p>';
    $html .= '<p><strong>Birthday:</strong> ' . $applicant['Birthday'] . '</p>';
    $html .= '<p><strong>Status:</strong> ' . $applicant['Status'] . '</p>';
    $html .= '<p><strong>Address:</strong> ' . $applicant['Adress'] . '</p>';
    $html .= '<p><strong>Phone:</strong> ' . $applicant['Phone'] . '</p>';
    $html .= '<p><strong>Diploma:</strong> ' . $applicant['Diploma'] . '</p>';
    $html .= '<p><strong>Competence:</strong> ' . $applicant['Competence'] . '</p>';
    $html .= '<p><strong>University:</strong> ' . $applicant['University'] . '</p>';
    $html .= '<p><strong>Experience:</strong> ' . $applicant['Experience'] . ' years</p>';
  
    echo $html;

  

?>