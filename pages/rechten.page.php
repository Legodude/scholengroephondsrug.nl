<?php
    if(isset($_POST['pagina_Id']))
    {
        if(!isset($_POST['inMenu'])) $inmenu=0;
        else $inmenu = $_POST['inMenu'];
        $sql = 'UPDATE `cms_pagina` SET 
                `menuText` = "'.$_POST['menuText'].'",
                `slug` = "'.$_POST['slug'].'",
                `inMenu` = "'.$inmenu.'"
                WHERE `pagina_Id` = "'.$_POST['pagina_Id'].'"';
        $mysqli->query($sql);
        $sql = 'DELETE FROM `cms_paginapermissie` WHERE `pagina_Id` = "'.$_POST['pagina_Id'].'"';
        $mysqli->query($sql);
        if(isset($_POST['level']))
        {
            $levels = $_POST['level'];
            $sql = 'INSERT INTO `cms_paginapermissie` (`gebruikerlevel`,`pagina_Id`) VALUES ';
            $i =0;
            foreach($levels as $key=>$value)
            {
                $i++;
                if($i!=sizeof($levels)) $sql.= '("'.$key.'","'.$_POST['pagina_Id'].'"),';
                else $sql.= '("'.$key.'","'.$_POST['pagina_Id'].'")';
            }
            $mysqli->query($sql);
        }
    }
?>

<style type="text/css">
    th{
        font-size:11px;
    }
    </style>
    1:IncidentBeheer, 2:Probleembeheer, 3:Wijzigingsbeheer, 4:Configuratiebeheer
<table>
    <th>ID</th><th>menuText</th><th>slug</th><th>inMenu</th><th>1</th>
        <th>2</th><th>3</th>
            <th>4</th><th>5</th>
<?php

$sql = "SELECT * FROM `cms_pagina`";
$result = $mysqli->query($sql);
while($row = $result->fetch_assoc())
{
    echo '<form method="POST" action="#">';
    echo '<tr>';
        echo '<td>'.$row['pagina_Id'].'<input type="hidden" name="pagina_Id" value="'.$row['pagina_Id'].'" /></td>';
        echo '<td><input type="text" value="'.$row['menuText'].'" name="menuText"/></td>';
        echo '<td><input type="text" value="'.$row['slug'].'" name="slug" /></td>';
        echo '<td>';
        echo '<input type="checkbox" name="inMenu" value="1"';
        if($row['inMenu']==1) echo 'checked="checked" ';
        echo ' />';
        echo '</td>';
        echo '<td>'; 
        $sql = 'SELECT * FROM `cms_paginapermissie` WHERE `pagina_Id` = "'.$row['pagina_Id'].'" AND `gebruikerlevel` = 1';
        $perm = $mysqli->query($sql);
        echo '<input type="checkbox" name="level[1]" value="1"';
        if($perm->num_rows==1) echo 'checked="checked" ';
        echo ' />';
        echo '</td>';
        echo '<td>'; 
        $sql = 'SELECT * FROM `cms_paginapermissie` WHERE `pagina_Id` = "'.$row['pagina_Id'].'" AND `gebruikerlevel` = 2';
        $perm = $mysqli->query($sql);
        echo '<input type="checkbox" name="level[2]" value="1"';
        if($perm->num_rows==1) echo 'checked="checked" ';
        echo ' />';
        echo '</td>';
        echo '<td>'; 
        $sql = 'SELECT * FROM `cms_paginapermissie` WHERE `pagina_Id` = "'.$row['pagina_Id'].'" AND `gebruikerlevel` = 3';
        $perm = $mysqli->query($sql);
        echo '<input type="checkbox" name="level[3]" value="1"';
        if($perm->num_rows==1) echo 'checked="checked" ';
        echo ' />';
        echo '</td>';
        echo '<td>'; 
        $sql = 'SELECT * FROM `cms_paginapermissie` WHERE `pagina_Id` = "'.$row['pagina_Id'].'" AND `gebruikerlevel` = 4';
        $perm = $mysqli->query($sql);
        echo '<input type="checkbox" name="level[4]" value="1"';
        if($perm->num_rows==1) echo 'checked="checked" ';
        echo ' />';
        echo '</td>';
        echo '<td>'; 
        $sql = 'SELECT * FROM `cms_paginapermissie` WHERE `pagina_Id` = "'.$row['pagina_Id'].'" AND `gebruikerlevel` = 5';
        $perm = $mysqli->query($sql);
        echo '<input type="checkbox" name="level[5]" value="1"';
        if($perm->num_rows==1) echo 'checked="checked" ';
        echo ' />';
        echo '</td>';
        echo '<td>';
        echo '<input type="submit" value="opslaan" />';
        echo '</td>';
    echo '</tr>';
    echo '</form>';
}
?>
</table>