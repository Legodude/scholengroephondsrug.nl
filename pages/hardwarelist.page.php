<div class="filteroptions">
    <form action="#" method="POST" id="filteroptionsform">
        <input type="hidden" name="action" value="hardware" />
        <?php
        $type = "";
        if(isset($_POST["type"])) $type = $_POST["type"];
        generateDropdownFromTable("filteroptionsform", "cmdb_type", "Type_ID", "TypeOmschrijving", "type", "", $type, "cmdb_hardware","hardwareType_ID");
        $locatie = "";
        if(isset($_POST["locatie"])) $locatie = $_POST["locatie"];
        generateDropdownFromTable("filteroptionsform","cmdb_locatie", "Locatie_ID", "LocatieOmschrijving", "locatie", "", $locatie);
        $ontwikkelaar = "";
        if(isset($_POST["ontwikkelaar"])) $ontwikkelaar = $_POST["ontwikkelaar"];
        generateDropdownFromTable("filteroptionsform","cmdb_ontwikkelaar", "Ontwikkelaar_ID", "OntwikkelaarNaam", "ontwikkelaar", "", $ontwikkelaar, "cmdb_hardware","hardwareOntwikkelaar_ID");
        
        $skip = 0;
        if(isset($_POST["skip"])) $skip=$mysqli->real_escape_string(strip_tags($_POST["skip"]));
        $sql = 'SELECT 
	`cmdb_hardware`.`Hardware_ID`,
	`cmdb_type`.`TypeOmschrijving`,
	`cmdb_locatie`.`locatieOmschrijving`,
	`cmdb_software`.`softwareNaam`,
	`cmdb_ontwikkelaar`.`OntwikkelaarNaam`,
	`cmdb_leverancier`.`LeverancierNaam`,
	`cmdb_hardware`.`HardwareAankoopJaar`
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
        WHERE 1 ';
        if(isset($_POST["type"]))
        {
            if (!empty($_POST["type"]))
            {
                $sql.='AND `HardwareType_ID` = "' . $mysqli->real_escape_string(strip_tags($_POST["type"])) . '"';
            }
        }
        if(isset($_POST["locatie"]))
        {
            if (!empty($_POST["locatie"]))
            {
                $sql.='AND `HardwareLocatie_ID` = "' . $mysqli->real_escape_string(strip_tags($_POST["locatie"])) . '"';
            }
        }
        if(isset($_POST["ontwikkelaar"]))
        {
            if (!empty($_POST["ontwikkelaar"]))
            {
                $sql.='AND `HardwareOntwikkelaar_ID` = "' . $mysqli->real_escape_string(strip_tags($_POST["ontwikkelaar"])) . '"';
            }
        }
        $sql.= ' AND `HardwareStatus` IS NULL ';
        $result = $mysqli->query($sql);
        $numberrows = $result->num_rows; 
        echo '<div style="float:right; padding-right:15px;">';
        if($skip<20)
        {
            echo '<label for="firstpage"><<</label>
        <input id="firstpage" type="checkbox" class="pageselector" name="skip" disabled="disabled"/>
        <label for="previouspage"><</label>
        <input id="previouspage" class="pageselector" type="checkbox" name="skip" disabled="disabled"/>';
        }
        else
        {
            echo '<label for="firstpage"><<</label>
        <input id="firstpage" class="pageselector" type="checkbox" name="skip" value="0" onclick="document.getElementById(\'filteroptionsform\').submit();" />
        <label for="previouspage"><</label>
        <input id="previouspage" class="pageselector" type="checkbox" name="skip" value="'.($skip-20).'" onclick="document.getElementById(\'filteroptionsform\').submit();" />';
        }
        echo " | ".(($skip/20)+1)."/".  ceil($numberrows/20)." |  ";
        if($skip>=$numberrows-20)
        {
            echo '<label for="nextpage">></label>
        <input id="nextpage" class="pageselector" type="checkbox" name="skip" disabled="disabled"/>
        <label for="lastpage">>></label>
        <input id="lastpage" class="pageselector" type="checkbox" name="skip" disabled="disabled"/>';
        }
        else
        {
            echo '<label for="nextpage">></label>
        <input id="nextpage" class="pageselector" type="checkbox" name="skip" value="'.($skip+20).'" onclick="document.getElementById(\'filteroptionsform\').submit();" />
        <label for="lastpage">>></label>
        <input id="lastpage" class="pageselector" type="checkbox" name="skip" value="'.(floor(($numberrows-20)/20)*20).'" onclick="document.getElementById(\'filteroptionsform\').submit();" />';
        }
        echo '</div>';
        ?>
        
        </form>
</div>

<?php
if(isset($_POST["skip"]))
{
    $sql.= ' LIMIT '.$skip .',20';
}
else $sql.=' LIMIT 0,20';

$result = $mysqli->query($sql);
if($result->num_rows!=0)
{
    echo '<table class="ci-table">';
    echo '<th>HardwareID</th><th>type</th><th>locatie</th><th>OS</th><th>ontwikkelaar</th><th>leverancier</th><th>aankoopjaar</th>';
    $i=0;
    while ($row = $result->fetch_assoc())
    {
        $nextaction = 'hardwareitem';
        if(isset($_GET['nextaction'])) $nextaction = $_GET['nextaction'];
        echo '<tr onclick="window.document.location.href=\'?action='.$nextaction.'&hardwareID='.$row["Hardware_ID"].'\'" class="ci-table-row ';
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
}
else echo 'Geen resultaten voor deze filters.<br /><a href="?action=hardware">klik hier om te resetten</a>';
?>