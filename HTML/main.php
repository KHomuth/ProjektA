<?php session_start();?>
<!doctype HTML>
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
    <nav>
      <ul>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
    <main>
      <?php include('chat.php'); ?>
      <div class="chat_wrapper">
        <div class="message_box" id="message_box"></div>
        <div class="panel">
            <input type="text" name="message" id="message" placeholder="Message" maxlength="80" style="width:87%" />
          <button id="send-btn">Send</button>
        </div>
      </div>
    </main>
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
