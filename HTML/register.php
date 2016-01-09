<!DOCTYPE HTML>
<html>
  <head>
      <link rel="stylesheet" href="style.css" type"text/css" />
      <meta content="text/html; charset=utf-8">
      <meta name="viewport" content="width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>HAWTalk</title>
  </head>
  <body>
    <header>
      <img src="header.png" />
    </header>
    
    <div id="navbar">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="" id="loginLink">Login</a></li>
      </ul>
    </div>
    <div id="main">
      <form method="post" action="login.php">
            <label for="mail">
              <input type="text" name="mail" id="mail" placeholder="E-Mail Adresse" />
            </label>
            <label for="username">
              <input type="text" name="username" id="username" placeholder="Username (Bitte Vor- und Nachname in der Form: VornameNachname)" />
            </label>
            <label for="password">
              <input type="password" name="password" id="password" placeholder="Passwort" />
            </label>
            <button type="submit" name="submit" id="button-ok">Anmelden</button>
      </form>
    </div>
    
    <footer>
      <ul>
        <li>&copy; 2016</li>
        <li>Kevin Homuth</li>
        <li>Nenad Slavujevic</li>
        <li>HAW Hamburg</li>
      </ul>
    </footer> 
  </body>
</html>
