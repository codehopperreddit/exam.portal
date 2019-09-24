<?php
    session_start();
    if (isset($_SESSION['loggedin']))
    {
        header('Location: '.$uri.'/exam.portal/usertype.php');

    }
    
    
?>
<html>
    <head>
        <title>Page to input questions and answers into two dB</title>
        <style>
            a{
                text-decoration: none;
            }
           
        </style>
        <script>
            
		

        </script>
        
    </head>
    <body>
              
         
         <a href="signup.html">Sign up</a>         

         <a href="login.html">Log in</a>         


        
        
            
    </body>
</html>