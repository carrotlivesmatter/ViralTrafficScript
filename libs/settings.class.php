<?php
error_reporting(0);
include('database.php');

class viralTraffic {
    public $db;
    public function __construct()
    {
        $this->connectDB();
    }

    function connectDB()
    {
        return $this->db = new PDO("mysql:host=".dbhost.";dbname=".dbname."", dbuser, dbpass);
    }

	function getSettings($setting)
	{
        $a = $this->db->query("SELECT $setting FROM settings");
		$b = $a->fetchAll();
		return $b[0][$setting];
        //print_r($b);
	}
	
	function getViews($referralID)
	{
		$a = $this->db->query( "SELECT views FROM cookieReferral WHERE referralID='{$referralID}'");
		$b = $a->fetchAll();
		return $b[0][0];
	}
		
	function generateReferralCode($length)
	{
		return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}
}
?>