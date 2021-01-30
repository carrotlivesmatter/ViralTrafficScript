<?php
error_reporting(0);
function step_1(){
  if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['pre_error'] ==''){
   header('Location: install.php?step=2');
   exit;
  }
  if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['pre_error'] != '')
   print '<div class="alert alert-danger" role="alert">'.$_POST["pre_error"].'</div>';
      
  if (phpversion() < '7.0') {
   $pre_error = 'You need to use PHP 7.0 or above for our site!<br />';
  }
  if (ini_get('session.auto_start')) {
   $pre_error .= 'Our site will not work with session.auto_start enabled!<br />';
  }
  if (!extension_loaded('pdo_mysql')) {
   $pre_error .= 'pdo_mysql extension needs to be loaded for our site to work!<br />';
  }
      if (!is_writable('libs/database.php')) {
        $pre_error .= 'database.php needs to be writable for this script to be installed!';
      }
      if (!is_writable('cache/')) {
          $pre_error .= 'cache directory needs to be writable for this script to be installed!';
      }
        if (!is_writable('templates_c/')) {
            $pre_error .= 'templates_c directory needs to be writable for this script to be installed!';
        }
  ?>
  <table class="table table-bordered">
      <thead>
        <tr>
          <th>Check</th>
          <th>Required</th>
          <th>Your Server</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        
        <tr>
          <td>PHP Version</td>
          <td>7+</td>
          <td><?php echo phpversion(); ?></td>
          <td><?php echo (phpversion() >= '7.0') ? '<span style="color:green;"><strong>OK!</strong></span>' : '<span style="color:red;"><strong>ERROR INSTALL PHP 7.0 OR GREATER</strong></span>'; ?></td>
        </tr>
        
        <tr>
          <td>PDO mySQL</td>
          <td>Running</td>
          <td><?php echo extension_loaded('pdo_mysql') ? 'Running' : 'Not Running'; ?></td>
          <td><?php echo extension_loaded('pdo_mysql') ? '<span style="color:green;"><strong>OK!</strong></span>' : '<span style="color:red;"><strong>IS pdo_mysql RUNNING?</strong></span>'; ?></td>
        </tr>
        
        <tr>
          <td>libs/database.php</td>
          <td>Writable (0777)</td>
          <td><?php echo is_writable('libs/database.php') ? 'Writable' : 'Unwritable'; ?></td>
          <td><?php echo is_writable('libs/database.php') ? '<span style="color:green;"><strong>OK!</strong></span>' : '<span style="color:red;"><strong>FILE IS NOT WRITABLE! FIX FILE PERMISSIONS</strong></span>'; ?></td>
        </tr>

        <tr>
            <td>cache/</td>
            <td>Writable (0777)</td>
            <td><?php echo is_writable('cache/') ? 'Writable' : 'Unwritable'; ?></td>
            <td><?php echo is_writable('cache/') ? '<span style="color:green;"><strong>OK!</strong></span>' : '<span style="color:red;"><strong>FILE IS NOT WRITABLE! FIX FILE PERMISSIONS</strong></span>'; ?></td>
        </tr>

        <tr>
            <td>templates_c/</td>
            <td>Writable (0777)</td>
            <td><?php echo is_writable('templates_c/') ? 'Writable' : 'Unwritable'; ?></td>
            <td><?php echo is_writable('templates_c/') ? '<span style="color:green;"><strong>OK!</strong></span>' : '<span style="color:red;"><strong>FILE IS NOT WRITABLE! FIX FILE PERMISSIONS</strong></span>'; ?></td>
        </tr>
        
        
      </tbody>
    </table>
  
  <center>
  <form action="install.php?step=1" method="post">
   <input type="hidden" name="pre_error" id="pre_error" value="<?php echo $pre_error;?>" />
   <input type="submit" class="btn-primary btn" name="continue" value="Continue" />
  </form>
  </center>
