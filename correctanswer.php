<?php
    session_start();
    if($_SESSION['usertype']=="tester") //instrutor
    {
        if (!isset($_SESSION['loggedin'])) 
        {
            header('Location: index.php');
            exit();
        }

    }
   
?>
<html>
<head>

<title>Stores correct answer</title>
</head>
<body>
	<h2>The Answer you entered:</h2>
	<?php 
        /*
            Take the selected answer from the previous page and save it along with the same question number and
            question in a separate table
        */
        include 'dbinfo.php';
        
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
        
        if(! $conn ) 
        {
           die('Could not connect: ' . mysqli_error($conn));
        }
        
        $sql = 'SELECT * FROM mainquestions ORDER BY qn DESC LIMIT 1';
        mysqli_select_db($conn,'examportal');
        $retval = mysqli_query($conn,$sql);//gets the last question to get the question number
        $row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
        $qn = $row['qn'];
        $questiontxt = $row['question'];
        if(! $retval ) 
        {
           die('Could not get data: ' . mysqli_error($conn));
        }
        
        $sql = $conn->prepare("INSERT INTO correctanswers (qn, question, correct) VALUES (?, ?, ?)");
        $sql->bind_param("sss", $qn, $questiontxt, $correcttxt);

        
        
        $correcttxt=$_POST["correctanswer"];
         echo $correcttxt;

        
        $sql->execute();
        
        
       
        
        mysqli_close($conn);
	
		
    ?>
    <a href="instructorportal.php">Enter another question</a>  <br>
    
    <a href="instructoraccountcreator/signup.html">Create new account</a> <br>

    <a href="logout.php">Log Out</a> <br>

    </body>
</html> 