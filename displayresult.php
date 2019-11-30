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
                //$ansseq=$_SESSION['ansseq'];
                //$numqn=$_SESSION['numqn'];
                $id=$_SESSION['id']; //Each student account has a unique id

                include 'dbinfo.php';
                $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
                mysqli_select_db($conn,'examportal');
                if(! $conn ) 
                {
                   die('Could not connect: ' . mysqli_error($conn));
                }
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
                    $sql->bind_result($serialqnseq,$serialansseq);
                    if($sql->fetch())
                    {
                        $qnseq=unserialize($serialqnseq);
                        $ansseq=unserialize($serialansseq);
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
                 
                $numqn=count($qnseq);

                //The next few lines define the marking scheme, to make changes read the comments
                $marks=0;
                 
                 for($i=0;$i<$numqn;$i++)
                 {
                     if($ansseq[$i]==1)
                     {
                         $marks+=1;  //Here 1 is the marks awarded for correct answer, change according to marking scheme
                     }
                     else if($ansseq[$i]==0)
                     {
                         $marks-=0;  //Here 0 is the marks subtracted for wrong answers , change accordingly 
                     }  
                 }
      
        ?>
        <p>Marks Awarded is :<?php echo $marks;?></p><br>
        <a href="logout.php">Log Out</a> <br>
    </body>
</html>