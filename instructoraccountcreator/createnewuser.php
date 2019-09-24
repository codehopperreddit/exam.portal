<?php
    //Remove from here
    session_start();
    if($_SESSION['usertype']=="tester") //instrutor
    {
        if (!isset($_SESSION['loggedin'])) 
        {
            header('Location: index.php');
            exit();
        }

    }
    //to here to access without have a instructor account already set up
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

    if ($stmt = $conn->prepare('SELECT id FROM instructoraccounts WHERE username = ?')) 
        {
            echo 'usertype testee';
            $stmt->bind_param('s', $_POST['username']);
            $stmt->execute();
        
            if ($stmt->num_rows > 0) 
            {
                header('Location: '.$uri.'/exam.portal/useralreadyexists.html');
            }
        }

    $sql = 'SELECT id FROM instructoraccounts ORDER BY id DESC LIMIT 1';
        
        $retval = mysqli_query($conn,$sql);//gets the last id
        $row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
        
        $newid = $row['id'];
        $newid++;
    $username=$_POST['username'];
    $name=$_POST['name'];
    $password=$_POST['password'];
    $options = [
        'cost' => 12,
                ];
    $hash=password_hash($password,PASSWORD_BCRYPT, $options);
    $password="password";
    $sql=$conn->prepare('INSERT INTO instructoraccounts (id,username,name,password) VALUES (?,?,?,?)');

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

    <a>
    

    

?>