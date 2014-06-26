<style>
    td, th{
        font-size:11px;
    }
</style>
<?php
 $sql = "SELECT gebruikercode, voornaam, achternaam, gebruikerslevel, email
         FROM cms_gebruikers";
       
$result = $mysqli->query($sql);
?>
<table>
    <tr><th>gebruikercode</th><th>voornaam</th><th>achternaam</th><th>gebruikerslevel</th><th>e-mail</th></tr>
    
<?php
$i=0;
while($row=$result->fetch_assoc()){
    echo '<tr onclick="window.document.location.href=\'?action=wijziguser&gebruikercode='.$row["gebruikercode"].'\'" class="ci-table-row ';
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
    

        
?>
</table>