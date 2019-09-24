
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
    elseif($_SESSION['usertype']=="testee")//student
    {
        header('Location: '.$uri.'/exam.portal/studentportal.php');
    }
    else
    {
        header('Location: '.$uri.'/exam.portal/logout.php');
    }
?>
<html>
    <head>
        <title>Page to input questions and answers into two dB</title>
        <style>
           
        </style>
        <script>
            
		function Cancel()
		{
			
			document.student.reset();
			
		}
        function submitforms()
        {
            var form1=document.fullquestion;
            
            if(form1.question.value==""||form1.option1.value==""||form1.option2.value==""||x.style.display==="none"||
			form1.option3.value==""||form1.option4.value=="")
			{
				
				alert("Data is Missing Fill up all fields");
                
				return false;
			}
			
			else
                {
            
                document.forms.fullquestion.submit();
                return true;
                }
            
        }

        </script>
        
    </head>
    <body>
    
        
            <form name="fullquestion" action="chooseanswer.php" method="POST">
                <p>Question<input type="text" name="question"></p>
                <p>Answers:</p>
                <p>1.<input type="text" name="option1"></p>
                <p>2.<input type="text" name="option2"></p>
                <p>3.<input type="text" name="option3"></p>
                <p>4.<input type="text" name="option4"></p>
                
                <button onclick="return submitforms()">Submit</button>
                <button onclick="Cancel()">Clear All</button>
            </form>

            <br>
            
            <a href="instructoraccountcreator/signup.html">Create new account</a> <br>
        
        
            
    </body>
</html>