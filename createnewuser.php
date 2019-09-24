<?php
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

    if ($stmt = $conn->prepare('SELECT id FROM studentaccounts WHERE username = ?')) 
        {
            echo 'usertype testee';
            $stmt->bind_param('s', $_POST['username']);
            $stmt->execute();
        
            if ($stmt->num_rows > 0) 
            {
                header('Location: '.$uri.'/exam.portal/useralreadyexists.html');
            }
        }

    $sql = 'SELECT id FROM studentaccounts ORDER BY id DESC LIMIT 1';
        
        $retval = mysqli_query($conn,$sql);//gets the last id
        $row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
        
        $newid = $row['id'];
        $newid++;  //creating new id
    $username=$_POST['username'];
    $name=$_POST['name'];
    $password=$_POST['password'];
    $options = [
        'cost' => 12,
                ];
    $hash=password_hash($password,PASSWORD_BCRYPT, $options);
    $password="password";
    $sql=$conn->prepare('INSERT INTO studentaccounts (id,username,name,password) VALUES (?,?,?,?)');

    if($sql !== FALSE) 
        {
             $sql->bind_param('isss',$newid,$username,$name,$hash);
        }
        else
        {
            die('prepare() failed: ' . htmlspecialchars($conn->error)); //dev only remove after
        
        }
    $sql->execute();   
    $sql->close();

            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['usertype']="testee"; 
            $_SESSION['name'] = $username;
            $_SESSION['id'] = $id;

    header('Location: '.$uri.'/exam.portal/studentportal.php');

?>