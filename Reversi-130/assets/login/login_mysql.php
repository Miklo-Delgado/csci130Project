<?php
// Include config file
require_once 'config_mysql.php';
 
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $email_err = 'Please enter email.';
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT email, pass FROM person WHERE email = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            // Set parameters
            $param_email = $email;
			// echo $param_username;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);  
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
					mysqli_stmt_bind_result($stmt, $email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
						echo $password ."<br>";
						echo $hashed_password ."<br>";
                        if(password_verify($password, $hashed_password)){
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            session_start();
                            $_SESSION['email'] = $email;      
                            header("location: ../../index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $email_err = 'No account found with that email.';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/homepage.css">
    <title>Login</title>
</head>
<body>
<div class="header_nav">
        <div class="header_link">
            <a href="../../reversiGame.php">Reversi!</a><!--this will take you back to the home screen-->
        </div>
        <div class="header_link">
            <a href="../../about_page.php">About</a><!--this will bring up pages about the game and or authors james and miklo-->
        </div>
        <div class="header_link">
            <a href="../../howto_page.php">How to Play</a><!--add the wikipedia website for the how to play-->
       <!--maybe actually make an about page and put the wikipedia link in there and a helpful youtube video-->
        </div>
        <div class="header_link">
            <a href="../../index.php">Home</a><!--this will bring up pages about the game and or authors james and miklo-->
        </div>
        <div class="header_link">
            <a href="register_mysql.php">SignUp</a><!--this will bring up pages about the game and or authors james and miklo-->
        </div>

</div>
    <div class="user_form">
        <div class="section_container">
        <div class="section_title"><h2 class="_text">Login</h2></div>
        
        <p class="p_header">Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="f_form">
            <div  <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>email:<sup>*</sup></label>
                <input type="text" name="email" value="<?php echo $email; ?>" class="input_f">
                <span><?php echo $email_err; ?></span>
            </div>    
            <div <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password:<sup>*</sup></label>
                <input type="password" name="password" class="input_f">
                <span><?php echo $password_err; ?></span>
            </div>
            <div>
                <input type="submit" value="Submit" class="form_submit">
            </div>
            <p >Don't have an account? <a class="form_link" href="register_mysql.php">Sign up now</a>.</p>
        </form>
    </div>  
    </div>
      
</body>
</html>