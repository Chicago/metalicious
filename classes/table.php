<?php
/**
 * City Data Dictionary - Table.
 * 
 * @package Table
 */
class Table
{
    public $table_id; //table id.
    public $table_name; //table name.
    
    /**
     * Business Function Table empty constructor.
     *
     * @return Table Empty Table object.
     */
    public function __construct()
    {
        
    }

    /**
     * Get all Tables.
     *
     * @return array An array of all Tables.
     */
    public static function get_all_tables()
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $all_tables = mysqli_query($cnnCDD, "Call Table__Get_All_Tables()");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return all tables
        return $all_tables;
    }    
    
    /**
     * Get Table info.
     *
     * @param string table_id The ID of the Table from which to retrieve
     *                           info.
     * @return array An array of Table info.
     */
    public static function get_table_info($table_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $table_info = mysqli_query($cnnCDD, "Call Table__Get_Table_Info(" . $table_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return table info
        return mysqli_fetch_assoc($table_info);
    }    
    
    /**
     * Get Table's parent databases.
     *
     * @param string table_id The ID of the Table from which to retrieve
     *                        its parent database.
     * @return array An array of the specified Table's Database info.
     */
    public static function get_parent_databases($table_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $parent_databases = mysqli_query($cnnCDD, "Call Table__Get_Parent_Databases(" . $table_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return table tables
        return $parent_databases;
    }
    
    /**
     * Get Table's Variables.
     *
     * @param string table_id The ID of the Table from which to retrieve
     *                        Variables.
     * @return array An array of the specified Table's Variables.
     */
    public static function get_table_variables($table_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $table_variables = mysqli_query($cnnCDD, "Call Table__Get_Table_Variables(" . $table_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return table tables
        return $table_variables;
    }

    /**
     * Creates a Table revision.
     *
     * @param string table_id The ID of the Table.
     */
    public static function create_revision($table_id,
                                           $table_name,
                                           $table_description,
                                           $table_comments,
                                           $creator,
                                           $database_id)
    {
        $database_id = ($database_id == '') ? 'NULL' : $database_id;
        
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Table__Create_Revision(" . $table_id
                                            . ",'" . addslashes($table_name)
                                            . "','" . addslashes($table_description)
                                            . "','" . addslashes($table_comments)
                                            . "','" . addslashes($creator)
                                            . "'," . addslashes($database_id) . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }      
    
    /**
     * Get Table's revisions.
     *
     * @param string table_id The ID of the Table from which to retrieve
     *                           revisions.
     * @return array An array of the specified Table's revisions.
     */
    public static function get_table_revisions($table_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $table_revisions = mysqli_query($cnnCDD, "Call Table__Get_Table_Revisions(" . $table_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return table revisions
        return $table_revisions;
    }
    
    /**
     * Activate Table revision.
     *
     * @param string revision_id The ID of the Table Revision to be activated.
     */
    public static function activate_revision($revision_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Table__Activate_Revision(" . $revision_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }
    
    /**
     * Get orphan Table revisions.
     *
     */
    public static function get_orphan_revisions()
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $orphan_table_revisions = mysqli_query($cnnCDD, "Call Table__Get_Orphan_Revisions()");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return database tables
        return $orphan_table_revisions;
    }
    
    /**
     * Get Table's keywords.
     *
     * @param string table_id The ID of the Table from which to retrieve
     *                        Keywords.
     */
    public static function get_keywords($table_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $table_keywords = mysqli_query($cnnCDD, "Call Table__Get_Keywords(" . $table_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return keywords
        return $table_keywords;
    }
    
    /**
     * Delete Table revision.
     *
     * @param string revision_id The ID of the Table Revision to be deleted.
     */
    public static function delete_revision($revision_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Table__Delete_Revision(" . $revision_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }

    /**
     * Create Table Variable relationship.
     *
     * @param string table_name       The name of the Table in the relationship.
     * @param string variable_id      The ID of the Variable in the relationship.
     */
    public static function create_table_variable_relationship($table_name,
                                                                $variable_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $error = mysqli_query($cnnCDD, "Call Table__Create_Table_VariableRelationship('"
                                                                . addslashes($table_name) . "',"
                                                                . $variable_id . ")");
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        return $error;
    }
    
    /**
     * Delete Table Variable relationship.
     *
     * @param string table_variable_id The ID of the Table Variable relationship
     *                                 to be deleted.
     */
    public static function delete_table_variable_relationship($table_variable_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Table__Delete_Table_Variable_Relationship(" . $table_variable_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }
    
    /**
     * Add 1 view to the Table.
     *
     * @param string table_id The ID of the Table to which the view is to
     *                        be added.
     */
    public static function add_view($table_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Table__Add_View(" . $table_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }
    
    /**
     * Toggle public Table.
     *
     * @param string table_id The ID of the Table to be toggled.
     * @param string public   The toggle position (1=public, 0=non-public).
     */
    public static function toggle_public($table_id, $public)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Table__Toggle_Public(" . $table_id .
                                                        "," . $public . ")");
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }
}
?>