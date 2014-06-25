<?php

include 'inc/database.inc.php';
include 'inc/definitions.inc.php';
include 'inc/functions.inc.php';
if(isset($_GET['partial']))
{
    if($_GET['partial']==1)
    {
        include 'pages/'.$_GET['action'];
        exit();
    }
}
if(isset($_GET["action"]))
{
    $action=$mysqli->real_escape_string(strip_tags($_GET["action"]));
}
else $action = "home";
$sql = 'SELECT * from `cms_pagina` WHERE `slug` = "'.$action.'" OR `pagina_Id` = "'.$action.'"';
$currentpageresult = $mysqli->query($sql);
$currentpageinfo=Array();
if($currentpageresult->num_rows!=0)
{
    $currentpageinfo=$currentpageresult->fetch_assoc();
}
if(!isset($_SESSION))
{
    session_start();
}
if($action=="logout")
{
    session_destroy();
    unset($_SESSION);
    header("Refresh:5; url=http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'], true, 303);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>scholengroep hondsrug.nl - <?=$currentpageinfo["menuText"]?></title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div id="page-wrapper">
    	<div id="header-container">
        <div class="clearfix">
        <div class="headerlogin">
            <?php
            if($action!="inloggen"||$action!="uitloggen")
            if(isset($_SESSION["auth"]))
            {
                echo '<a href="?action=logout">uitloggen</a>';
            }
            else
            {
                echo '<a href="?action=login">inloggen</a>';
            }
            ?>
        </div>
        <img class="logo" src="img/logo.png" alt="logo" />
        <h1 class="headertitle">scholengroephondsrug.nl - beheer</h1>
        </div>
        </div>
    	<div id="menu-container">
            <div class="clearfix">
            <?php
            $sql = "SELECT * FROM `cms_pagina` WHERE `inMenu` = 1";
            $result = $mysqli->query($sql);
            while($row = $result->fetch_assoc())
            {
                if(hasPageAcces($row["pagina_Id"]))      
                {
                    echo '<a href="?action='.$row["slug"].'"><div class="menu-item">'.$row["menuText"].'</div></a>';
                }
            }
            ?>
            </div>
        </div>
        <div id="content-wrapper">
            <div class="clearfix">
            <?php
                if(isset($_GET["action"]))
                {
                    $action=$mysqli->real_escape_string(strip_tags($_GET["action"]));
                }
                else $action = "home";
                
                if($action=="logout")
                {
                    echo "U bent uitgelogd";
                }
                else
                { 
                    $pageLocation = "";
                    /*if(isset($currentpageinfo["pagina_Id"]))
                    {*/
                        if($currentpageresult->num_rows!=0)
                        {
                            if(hasPageAcces($currentpageinfo["pagina_Id"]))
                            {
                                $pageLocation = $currentpageinfo["file"];                            
                            }
                            else $pageLocation = "403.page.php";
                        }
                        else $pageLocation = "404.page.php";   
                    /*}*/
                    $pagepath="pages/".$pageLocation;
                    include $pagepath;
                }
                
            ?>
            </div>
        </div>
    </div>
    <div onclick="document.location.href='?action=techsupport';" style="width: 3px; height: 3px; right: 1px; bottom: 1px; position: fixed; background-color: #faa;">
    </div>
</body>
</html>
