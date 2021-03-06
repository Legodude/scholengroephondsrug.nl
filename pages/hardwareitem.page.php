<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$hardwareid = $mysqli->real_escape_string(strip_tags($_GET["hardwareID"]));
if(isset($_GET['schrijfaf']))
{
    $sql = 'UPDATE `cmdb_hardware` SET `HardwareStatus` = 1 WHERE `Hardware_ID` = "'.$hardwareid.'"';
    $mysqli -> query($sql);
    echo "Hardwareitem afgeschreven.";
    exit();
    
}
if(isset($_POST['Hardware_ID']))
{
    
    
    $sql = 'UPDATE `cmdb_hardware` SET `HardwareOS_ID` = '.$_POST['HardwareOS_ID'].' WHERE `Hardware_ID` = "'.$hardwareid.'"';
    $mysqli->query($sql);
    if(isset($_POST['Software_ID']))
    {
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
    }
    if(isset($_POST['SoftwareNieuw']))
    {
        if(!empty($_POST['SoftwareNieuw']))
        {
            $sql = 'INSERT INTO `cmdb_geinstalleerdesoftware` (`Software_ID`,`Hardware_ID`) VALUES ("'.$_POST['SoftwareNieuw'].'","'.$_POST['Hardware_ID'].'")';
            $mysqli->query($sql);
        }
    }
    if(isset($_POST['Hardwarelink']))
    {
        foreach($_POST['Hardwarelink'] as $key=>$value)
        {
            $sql = "";
            if(empty($value))
            {
                $sql .= 'DELETE FROM `cmdb_hardwarelink` WHERE `Link_ID` = "'.$key.'"';
            }
            else 
            {
                $sql .= 'UPDATE `cmdb_hardwarelink` SET `Hardware_ID_sub` = "'.$value.'" WHERE `Link_ID` = "'.$key.'"';
            }
            $mysqli->query($sql);
        }
    }
    if(isset($_POST['Hardwarelinknieuw']))
    {
        if(!empty($_POST['Hardwarelinknieuw']))
        {
            $sql = 'INSERT INTO `cmdb_hardwarelink` (`Hardware_ID_hoofd`,`Hardware_ID_sub`) VALUES ("'.$_POST['Hardware_ID'].'","'.$_POST['Hardwarelinknieuw'].'")';
            $mysqli->query($sql);
        }
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
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Geïnstalleerde software:
        </td>
        <td class="hardwareitemtable-cell">
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
                generateDropdownFromTable("", "cmdb_software", "Software_ID", "SoftwareNaam", "SoftwareNieuw", "Geen", "", "cmdb_geinstalleerdesoftware", "Software_ID",200);
            ?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td>
            Verbindingen:
        </td>
        <td>
            <?php
                $sql = 'SELECT 
                        * 
                        FROM 
                        `cmdb_hardwarelink` 
                        INNER JOIN `cmdb_hardware` 
                        ON `cmdb_hardwarelink`.`Hardware_ID_sub` = `cmdb_hardware`.`Hardware_ID`
                        WHERE 
                        `Hardware_ID_hoofd` = "'.$hardwareid.'"';
                $result=$mysqli->query($sql);
                if($result->num_rows)
                {
                    while($row = $result->fetch_assoc())
                    {
                        
                        $otherHardwareItem = $row['Hardware_ID_sub'];
                        generateDropdownFromTable("", "cmdb_hardware", "Hardware_ID", "Hardware_ID", "Hardwarelink[".$row['Link_ID']."]", "(verwijderen)", $otherHardwareItem,"","",200);
                        //generateDropdownFromTable("", "cmdb_hardware", "Hardware_ID", "Hardware_ID", "Hardware_ID[".$row['Hardware_ID']."]", "(verwijderen)", $row["Hardware_ID"], "cmdb_hardwarelink", "Hardware_ID",200);
                        /*echo $row["SoftwareNaam"];*/
                        echo '<br />';
                        
                    }
                }
                //generateDropdownFromTable("", "cmdb_software", "Software_ID", "SoftwareNaam", "SoftwareNieuw", "Geen", "", "cmdb_geinstalleerdesoftware", "Software_ID",200);
                //generateDropdownFromTable("", "cmdb_hardware", "Hardware_ID", "Hardware_ID", "Hardware_ID[".$row['Hardware_ID']."]", "(verwijderen)", "", "cmdb_hardwarelink", "Hardware_ID",200);
                generateDropdownFromTable("", "cmdb_hardware", "Hardware_ID", "Hardware_ID", "Hardwarelinknieuw", "Geen", "","","",200);
            ?>
        </td>
    </tr>
</table>
<input type="submit" value="Opslaan"/>
</form>
<input type="button" id="verwijderen" value="Afschrijven" onclick="document.getElementById('verwijderen').style.display='none';document.getElementById('echtverwijderen').style.display='block';" />
<input type="button" id="echtverwijderen" style="display:none;" value="Echt afschrijven!" onclick="location.href='?action=hardwareitem&hardwareID=<?php echo $_GET['hardwareID']; ?>&schrijfaf'" />
<?php
}
else echo 'Dit item is niet gevonden in de lijst.<br /> klik <a href="?action=hardware">hier</a> om terug te gaan naar de hardwarelijst';
?>