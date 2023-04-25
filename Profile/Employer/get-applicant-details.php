<?php
include '../../sql/config.php';

    $applicantId = $_GET['id'];
   
    
    $applicant = $conn->query("SELECT * FROM resume WHERE id = $applicantId")->fetch_assoc();
      
    
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
