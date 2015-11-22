<?php

	session_start();
	error_reporting(E_ALL ^ E_NOTICE);

	if( isset($_SESSION["username"]) )
    {
        header("location: start.php"); //Person wird auf die Startseite weitergeleitet, falls eingeloggt.
    }

	$submit = $_POST["submit"];	//Feld für das Anmelden
	$username = $_POST["username"];	//Feld für den Benutzernamen
	$password = $_POST["password"];	//Feld für das Passwort
	$md5password = md5($password);
	$test = 0;

	if(isset($submit)){
		if (empty($username) or empty($password)){
			echo("Please fill in all input fields.");
		}
		else {
			$userfile = fopen ("userdata.txt","r");
			while (!feof($userfile)) {
   				$line = fgets($userfile,500);
   				$userdata = explode("|", $line);

   				if ($userdata[0]==$username and $md5password==trim($userdata[1])) {
      				$_SESSION["username"] = $username;
        			echo "Login was succesful. <a href='start.php'>Member Page</a>";
      			$test = 1;
      			}
   			} 

   				if ($test==0) {
   					echo "Login was unsuccesful. <a href='index.php'>Try again</a>";
   				} 	
			}
		}
?>

<form action="index.php" method="POST">
	Username : <br /><input type="text" name="username"/><br />
	Password : <br /><input type="password" name="password"/><br />
	<input type="submit" name="submit" value="Login">
</form>
