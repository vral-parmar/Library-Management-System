<?php

	include("get_db.php");
	
	//Load the Data according to the category selected.
	if(isset($_POST['category']))
	{
		$table=$_POST['category'];
		if($table=='candidate')
		{
			$colname=array('cid','cname','ctype','deptid');
		}
		else if($table=='books')
		{
			$colname=array('bookid','bookname','author');
		}
		else if($table=='department')
		{
			$colname=array('deptid','dname');
		}
		else if($table=='issue')
		{
			$colname=array('tid','bookid','ownerid','issue_date','return_date');
		}
		else if($table=='fine')
		{
			$colname=array('tid','fine_amount','paid');
		}
		$sql="select * from ".$table;
		$result=mysqli_query($db,$sql);
		
		$table="<table class=`w3-table-all`><thead><tr>";
		foreach($colname as $col)
		{
			$table.="<th>".strtoupper($col)."</th>";
		}
		echo "</tr></thead><tbody>";
		$a=1;
		while($row=mysqli_fetch_array($result))
		{
			$a=4;
			$table.="<tr>";
			foreach($colname as $col)
			{
				$table.="<td> $row[$col] </td>";
			}
			$table.="</tr>";
		}
		$table.="</tbody></table";
		echo $table;
	}
	
	//Candidate Form Handler
	if(isset($_POST['submit-candidate']))
	{
		$cid=$_POST['cid'];
		$cname=$_POST['cname'];
		$deptid=$_POST['deptid'];
		$ctype=$_POST['ctype'];
		
		$sql="insert into candidate(cid,cname,deptid,ctype) values('$cid','$cname','$deptid','$ctype')";
		$result=mysqli_query($db,$sql);
		//print_r($_POST);
	}
	
	//Book Form Handler
	if(isset($_POST['submit-book']))
	{
		$bookname=$_POST['bookname'];
		$author=$_POST['author'];
		$quantity=$_POST['quantity'];
		$query="select count(*) from books";
		$res=mysqli_query($db,$query);
		$row=mysqli_fetch_row($res);
		
		$count=$row[0];
		//echo "Count: ".$count;
		
		if($count<10)
		{
			$bookid="B000".($count+1);
		}
		else if($count<100 && $count>=10)
		{
			$bookid="B00".($count+1);
		}
		else if($count<1000 && $count>=100)
		{
			$bookid="B0".($count+1);
		}
		else if($count==1000)
		{
			$bookid="B".($count+1);
		}
		
		$sql="insert into books(bookid,bookname,author) values('$bookid','$bookname','$author')";
		mysqli_query($db,$sql);
		echo mysqli_error($db);
		
		for($i=1;$i<=$quantity;$i++)
		{
			if($i<10)
			{
				$copyid=$bookid."00".$i;
			}
			else if($i<100 && $i>=10)
			{
				$copyid=$bookid."0".$i;
			}
			else if($i==100)
			{
				$copyid=$bookid.$i;
			}
			$sql="insert into booksid(copyid,bookid) values('$copyid','$bookid')";
			$result=mysqli_query($db,$sql);
		}
	}

	//Load all the bookname
	if(isset($_POST['table']))
	{
		$table=$_POST['table'];
		$sql="select bookname from books";
		$result=mysqli_query($db,$sql);
		while($row=mysqli_fetch_array($result))
		{
			$value=$row['bookname'];
			echo "<option value='";
			echo $value;
			echo "'>";
			echo $value;
			echo "</option>";
		}
	}
	
	//Load the bookname after filtering
	if(isset($_POST['val']))
	{
		$val=$_POST['val'];
		$sql="select bookname from books where bookname LIKE '".$val."%'";
		echo $sql;
		$result=mysqli_query($db,$sql);
		echo "Error1: ".mysqli_error($db);
		echo mysqli_num_rows($result);
		while($row=mysqli_fetch_array($result))
		{
			$value=$row['bookname'];
			echo "<option value='";
			echo $value;
			echo "'>";
			echo $value;
			echo "</option>";
		}
		echo "Error2: ".mysqli_error($db);
	}
	
	//Check the Quantity of book
	if(isset($_POST['bkname']))
	{
		$bkname=$_POST['bkname'];
		$sql="select bookid from books where bookname='".$bkname."'";
		$rowID=mysqli_fetch_row(mysqli_query($db,$sql));
		$sql="select count(copyid) from booksid where bookid='".$rowID[0]."' AND status=0";
		$row=mysqli_fetch_row(mysqli_query($db,$sql));
		echo $row[0];
	}
	
	//Check the count of transactions
	if(isset($_POST['oid']))
	{
		$oid=$_POST['oid'];
		$sql="select count(tid) from issue where ownerid='".$oid."' AND returned_status=1";
		$row=mysqli_fetch_row(mysqli_query($db,$sql));
		echo $row[0];
	}
	
	//Check the type of owner to limit the issuing of books
	if(isset($_POST['oidtype']))
	{
		$oid=$_POST['oidtype'];
		$sql="select ctype from candidate where cid='".$oid."'";
		$row=mysqli_fetch_row(mysqli_query($db,$sql));
		echo $row[0];
	}
	
	//Issue Form Handler
	if(isset($_POST['submit-issue']))
	{
		$ownerid=$_POST['ownerid'];
		$bookname=$_POST['bookname'];
		
		$sql="select bookid from books where bookname='".$bookname."'";
		$row=mysqli_fetch_row(mysqli_query($db,$sql));
		$sql="select copyid from booksid where bookid='".$row[0]."' and status=0";
		$row=mysqli_fetch_row(mysqli_query($db,$sql));

		$sql="insert into issue(bookid,ownerid,issue_date) values('".$row[0]."','".$ownerid."','".date("Y-m-d")."')";
		mysqli_query($db,$sql);
		
		$sql="update booksid set status=1 where copyid='".$row[0]."'";
		mysqli_query($db,$sql);
		echo "Issued BookID: ".$row[0];
		
		//print_r($_POST);
	}
	
	//Return Form Handler
	if(isset($_POST['submit-return']))
	{
		$ownerID=$_POST['ownerid'];
		$bookid=$_POST['bookid'];
		
		$sql="select tid from issue where ownerid='".$ownerID."' AND bookid='".$bookid."'";
		$row=mysqli_fetch_row(mysqli_query($db,$sql));
		$tid=$row[0];
		$sql="update issue set return_date='".date("Y-m-d")."' where tid='".$tid."'"; //
		mysqli_query($db,$sql);
		$sql="update issue set returned_status=1 where tid='".$tid."'";
		mysqli_query($db,$sql);
		$sql="update booksid set status=0 where copyid='".$bookid."'";
		mysqli_query($db,$sql);
		
		$sql="select issue_date,return_date from issue where tid='".$tid."'";
		$row=mysqli_fetch_assoc(mysqli_query($db,$sql));
		$idate=date_create($row['issue_date']);
		//$rdate=date_create("2018-12-20");
		$rdate=date_create($row['return_date']);
		$diff=date_diff($idate,$rdate)->format("%a");
		//echo $diff;
		if($diff>7)
		{
			$day=$diff-7;
			$amount=10*$day;
			$sql="insert into fine(tid,fine_amount) values('".$tid."','".$amount."')";
			mysqli_query($db,$sql);
		}
		echo "Book returned";
		//print_r($_POST);
	}
	
	//Get the value of fine
	if(isset($_POST['FINEoid']))
	{
		$FINEoid=$_POST['FINEoid'];
		$FINEbkid=$_POST['FINEbkid'];
		$sql="select tid from issue where ownerid='".$FINEoid."' AND bookid='".$FINEbkid."'";
		$row=mysqli_fetch_assoc(mysqli_query($db,$sql));
		$FINEtid=$row['tid'];
		$sql="select fine_amount from fine where tid='".$FINEtid."'";
		$row=mysqli_fetch_assoc(mysqli_query($db,$sql));
		echo $row['fine_amount'];
	}
	
	//Fine Form Handler
	if(isset($_POST['submit-fine']))
	{
		$ownerid=$_POST['ownerId'];
		$bookid=$_POST['bookid'];
		$sql="select tid from issue where ownerid='".$ownerid."' AND bookid='".$bookid."'";
		$row=mysqli_fetch_row(mysqli_query($db,$sql));
		$tid=$row[0];
		$sql="update fine set paid=1 where tid='".$tid."'";
		mysqli_query($db,$sql);
		print_r($_POST);
	}
	
?>