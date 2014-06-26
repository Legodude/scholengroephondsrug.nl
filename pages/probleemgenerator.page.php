<html>
<?php
if(!isset($_POST['incidents'])){

$sql="SELECT `im_Incidenten`.`Incident_ID`,
`im_Incidenten`.`IncidentHardware_ID`,
`cmdb_type`.`TypeOmschrijving`,
`cmdb_locatie`.`locatieOmschrijving`,
`cmdb_ontwikkelaar`.`OntwikkelaarNaam`,
`cmdb_leverancier`.`leverancierNaam`,
`cmdb_hardware`.`HardwareAankoopJaar`,
`im_Incidenten`.`IncidentOmschrijving`,
`im_Incidenten`.`IncidentWorkaround`
FROM `im_Incidenten`
INNER JOIN `cmdb_hardware`
ON `im_Incidenten`.`IncidentHardware_ID` = `cmdb_hardware`.`Hardware_ID`
INNER JOIN `cmdb_type`
ON `cmdb_hardware`.`HardwareType_ID`=`cmdb_type`.`Type_ID`
INNER JOIN `cmdb_locatie`
ON `cmdb_hardware`.`HardwareLocatie_ID`=`cmdb_locatie`.`Locatie_ID`
INNER JOIN `cmdb_leverancier`
ON `cmdb_hardware`.`HardwareLeverancier_ID`=`cmdb_leverancier`.`Leverancier_ID`
INNER JOIN `cmdb_ontwikkelaar`
ON `cmdb_hardware`.`HardwareOntwikkelaar_ID`=`cmdb_ontwikkelaar`.`Ontwikkelaar_ID`
WHERE `im_Incidenten`.`IncidentOmschrijving`
IN (
    SELECT `im_Incidenten`.`IncidentOmschrijving`
    FROM `im_Incidenten`
    GROUP BY `im_Incidenten`.`IncidentOmschrijving`
    HAVING COUNT(`im_Incidenten`.`IncidentOmschrijving`) >=2
)
AND `im_Incidenten`.`Incident_ID` NOT IN
(
   SELECT DISTINCT  `Incident_ID` 
    FROM  `im_incidentprobleemlink` 
)
ORDER BY `im_Incidenten`.`IncidentOmschrijving`,
`cmdb_Ontwikkelaar`.`OntwikkelaarNaam`,
`cmdb_Hardware`.`HardwareAankoopJaar`,
`cmdb_leverancier`.`leverancierNaam`";

$result=$mysqli->query($sql);
if($result->num_rows==0) echo "Geen problemen kunnen definiëren.", exit();
?>
<form method="post" action="#">
    <table class="ci-table">
        <tr><td>Omschrijving:</td><td><input type="text" style="width: 300px;" name="Omschrijving"></td></tr>
        <tr ><td>Workaround:</td><td><input type="text" style="width: 300px;" name="Workaround" /></td></tr>
        <tr ><td>Opgelost:</td><td><input type="checkbox" name="Opgelost" /></td></tr>
    </table>
     <input type="submit" value="Probleem aanmaken">
    <table class="ci-table">
        <!--<tr><th>ID</th><th>HardwareID</th><th>TypeOmschrijving</th><th>LocatieOmschrijving</th><th>Ontwikkelaar</th><th>Leverancier</th><th>Aankoopjaar hardware</th><th>IncidentOmschrijving</th><th>Workaround</th><th>Toevoegen</th></tr>-->
<?php
$i=0;
while($row = $result->fetch_assoc()){
    echo '<tr class="ci-table-row ';
    if($i%2) echo "even";
        else echo "uneven";
    echo '">
        <td>'.$row['Incident_ID'].'</td>
        <td>'.$row['IncidentHardware_ID'].'</td>
        <td>'.$row['TypeOmschrijving'].'</td>
        <td>'.$row['locatieOmschrijving'].'</td>
        <td>'.$row['OntwikkelaarNaam'].'</td>
        <td>'.$row['leverancierNaam'].'</td>
        <td>'.$row['HardwareAankoopJaar'].'</td>
        <td>'.$row['IncidentOmschrijving'].'</td>
        <td>'.$row['IncidentWorkaround'].'</td>
        <td><input type="checkbox" name="incidents[]" value="'.$row['Incident_ID'].'"
       </tr>';
    $i++;
}


?>
    </table>
</form>
    <?php
}
else{
    $checkbox = 0;
    if(isset($_POST['Opgelost']))
    {
        $checkbox = ($_POST['Opgelost']=="on")?(1):(0);
    }
    
    $sql = "INSERT INTO `im_problemen` (`Probleem_Omschrijving`, `Probleem_Workaround`, `Probleem_Opgelost`) "
            . 'VALUES ("'.$_POST['Omschrijving'].'", "'.$_POST['Workaround'].'","'.$checkbox.'")';
    $mysqli->query($sql);
    
    $probleemid = $mysqli->insert_id;
    $sql = "INSERT INTO `im_incidentprobleemlink` (`Incident_ID`, `Probleem_ID`) VALUES ";
    foreach($_POST['incidents'] as $key=>$incidentID)
    {
        $sql.='("'.$incidentID.'", "'.$probleemid.'")';
        if($key!=(sizeof($_POST['incidents'])-1)) $sql.=', ';
    }
    $mysqli->query($sql);
    echo "Probleem aangemaakt!";
    /*$incidents = $_POST['incidents[]'];
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
    */
}
?>
</html>