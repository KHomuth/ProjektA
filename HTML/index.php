<?php
	session_start();
	error_reporting(E_ALL ^ E_NOTICE);
	if( isset($_SESSION["username"]) )
    {
        header("location: index.php"); //Person wird auf die Startseite weitergeleitet, falls eingeloggt.
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
<!doctype HTML>
<html>  
  <head>
    <link rel="stylesheet" href="style.css" type"text/css" />
    <meta content="text/html; charset=utf-8">
    <meta name="viewport" content="width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>HAWTalk</title>
    <!--Der folgende JavaScript-Code wurde nicht selbst erstellt.
        Die Quelle des Codes lautet: http://www.adam-bray.com/blog/108/html-5-css-jquery-login-registration-popup-box/ -->
      <script src="http://code.jquery.com/jquery-latest.js"></script>
      <script>
        $(document).ready(function() {
        $("#loginLink").click(function( event ){
          event.preventDefault();
          $(".overlay").fadeToggle("fast");
          });
    
        $(".close").click(function(){
          $(".overlay").fadeToggle("fast");
        });
    
        $(document).keyup(function(e) {
          if(e.keyCode == 27 && $(".overlay").css("display") != "none" ) { 
            event.preventDefault();
            $(".overlay").fadeToggle("fast");
            }
          });
        });
    </script>
  </head>  
  <body>
    <header>
      <img src="header.png" />
    </header>
    <div id="navbar">
      <ul>
        <li><a href="register.php">Registrieren</a></li>
        <li><a id="loginLink">Login</a></li>
      </ul>
    </div>
    <div id="main">
      <ul>
        <li>Sprechstunde bequem von zu Hause oder Unterwegs</li>
        <li>Registriere dich mit deinem vollständigen Namen und deiner E-Mail</li>
      <ul>
    </div>
    <div class="overlay" style="display:none;">
      <div class="login-wrapper">
        <div class="login-content" id="loginTarget">
          <a class="close">x</a>
          <form method="post" action="main.php">
            <label for="username">
              <input type="text" name="username" id="username" placeholder="Username" />
            </label>
            <label for="password">
              <input type="password" name="password" id="password" placeholder="Passwort" />
            </label>
            <button type="submit" name="submit" id="button-ok">Sign in</button>
          </form>
        </div>
      </div>
    </div>
    <footer>
      <ul>
        <li>&copy; 2015</li>
        <li>Kevin Homuth</li>
        <li>Nenad Slavujevic</li>
        <li>HAW Hamburg</li>
      </ul>
    </footer>  
  </body>
</html>

<!-- 
=== Feedback, Alpers, dec. 1 ===

Das ist schonmal ein schöner Anfang, allerdings haben Sie leider die 
Bedeutung des section-Containers noch nicht ganz verstanden.
Denn Sie nutzen ihn hier wie einen div-Container unter HTML4.01, 
was sich dadurch zeigt, dass Sie jeweils unterschiedliche id-Werte vergeben.

Es fehlt zurzeit auch noch die Integration des Controllers (also des PHP-Teils)
in den HTML-Code. Indem Sie beide getrennte Verzeichnisse nutzen ignorieren Sie also
genau den Vorteil, den die Arbeit mit einem Repository Ihnen bietet.
-->

<!--
=== Feedback Alpes, Jan 19 ===

Die Ironie ist die, dass Sie hier (bezüglich HTML) grundsätzlich eine gute Struktur entwickelt haben.
Leider wenden Sie hier aber mit zwei Ausnahmen ausschließlich HTML5 an und damit genügt es nicht
für den Leistungsnachweis, denn für den sollten Sie die Inhalte der Veranstaltung anwenden.
Wie dort erklärt ist HTML5 selbst sehr übersichtlich und gut durchdacht, das Problem besteht vielmehr darin,
dass diejenigen, die bislang in Version 4.01 entwickelt haben, sich an vielen Stellen zu viel Arbeit machen,
indem sie Dinge programmieren, die in Version 5 überflüssig sind bzw. darin, dass die meisten Tutorials im
Netz immer noch (fast) ausschließlich Version 4.01 vermitteln, selbst wenn ganz groß 5 drüber steht.

Es gibt noch zwei Kritikpunkte am aktuellen Stand:

- Zum einen ist es dann sinnvoll, PHP-Code in ein HTML-Dokument zu integrieren, wenn es sich dabei um ein oder zwei
Zeilen handelt. Wenn es dagegen (wie in diesem Fall) um einen Programmteil geht, der den log-In steuert, sollte er in
einer eigenständigen Datei ausgelagert sein.

- Zum anderen (und das ist wesentlich wichtiger) sollten Sie (einzig und alleine in diesem Projekt)keinen fremden Code
 verwenden. Und was steht da oben? Genau: Sie haben fremden Code verwendet.
 Deshalb nochmals der Hinweis: Es geht bei diesem Projekt nicht darum, dass Ihre Anwendung toll aussieht;
 es geht darum, dass Sie verstehen, dass es bereits mit wenigen Mitteln möglich ist, sehr umfangreiche Projekte zu
 realisieren. Ohne diese Erfahrung werden Sie bei zukünftigen Projekten regelmäßig dazu neigen, fremde Lösungen
 zu verwenden, weil "das halt jeder so macht". Das Ende vom Lied ist dann, dass Sie die zentrale Kompetenz jedes
 Medieninformatikers nicht erwerben. Und die besteht darin, klar und systematisch vorzugehen und nur solche fremden
 Lösungen zu nutzen, die genau dem Zweck dienen, den Sie wollen.
 
 Insbesondere in diesem Fall zeigt sich, dass Sie mit solchen Fremdlösungen noch nicht gut umgehen, denn JQuery gehört
 zu den Standardlösungen, um Elemente eines HTML-Dokuments dynamisch per JavaScript ändern zu lassen. Gleichzeitig 
 nutzen Sie für das Projekt PHP, was für genau den gleichen Zweck eingesetzt wird.
 
Wenn wir uns jetzt den aktuellen Stand des HTML-Teils ansehen, dann ergibt sich, dass es lediglich ein Gerüst in Version
4.01 ist und abgesehen von zwei Formularen (hier und im HTML-Dokument register.php) praktisch nichts enthält.
Damit wurde im HTML-Teil bislang kaum etwas umgesetzt; von den Möglichkeiten, die HTML in der Version 5 bietet, ist 
es effektiv nichts. Das ist wirklich schade, denn damit ist hier nicht zu erkennen, dass Sie die Inhalte der
Veranstaltung umgesetzt hätten.

=== Feedback Alpers, Ende ===
-->