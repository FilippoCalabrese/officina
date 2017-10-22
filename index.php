<?php
include 'constants.php';
include ('queryFunctions.php');
include ('utilityFunctions.php');
include ('connection.php');

session_start();
$error = "";
if (array_key_exists("logout", $_GET)) {
    session_unset();
    setcookie("id", "", time() - 60 * 60);
  	setcookie("level_id", "", time() - 60 * 60);
    $_COOKIE["id"] = "";
  	$_COOKIE["level_id"] = "";
} else if ((array_key_exists("id", $_SESSION) and $_SESSION['id']) or (array_key_exists("id", $_COOKIE) and $_COOKIE['id'])) {
    redirectToCorrectPage();
}
if (array_key_exists("submit", $_POST)) {
    if (! $_POST['username']) {
        $error .= "Devi inserire il tuo nome utente<br>";
    }
    if (! $_POST['password']) {
        $error .= "A password is required<br>";
    }
    if ($error != "") {
        $error = "<p>There were error(s) in your form:</p>" . $error;
    } else {
        $error = performLogin($link);
    }
}
?>

<html>
<head>
</head>
<body>

  <div id="error"><?php echo $error; ?></div>

  <!--- FORM DI LOGIN --->
  <form method="post">
  	<input type="text" name="username" placeholder="Username"> <input
  		type="password" name="password" placeholder="Password"> <input
  		type="checkbox" name="stayLoggedIn" value=1> <input type="hidden"
  		name="signUp" value="0"> <input type="submit" name="submit"
  		value="Log In!">
  </form>

</body>
</html>
