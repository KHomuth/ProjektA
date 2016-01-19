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

<!--
=== Feedback, alpers, dec 1 ===

Dieser Kommentar bezieht sich auch auf die übrigen PHP-Skripte.

Sehr gut. Bitte beachten Sie aber, dass Sie die PHP-Code-Fragmente entweder durch einen Aufruf 
aus dem HTML-Code oder als <?php ?>-Container ins HTML einbinden sollten.

Momentan arbeiten Sie beide noch in getrennten Verzeichnissen und dadurch lassen Sie sich den
Vorteil der Arbeit mit Repositories entgehen.

Für den Fall, dass das auf einem Missverständnis beruht: Zwar soll in jeder Gruppe jedes Team-
Mitglied sich auf einen Bereich (HTML / PHP / MySQL) konzentrieren, aber das bedeutet nicht,
dass jeder nur in den eigenen Dateien arbeiten darf. Ganz im Gegenteil: Beim Arbeiten im Team
arbeiten Sie jeweils an den Stellen, wo der Code, den Sie erzeugen hingehört.

Umgekehrt ist es deshalb so wichtig, beim git push einen klaren und kurzen Kommentar einzutragen.
Denn nur so ist es später nachvollziehbar, wozu eine Änderung durchgeführt wurde. Und damit
diese Kommentare nicht zu sehr ausufern ist es wiederum wichtig, dass Sie bei einzelnen commits nicht zu
umfangreiche Änderungen durchführen.

=== Feedback Ende ===
-->

<!--
=== Feedback Alpers, Jan 19 ===

Wenn ich es richtig sehe, haben Sie meinen Hinweis bezüglich der Zusammenarbeit missverstanden:

Wenn es um einige wenige Codezeilen PHP (besser nur bei ein oder zwei Zeilen) geht,
dann macht es häufig Sinn, diese Zeilen direkt im HTML-Code einzubinden.

Wenn es dagegen um umfangreiche Blöcke geht (wie hier und an anderer Stelle),
dann macht es mehr Sinn, diesen Code in einer eigenen Datei auszulagern und ihn
per include() ins HTML zu integrieren, ohne ihn dorthin zu kopieren.

=== Feedback Alpers, Ende ===
-->