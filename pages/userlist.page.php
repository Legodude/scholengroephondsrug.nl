<div class="filteroptions">
    <form action="#" method="GET" id="filteroptionsform">
        <input type="hidden" name="action" value="hardware" />
        <?php
        $level = "";
        if(isset($_GET["level"])) $level = $_GET["level"];
        generateDropdownFromTable("filteroptionsform", "cms_gebruikers", "gebruikerslevel", "GebruikersLevel", "level", "", $level, "cmdb_hardware","gebruikerslevel");
        
        $skip = 0;
        if(isset($_GET["skip"])) $skip=$mysqli->real_escape_string(strip_tags($_GET["skip"]));
        $sql = "SELECT gebruikercode, voornaam, achternaam, gebruikerslevel, email
        FROM cms_gebruikers";
        if(isset($_GET["level"]))
        {
            if (!empty($_GET["level"]))
            {
                $sql.='AND `gebruikerslevel` = "' . $mysqli->real_escape_string(strip_tags($_GET["level"])) . '"';
            }
        }
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
        echo " | ".(($skip/20)+1)." |  ";
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
if(isset($_GET["skip"]))
{
    $sql.= ' LIMIT '.$skip .',20';
}
else $sql.=' LIMIT 0,20';
$result = $mysqli->query($sql);
if($result->num_rows!=0)
{
    echo '<table class="ci-table">';
    echo '<th>gebruikercode</th><th>voornaam</th><th>achternaam</th><th>gebruikerslevel</th><th>email</th>';
    $i=0;
    while ($row = $result->fetch_assoc())
    {
        echo '<tr onclick="window.document.location.href=\'?action=hardwareitem&hardwareID='.$row["Hardware_ID"].'\'" class="ci-table-row ';
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