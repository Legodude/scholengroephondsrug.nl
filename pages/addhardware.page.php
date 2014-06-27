<?php if(isset($_POST['HardwareType_ID']))
{
    if(empty($_POST['HardwareType_ID'])||empty($_POST['HardwareLocatie_ID'])) echo "Formulier incorrect verzonden. ga terug.", exit();
    $locaties = Array(1=>"ANL",2=>"GRL",3=>"BHFK",4=>"BRG",5=>"GSS",6=>"GTN",7=>"GTV",8=>"HFK");
    $type = Array(48=>"",49=>"M",50=>"P",51=>"WS",52=>"",53=>"",54=>"R",55=>"P",56=>"P");
    //$sql = 'SELECT * from `cmdb_hardware` where `HardwareLocatie_ID` = "'.$_POST['HardwareLocatie_ID'].'" AND `HardwareType_ID` = "'.$_POST['HardwareType_ID'].'" ORDER BY Hardware_ID DESC';
    $sql = 'SELECT * from `cmdb_hardware` where `Hardware_ID` LIKE "'.$locaties[$_POST['HardwareLocatie_ID']].$type[$_POST['HardwareType_ID']].'%" ORDER BY `Hardware_ID` DESC';
    $result = $mysqli->query($sql);
    if($result->num_rows!=0)
    {
        $highestid = $result->fetch_assoc()['Hardware_ID'];
        $highestidnum = 0;
        for($i=0;$i<strlen($highestid);$i++)
        {
            $sub = substr($highestid, $i);
            if(is_numeric($sub))
            {
                $highestidnum = $sub;
                break;
            }
        }
        $idpartlen = strlen($highestidnum);
        $highestidnum = (int)$highestidnum;
        $highestidnumlen = strlen($highestidnum);
        $highestidnum++;
        for($i=$highestidnumlen;$i<$idpartlen;$i++)
        {
            $highestidnum = '0'.$highestidnum;
        }
        $os = "NULL";
        if(!empty($_POST['HardwareOS_ID'])) $os = '"'.$_POST['HardwareOS_ID'].'"';
        $new_ID = $locaties[$_POST['HardwareLocatie_ID']].$type[$_POST['HardwareType_ID']].$highestidnum;
        $sql = 'INSERT INTO `cmdb_hardware` '
                . '(`Hardware_ID`,`HardwareType_ID`,`HardwareLocatie_ID`,'
                . '`HardwareOS_ID`,`HardwareOntwikkelaar_ID`,'
                . '`HardwareLeverancier_ID`, `HardwareAankoopJaar`) '
                . 'VALUES ("'.$new_ID.'","'.$_POST['HardwareType_ID'].'",'
                . '"'.$_POST['HardwareLocatie_ID'].'",'.$os.','
                . '"'.$_POST['HardwareOntwikkelaar_ID'].'","'.$_POST['HardwareLeverancier_ID'].'",'
                . '"'.$_POST['HardwareAankoopJaar'].'")';
        echo $sql;
        $mysqli->query($sql);
        echo "Hardwareitem toegevoegd.<br />";
        echo '<a href="?action=hardwareitem&hardwareID='.$new_ID.'">Klik hier</a> om software toe te voegen, en de netwerkverbindingen in te stellen.';
    }
    
}
else
{
?>

<form action="#" method="POST">
<table class="hardwareitemtable">
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Type:
        </td>
        <td class="hardwareitemtable-cell">
            <?php
                generateDropdownFromTable("","cmdb_type", "Type_ID", "TypeOmschrijving", "HardwareType_ID","Geen","","cmdb_hardware","hardwareType_ID");
            ?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Locatie:
        </td>
        <td class="hardwareitemtable-cell">
            <?php
                generateDropdownFromTable("","cmdb_locatie", "Locatie_ID", "LocatieOmschrijving", "HardwareLocatie_ID","Geen");
            ?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Operating System:
        </td>
        <td class="hardwareitemtable-cell">
            <?php
                generateDropdownFromTable("","cmdb_software", "Software_ID", "SoftwareNaam", "HardwareOS_ID","Geen","","cmdb_hardware","hardwareOS_ID");
            ?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Ontwikkelaar:
        </td>
        <td class="hardwareitemtable-cell">
            <?php
                generateDropdownFromTable("","cmdb_ontwikkelaar", "Ontwikkelaar_ID", "OntwikkelaarNaam", "HardwareOntwikkelaar_ID", "Ontwikkelaar");
            ?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Leverancier:
        </td>
        <td class="hardwareitemtable-cell">
            <?php
                generateDropdownFromTable("","cmdb_leverancier", "Leverancier_ID", "LeverancierNaam", "HardwareLeverancier_ID","Leverancier");
            ?>
        </td>
    </tr>
    <tr class="hardwareitemtable-row">
        <td class="hardwareitemtable-cell">
            Aankoopjaar:
        </td>
        <td class="hardwareitemtable-cell">
            <input name="HardwareAankoopJaar" type="number" value="<?php echo date('Y'); ?>" />
        </td>
    </tr>
</table>
    <input type="submit" value="Toevoegen"/>
</form>

<?php
}
?>
