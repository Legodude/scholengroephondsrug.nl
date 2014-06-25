<html>
<?php
$query="SELECT Probleem_ID, Probleem_Omschrijving, Probleem_Workaround, Probleem_Opgelost, Fout
        FROM im_problemen";
$result=$mysqli->query($query);
echo "<table><tr><th>ID</th><th>Omschrijving</th><th>Workaround</th><th>Opgelost</th><th>Fout</th></tr>";
$i=0;
while($row=$result->fetch_assoc()){
    echo '<tr onclick="window.document.location.href=\'?action=probleemoverzicht&probleemID='.$row["Probleem_ID"].'\'" class="ci-table-row ';
        if($i%2) echo "even";
        else echo "uneven";
        echo '">';
        foreach($row as $field)
        {
            echo '<td class="ci-table-cell">'.$field."</td>";
        }
        echo "</tr>";
        $i++;
}
echo "</table>";
?>
</html>