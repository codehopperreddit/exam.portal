<?php
    session_start();
    session_destroy();
    
    header('Location: '.$uri.'/exam.portal/loggedout.html');
?>