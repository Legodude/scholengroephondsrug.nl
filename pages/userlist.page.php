
<?php
 $sql = "SELECT gebruikercode, voornaam, achternaam, gebruikerslevel, email
         FROM cms_gebruikers";
       
$result = $mysqli->query($sql);
?>
<table>
    <tr><th>gebruikercode</th><th>voornaam</th><th>achternaam</th><th>gebruikerslevel</th><th>e-mail</th></tr>
    
<?php
while($row=$result->fetch_assoc()){
    print("<tr>
        <td>$row[gebruikercode]</td>
        <td>$row[voornaam]</td>
        <td>$row[achternaam]</td>
        <td>$row[gebruikerslevel]</td>
        <td>$row[email]</td>
       </tr>");
}
    

        
?>
</table>