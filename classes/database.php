<?php
/**
 * City Data Dictionary - Database.
 * 
 * @package Database
 */
class Database
{
    public $database_id; //database id.
    public $database_name; //database name.
    
    /**
     * Business Function Database empty constructor.
     *
     * @return Database Empty Database object.
     */
    public function __construct()
    {
        
    }

    /**
     * Get all Databases.
     *
     * @return array An array of all Databases.
     */
    public static function get_all_databases()
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $all_databases = mysqli_query($cnnCDD, "Call Database__Get_All_Databases()");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return all databases
        return $all_databases;
    }    
    
    /**
     * Get Database info.
     *
     * @param string database_id The ID of the Database from which to retrieve
     *                           info.
     * @return array An array of Database info.
     */
    public static function get_database_info($database_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $database_info = mysqli_query($cnnCDD, "Call Database__Get_Database_Info(" . $database_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return database info
        return mysqli_fetch_assoc($database_info);
    }    
    
    /**
     * Get Database's tables.
     *
     * @param string database_id The ID of the Database from which to retrieve
     *                           Tables.
     * @return array An array of the specified Database's tables.
     */
    public static function get_database_tables($database_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $database_tables = mysqli_query($cnnCDD, "Call Database__Get_Database_Tables(" . $database_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return database tables
        return $database_tables;
    }    
    
    /**
     * Creates a Database revision.
     *
     * @param string database_id The ID of the Database from which to retrieve
     *                           Tables.
     * @return array An array of the specified Database's tables.
     */
    public static function create_revision($database_id,
                                            $database_name,
                                            $description,
                                            $business_owner,
                                            $contact_information,
                                            $data_period,
                                            $software_platform,
                                            $general_accuracy,
                                            $comments,
                                            $creator)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Database__Create_Revision(" . $database_id
                                            . ",'" . addslashes($database_name)
                                            . "','" . addslashes($description)
                                            . "','" . addslashes($business_owner)
                                            . "','" . addslashes($contact_information)
                                            . "','" . addslashes($data_period)
                                            . "','" . addslashes($software_platform)
                                            . "','" . addslashes($general_accuracy)
                                            . "','" . addslashes($comments)
                                            . "','" . addslashes($creator) . "')");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }      
    
    /**
     * Get Database's revisions.
     *
     * @param string database_id The ID of the Database from which to retrieve
     *                           revisions.
     * @return array An array of the specified Database's revisions.
     */
    public static function get_database_revisions($database_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $database_revisions = mysqli_query($cnnCDD, "Call Database__Get_Database_Revisions(" . $database_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return database revisions
        return $database_revisions;
    } 
    
    /**
     * Activate Database revision.
     *
     * @param string revision_id The ID of the Database Revision to be activated.
     */
    public static function activate_revision($revision_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Database__Activate_Revision(" . $revision_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }
    
    /**
     * Get orphan Database revisions.
     *
     */
    public static function get_orphan_revisions()
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $orphan_database_revisions = mysqli_query($cnnCDD, "Call Database__Get_Orphan_Revisions()");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return database tables
        return $orphan_database_revisions;
    }
    
    /**
     * Delete Database Table relationship.
     *
     * @param string database_table_id The ID of the Database Table relationship
     *                                 to be deleted.
     */
    public static function delete_database_table_relationship($database_table_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Database__Delete_Database_Table_Relationship(" . $database_table_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }
    
    /**
     * Create Database Table relationship.
     *
     * @param string database_name The name of the Database in the relationship.
     * @param string table_id      The ID of the Table in the relationship.
     */
    public static function create_database_table_relationship($database_name,
                                                                $table_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $error = mysqli_query($cnnCDD, "Call Database__Create_Database_Table_Relationship('"
                                                                . addslashes($database_name) . "',"
                                                                . $table_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        return $error;
    }

    /**
     * Get Database's keywords.
     *
     * @param string database_id The ID of the Database from which to retrieve
     *                           Keywords.
     */
    public static function get_keywords($database_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $database_keywords = mysqli_query($cnnCDD, "Call Database__Get_Keywords(" . $database_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return keywords
        return $database_keywords;
    }
    
    /**
     * Get Database's Business Functions.
     *
     * @param string database_id The ID of the Database from which to retrieve
     *                           Business Functions.
     */
    public static function get_business_functions($database_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $database_business_functions = mysqli_query($cnnCDD, "Call Database__Get_Business_Functions(" . $database_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return table keywords
        return $database_business_functions;
    }
    
    /**
     * Delete Database revision.
     *
     * @param string revision_id The ID of the Database Revision to be deleted.
     */
    public static function delete_revision($revision_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Database__Delete_Revision(" . $revision_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }
    
    /**
     * Add 1 view to the Database.
     *
     * @param string database_id The ID of the Database to which the view is to
     *                           be added.
     */
    public static function add_view($database_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Database__Add_View(" . $database_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }
    
    /**
     * Toggle public Database.
     *
     * @param string database_id The ID of the Database to be toggled.
     * @param string public      The toggle position (1=public, 0=non-public).
     */
    public static function toggle_public($database_id, $public)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Database__Toggle_Public(" . $database_id .
                                                        "," . $public . ")");
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }
}
?>
