

        <?php
            session_start();

            $count=$_SESSION['count']; //keep track of the present question
            $qnseq=$_SESSION['qnseq'];//this is a array that has all the questions in a random order
            $ansseq=$_SESSION['ansseq'];
            $id=$_SESSION['id']; //Each student account has a unique id

            //put a check taht the previous page is question.php
    
    
            //receives the answer and serves another question
        
            //store answers in an array where qn is the index
   
            // $qn=$_SESSION['qn'];
            //$chanswer=$_POST['choosenanswer'];
            include 'dbinfo.php';
            $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
            mysqli_select_db($conn,'examportal');
            if(! $conn ) 
            {
               die('Could not connect: ' . mysqli_error($conn));
            }

            $answer=$_POST['answer'];
            $qnumber=$qnseq[$count];

            
            
            //Now we check if the anseer is correct

            $sql = $conn->prepare("SELECT correct FROM correctanswers WHERE qn=?");
            $sql->bind_param("s", $qnumber);

            $sql->execute();
            $sql->store_result();
            if($sql->num_rows > 0)
            {
                
                $sql->bind_result($correct);
                if($sql->fetch())
                {
                    if($correct==$answer)
                    {
                        $ansseq[$count]=1;
                    }
                    else
                    {
                        $ansseq[$count]=0;
                    }

                }
                else
                {
                    die("error in getting answer"); //replace with something better
                }
            }
            else
            {
                die("No result");
            }

            
            //We store the answer in dB
            $serializedansseq=serialize($ansseq);
            
            if ($sql = $conn->prepare('UPDATE studentaccounts SET ansseq = ? WHERE id = ?')) 
            {
            
                $sql->bind_param('si',$serializedansseq,$id);
                $sql->execute();
        
                
            }
            else
            {
                echo 'bind error in studentacc';
            }

            


            mysqli_close($conn);

            $count++;
            $_SESSION['count']=$count; //Only values that will be updated during the test
            $_SESSION['ansseq']=$ansseq;

            header('Location: '.$uri.'/exam.portal/question.php');
        ?>
    