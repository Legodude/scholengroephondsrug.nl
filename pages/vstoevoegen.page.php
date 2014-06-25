<table>
<?php

if(isset($_POST['vraag']))
{
    if(!empty($_POST['vraag']))
    {
        $sql = 'INSERT INTO `vs_vragen` (`Vraag`) VALUES ("'.$_POST['vraag'].'")';
        $mysqli->query($sql);
    }
}

$sql = "SELECT * FROM `vs_vragen`";
$result = $mysqli->query($sql);
$i=0;
while($row = $result->fetch_assoc())
{
    $i=$row['Vraag_ID'];
    echo '<tr>';
    echo '<td>'.$row['Vraag_ID'].'</td><td>'.$row['Vraag'].'</td>';
    echo '</tr>';
}
?>
<tr>
    <td><?php echo ($i+1) ?></td><td><form action="#" method="POST"><input type="text" name="vraag" style="width:300px;"><input type="submit" /></form></td>
</tr>
</table>