<html>
    <head>
        <style>
            a
            {
                text-decoration:none;
            }
        </style>
        
    </head>
    <body>
    <?php
        session_start();
        
        $id=$_SESSION['id']; //Each student account has a unique id
            


        include 'dbinfo.php';
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
        
        if(! $conn ) 
        {
           die('Could not connect: ' . mysqli_error($conn)); 
        }
        mysqli_select_db($conn,'examportal');
        
        //Now we need to check if the student is a returning one or a new one starting the exam

        if ($sql = $conn->prepare('SELECT count FROM studentaccounts WHERE id = ?')) 
        {
            
            $sql->bind_param('i', $id);
            $sql->execute();
        
            $sql->store_result();
        }
        else
        {
            echo 'bind error in studentacc';
        }
        if ($sql->num_rows > 0) 
        {
            $sql->bind_result($count);
             $sql->fetch();
         }
       
       
      if($count==0) //if count is null then the student hasn't answered anything and its safe to start
       {
        
            $sql= 'SELECT qn FROM mainquestions ORDER BY RAND()';//fetches in random order

         

       

        
            //now we store the sequence in a array
            $retval = mysqli_query($conn,$sql);
            if(! $retval ) 
            {
                die('Could not get data: ' . mysqli_error($conn));
            }
            $qnseq=array();
            if (mysqli_num_rows($retval) > 0) 
            { 
             
                while ($row = mysqli_fetch_array($retval)) 
                { 
                
                    array_push($qnseq,$row['qn']);
                
                } 
                                            //This should create an array of qn in random order
                mysqli_free_result($retval); 
            }  
            else 
            { 
                 echo "No matching records are found."; 
            } 
        
            $ansseq=array();//array to store the answers 
         
         
            $_SESSION['count']=0; //keep track of the present question
            $_SESSION['qnseq']=$qnseq;//this is a array that has all the questions in a random order
            $_SESSION['ansseq']=$ansseq;
            $_SESSION['numqn']=count($qnseq);//this is the number of questions
        
            //now we need to store qnseq into the db for retrieval in case of disconnection

            $serializedqnseq=serialize($qnseq);
            
            if ($sql = $conn->prepare('UPDATE studentaccounts SET qnseq = ? WHERE id = ?')) 
            {
            
                $sql->bind_param('si',$serializedqnseq,$id);
                $sql->execute();
        
                
            }
            else
            {
                echo 'bind error in studentacc';
            }

            mysqli_close($conn);
	
            header('Location: '.$uri.'/exam.portal/question.php'); //Remove this after implementation of a timer 

        }
        else  // Here we handle the case where the student has started already
        {
            //we need to retrieve the qnseq and ansseq (since count has already being retrieved)
            if ($sql = $conn->prepare('SELECT qnseq,ansseq FROM studentaccounts WHERE id = ?')) 
            {
            
                $sql->bind_param('i', $id);
                $sql->execute();
        
                $sql->store_result();
            }
            else
            {
                echo 'bind error in studentacc';
            }
            if ($sql->num_rows > 0) 
            {   
                $sql->bind_result($qnseq,$ansseq);
                if($sql->fetch())
                {
                    $_SESSION['count']=$count; //keep track of the present question
                    $_SESSION['qnseq']=unserialize($qnseq);//this is a array that has all the questions in a random order
                    $_SESSION['ansseq']=unserialize($ansseq);  //The data is serialized before storing
                    $_SESSION['numqn']=count($qnseq);//this is the number of questions

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
            


                


            mysqli_close($conn);
	
            header('Location: '.$uri.'/exam.portal/question.php'); //Remove this after implementation of a timer 

        }
    ?>
    <a href="question.php">Start test</a>   
    <input type="button" value="Start test"></input>
    <p>replace above with button</p>
    <body>
</html>

