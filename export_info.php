<?php
//get database table info
if (isset($_GET['database_id'])) {
    //open DB
    include 'include/dbconnopen.php';
    
    //get all database info
    $database_info = mysqli_query($cnnCDD, "Call Database__Get_Database_Info(" . $_GET['database_id'] . ")");
    $database_info = mysqli_fetch_assoc($database_info);
    //close DB
    include ('include/dbconnclose.php');
    
    //open DB
    include 'include/dbconnopen.php';
    
    //get all database tables
    $database_tables = mysqli_query($cnnCDD, "Call Database__Get_Database_Tables(" . $_GET['database_id'] . ")");
    
    //close DB
    include ('include/dbconnclose.php');
    
    //write info
    $fp = fopen('./' . $database_info['Database_Name'] . '_database_export.csv', 'w');
    
    //table headers
    fputcsv($fp, array('Table_Name', 'Table_Description'));
    
    //table data
    while ($row = mysqli_fetch_assoc($database_tables)) {
        fputcsv($fp, array($row['Table_Name'], $row['Table_Description']));
    }
    fclose($fp);

    header("Location: ./" . $database_info['Database_Name'] . "_database_export.csv");
    //unlink('./' . $database_info['Database_Name'] . '_database_export.csv');
            
//get table variable info
} else if (isset($_GET['table_id'])) {
    
    //open DB
    include 'include/dbconnopen.php';
    
    //get all database info
    $table_info = mysqli_query($cnnCDD, "Call Table__Get_Table_Info(" . $_GET['table_id'] . ")");
    $table_info = mysqli_fetch_assoc($table_info);
    //close DB
    include ('include/dbconnclose.php');
    
    //open DB
    include 'include/dbconnopen.php';
    
    //get all database tables
    $table_variables = mysqli_query($cnnCDD, "Call Table__Get_Table_Variables(" . $_GET['table_id'] . ")");
    
    //close DB
    include ('include/dbconnclose.php');
    
    //write info
    $fp = fopen('./' . $table_info['Table_Name'] . '_table_export.csv', 'w');
    
    //table headers
    fputcsv($fp, array('Variable_Name', 'Variable_Data_Type'));
    
    //table data
    while ($row = mysqli_fetch_assoc($table_variables)) {
        fputcsv($fp, array($row['Variable_Name'], $row['Variable_Data_Type']));
    }
    fclose($fp);
    
    header("Location: ./" . $table_info['Table_Name'] . "_table_export.csv");
    //unlink('./' . $table_info['Table_Name'] . '_table_export.csv');
    
//get variable info
} else if (isset($_GET['variable_id'])) {
    
    //open DB
    include 'include/dbconnopen.php';
    
    //get all variable info
    $variable_info = mysqli_query($cnnCDD, "Call Variable__Get_Variable_Info(" . $_GET['variable_id'] . ")");
    $variable_info_fields = $variable_info;
    $variable_info = mysqli_fetch_assoc($variable_info);
    
    //close DB
    include ('include/dbconnclose.php');
    
    //write info
    $fp = fopen('./' . $variable_info['Variable_Name'] . '_variable_export.csv', 'w');
    
    //variable headers
    $variable_info_fields = mysqli_fetch_fields($variable_info_fields);
    $variable_fields = array();
    foreach ($variable_info_fields as $key => $value) {
        array_push($variable_fields, $value->name);
    }
    
    //write header
    fputcsv($fp, $variable_fields);
    
    //write variable data
    fputcsv($fp, $variable_info);
    
    fclose($fp);
    
    header("Location: ./" . $variable_info['Variable_Name'] . "_variable_export.csv");
    //unlink('./' . $table_info['Table_Name'] . '_table_export.csv');
}
?>