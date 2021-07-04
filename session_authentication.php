<?php
//session
session_start();
?>

<?php
$name = $email = $password = $nameError = $emailError = $passwordError = $headingSuccess = $headingAlert = "";
$nameValid = $emailValid = $passwordValid = ""; 
$heading = "Register Here:";

if(isset($_POST["register"])) {
    
    // Full Name validation
    if(empty($_POST['name'])){
        $nameError = "Please input your full name";
    } else {
        $name = test_input($_POST['name']);
        if(!preg_match('/^[a-zA-Z\s]+$/', $name)) {
            $nameError = "Must contain letters and spaces only";
        } else {
            $nameValid = "Full Name is Valid";
            $nameError = "";
        }
    }

    // Email validation
    if(empty($_POST['email'])){
        $emailError = "Please input your email address";
    } else {
        $email = test_input($_POST['email']);
        if(!preg_match( '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', strtolower($email))) {
            $emailError = "email must be a valid email address";
        } else {
            $emailValid = "Email Address is Valid";
            $emailError = "";
        }
    }

    // Password validation
    if(empty($_POST['password'])) {
        $passwordError = "Please set a password";
    } else {
        $password = test_input($_POST['password']);
        if(!preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', $password)) {
            $passwordError = "Must contain at least one, number, lowercase, uppercase letter and 8 length long";
        } else {
            $passwordValid = "Password is Valid";
            $passwordError = "";
        }
    }

    // Registeration successful
    if($nameValid=="Full Name is Valid" && $emailValid=="Email Address is Valid" && $passwordValid=="Password is Valid") {
        $headingSuccess = "Registeration Successful";
        $heading = "";
        $_SESSION["name"] = $name;
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
    } else {
        $headingAlert = "Fill all fields correctly!";
        $heading = "";
    }
}

// print_r($_SESSION);

// Validation to login after registeration
 $logging = "Log-In Here:";
 $logemailError = $logpasswordError = "";
 $loggingSuccess = $logemailValid = $logpasswordValid = $loggingAlert = $validEmail = $validPassword = "";

 if(isset($_POST["login"])) {
    // session_start();
     //Check email to know if registered
     if(empty($_POST["logemail"])) {
         $logemailError = "Please enter your email";
     } else{
        $validEmail = test_input($_POST["logemail"]);
         if($_SESSION["email"]===$validEmail) {
             $logemailValid = "Valid";
             $logemailError = "";
         } else {
             $logemailError = "User not found";
             $loggingAlert = "Register first!";
             $logging = "";
         }
     }

     //Check password to know if correct
     if(empty($_POST["logpassword"])) {
         $logpasswordError = "Please enter your password";
     } else {
         $validPassword = test_input($_POST["logpassword"]);
         if(($_SESSION["password"]===$validPassword) && ($_SESSION["email"]===$validEmail)) {
             $logpasswordValid= "Valid";
         } elseif(($_SESSION["password"]===$validPassword) && ($_SESSION["email"]!==$validEmail)) {
            $logpasswordValid = "";
            $loggingAlert = "Register first!";
         } elseif(($_SESSION["password"]!==$validPassword) && ($_SESSION["email"]===$validEmail)) {
            $logpasswordValid="";
            $logpasswordError="Wrong password";
            $loggingAlert = "Enter the right password!";
            $logging = "";
         }
     }

     if($logemailValid=="Valid" && $logpasswordValid=="Valid") {
         $loggingSuccess = "Log-In was Successful, WELCOME!";
         $logging = "";
     } 
 }

 function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>

        h2 {
            color: green;
        }
        #register {
            float: left;
            margin-left: 100px;
        }
        #login {
            float:  right;
            margin-right: 200px;
            margin-top: 10px;
        }
        input {
            margin-left: 50px;
        }
        #name {
            margin-left: 20px;
        }
        #password {
            margin-left: 27px;
        }
        .submit {
            margin-left: 0px;
        }
        h5 {
            margin-left: 90px;
        }
        .blue {
            color: blue;
        }
        .green {
            color: green;
        }
        .red {
            color: red;
        }
    </style>
</head>
<body>
    <!-- Registeration Field -->
    <form action="session_authentication.php" method="POST" id="register">
    <h2 class="blue"><?php echo $heading; ?></h2>
    <h2 class="red"><?php echo $headingAlert; ?></h2>
    <h2 class="green"><?php echo $headingSuccess; ?></h2>
    <p><label for="name">Full Name:</label><input type="text" name="name" id="name"><br /></p>
    <h5 class="red"><?php echo $nameError; ?></h5>
    <h5 class="green"><?php echo $nameValid; ?></h5>
    <p><label for="email">Email:</label><input type="email" name="email" id="email"><br /></p>
    <h5 class="red"><?php echo $emailError; ?></h5>
    <h5 class="green"><?php echo $emailValid; ?></h5>
    <p><label for="password">Password:</label><input type="password" name="password" id="password"><br /></p>
    <h5 class="red"><?php echo $passwordError; ?></h5>
    <h5 class="green"><?php echo $passwordValid; ?></h5>
    <input type="submit" name="register" value="Register" class="submit">
    </form>

    <!-- Login -->
    <form action="session_authentication.php" method="POST" id="login">
    <h2 class="blue"><?php echo $logging; ?></h2>
    <h2 class="red"><?php echo $loggingAlert; ?></h2>
    <h2 class="green"><?php echo $loggingSuccess; ?></h2>
    <p><label for="email">Email:</label><input type="email" name="logemail" id="email"></p>
    <h5 class="red"><?php echo $logemailError; ?></h5>
    <h5 class="green"><?php echo $logemailValid; ?></h5>
    <p><label for="password">Password:</label><input type="password" name="logpassword" id="password"></p>
    <h5 class="red"><?php echo $logpasswordError; ?></h5>
    <h5 class="green"><?php echo $logpasswordValid; ?></h5>
    <input type="submit" name="login" value="Log In" class="submit">
    </form>
</body>
</html>