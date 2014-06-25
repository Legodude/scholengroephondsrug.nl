<html>
<?php
$query="SELECT Probleem_ID, Probleem_Omschrijving, Probleem_Workaround, Probleem_Opgelost, Fout
        FROM im_problemen";
$result=$mysqli->query($query);
echo "<table><tr><th>ID</th><th>Omschrijving</th><th>Workaround</th><th>Opgelost</th><th>Fout</th></tr>";
while($row = $result->fetch_assoc())
{
print("<tr><td>$row['Probleem_ID']</td><td>$row['Probleem_Omschrijving']</td><td>$row['Probleem_Workaround']</td><td>$row['Probleem_Opgelost']</td><td>$row['Fout']</td></tr>");
}
echo "</table>";
?>
</html>