<html>
    <head>

        <style>
             a
            {
                text-decoration:none;
            }
        </style>
        <script>
            function submitforms()
        {
            
            
                document.forms.getanswer.submit();
            
            
        }

        </script>
    </head>
    <body>
        <?php
            session_start();
                                //put login checks here later
            //Serves question

            //First we retrieve all the info we need to fetch a question
            
            $count=$_SESSION['count']; //keep track of the present question
            $qnseq=$_SESSION['qnseq'];//this is a array that has all the questions in a random order
            $numqn=$_SESSION['numqn'];//this is the number of questions

            if($count<$numqn)
            {
                //now we check which question we will fetch ($count holds the INDEX value)
                $qnumber=$qnseq[$count];

                

                //now we start with the db stuff
                include 'dbinfo.php';
                $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
                mysqli_select_db($conn,'examportal');
                if(! $conn ) 
                {
                   die('Could not connect: ' . mysqli_error($conn));
                }
                
                $sql = $conn->prepare("SELECT question ,option1 ,option2 ,option3 ,option4 FROM mainquestions WHERE qn=?");
                if($sql !== FALSE) 
                {       
                    $sql->bind_param("s", $qnumber);
                }
                else
                {
                    die('prepare() failed: ' . htmlspecialchars($conn->error)); //dev only remove after
                
                }
                $sql->execute();
                $sql->store_result();  
                //Here we handle the results
                if($sql->num_rows > 0)
                {
                    
                    $sql->bind_result($question, $option1, $option2, $option3, $option4);
                    if($sql->fetch())
                    {
                        ?>
                            <p><?php echo $question;?></p>
                            <form name="getanswer" action="checkanswer.php" method="POST">
		                    <input type="radio" name="answer" value="<?php echo $option1;?>" ><?php echo $option1; ?></input><br>
		                    <input type="radio" name="answer" value="<?php echo $option2; ?>" ><?php echo $option2; ?></input><br>
		                    <input type="radio" name="answer" value="<?php echo $option3; ?>" ><?php echo $option3; ?></input><br>
		                    <input type="radio" name="answer" value="<?php echo $option4; ?>" ><?php echo $option4; ?></input><br>
		                    <input type="button" value="Submit" onclick="submitforms()"></input>
	                        </form>

                        <?php
                    }
                    else
                    {
                        die("eroor in getting answer"); //replace with something better
                    }
                }
                else
                {
                    die("No result");
                }
                
                mysqli_close($conn);
            }   
            else
            {
                //code block here gets executed when the questions are over
                
                

                header('Location: '.$uri.'/exam.portal/displayresult.php');
            }   

        
        ?>
        
    </body>
</html>