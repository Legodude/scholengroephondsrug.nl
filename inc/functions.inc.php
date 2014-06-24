<?php

function hasPageAcces($pageId)
{
    if(isset($_SESSION["gebruikerslevel"]))
    {
        if($_SESSION["gebruikerslevel"]==5) return true;
    }
    global $mysqli;
    $sql = "SELECT * from `cms_paginapermissie` WHERE `pagina_Id` =".$pageId;
    $result = $mysqli->query($sql);
    if($result->num_rows==0) 
    {
        return true;
    }
    while($level = $result->fetch_assoc()["gebruikerlevel"])
    {
        if(isset($_SESSION["gebruikerslevel"]))
        {
            if($_SESSION["gebruikerslevel"]==$level) return true;
        }
    }
    return false;
}

function showLoginForm()
{
    echo '<form action="#" METHOD="POST">
    <table>
        <tr>
            <td><label for="user">Gebruikersnaam</label></td><td><input type="text" id="userfield" name="user" /></td>
        </tr>
        <tr>
            <td><label for="pass">Wachtwoord:</label></td><td><input type="password" id="passfield" name="pass" /></td>
        </tr>
    </table>
    <input type="submit" value="Inloggen" />
</form> ';
}

function generateDropdownFromTable($formid,$table, $valuefield, $textfield, $dropdownname,$novalue="",$defaultsset=Array(), $joinTable="", $joinField="",$width = 100)
{
    //echo 'generateDropdownFromTable('.$formid.','.$table.','.$valuefield.','.$textfield.','.$dropdownname.','.$novalue.','.$defaultsset.','.$joinTable.','.$joinField.','.$width.');';
    global $mysqli;
    echo '<select ';
    if (!empty($formid)) echo 'onchange="document.getElementById(\''.$formid.'\').submit();" ';
    echo 'name="'.$dropdownname.'" style="width:'.$width.'px;">'; 
    if(empty($novalue)) $novalue=$dropdownname;
    echo '<option value="">'.$novalue.'</option>';
    $sql = "SELECT ".$table.".".$valuefield.", ".$table.".".$textfield." FROM `".$table."`";
    if(!empty($joinTable)&&!empty($joinField))
    {
        $sql .= "INNER JOIN ".$joinTable."
        ON ".$joinTable.".".$joinField."=".$table.".".$valuefield."
        GROUP BY ".$table.".".$valuefield;
    }
    echo $sql;
    $result = $mysqli->query($sql);
    while($row = $result->fetch_assoc())
    {
        echo '<option ';
        if(isset($defaultsset)&&!empty($defaultsset))
        {
            if($defaultsset==$row[$valuefield]) echo 'selected="selected" ';
        }
        echo 'value='.$row[$valuefield].'>'.$row[$textfield].'</option>';
    }
    echo '</select>';
}