<?php
}
function step_2(){
  if (isset($_POST['submit']) && $_POST['submit']=="Install!") {
   $database_host=isset($_POST['database_host'])?$_POST['database_host']:"";
   $database_name=isset($_POST['database_name'])?$_POST['database_name']:"";
   $database_username=isset($_POST['database_username'])?$_POST['database_username']:"";
   $database_password=isset($_POST['database_password'])?$_POST['database_password']:"";
   $sitename=isset($_POST['sitename'])?$_POST['sitename']:"";
   $siteurl=isset($_POST['siteurl'])?$_POST['siteurl']:"";
  
  if (empty($database_host) || empty($database_username) || empty($database_name)) {
   echo "All fields are required! Please re-enter.<br />";
  } else {
      $connection = new PDO("mysql:host=".$database_host.";dbname=".$database_name."", $database_username, $database_password);

   $connection->query("CREATE TABLE IF NOT EXISTS `cookieReferral` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referralID` text NOT NULL,
  `views` text NOT NULL,
  `userIP` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;");

      $connection->query("CREATE TABLE IF NOT EXISTS `referralIP` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userIP` text NOT NULL,
  `referralID` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;");

      $connection->query("CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `sitename` text NOT NULL,
  `siteurl` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;");

      $connection->query("INSERT INTO settings (sitename, siteurl) VALUES ('{$sitename}', '{$siteurl}')");

   $f=fopen("libs/database.php","w");
   $database_file="<?php
define('dbhost', '".$database_host."');
define('dbname', '".$database_name."');
define('dbuser', '".$database_username."');
define('dbpass', '".$database_password."');
?>";
  if (fwrite($f,$database_file)>0){
   fclose($f);
  }
  header("Location: install.php?step=3");
  }
  }
?>



<div class="well">
<form method="post" class="form-horizontal" role="form" action="install.php?step=2">

  <div class="form-group">
    <label for="input1" class="col-sm-3 control-label">Database Host</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="database_host" id="input1">
    </div>
  </div>
  
  <div class="form-group">
    <label for="input2" class="col-sm-3 control-label">Database Name</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="database_name" id="input2" >
    </div>
  </div>
  
  <div class="form-group">
    <label for="input3" class="col-sm-3 control-label">Database Username</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="database_username" id="input3">
    </div>
  </div>
  
  <div class="form-group">
    <label for="input4" class="col-sm-3 control-label">Database Password</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="database_password" id="input4">
    </div>
  </div>
  
  <br><br>
  
  <div class="form-group">
    <label for="input5" class="col-sm-3 control-label">Site Name</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="sitename" id="input5">
    </div>
  </div>
  
  <div class="form-group">
    <label for="input6" class="col-sm-3 control-label">Site URL</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="siteurl" value="<?='http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);?>" id="input6">
    </div>
  </div>
 
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
      <input type="submit" class="btn btn-primary" name="submit" value="Install!">
    </div>
  </div>
</form>
</div>
<?php
}
function step_3(){
?>
 <div class="well">
 <center><h4>Installation Complete!</h4><br>Please DELETE this install.php file <br><br><br> <a href="<?='http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);?>">View my Site >></a> </center>
<?php 
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Installation</title>
<link href='http://fonts.googleapis.com/css?family=Lato:300,700,300italic' rel='stylesheet' type='text/css'>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container-fluid">
	<div class="row">
    <center><h2>ViralTrafficScript Installation</h2></center>
    <br><br>
		<div class="col-md-3"></div>
        <div class="col-md-6">
        
        
<?php
$step = (isset($_GET['step']) && $_GET['step'] != '') ? $_GET['step'] : '';
switch($step){
  case '1':
  step_1();
  break;
  case '2':
  step_2();
  break;
  case '3':
  step_3();
  break;
  case '4':
  step_4();
  break;
  default:
  step_1();
}
?>
		</div>
		<div class="col-md-3"></div>
    </div>
    </div>
<body>