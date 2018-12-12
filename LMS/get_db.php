<?php
	$db=mysqli_connect("localhost","root","","lms");
	
	if(!$db)
	{
		echo "<script>console.log('Connection Failed: ".mysqli_connect_error()."')'</script>";
	}
	else
	{
		//echo "<script>console.log('Database Connected');</script>";
	}
?>