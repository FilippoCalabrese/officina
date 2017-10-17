<?php
include 'constants.php';
session_start();
$error = "";
if (array_key_exists("logout", $_GET)) {
    
    unset($_SESSION);
  
    setcookie("id", "", time() - 60 * 60);
  
  	setcookie("level_id", "", time() - 60 * 60);
  
    $_COOKIE["id"] = "";
  
  	$_COOKIE["level_id"] = "";
  
} else if ((array_key_exists("id", $_SESSION) and $_SESSION['id']) or (array_key_exists("id", $_COOKIE) and $_COOKIE['id'])) {
    
    if(($_SESSION['level_id']==999) or ($_COOKIE['level_id'] == 999)){
                    
      header("Location: superAdminPanel.php");
    }else if(($_SESSION['level_id']==100) or ($_COOKIE['level_id'] == 100)) {
      header("Location: adminPanel.php");
    } else {
      header("Location: loggedinpage.php");
    }
}
if (array_key_exists("submit", $_POST)) {
    
    $link = mysqli_connect("shareddb1d.hosting.stackcp.net", "officina", "123stella", "officina-3137abd2");
    
    if (mysqli_connect_error()) {
        
        die("Errore nello stabilire una connessione con il database");
    }
    
    if (! $_POST['username']) {
        
        $error .= "Devi inserire il tuo nome utente<br>";
    }
    
    if (! $_POST['password']) {
        
        $error .= "A password is required<br>";
    }
    if ($error != "") {
        
        $error = "<p>There were error(s) in your form:</p>" . $error;
    } else {
        
        $query = "SELECT * FROM USERS WHERE USERNAME = '" . mysqli_real_escape_string($link, $_POST['username']) . "'";
        
        $result = mysqli_query($link, $query);
        
        $row = mysqli_fetch_array($result);
        
        if (isset($row)) {
            
            // $hashedPassword = md5(md5($row['id']) . $_POST['password']); deve essere ripristinato una volta implementata l'aggiunta utenti!
            $hashedPassword = $_POST['password'];
            
            if ($hashedPassword == $row['PASSWORD']) {
                
                $_SESSION['id'] = $row['ID'];
              
              	$_SESSION['level_id'] = $row['LEVEL_ID'];
                
                if ($_POST['stayLoggedIn'] == '1') {
                    
                    setcookie("id", $row['ID'], time() + 60 * 60 * 24 * 365);
                  
                  	setcookie("level_id", $row['LEVEL_ID'], time() + 60 * 60 * 24 * 365);
                  
                }
                
                $level = $row['LEVEL_ID'];
                
                if($level = $superAdmin){
                    
                    header("Location: superAdminPanel.php");
                    
                }else if($level = $admin) {
                    
                    header("Location: adminPanel.php");
                    
                } else {
                    
                    header("Location: loggedinpage.php");
                    
                }
                
                
                
            } else {
                
                $error = "Login fallito. Riprova";
                
            }
            
        } else {
            
            $error = "Login fallito. Riprova.";
        }
    }
}
?>

<div id="error"><?php echo $error; ?></div>

<form method="post">

	<input type="text" name="username" placeholder="Username"> <input
		type="password" name="password" placeholder="Password"> <input
		type="checkbox" name="stayLoggedIn" value=1> <input type="hidden"
		name="signUp" value="0"> <input type="submit" name="submit"
		value="Log In!">

</form>