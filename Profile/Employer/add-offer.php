<?php
include '../../sql/config.php';
session_start();

?>
<style>

body {
  background-color: #f5f5f5;
  font-family: Arial, sans-serif;
  font-size: 16px;
  line-height: 1.5;
  margin: 0;
}


h1 {
  font-size: 32px;
  margin-top: 0;
}

form label {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
}

form input[type="text"],
form textarea {
  width: 100%;
  padding: 10px;
  border: none;
  border-radius: 5px;
  margin-bottom: 20px;
  box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.2);
}

form textarea {
  height: 200px;
}

form button {
  display: block;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  font-size: 18px;
  cursor: pointer;
}

form button:hover {
  background-color: #0069d9;
}

.checkbox-container {
  display: flex;
  align-items: center;
  margin-bottom: 1rem;
}

.checkbox-container input[type="checkbox"] {
  margin-right: 0.5rem;
}

.checkbox-container label {
  font-size: 1.1rem;
  font-weight: bold;
}
form input[type="submit"] {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  margin-top: 10px;
}

</style>

<h1>Add Job Offer</h1>
<form action="dashboard.php" method="post" class="job-offer-form">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea>

    <label for="diploma">Diploma:</label>
    <select id="diploma" name="diploma" required>
        <option value="">--Select--</option>
        <option value="BSc">BSc</option>
        <option value="MSc">MSc</option>
        <option value="PhD">PhD</option>
    </select>

    <label for="skills">Skills:</label>
    <div class="checkbox-container">
        <input type="checkbox" id="skill1" name="skills[]" value="PHP">
        <label for="skill1">PHP</label>

        <input type="checkbox" id="skill2" name="skills[]" value="JavaScript">
        <label for="skill2">JavaScript</label>

        <input type="checkbox" id="skill3" name="skills[]" value="Python">
        <label for="skill3">Python</label>

        <input type="checkbox" id="skill4" name="skills[]" value="Java">
        <label for="skill4">Java</label>
    </div>

    <label for="experience">Years of experience:</label>
    <input type="number" id="experience" name="experience" required>

    <label for="salary">Proposed Salary:</label>
    <input type="number" id="salary" name="salary" required>
      <br>
    <input type="submit" value="Add Offer">
</form>