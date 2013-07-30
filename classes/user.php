<?php
/**
 * City Data Dictionary - User.
 * 
 * @package User
 */
class User
{
    public $user_id; //user id.
    public $user_name; //user name.
    
    /**
     * Business Function User empty constructor.
     *
     * @return User Empty User object.
     */
    public function __construct()
    {
        
    }

    /**
     * Get all Users.
     *
     * @return array An array of all Users.
     */
    public static function get_all_users()
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $all_users = mysqli_query($cnnCDD, "Call User__Get_All_Users()");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return all users
        return $all_users;
    }    
    
    /**
     * Get all User Types.
     *
     * @return array An array of all User Type.
     */
    public static function get_all_user_types()
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $all_user_types = mysqli_query($cnnCDD, "Call User__Get_All_User_Types()");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return all users
        return $all_user_types;
    }    
    
    /**
     * Get User info.
     *
     * @param string user_id The ID of the User from which to retrieve
     *                           info.
     * @return array An array of Users info.
     */
    public static function get_user_info($user_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $user_info = mysqli_query($cnnCDD, "Call User__Get_User_Info(" . $user_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return user info
        return mysqli_fetch_assoc($user_info);
    }    
    
    /**
     * Get User's User Types (permissions).
     *
     * @param string user_id The ID of the User from which to retrieve
     *                       User Types.
     * @return array An array of the specified User's User Types.
     */
    public static function get_users_user_types($user_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $users_user_types = mysqli_query($cnnCDD, "Call User__Get_Users_User_Types(" . $user_id . ")");
        
        $users_user_types_array = array();
        
        while ($user_type = mysqli_fetch_array($users_user_types)) {
            $users_user_types_array[] = $user_type['User_Type_Name'];
        }
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return user users
        return $users_user_types_array;
    }    
    
    /**
     * Validate User's Login.
     *
     * @param string username The username of the User from which to retrieve
     *                        the login.
     * @param string password The password of the User from which to retrieve
     *                        the login.
     * @return array An array of the specified User's info.
     */
    public static function validate_login($username, $password)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $user_info = mysqli_query($cnnCDD, "Call User__Validate_Login('" . $username . "', '" . $password . "')");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return user users
        return $user_info;
    }
    
    /**
     * Add User_Type to User.
     *
     * @param string user_id      The ID of the User to which to add a User_Type.
     * @param string user_type_id The ID of the User_Type that is being added.
     */
    public static function add_user_user_type($user_id, $user_type_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call User__Add_User_User_Type(" . $user_id
                                                        . "," . $user_type_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }
}
?>
