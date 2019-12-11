<?php
// Include config file
require_once 'config_mysql.php';
 

// Define variables and initialize with empty values
$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    if(empty(trim($_POST['email']))){
        $email_err = "Please enter a email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM person WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);       
            // Set parameters
            echo "Email is: " . $email;
            $param_email = trim($_POST['email']);          
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);   
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST['email']);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST['password'])) < 4){
        $password_err = "Password must have atleast 4 characters.";
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Please confirm password.';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Password did not match.';
        }
    }
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO person (email, pass) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);
            
            // Set parameters
            $param_email = $email;
           $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
           //$param_password = $password;
            
           // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login_mysql.php");
                //echo $email . $password;
            } else{
                echo "Something went wrong. Please try again later.";
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
    <title>Sign Up</title>
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
            <a href="login_mysql.php">LogIn</a><!--this will bring up pages about the game and or authors james and miklo-->
        </div>
        <div class="header_link">
            <a href="../../index.php">Home</a><!--this will bring up pages about the game and or authors james and miklo-->
        </div>

</div>

    <div class="user_form">
        <div class="section_container">
            <div class="section_title"><h2>Sign Up</h2></div>
            
        <p class="p_header">Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="f_form">
            <div <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>email:<sup>*</sup></label>
                <input type="text" name="email" value="<?php echo $email; ?>" class="input_f">
                <span><?php echo $email_err; ?></span>
            </div>    
            <div <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password:<sup>*</sup></label>
                <input type="password" name="password" value="<?php echo $password; ?>" class="input_f">
                <span><?php echo $password_err; ?></span>
            </div>
            <div <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password:<sup>*</sup></label>
                <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>" class="input_f">
                <span><?php echo $confirm_password_err; ?></span>
            </div>
            <div>
                <input type="submit" value="Submit" class="form_submit">
                <input type="reset"  value="Reset" class="form_submit">
            </div>
            <p class="p_bottom">Already have an account? <a class="form_link" href="login_mysql.php">Login here</a>.</p>
        </form>
        </div>
        
    </div>    
</body>
</html>