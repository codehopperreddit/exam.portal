<html>
    <head>

        <style>
             a
            {
                text-decoration:none;
            }
        </style>
        <script>
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

                $count++;
                $_SESSION['count']=$count; //Only value that will be updated during the test

                
            }   
            else
            {
                //code block here gets executed when the questions are over

                //redirect to result page maybe?
            }   

        
        ?>
        <form name="getanswer" action="checkanswer.php" method="POST">
		<input type="radio" name="correctanswer" value="<?php echo ;?>" ><?php echo ; ?></input><br>
		<input type="radio" name="correctanswer" value="<?php echo ; ?>" ><?php echo ; ?></input><br>
		<input type="radio" name="correctanswer" value="<?php echo ; ?>" ><?php echo ; ?></input><br>
		<input type="radio" name="correctanswer" value="<?php echo ; ?>" ><?php echo ; ?></input><br>
		<input type="button" value="Submit" onclick="submitforms()"></input>
	</form>
    </body>
</html>