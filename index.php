<?php
session_start();

$error = "";

if (array_key_exists("logout", $_GET)) {
    
    unset($_SESSION);
    setcookie("id", "", time() - 60 * 60);
    $_COOKIE["id"] = "";
} else if ((array_key_exists("id", $_SESSION) and $_SESSION['id']) or (array_key_exists("id", $_COOKIE) and $_COOKIE['id'])) {
    
    header("Location: loggedinpage.php");
}

if (array_key_exists("submit", $_POST)) {
    
    $link = mysqli_connect("localhost", "cl29-secretdi", "D-fnT^Hbz", "cl29-secretdi");
    
    if (mysqli_connect_error()) {
        
        die("Database Connection Error");
    }
    
    if (! $_POST['email']) {
        
        $error .= "An email address is required<br>";
    }
    
    if (! $_POST['password']) {
        
        $error .= "A password is required<br>";
    }
    if ($error != "") {
        
        $error = "<p>There were error(s) in your form:</p>" . $error;
    } else {
        
        $query = "SELECT * FROM `users` WHERE email = '" . mysqli_real_escape_string($link, $_POST['email']) . "'";
        
        $result = mysqli_query($link, $query);
        
        $row = mysqli_fetch_array($result);
        
        if (isset($row)) {
            
            $hashedPassword = md5(md5($row['id']) . $_POST['password']);
            
            if ($hashedPassword == $row['password']) {
                
                $_SESSION['id'] = $row['id'];
                
                if ($_POST['stayLoggedIn'] == '1') {
                    
                    setcookie("id", $row['id'], time() + 60 * 60 * 24 * 365);
                }
                
                header("Location: loggedinpage.php");
            } else {
                
                $error = "That email/password combination could not be found.";
            }
        } else {
            
            $error = "That email/password combination could not be found.";
        }
    }
}

?>

<div id="error"><?php echo $error; ?></div>

<form method="post">

	<input type="email" name="email" placeholder="Your Email"> <input
		type="password" name="password" placeholder="Password"> <input
		type="checkbox" name="stayLoggedIn" value=1> <input type="hidden"
		name="signUp" value="0"> <input type="submit" name="submit"
		value="Log In!">

</form>