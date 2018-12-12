<!DOCTYPE html>
<html>
<head>
	<title>Student Registration and records</title>
	<link rel="stylesheet" type="text/css" href="w3.css" />
</head>
<body>
	<div class="w3-bar w3-border w3-card-4 w3-light-grey ">
  <a href="Main.html" class="w3-bar-item w3-button">Home</a>
  <a href="Teacher.php" class="w3-bar-item w3-button">Teacher</a>
  <a href="Book.php" class="w3-bar-item w3-button">Book's</a>
  <a href="issue.php" class="w3-bar-item w3-button">Issue Book</a>
  <a href="fine.php" class="w3-bar-item w3-button">Fine</a>
</div>
<div class="w3-container w3-row">
<div class="w3-third w3-container w3-col s3 ">
  	<button type="button" onclick="document.getElementById('id01').style.display='block'" class="w3-margin w3-block w3-padding w3-btn w3-green w3-hover-blue">Student Register</button>
  	
</div>
<div class="w3-col s9 w3-padding">
    <table class="w3-table-all">
    <thead>
      <tr class="w3-light-grey w3-hover-black">
        <th>First Name</th>
        <th>Last Name</th>
        <th>Points</th>
      </tr>
    </thead>
    <tr class="w3-hover-blue">
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    
  </table>

</div>
</div>
</div>
  <div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4">
      <header class="w3-container w3-teal w3-padding"> 
        <span onclick="document.getElementById('id01').style.display='none'" 
        class="w3-button w3-display-topright w3-hover-red">&times;</span>
        <h2>Student Registration</h2>
      </header>
      <form action="" method="??">
      <div class="w3-container w3-margin w3-padding w3-border">
		<label>EnrollMent No: </label>
		<input type="number" name="enroll" class="w3-input w3-border w3-hover-shadow">
		<label>Name: </label>
		<input type="text" name="name" class="w3-input w3-border w3-hover-shadow">
		<label>Department name:</label><br>
		<select name="category" class="w3-select w3-border w3-hover-shadow" required>
			<option value="0" class="">Select</option>
			<option value="1">CSE</option>
			<option value="2">IT</option>
			<option value="3">MECH</option>
			<option value="4">AUTO</option>
			<option value="5">CIVIL</option>
		</select><br>
		</div>
		<footer class="w3-container w3-teal">
		        <button type="submit" class="w3-right w3-margin w3-btn w3-green w3-hover-blue">submit</button>
		        <button type="reset" class="w3-left w3-margin w3-btn w3-green w3-hover-blue">reset</button>
	    </form>
      </footer>
    </div>
  </div>

</body>
</html>