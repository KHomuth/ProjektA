<?php

error_reporting(E_ALL ^ E_NOTICE);

$username = $_POST["username"];
$password = $_POST["password"];
$password2 = $_POST["password2"];

?>

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
        echo "Username already in use.";
    }

    else {
        $userfile = fopen ("userdata.txt","a");
        fwrite($userfile, $username);
        fwrite($userfile, "|");
        fwrite($userfile, $md5password);
        fwrite($userfile, "\r\n");
        fclose($userfile);
        echo "$username, your registration was succesful.";
      }
}

if ($password != $password2) {
    echo "The passwords you entered differ.";
}
?>
