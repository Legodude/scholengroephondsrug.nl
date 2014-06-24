<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$hardwareid = $mysqli->real_escape_string(strip_tags($_GET["hardwareID"]));

if(isset($_POST['HardwareType_ID'])&&isset($_POST['HardwareLocatie_ID'])&&isset($_POST['HardwareOS_ID'])&&isset($_POST['HardwareOntwikkelaar_ID'])&&isset($_POST['HardwareLeverancier_ID'])&&isset($_POST['HardwareAankoopJaar']))
{
    $sql = 'UPDATE `cmdb_hardware` SET ';
    foreach($_POST as $key=>$value)
    {
        if(empty($value)) $sql.= '`'.$key.'`=NULL';
        else $sql.= '`'.$key.'`="'.$value.'"';
        if($key!="HardwareAankoopJaar") $sql.=', ';
        else $sql.=' ';
    }
    $sql .= 'WHERE `Hardware_ID` = "'.$hardwareid.'"';
    $mysqli->query($sql);
}

$sql = 'SELECT 
	*
	FROM
	`cmdb_hardware` 
	LEFT JOIN `cmdb_type`
	ON `cmdb_hardware`.`HardwareType_ID`=`cmdb_type`.`Type_ID`
	LEFT JOIN `cmdb_locatie`
	ON `cmdb_hardware`.`HardwareLocatie_ID`=`cmdb_locatie`.`locatie_ID`
	LEFT JOIN `cmdb_software`
	ON `cmdb_hardware`.`HardwareOS_ID`=`cmdb_software`.`Software_ID`
	LEFT JOIN `cmdb_ontwikkelaar`
	ON `cmdb_hardware`.`HardwareOntwikkelaar_ID`=`cmdb_ontwikkelaar`.`Ontwikkelaar_ID`
	LEFT JOIN `cmdb_leverancier`
	ON `cmdb_hardware`.`HardwareLeverancier_ID`=`cmdb_leverancier`.`leverancier_ID`
        WHERE `Hardware_ID` = "'.$hardwareid.'"';
$result = $mysqli->query($sql);
$hardwareinfo = array();
if($result->num_rows==1)
{
    $hardwareinfo = $result->fetch_assoc(); 
?>  
<form action="#" method="POST">
<table class="hardwareitemtable">
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            HardwareID:
        </td>
        <td class="hardwareitemtable-cell">
            <input name="Hardware_ID" type="text" value="<?php echo $hardwareinfo['Hardware_ID'] ?>" disabled="disabled" />
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Type:
        </td>
        <td class="hardwareitemtable-cell">
            <?php
                generateDropdownFromTable("","cmdb_type", "Type_ID", "TypeOmschrijving", "HardwareType_ID","Geen",$hardwareinfo['HardwareType_ID'],"cmdb_hardware","hardwareType_ID");
            ?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Locatie:
        </td>
        <td class="hardwareitemtable-cell">
            <?php
                generateDropdownFromTable("","cmdb_locatie", "Locatie_ID", "LocatieOmschrijving", "HardwareLocatie_ID","Geen",$hardwareinfo['HardwareLocatie_ID']);
            ?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Operating System:
        </td>
        <td class="hardwareitemtable-cell">
            <?php
                generateDropdownFromTable("","cmdb_software", "Software_ID", "SoftwareNaam", "HardwareOS_ID","Geen",$hardwareinfo['HardwareOS_ID'],"cmdb_hardware","hardwareOS_ID");
            ?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Ontwikkelaar:
        </td>
        <td class="hardwareitemtable-cell">
            <?php
                generateDropdownFromTable("","cmdb_ontwikkelaar", "Ontwikkelaar_ID", "OntwikkelaarNaam", "HardwareOntwikkelaar_ID","Geen",$hardwareinfo['HardwareOntwikkelaar_ID'],"cmdb_hardware","hardwareOntwikkelaar_ID");
            ?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Leverancier:
        </td>
        <td class="hardwareitemtable-cell">
            <?php
                generateDropdownFromTable("","cmdb_leverancier", "Leverancier_ID", "LeverancierNaam", "HardwareLeverancier_ID","Geen",$hardwareinfo['HardwareLeverancier_ID'],"cmdb_hardware","hardwareLeverancier_ID");
            ?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Aankoopjaar:
        </td>
        <td class="hardwareitemtable-cell">
            <?php echo '<input name="HardwareAankoopJaar" type="number" maxlength="4" value="'.$hardwareinfo['HardwareAankoopJaar'].'"/>';?>
        </td>
    </tr>
    <tr>
        <td>
            Geïnstalleerde software:
        </td>
        <td>
            <?php
                $sql = 'SELECT 
                        * 
                        FROM 
                        `cmdb_geinstalleerdesoftware` 
                        INNER JOIN `cmdb_software` 
                        ON `cmdb_geinstalleerdesoftware`.`Software_ID` = `cmdb_software`.`Software_ID`
                        WHERE 
                        `Hardware_ID` = "'.$hardwareid.'"';
                $result=$mysqli->query($sql);
                if($result->num_rows)
                {
                    while($row = $result->fetch_assoc())
                    {
                        //generateDropdownFromTable("", "cmdb_software", "Software_ID", "SoftwareNaam", "Software_ID", "(geen)", $row["Software_ID"], "cmdb_geinstalleerdesoftware", "Software_ID",200);
                        echo $row["SoftwareNaam"];
                        echo '<br />';
                    }
                }
            ?>
        </td>
    </tr>
</table>
<input type="submit" value="opslaan"/>
</form>
<?php
}
else echo 'Dit item is niet gevonden in de lijst.<br /> klik <a href="?action=hardware">hier</a> om terug te gaan naar de hardwarelijst';
?>