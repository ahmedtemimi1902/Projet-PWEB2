<?php
include '../../sql/config.php';
session_start();

?>
<style>
  select {
  padding: 10px;
  font-size: 16px;
  border: none;
  border-radius: 5px;
  background-color: #f2f2f2;
  color: #333;
  box-shadow: none;
}

select:focus {
  outline: none;
  box-shadow: 0 0 5px #42AEEC;
}

select option:first-child {
  color: #999;
}

select option {
  color: #333;
}

select::-ms-expand {
  display: none;
}

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

form {
  max-width: 600px;
  margin: 0 auto;
  padding: 30px;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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

form input[type="text"]:focus,
form textarea:focus {
  box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.2), 0 0 5px #42AEEC;
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
  transition: background-color 0.3s ease;
}

form button:hover {
  background-color: #0069d9;
}

.checkbox-container {
  display: flex;
  align-items: center;
  margin-bottom: 1rem;
  flex-wrap: wrap;

}
.checkbox-container label {
  padding-left: 5px;
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
  transition: background-color 0.3s ease;
}

form input[type="submit"]:hover {
  background-color: #44c767;
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
        <label for="skill1">PHP</label>
        <input type="checkbox" id="skill1" name="skills[]" value="PHP">


        <label for="skill2">JavaScript</label>
        <input type="checkbox" id="skill2" name="skills[]" value="JavaScript">


        <label for="skill3">Python</label>
        <input type="checkbox" id="skill3" name="skills[]" value="Python">


        <label for="skill4">Java</label>
        <input type="checkbox" id="skill4" name="skills[]" value="Java">

        <label for="skill1">C++</label>
        <input type="checkbox" id="skill5" name="skills[]" value="C++">


        <label for="skill1">C#</label>
        <input type="checkbox" id="skill6" name="skills[]" value="C#">


        <label for="skill1">CSS</label>
        <input type="checkbox" id="skill7" name="skills[]" value="CSS">


        <label for="skill1">Ruby</label>
        <input type="checkbox" id="skill8" name="skills[]" value="Ruby">

        
        <label for="skill1">Swift</label>
        <input type="checkbox" id="skill9" name="skills[]" value="Swift">

        <label for="skill1">C</label>
        <input type="checkbox" id="skill10" name="skills[]" value="C">

        

    </div>

    <label for="experience">Years of experience:</label>
    <input type="number" id="experience" name="experience" required>

    <label for="salary">Proposed Salary:</label>
    <input type="number" id="salary" name="salary" required>
      <br>
    <input type="submit" name ="add_offer" value="Add Offer">
</form>