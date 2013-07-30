<?php
/**
 * City Data Dictionary - Variable.
 * 
 * @package Variable
 */
class Variable
{
    public $variable_id; //variable id.
    public $variable_name; //variable name.
    
    
    /**
     * Business Function Variable empty constructor.
     *
     * @return Variable Empty Variable object.
     */
    public function __construct()
    {
        
    }

    /**
     * Get all Variables.
     *
     * @return array An array of all Variables.
     */
    public static function get_all_variables()
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $all_variables = mysqli_query($cnnCDD, "Call Variable__Get_All_Variables()");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return all variables
        return $all_variables;
    }    
    
    /**
     * Get Variable info.
     *
     * @param string variable_id The ID of the Variable from which to retrieve
     *                           info.
     * @return array An array of Variables info.
     */
    public static function get_variable_info($variable_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $variable_info = mysqli_query($cnnCDD, "Call Variable__Get_Variable_Info(" . $variable_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return variable info
        return mysqli_fetch_assoc($variable_info);
    }    
    
    /**
     * Get Variable's parent Tables.
     *
     * @param string variable_id The ID of the Variable from which to retrieve
     *                           parent Tables.
     * @return array An array of the specified Variable's Tables.
     */
    public static function get_variable_tables($variable_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $variable_tables = mysqli_query($cnnCDD, "Call Variable__Get_Parent_Tables(" . $variable_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return variable variables
        return $variable_tables;
    }    

    /**
     * Creates a Variable revision.
     *
     * @param string variable_id The ID of the Variable.
     */
    public static function create_revision($variable_id,
                                           $variable_name,
                                           $variable_description,
                                           $variable_type_format,
                                           $variable_length,
                                           $variable_values,
                                           $variable_example,
                                           $variable_comments,
                                           $data_portal,
                                           $creator,
                                           $table_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Variable__Create_Revision(" . $variable_id
                                            . ",'" . addslashes($variable_name)
                                            . "','" . addslashes($variable_description)
                                            . "','" . addslashes($variable_type_format)
                                            . "','" . addslashes($variable_length)
                                            . "','" . addslashes($variable_values)
                                            . "','" . addslashes($variable_example)
                                            . "','" . addslashes($variable_comments)
                                            . "','" . addslashes($data_portal)
                                            . "','" . addslashes($creator)
                                            . "'," . addslashes($table_id) . ")");
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }      
    
    /**
     * Get Variable's revisions.
     *
     * @param string variable_id The ID of the Variable from which to retrieve
     *                           revisions.
     * @return array An array of the specified Variable's revisions.
     */
    public static function get_variable_revisions($variable_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $variable_revisions = mysqli_query($cnnCDD, "Call Variable__Get_Variable_Revisions(" . $variable_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return variable revisions
        return $variable_revisions;
    }
        
    /**
     * Activate Variable revision.
     *
     * @param string revision_id The ID of the Variable Revision to be activated.
     */
    public static function activate_revision($revision_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Variable__Activate_Revision(" . $revision_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }
    
    /**
     * Get orphan Variable revisions.
     *
     */
    public static function get_orphan_revisions()
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $orphan_variable_revisions = mysqli_query($cnnCDD, "Call Variable__Get_Orphan_Revisions()");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return database tables
        return $orphan_variable_revisions;
    }

    /**
     * Delete Variable revision.
     *
     * @param string revision_id The ID of the Variable Revision to be deleted.
     */
    public static function delete_revision($revision_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Variable__Delete_Revision(" . $revision_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }
    
    /**
     * Get Variable's parent tables.
     *
     * @param string variable_id The ID of the Variable from which to retrieve
     *                           its parent Table.
     * @return array             An array of the specified Variable's Table info.
     */
    public static function get_parent_tables($variable_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $parent_databases = mysqli_query($cnnCDD, "Call Variable__Get_Parent_Tables(" . $variable_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return table tables
        return $parent_databases;
    }

    /**
     * Add 1 view to the Variable.
     *
     * @param string variable_id The ID of the Variable to which the view is to
     *                           be added.
     */
    public static function add_view($variable_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Variable__Add_View(" . $variable_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }

    /**
     * Get Variable's keywords.
     *
     * @param string variable_id The ID of the Variable from which to retrieve
     *                           Keywords.
     */
    public static function get_keywords($variable_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $variable_keywords = mysqli_query($cnnCDD, "Call Variable__Get_Keywords(" . $variable_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return keywords
        return $variable_keywords;
    }
    
    /**
     * Toggle public Variable.
     *
     * @param string variable_id The ID of the Variable to be toggled.
     * @param string public      The toggle position (1=public, 0=non-public).
     */
    public static function toggle_public($variable_id, $public)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Variable__Toggle_Public(" . $variable_id .
                                                        "," . $public . ")");
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }
}
?>
