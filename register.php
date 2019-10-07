<?php
#################################################################################
##                                                                             ##
##              -= YOU MUST NOT REMOVE OR CHANGE THIS NOTICE =-                ##
##                                                                             ##
## --------------------------------------------------------------------------- ##
##                                                                             ##
##  Project:       Travian 4 Vn stable build                                   ##
##  Version:       2012.11.01                                                  ##
##  Filename:      index.php                                                   ##
##  Developed by:  Advocaite                                                   ##
##  Little changes by:  dzoki                                                  ##
##  License:       Creative Commons BY-NC-SA 3.0                               ##
##  Copyright:     Travian 4 Vn (c) 2011 - All rights reserved                 ##
##  URLs:          http://extreemgaming.com                                    ##
##  Source code:   Private                                                     ##
##                                                                             ##
#################################################################################
//error reporting
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
ob_start(); 

define('INSIDE',true);
$ugamela_root_path = './';
require_once($ugamela_root_path . 'extension.inc');
require_once($ugamela_root_path . 'includes/db_connect.php'); 
require_once($ugamela_root_path . 'includes/common.'.$phpEx);
//mock register for auth system  by advocaite
//what this file dose is registers the user name and passwords to one table
// and email username and other stuff to profile the custermer id is important 
//skype:advocaite
//sanitise the inputs before you release
//also make sure this db conection points to the auth db sql file in release
global $lang, $user;

if (check_user())
    {
    header ("Location: village1.php");
    }

includeLang ('index_register');
$parse=$lang;
$parse['news_list_1'] = load_list_news();
// $parse['fb_like_box'] = load_facebook_box();
//set all errors blank
$parse['error1'] = "";
$parse['error2'] = "";
$parse['error3'] = "";  
$parse['error4'] = "";  
$parse['error5'] = "";
$parse['error6'] = "";
$parse['error7'] = ""; 
$parse['account_created'] = "";   
if (count($_POST) <> 0 )
{
if (empty($_POST["username"]))
    {
        $parse['error1']   = $lang['register_error1'];
    }else if( checkIfExists('username',$_POST['username']) ){
        $parse['error1'] = $lang['register_error8'];
    }else if (empty($_POST["email"]))
    {
        $parse['error2'] = $lang['register_error2'];
    }else if( !preg_match("/^.+?@.+?\..+?/i",$_POST['email']) ){
        $parse['error2'] = $lang['register_error11'];
    }else if (empty($_POST["email2"]))
    {
        $parse['error3'] = $lang['register_error3'];
    } else if( !preg_match("/^.+?@.+?\..+?/i",$_POST['email2']) ){
        $parse['error3'] = $lang['register_error11'];  
    } else if( $_POST['email'] != $_POST['email2'] ){
        $parse['error3'] = $lang['register_error12'];
    }  else if (empty($_POST["password"]))
    {
        $parse['error4'] = $lang['register_error4'];
    } else  if (empty($_POST["confirmpassword"]))
    {
        $parse['error5'] = $lang['register_error5'];
    } else if( $_POST['password'] != $_POST['confirmpassword'] ){
        $parse['error5'] = $lang['register_error10'];
    } else if(!$_POST['agb'])
     {
      $parse['error6'] = $lang['register_error13'];
     } else {
         //do register stuff
         if (!get_magic_quotes_gpc())
        {
            $username = str_replace('$', '\$', addslashes($_POST["username"]));
            $password = str_replace('$', '\$', addslashes($_POST["password"]));
            $email = str_replace('$', '\$', addslashes($_POST["email"]));
        
        }
        else
        {
            $username = str_replace('$', '\$', $_POST["username"]);
            $password = str_replace('$', '\$', $_POST["password"]);
            $email = str_replace('$', '\$', $_POST["email"]);
        }
        $username = $db->getEscaped($username);
        $password = $db->getEscaped($password);
        $email = $db->getEscaped($email);
        $password_md5 = md5($password);
        $timenow = time();
        $referrerID = 0;
        $regip = $_SERVER['REMOTE_ADDR'];
        $uniqueLink = rand(1222222,9999999);
        $actkey = rand(1222222,9999999);

         $sql         =
       "INSERT INTO auth SET username='$username',password='$password_md5',refID='$referrerID' ,uniqueLink='$uniqueLink'";
    $db->setQuery($sql);

    if (!$db->query())
    {
        globalError2 ('function InsertAuth:' . $sql);
    }
    $customerID = mysql_insert_id();
    $sql         =
       "INSERT INTO profiles SET customerid='$customerID',email='$email',username='$username',actkey='$actkey'";
    $db->setQuery($sql);

    if (!$db->query())
    {
        globalError2 ('function InsertAuth2:' . $sql);
    }
     $parse['account_created'] = $lang['account_created2'];
     }
    
}
  
$page           =parsetemplate(gettemplate('index_register'), $parse);
display3($page, $lang['title']);

function load_list_news()
{
    global $db, $game_config, $lang;
    includeLang('login');

    //lay news tu database
    $sql = " SELECT intro_text, url FROM `wg_news` ORDER BY date_create  DESC LIMIT 1";
    $db->setQuery($sql);
    $array_news = null;
    $array_news = $db->loadObjectList();

    if ($array_news == null)
        return $listnews = 'No News';

    $i = 0;

    foreach ($array_news as $news)
    {
        $parse['Stt']    = ++$i;
        $parse['news']   = $news->intro_text;
        $parse['url']    = $news->url;
        $parse['detail'] = $lang['news2'];
        $listnews .= parsetemplate(gettemplate('news_login'), $parse);
    }

    return $listnews;
}

function checkIfExists($field,$value) {
    $sql = mysql_query("SELECT * FROM auth WHERE $field='$value'");
    
    if( mysql_num_rows($sql) > 0 ) {
        return true;
    } else {
        return false;
    }
}

 /*if(isset($_POST['submit'])) {
    if( !$_POST['username'] ){
        $error = "You did not enter a username";
    } else if( checkIfExists('username',$_POST['username']) ){
        $error = "Username already taken.";
    } else if( empty($_POST['password']) ){
        $error = "You did not enter a password.";
    } else if( $_POST['password'] != $_POST['confirmpassword'] ){
        $error = "The passwords you gave do not match.";
    } else if( !$_POST['email'] ){
        $error = "You did not give a username.";
    } else if( $_POST['email'] != $_POST['email2'] ){
        $error = "Email addresses do not match";
    } else if( !preg_match("/^.+?@.+?\..+?/i",$_POST['email']) ){
        $error = "Please enter a valid email address, in the correct format.";
    } else {
        
         
    
    }
}      */



?> 	
 

             

                