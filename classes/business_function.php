<?php
/**
 * City Data Dictionary - Business Function.
 * 
 * @package Business_Function
 */
class Business_Function
{
    public $business_function_id; //business function id.
    public $business_function_name; //business function name.
    
    /**
     * Business Function Project empty constructor.
     *
     * @return Business_Function Empty Project object.
     */
    public function __construct()
    {
        
    }

    /**
     * Get all Business Functions.
     *
     * @param string business_function_id The business_function_id of the
     *                                    Business Function that is being
     *                                    loaded.
     * @return array Loaded BusinessFunction object array.
     */
    public function load_with_business_function_id($business_function_id)
    {
        //set project_id
        $this->project_id = $project_id;

        //open DB
        echo dirname(__FILE__) . '/../../include/dbconnopen.php';
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $project_info = mysqli_query($cnnCHTime, "Call Project__Load_With_Project_ID('" . $this->project_id . "')");
        
        //set public variables
        $project_info_temp = mysqli_fetch_array($project_info);

        $this->project_pi = $project_info_temp['Project_PI'];
        $this->project_title = stripslashes($project_info_temp['Project_Title']);
        $this->project_fas = $project_info_temp['Project_FAS'];
        $this->project_funder = stripslashes($project_info_temp['Project_Funder']);
        $this->start_date = $project_info_temp['Start_Date'];
        $this->end_date = $project_info_temp['End_Date'];
        $this->project_created_date = $project_info_temp['Project_Created_Date'];
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return project info
        return $project_info;
    }    
    
    
    
    
    
    
    
    
    
    
    
    
    /**
     * Get Business Function info.
     *
     * @param string business_function_id The ID of the Business Function from
     *                                    which to retrieve info.
     * @return array An array of Business Function info.
     */
    public static function get_business_function_info($business_function_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $business_function_info = mysqli_query($cnnCDD, "Call Business_Function__Get_Business_Function_Info(" . $business_function_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return table info
        return mysqli_fetch_assoc($business_function_info);
    }
    
    /**
     * Get Business Function info.
     *
     * @param string business_function_id The ID of the Business Function from
     *                                    which to retrieve info.
     * @return array An array of Business Function info.
     */
    /*
    public static function get_business_function_info($business_function_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $business_function_info = mysqli_query($cnnCDD, "Call Business_Function__Get_Business_Function_Info(" . $business_function_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return table info
        return mysqli_fetch_assoc($business_function_info);
    }
    */
    
    /**
     * Get Business Functions.
     *
     * @return array An array of Business Functions.
     */
    public static function get_all_business_functions()
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $all_business_functions = mysqli_query($cnnCDD, "Call Business_Function__Get_All_Business_Functions()");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return table info
        return $all_business_functions;
    }
    
    /**
     * Get Business Function's Databases.
     *
     * @param string business_function_id The ID of the Business Function from
     *                                    which to retrieve Databases.
     * @return array An array of Business Function Databases.
     */
    public static function get_business_function_databases($business_function_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $all_business_functions = mysqli_query($cnnCDD, "Call Business_Function__Get_All_Business_Function_Databases(" . $business_function_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return table info
        return $all_business_functions;
    }
    
    /**
     * Add Business Function.
     *
     * @param string business_function_name  The name of the Business Function
     *                                       to be added.
     * @param string database_id        The ID of the Database to which the
     *                                  Business Function is to be added.
     */
    public static function add_business_function($business_function_name,
                                                 $database_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $error = mysqli_query($cnnCDD, "Call Business_Function__Add_Business_Function('"
                                            . addslashes($business_function_name)
                                            . "'," . $database_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        return $error;
    }

    /**
     * Remove Business Function.
     *
     * @param string business_function_id  The ID of the Business Function
     *                                     to be removed.
     * @param string database_id  The ID of the Database from which the Business
     *                            Function is to be removed.
     */
    public static function remove_business_function($business_function_id,
                                                    $database_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Business_Function__Remove_Business_Function("
                                                . $business_function_id
                                                . "," . $database_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }
}
?>