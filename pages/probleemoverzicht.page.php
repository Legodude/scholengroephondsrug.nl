<html>
<?php
$query="SELECT Probleem_ID, Probleem_Omschrijving, Probleem_Workaround, Probleem_Opgelost
        FROM im_problemen";
$result=$mysqli->query($query);
echo "<table><tr><th>ID</th><th>Omschrijving</th><th>Workaround</th><th>Opgelost</th></tr>";
$i=0;
if($result->num_rows!=0)
{
    while($row=$result->fetch_assoc()){
        echo '<tr  class="ci-table-row ';
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
} else echo "geen problemen.";
?>
</html>