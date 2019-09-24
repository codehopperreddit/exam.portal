<?php
    ob_start();
    if ( !isset($_POST['username'], $_POST['password']) ) 
    {
       
        die ('Please fill both the username and password field!');
    }
    include 'dbinfo.php';
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
        
        if(! $conn ) 
        {
           die('Could not connect: ' . mysqli_error($conn));
        }
        mysqli_select_db($conn,'examportal');
    
    if($_POST['usertype']=='tester') //instrutor
    {
        if ($stmt = $conn->prepare('SELECT id, password FROM instructoraccounts WHERE username = ?')) 
        {
            echo 'usertype tester';
            $stmt->bind_param('s', $_POST['username']);
            $stmt->execute();
        
            $stmt->store_result();
        }

    }
    elseif($_POST['usertype']=='testee')//student
    {
        if ($stmt = $conn->prepare('SELECT id, password FROM studentaccounts WHERE username = ?')) 
        {
            echo 'usertype testee';
            $stmt->bind_param('s', $_POST['username']);
            $stmt->execute();
        
            $stmt->store_result();
        }
    }
    else
    {
        echo 'Incorrect usertype';
    }
    
    
    if ($stmt->num_rows > 0) 
    {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        
        if (password_verify($_POST['password'], $password)) 
        {
            session_start();
            if (isset($_SESSION['loggedin']))
                session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['usertype']= $_POST['usertype'];
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            echo 'Welcome ' . $_SESSION['name'] . '!';
        } else 
        {
            echo 'Incorrect password or username!';
        }
    } 
    else 
    {
        echo 'Incorrect username or password!';
    }
    $stmt->close();

    header('Location: '.$uri.'usertype.php');
?>