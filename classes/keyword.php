<?php
/**
 * City Data Dictionary - Keyword.
 * 
 * @package Keyword
 */
class Keyword
{
    /**
     * Keyword empty constructor.
     *
     * @return Keyword Empty Keyword object.
     */
    public function __construct()
    {
        
    }

    /**
     * Get all Keywords.
     *
     * @return array An array of all Keywords.
     */
    public static function get_all_keywords()
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $all_keywords = mysqli_query($cnnCDD, "Call Keyword__Get_All_Keywords()");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        
        //return all keywords
        return $all_keywords;
    }
    
    /**
     * Add Keyword.
     *
     * @param string keyword        The Keyword to be added.
     * @param string element_type   The type of the element to which the Keyword
     *                              is to be added.
     * @param string element_id     The ID of the element to which the Keyword
     *                              is to be added.
     */
    public static function add_keyword($keyword,
                                        $element_type,
                                        $element_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        $error = mysqli_query($cnnCDD, "Call Keyword__Add_Keyword('" . addslashes($keyword)
                                                . "','" . $element_type
                                                . "'," . $element_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
        return $error;
    }
   
    /**
     * Remove Keyword.
     *
     * @param string keyword        The Keyword to be removed.
     * @param string element_type   The type of the element to which the Keyword
     *                              is to be removed.
     * @param string element_id     The ID of the element to which the Keyword
     *                              is to be removed.
     */
    public static function remove_keyword($keyword,
                                        $element_type,
                                        $element_id)
    {
        //open DB
        include dirname(__FILE__) . '/../include/dbconnopen.php';
        mysqli_query($cnnCDD, "Call Keyword__Remove_Keyword('" . addslashes($keyword)
                                                . "','" . $element_type
                                                . "'," . $element_id . ")");
        
        //close DB
        include dirname(__FILE__) . '/../include/dbconnclose.php';
    }
}
?>
