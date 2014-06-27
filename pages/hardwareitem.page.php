<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$hardwareid = $mysqli->real_escape_string(strip_tags($_GET["hardwareID"]));

if(isset($_POST['Hardware_ID']))
{
    $sql = 'UPDATE `cmdb_hardware` SET `HardwareOS_ID` = '.$_POST['HardwareOS_ID'].' WHERE `Hardware_ID` = "'.$hardwareid.'"';
    $mysqli->query($sql);
    
    foreach($_POST['Software_ID'] as $key=>$value)
    {
        $sql = "";
        if(empty($value))
        {
            $sql .= 'DELETE FROM `cmdb_geinstalleerdesoftware` WHERE `GeinstalleerdeSoftware_ID` = "'.$key.'"';
        }
        else 
        {
            $sql .= 'UPDATE `cmdb_geinstalleerdesoftware` SET `Software_ID` = "'.$value.'" WHERE `GeinstalleerdeSoftware_ID` = "'.$key.'"';
        }
        $mysqli->query($sql);
    }
    if(!empty($_POST['SoftwareNieuw']))
    {
        $sql = 'INSERT INTO `cmdb_geinstalleerdesoftware` (`Software_ID`,`Hardware_ID`) VALUES ("'.$_POST['SoftwareNieuw'].'","'.$_POST['Hardware_ID'].'")';
        $mysqli->query($sql);
    }
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
            <input name="Hardware_ID" type="hidden" value="<?php echo $hardwareinfo['Hardware_ID'] ?>" />
            <?php echo $hardwareinfo['Hardware_ID'] ?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Type:
        </td>
        <td class="hardwareitemtable-cell">
            <?php
               echo $hardwareinfo['HardwareType_ID'];
            ?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Locatie:
        </td>
        <td class="hardwareitemtable-cell">
            <?php
                echo $hardwareinfo['HardwareLocatie_ID'];
            ?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Ontwikkelaar:
        </td>
        <td class="hardwareitemtable-cell">
            <?php
                echo $hardwareinfo['HardwareOntwikkelaar_ID'];
            ?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Leverancier:
        </td>
        <td class="hardwareitemtable-cell">
            <?php
                echo $hardwareinfo['HardwareLeverancier_ID'];
            ?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Aankoopjaar:
        </td>
        <td class="hardwareitemtable-cell">
            <?php echo $hardwareinfo['HardwareAankoopJaar'];?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Operating System:
        </td>
        <td class="hardwareitemtable-cell">
            <?php
                generateDropdownFromTable("","cmdb_software", "Software_ID", "SoftwareNaam", "HardwareOS_ID","Geen",$hardwareinfo['HardwareOS_ID'],"cmdb_hardware","hardwareOS_ID",200);
            ?>
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
                        generateDropdownFromTable("", "cmdb_software", "Software_ID", "SoftwareNaam", "Software_ID[".$row['GeinstalleerdeSoftware_ID']."]", "(verwijderen)", $row["Software_ID"], "cmdb_geinstalleerdesoftware", "Software_ID",200);
                        /*echo $row["SoftwareNaam"];
                        echo '<br />';*/
                        
                    }
                }
                generateDropdownFromTable("", "cmdb_software", "Software_ID", "SoftwareNaam", "SoftwareNieuw", "(geen)", "", "cmdb_geinstalleerdesoftware", "Software_ID",200);
            ?>
        </td>
    </tr>
</table>
<input type="submit" value="Opslaan"/>
</form>
<?php
}
else echo 'Dit item is niet gevonden in de lijst.<br /> klik <a href="?action=hardware">hier</a> om terug te gaan naar de hardwarelijst';
?>