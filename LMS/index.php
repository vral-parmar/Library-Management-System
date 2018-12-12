<?php
	require("get_db.php");
?>
<html>
	<head>
		<title>Library Management System</title>
		<link rel="icon" type="images/x-icon" href="PICS/logo.png">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="CSS/styles.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="JS/script.js"></script>
	</head>
	<body>
		<div class="w3-container cont-left"><br><center>
			Data of :
			<select name="category" class="category">
				<option disabled selected>-- Select --</option>
				<option value="books">Books</option>
				<option value="candidate">Candidate</option>
				<option value="issue">Issue</option>
				<option value="fine">Fine</option>
				<option value="department">Department</option>
			</select>
			<br><br>
			<button class="open-candidate w3-btn w3-red w3-hover-red">Add Candidate</button>
			<br><br>
			<button class="open-book w3-btn w3-yellow w3-hover-yellow">Add Book</button>
			<br><br>
			<button class="open-issue w3-btn w3-green w3-hover-green">Issue Book</button>
			<br><br>
			<button class="open-return w3-btn w3-black w3-hover-black">Return Book</button>
			<br><br>
			<button class="open-fine w3-btn w3-blue w3-hover-blue">Collect Fine</button>
		</center></div>
		<div class="w3-container cont-right">
			<h1 class="head-left">Library Management System</h1><br>
			<form method="post" action="" class="w3-border w3-hover-shadow head-right">
				<input id="search-input" class="w3-input">
				<button id="search-button" class="w3-button"><i class="fa fa-search w3-large"></i></button>
			</form>
		</div>
		<div id="data"></div>
	</body>
</html>
<?php 
	include("modals.php");
?>	