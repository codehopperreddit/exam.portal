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
        include 'dbinfo.php';
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
        
        if(! $conn ) 
        {
           die('Could not connect: ' . mysqli_error($conn)); 
        }
        
        //$sql = 'SELECT * FROM mainquestions ORDER BY RAND() LIMIT 1';
        //instead of this we should generate a random view for each user and serve that : studentview username varchar , viewname varchar
        //will allow to resume function
        //put a button called "start test" here 
        
        //Instead of that we can generate a rand sequence of qn and store in a variable and pass via sessions
        //$sql = 'SELECT qn FROM mainquestions ORDER BY RAND()';
        
        //mysqli_select_db($conn,'examportal');
        //$retval = mysqli_query($conn,$sql);//gets a random question
        //$row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
        //$qn = $row['qn'];//need to put a check for if this qn has been retrieved before
        //studentanswers: username(varchar),(column name should be qn store 1,2,3,4 acc to answer)
        //ALTER TABLE studentanswers ADD ? int(10);
        //i,qn
        //but creating everytime for each user will be problamatic, so creation of columns to be done while inputing questions

        //version 1
        mysqli_select_db($conn,'examportal');
        
        /*
        $sql = 'SELECT qn FROM mainquestions ORDER BY qn DESC LIMIT 1'; // first we find the last qn to know the size of 
        //the array needed
        $retval = mysqli_query($conn,$sql);
        if(! $retval ) 
        {
           die('Could not get data: ' . mysqli_error($conn));
        }
        $row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
        $lastqn = $row['qn']; //Now we know the last question number and the number of questions
        */
        //funtionality of the above code replaced by "count" 
       
        $sql= 'SELECT qn FROM mainquestions ORDER BY RAND()';//fetches in random order

        //https://www.w3schools.com/php/php_ref_array.asp
        //https://www.w3schools.com/php/func_array_push.asp
        //https://www.w3schools.com/php/php_arrays.aspg  

        //$sql ='SELECT qn FROM  mainquestions  ORDER BY RAND()';

        
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
            mysqli_free_res($retval); 
        }  
        else { 
            echo "No matching records are found."; 
        } 
        
         session_start();
         $_SESSION['count']=0; //keep track of the present question
         $_SESSION['qnseq']=$qnseq;//this is a array that has all the questions in a random order
         $_SESSION['numqn']=count($qnseq);//this is the number of questions
        
        
        mysqli_close($conn);
	
        header('Location: '.$uri.'/exam.portal/question.php'); 
    ?>
    <a href="question.php">Start test</a>   
    <input type="button" value="Start test"></input>
    <p>replace above with button</p>
    <body>
</html>

