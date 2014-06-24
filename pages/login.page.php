<?php
if(!isset($_POST["user"])||!isset($_POST["pass"]))
{
    if(!isset($_SESSION["auth"]))
    {
        showLoginForm();
    }
    else
    {
        echo "U bent al ingelogd";
    }
}
else
{
    $user = strtoupper($mysqli->real_escape_string(strip_tags($_POST["user"])));
    $pass = $mysqli->real_escape_string(strip_tags($_POST["pass"]));
    $sql = 'SELECT * FROM `cms_gebruikers` WHERE `gebruikercode` = "'.$user.'" AND `wachtwoord` = "'.$pass.'"'; 
    $result = $mysqli->query($sql);
    if($result->num_rows==1)
    {
        foreach($result->fetch_assoc() as $key=>$field)
        {
            if($key!="wachtwoord")
            {
                $_SESSION[$key]=$field;
            }
        }
        
        $sql = 'UPDATE `cms_gebruikers` SET `laatstingelogd`=NOW() WHERE `gebruikercode` = "'.$user.'"';
        $mysqli->query($sql);
        $_SESSION["auth"] = true;
        header('Location: /');
    }
    else
    {
        showLoginForm();
        echo "Toegang geweigerd!<br />Gebruikerscode of wachtwoord klopt niet.<br />";
    }
}
?>

