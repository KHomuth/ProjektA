<?php

	session_start();
	error_reporting(E_ALL ^ E_NOTICE);

	if( isset($_SESSION["username"]) )
    {
        header("location: start.php"); //Person wird auf die Startseite weitergeleitet, falls eingeloggt.
    }

	$submit = $_POST["submit"];		//Feld für das Anmelden
	$username = $_POST["username"];	//Feld für den Benutzernamen
	$password = $_POST["password"];	//Feld für das Passwort

	$usernames = array(
			"nenad",
			"kevin"
		);

	$passwords = array(
			$usernames[0] => "php",
			$usernames[1] => "html"
		);

	$correctpw = $passwords[$username];

	if(isset($submit)){
		if ( empty($username) or empty($password) ){
			echo("Please fill in all input fields.");
		}
		else {
			if (in_array($username, $usernames)){
				if($password == $correctpw){
					$_SESSION["username"] = $username;
					echo "Welcome ".$username." <a href='start.php'> Member Page </a>";
				}
				else{
					die("Password is incorrect.");
				}
			}
			else {
				die("Username doesn't exist");
			}
			exit();
		}
	}
?>

<form action="index.php" method="POST">
	Username : <br /><input type="text" name="username"/><br />
	Password : <br /><input type="password" name="password"/><br />
	<input type="submit" name="submit" value="Login">
</form>
