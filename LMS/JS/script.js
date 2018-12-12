$(document).ready(function()
{
	//Event Handler to retrieve the data select in the combobox at top left
	$(".category").on('change',function(){
		var category=this.value;
		$.ajax({
			url:"process.php", 
			method:"post",  
			data:{category:category},  
			success:function(data){  
				$('#data').html(data);  
			}
		})
	});
	
	//Event Handler to add new candidate 
	$("#submit-candidate").on('submit',function(event){		
		event.preventDefault();
		
		var formdata=new FormData(this);
		formdata.append("submit-candidate","submit-candidate");
		
		var type=$("input[name='ctype']:checked").val();
		if(type=="Student")//student
		{
			var value=$("#cid").val();
			if(value[0]!=='S')
			{
				alert("Invalid Candidate ID!");
				$("#cid").focus();
			}
			else
			{
				$.ajax({
					url:"process.php",
					method:"post",
					contentType: false,       
					cache: false,            
					processData:false,   
					data: formdata,
					success:function(data){
						//alert("Form Submitted");
						alert("Candidate Added Successfully");
						$("#candidate").modal("hide");
						$(".category")
							.val("candidate")
							.trigger('change');
					}
				});
			}
		}
		else if(type=="Teacher")//teacher
		{
			var value=$("#cid").val();
			if(value[0]!=='T')
			{
				alert("Invalid Candidate ID!");
				$("#cid").focus();
			}
			else
			{
				$.ajax({
					url:"process.php",
					method:"post",
					contentType: false,       
					cache: false,            
					processData:false,   
					data: formdata,
					success:function(data){
						//alert("Form Submitted");
						alert("Candidate Added Successfully");
						$("#candidate").modal("hide");
						$(".category")
							.val("candidate")
							.trigger('change');
					}
				});
			}
		}
	});
	
	//Event Handler to load all the booknames
	$("#bookname").keyup(function(){
		var val=$("#bookname").val();
		$.ajax({
			url:"process.php",
			method:"post",
			data: {val:val},
			success:function(data){
				$("#booklist").html(data);
			}
		})
	});
	
	//Event handler to load the name of book after filtering according to the value entered
	$("#bookname").click(function(){
		var table="books";
		$.ajax({
			url:"process.php",
			method:"post",
			data: {table:table},
			success:function(data){
				$("#booklist").html(data);
			}
		})
	});
	
	//Event handler to add new books in library
	$("#submit-book").on('submit',function(event){
		event.preventDefault();
		
		var formdata=new FormData(this);
		formdata.append("submit-book","submit-book");
		
		$.ajax({
			url:"process.php",
			method:"post",
			contentType: false,       
			cache: false,            
			processData:false,   
			data: formdata,
			success:function(data){
				alert("Books Added Successfully");
				$("#book").modal("hide");
				$(".category")
					.val("books")
					.trigger('change');
			}
		});
	});	
	
	//Event Handler to get the available quantities of book
	$("#QButton").click(function(){
		var bkname=$("#bookname").val();
		$.ajax({
			url:"process.php",
			method:"post",
			data:{bkname:bkname},
			success:function(data){
				$("#QLabel").html(data);
			}
		})
	});
	
	//Event Handler to issue new book to any candidate
	$("#submit-issue").on('submit',function(event){
		event.preventDefault();
		
		var formdata=new FormData(this);
		formdata.append("submit-issue","submit-issue");
		
		var quantity=parseInt($("#QLabel").val());
		var oid=$("#ownerid").val();
		var oidtype=$("#ownerid").val();
		var count,otype,limit;
		$.ajax({
			url:"process.php",
			method:"post",
			data:{oid:oid},
			success:function(data){
				count=data;
				//console.log(data);
			}
		}); //count the transactions of issuing the book
		
		$.ajax({
			url:"process.php",
			method:"post",
			data:{oidtype:oidtype},
			success:function(data){
				otype=data;
				//console.log(data);
			}
		}); //get the limit of issuing the book according to the type of candidate
		
		if(otype=="Student")
		{
			limit=4;
		}
		else if(otype=="Teacher")
		{
			limit=7;
		} //assign the limits according to the type of owner
		
		if(count>limit)//check if the no. of issued are books are more than the limit or not?
		{
			alert("Sorry! You have reached the maximum limit of issuing the books, Kindly the return the issued books to get the new book issued");
		}
		else{
			if(quantity<1)//Check the desired book is in stock or not
			{
				alert("Sorry! This Book is not available, All the Copies of this book are issued to other candidates");
			}
			else
			{
				var owner=$("#ownerid").val();								
				if(owner[0]=='T' || owner[0]=='S')//Validate the Owner ID
				{
					$.ajax({
						url:"process.php",
						method:"post",
						contentType: false,       
						cache: false,            
						processData:false,   
						data: formdata,
						success:function(data){
							alert("Book Issued Successfully, Please Try to return within 7days of issuing to avoid fines");
							$("#issue").modal("hide");
							$(".category")
								.val("issue")
								.trigger('change');
						}
					});
				}
				else
				{
					alert("Invalid Owner ID!");
				}
			}
		}
	});	
	
	//Event handler to return the issued book
	$("#submit-return").on('submit',function(event){
		event.preventDefault();
		
		var formdata=new FormData(this);
		formdata.append("submit-return","submit-return");
		
		$.ajax({
			url:"process.php",
			method:"post",
			contentType: false,       
			cache: false,            
			processData:false,   
			data: formdata,
			success:function(data){
				alert(data);
				//alert("Book Returned");
				$("#return").modal("hide");
				$(".category")
					.val("issue")
					.trigger('change');
			}
		});
	});

	$("#FButton").click(function(){
		var FINEoid=$("#ownerId").val();
		var FINEbkid=$("#bookid").val();
		
		$.ajax({
			url:"process.php",
			method:"post",
			data:{FINEoid:FINEoid,FINEbkid:FINEbkid},
			success:function(data){
				$("#FLabel").html(data);
			}
		});
	});
	//Event handler to collect fine on any transaction of book
	$("#submit-fine").on('submit',function(event){
		event.preventDefault();
		
		var formdata=new FormData(this);
		formdata.append("submit-fine","submit-fine");
		
		$.ajax({
			url:"process.php",
			method:"post",
			contentType: false,       
			cache: false,            
			processData:false,   
			data: formdata,
			success:function(data){
				alert("Fine Collected, Thank You");
				$("#fine").modal("hide");
				$(".category")
					.val("fine")
					.trigger('change');
			}
		});
	});	
	
	//Event Handler to open modals
	$(".open-book").click(function(){
		$("#book").modal("show");
	}); //Add new Books

	$(".open-issue").click(function(){
		$("#issue").modal("show");
	}); //Issue a Book
	
	$(".open-return").click(function(){
		$("#return").modal("show");
	}); //Return issued Book

	$(".open-candidate").click(function(){
		$("#candidate").modal("show");
	}); //Add new Candidate

	$(".open-fine").click(function(){
		$("#fine").modal("show");
	}); //Collect fine on late return
	
	//Event Handler to close modals
	$(".close-fine").click(function(){
		$("#fine").modal("hide");
	});

	$(".close-candidate").click(function(){
		$("#candidate").modal("hide");
	});

	$(".close-book").click(function(){
		$("#book").modal("hide");
	});

	$(".close-issue").click(function(){
		$("#issue").modal("hide");
	});
	
	$(".close-return").click(function(){
		$("#return").modal("hide");
	});
});