<?php

error_reporting(E_ALL ^ E_NOTICE);

$username = $_POST["username"];
$password = $_POST["password"];
$password2 = $_POST["password2"];

?>

<form action="register.php" method="POST">
    Username : <br /><input type="text" name="username"/><br />
    Password : <br /><input type="password" name="password"/><br />
    confirm Password : <br /><input type="password" name="password2"/><br />
    <input type="submit" name="submit" value="Register">
</form>

<?php

if ($password == $password2 && $password != "") {
    $registered_user = array();
    $md5password = md5($password);

    $userfile = fopen ("userdata.txt","r");
    while (!feof($userfile)) {
        $line = fgets($userfile,500);
        $userdata = explode("|", $line);
        array_push ($registered_user,$userdata[0]);
    }
    fclose($userfile);

    if (in_array($username,$registered_user)) {
        echo "Username already in use. <a href='register.php'>Try again</a>";
    }

    else {
        $userfile = fopen ("userdata.txt","a");
        fwrite($userfile, $username);
        fwrite($userfile, "|");
        fwrite($userfile, $md5password);
        fwrite($userfile, "\r\n");
        fclose($userfile);
        echo "$username, your registration was succesful. <a href='index.php'>Login</a>";
      }
}

if ($password != $password2) {
    echo "The passwords you entered differ. <a href='register.php'>Try again</a>";
}
?>
