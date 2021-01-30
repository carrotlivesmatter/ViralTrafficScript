<?php
require_once('libs/Smarty.class.php');
require_once('libs/settings.class.php');

$smarty = new Smarty();
$smarty->debugging = false;
$smarty->caching = false;
$smarty->cache_lifetime = 0;

$viralTraffic = new viralTraffic;

$ip = $_SERVER['REMOTE_ADDR'];

$referralID = '';
if(isset($_COOKIE['referralID'])) {
    $referralID = $_COOKIE['referralID'];
} else {
	$newreferralID = $viralTraffic->generateReferralCode(8);
	setcookie("referralID", $newreferralID, time() + (86400 * 30), '/');  // Sets a Cookie for 30 Days.
    $viralTraffic->db->query("INSERT INTO cookieReferral (referralID, userIP, views) values ('{$newreferralID}', '{$ip}', 0)");
    $referralID = $newreferralID;
}

if(isset($_GET['r'])){
    $xz = $viralTraffic->db->query("SELECT * FROM referralIP WHERE userIP = '{$ip}' and referralID = '{$_GET['r']}'");
    $testip = $viralTraffic->db->query("SELECT * FROM cookieReferral WHERE userIP = '{$ip}' AND referralID = '{$_GET['r']}'");

    if($xz->fetchColumn() < 1 && $testip->fetchColumn() < 1){
        $viralTraffic->db->query("UPDATE cookieReferral SET views = views + 1 WHERE referralID = '{$_GET['r']}'");
        $viralTraffic->db->query("INSERT INTO referralIP (userIP, referralID) values('{$ip}','{$_GET['r']}')");
    } else {
        // User has already viewed referral link or is trying to view own!
    }
}

$viralTraffic->getSettings('sitename');
$smarty->assign('sitename', $viralTraffic->getSettings("sitename"));
$smarty->assign('siteurl', $viralTraffic->getSettings("siteurl"));
$smarty->assign('ref_link', $viralTraffic->getSettings("siteurl") . "?r=" .$referralID);

$getViews = $viralTraffic->getViews($referralID);

if(!$getViews){
    $getViews = 0;
}
$smarty->assign('referralViews', $getViews);

$smarty->display('index.tpl');
?>