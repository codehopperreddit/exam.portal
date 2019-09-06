<html>
<head>

<title>Choose answer</title>
<script>
	
	function submitforms()
        {
            
            
                document.forms.getcorrectanswer.submit();
            
            
        }


</script>
</head>
<body>
	<h2>Choose the correct option</h2>
	

    <?php 
        /*
            We take the Last question number from the table and increment the question number by 1.
            Then we insert the question and answers entered in the previous page with the new question number into the table
        */
        $dbhost = 'localhost:3306';
        $dbuser = 'admin';
        $dbpass = 'securepassword';
        
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
        
        if(! $conn ) 
        {
           die('Could not connect: ' . mysqli_error($conn));
        }
        
        $sql = 'SELECT * FROM mainquestions ORDER BY qn DESC LIMIT 1';
        mysqli_select_db($conn,'examportal');
        $retval = mysqli_query($conn,$sql);//gets the last question
        $row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
        $newqn = $row['qn'];
        $newqn++;   //New question number created
        if(! $retval ) 
        {
           die('Could not get data: ' . mysqli_error($conn));
        }
        
        $sql = $conn->prepare("INSERT INTO mainquestions (qn, question, option1, option2 ,option3, option4) VALUES (?, ?, ?, ?, ?, ?)");
        $sql->bind_param("ssssss", $newqn, $questiontxt, $option1txt, $option2txt, $option3txt, $option4txt);

        
        $questiontxt=$_POST["question"];
		$option1txt=$_POST["option1"];
		$option2txt=$_POST["option2"];
		$option3txt=$_POST["option3"];
		$option4txt=$_POST["option4"];
        
        $sql->execute();
        
        
       
        
        mysqli_close($conn);
	
		
	?>
	<form name="getcorrectanswer" action="correctanswer.php" method="POST">
		<input type="radio" name="correctanswer" value=<?php echo $_POST["option1"]; ?> ><?php echo $_POST["option1"]; ?></input><br>
		<input type="radio" name="correctanswer" value=<?php echo $_POST["option2"]; ?> ><?php echo $_POST["option2"]; ?></input><br>
		<input type="radio" name="correctanswer" value=<?php echo $_POST["option3"]; ?> ><?php echo $_POST["option3"]; ?></input><br>
		<input type="radio" name="correctanswer" value=<?php echo $_POST["option4"]; ?> ><?php echo $_POST["option4"]; ?></input><br>
		<input type="button" value="Submit" onclick="submitforms()"></input>
	</form>
</body>
</html> 