<?php
session_start(); // Starting Session
$error='';// Variable To Store Error Message
$error_user_pass="";
$error_passwordconfirmation="";
if (isset($_POST['signin'])) {
           
           // Define $username and $password
            $semail=$_POST['semail'];
            $spassword=$_POST['spassword'];
            // Establishing Connection with Server by passing server_name, user_id and password as a parameter
            $connection = mysqli_connect("localhost", "root", "","nutmeg");
            // To protect MySQL injection for Security purpose
            $semail = stripslashes($semail);
            $spassword = stripslashes($spassword);
            $semail = mysqli_real_escape_string($connection,$semail);
            $spassword = mysqli_real_escape_string($connection,$spassword);
            $spassword=md5($spassword);
            // SQL query to fetch information of registerd users and finds user match.
            $query ="select fname,password from user where emailID='$semail'";
            $result=mysqli_query($connection,$query);
            $rowcount=mysqli_num_rows($result);
            $row=mysqli_fetch_array($result);

                            if ($rowcount==1 && $row['password']==$spassword) {
                            $_SESSION['login_user']=$semail; // Initializing Session
                            $_SESSION['fname']=$row['fname'];
                            header("location: welcome.php"); // Redirecting To Other Page
                            } else {
                            $error_user_pass = "Invalid EmailID or Password!";
                            }
    
mysqli_close($connection); // Closing Connection
} elseif(isset($_POST['signup'])){
    
    
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];
    $dob=$_POST['dob'];
    $gender=$_POST['gender'];
    $fname = stripslashes($fname);
    $lname = stripslashes($lname);
    $email = stripslashes($email);
    $password = stripslashes($password);
    $cpassword = stripslashes($cpassword);
    $gender = stripslashes($gender);
    $time = strtotime($dob);
    $dob=date( 'y-m-d',$time);
   
    

    
    
    
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = mysqli_connect("localhost", "root", "","nutmeg");
// To protect MySQL injection for Security purpose
    
$existingAccountCheck="select emailID from user where emailID='$email'";
$result=mysqli_query($connection,$existingAccountCheck);   
    
    $rowcount=mysqli_num_rows($result);
    
    if($rowcount==1){
    
    $error="Account already exists with this email ID!";
} elseif($password!=$cpassword){
        
      $error_passwordconfirmation="please ensure same password across Password and Confirm Password ! "  ;
        
        
    } else{
    
$email = mysqli_real_escape_string($connection,$email);
$password = mysqli_real_escape_string($connection,$password);
$Pass=md5($password);

  $query ="insert into user (fname,lname,emailID,password,dob,gender) values('$fname','$lname','$email','$Pass','$dob','$gender')";
    
    $result=mysqli_query($connection,$query);
    
    if($result){
        
        header("location: welcome.php");
    }
    
    
}}
?>