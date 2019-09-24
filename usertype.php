<?php
    session_start();
    if($_SESSION['usertype']=='tester') //instrutor
    {
       
        header('Location: '.$uri.'/exam.portal/instructorportal.php');

    }
    elseif($_SESSION['usertype']=='testee')//student
    {
        
        header('Location: '.$uri.'/exam.portal/studentportal.php');
    }
    else
    {
        
        header('Location: '.$uri.'/exam.portal/logout.php');
    }
    
?>