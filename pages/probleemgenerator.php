<html>
<?php
if(!isset($_POST['incidents[]'])){

$query="SELECT `Incidenten`.`Incident_ID`,
`IncidentHardware_ID`,
`type`.`TypeOmschrijving`,
`locatie`.`locatieOmschrijving`,
`ontwikkelaar`.`OntwikkelaarNaam`,
`leverancier`.`leverancierNaam`,
`hardware`.`HardwareAankoopJaar`,
`Incidenten`.`IncidentOmschrijving`,
`Incidenten`.`IncidentWorkaround`
FROM `Incidenten`
INNER JOIN `hardware`
ON `Incidenten`.`IncidentHardware_ID` = `hardware`.`Hardware_ID`
INNER JOIN `type`
ON `hardware`.`HardwareType_ID`=`type`.`Type_ID`
INNER JOIN `locatie`
ON `hardware`.`HardwareLocatie_ID`=`locatie`.`Locatie_ID`
INNER JOIN `leverancier`
ON `hardware`.`HardwareLeverancier_ID`=`leverancier`.`Leverancier_ID`
INNER JOIN `ontwikkelaar`
ON `hardware`.`HardwareOntwikkelaar_ID`=`ontwikkelaar`.`Ontwikkelaar_ID`
WHERE `incidenten`.`IncidentOmschrijving`
IN (
SELECT `incidenten`.`IncidentOmschrijving`
FROM `Incidenten`
GROUP BY `incidenten`.`IncidentOmschrijving`
HAVING COUNT(`incidenten`.`IncidentOmschrijving`) >=2
)
ORDER BY `incidenten`.`IncidentOmschrijving`,
`Ontwikkelaar`.`OntwikkelaarNaam`,
`Hardware`.`HardwareAankoopJaar`,
`leverancier`.`leverancierNaam`";

$result=$mysqli->query($query);
?>
<form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
    <table>
        <tr><td>Omschrijving:</td><td><input type='text' name='Omschrijving'></td></tr>
        <tr><td>Workaround:</td><td><input type='text' name='Workaround'</td></tr>
        <tr><td>Opgelost:</td><td><input type='checkbox' name='Opgelost'</td></tr>
    </table>
    <table>
        <tr><th>ID</th><th>HardwareID</th><th>TypeOmschrijving</th><th>LocatieOmschrijving</th><th>Ontwikkelaar</th><th>Leverancier</th><th>Aankoopjaar hardware</th><th>IncidentOmschrijving</th><th>Workaround</th><th>Toevoegen</th></tr>
<?php
while($row= $result->fetch_assoc()){
    print("<tr>
        <td>$row[Incident_ID]</td>
        <td>$row[IncidentHardware]</td>
        <td>$row[TypeOmschrijving]</td>
        <td>$row[locatieOmschrijving]</td>
        <td>$row[OntwikkelaarNaam]</td>
        <td>$row[leverancierNaam]</td>
        <td>$row[HardwareAankoopJaar]</td>
        <td>$row[IncidentOmschrijving]</td>
        <td>$row[IncidentWorkaround]</td>
        <td><input type='checkbox' name='incidents[]' value='$row[Incident_ID]'
       </tr>");
        
}


?>
    </table>
    <input type="submit" value='Probleem aanmaken'>
</form>
    <?php
}
else{
    $incidents = $_POST['incidents[]'];
    $omschrijving = $_POST['Omschrijving'];
    $workaround = $_POST['Workaround'];
    $opgelost = $_POST['Opgelost'];
    if($opgelost == "on"){
        $opgelost=1;
    }
    else{
        $opgelost=0;
    }

    $query ="INSERT INTO im_problemen (Probleem_Omschrijving, Probleem_Workaround, Probleem_Opgelost)
             VALUES ($omschrijving, $workaround, $opgelost)";
    $mysqli->query($query);
    
    $query="SELECT MAX(Probleem_ID)
            FROM im_problemen";
    $result=$mysqli->query($query);
    
    foreach($incidents as $value){
        $query="INSERT INTO im_incidentprobleemlink(Incident_ID, Probleem_ID)
                VALUES $value, $result";
        $mysqli->query($query);
    }
    
}
?>
</html>