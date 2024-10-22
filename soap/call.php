<?php
include ('config_auth_remote.php');
/**
* Acitve by remote to billing system
* @param: $username-> username want to active
* @param: $code of username
* @return: true or false. true if actived else false.
*/
function xGo_Update_Status($username)
{
    global $auth_remote;
    $wsdl = $auth_remote["url_xgo"];

}

function check_url($url)
{
    $options=array
        (
        CURLOPT_RETURNTRANSFER => true,            // return web page 
        CURLOPT_HEADER         => false,           // don't return headers
        CURLOPT_FOLLOWLOCATION => true,            // follow redirects 
        CURLOPT_ENCODING       => "",              // handle all encodings 
        CURLOPT_USERAGENT      => "http://yourdomain.com", // who am i 
        CURLOPT_AUTOREFERER    => true,            // set referer on redirect 
        CURLOPT_CONNECTTIMEOUT => 120,             // timeout on connect 
        CURLOPT_TIMEOUT        => 120,             // timeout on response 
        CURLOPT_MAXREDIRS      => 10,              // stop after 10 redirects 
        CURLOPT_SSL_VERIFYPEER => false,           // Turn off ssl verify 
        );

    $ch=curl_init($url);
    curl_setopt_array($ch, $options);
    $content          =curl_exec($ch);
    $err              =curl_errno($ch);
    $errmsg           =curl_error($ch);
    $header           =curl_getinfo($ch);
    curl_close ($ch);
    $header['errno']  =$err;
    $header['errmsg'] =$errmsg;
    $header['content']=$content;
    return $header;
}

function active_remote($username, $code)
{
    $user=get_profile($username);

    if (is_array($user))
    {
        $customerID=$user['customerid'];
        return (md5($customerID) == $code);
    }

    return false;
}

/**
* Login by remote to billing system
* @param: $user username want login
* @param: $pass pass of username
* @return: true or false. true if login success, else false.
*/
function login_remote($user, $pass)
{
    global $db;
    $sql =
        "SELECT * FROM auth WHERE username='$user' AND `password`='$pass'";
    $db->setQuery($sql);
    $logincheck=$db->loadAssocList();
//var_dump($logincheck);
    $login=json_encode($logincheck);
    return is_array(json_decode($login, true));

    echo '<pre>';
    print_r (json_decode($login, true));
    echo get_email_remote($user);
    die();
}

function get_profile($user)
{
    global $db;
//var_dump($user);
    $sql =
        "SELECT * FROM `profiles` WHERE username='$user'";
    $db->setQuery($sql);
    $getProfile=$db->loadAssocList();
//var_dump($getProfile);
    return json_encode($getProfile, true);

    echo '<pre>';
    print_r (json_decode($getProfile));
    die();
}

/**
* Get money form billing system
* @param: $user username want get
* @return: total money of user if login success, else return -1.
*/
function get_gold_remote($user)
{
    global $db;
    $customerID=get_customerid($user);
    $sql       ="SELECT asu FROM wg_plus_xgo WHERE customerid='" . $customerID . "'";
    $db->setQuery($sql);
    $asu=$db->loadResult();
    return $asu == NULL ? 0 : $asu;
}

/**
* Withdraw money form billing system
* @param: $user username want withdraw
* @param: $gold money withdraw
* @return: total money of user after withdraw if login success, else return false.
*/
function withdraw_gold_remote($user, $gold, $des)
{
    global $db;
    $customerID=get_customerid($user);
    $sql       ="UPDATE wg_plus_xgo SET asu=asu-'" . $gold . "' WHERE customerid=" . $customerID;
    $db->setQuery($sql);
    $db->query();
}

/**
* get email form billing system
* @param: $user username want get email
* @return: email if true, else return false.
*/
function get_email_remote($user)
{
    $userProFile=get_profile($user);

    if (is_array($userProFile)) return $userProFile['email'];

    return "";
}

function get_customerid($user)
{
    $userProFile=get_profile($user);

    if (is_array($userProFile)) return $userProFile['customerid'];

    return "";
}

/**
* get phone form billing system
* @param: $user username want get phone
* @return: phone if true, else return false.
*/
function get_phone_remote($username)
{
    global $db;
    $sql="SELECT phone FROM wg_profiles WHERE username='" . $username . "'";
    $db->setQuery($sql);
    $phone=$db->loadResult();
    return $phone;
}

function InsertLogPlus($userId, $des, $asu)
{
    global $db, $user;
    include_once ('./includes/function_plus.php');
    $asu_bill=get_gold_remote($user['username']); //lay ASU tu buildling systems
    $asu_game=showGold($user['id']);              //lay asu tu game

    $sql     ="SELECT logs FROM wg_plus WHERE user_id=" . $userId;
    $db->setQuery($sql);
    $char=NULL;

    if ($asu_game >= $asu)
    {
        $char = $db->loadResult() . date("H:i d-m-y") . ',1,' . $des . ',' . $asu . ';';
    }
    else
    {
        if ($asu_game + $asu_bill >= $asu)
        {
            $char = $db->loadResult() . date("H:i d-m-y") . ',2,' . $des . ',' . $asu . ';';
        }
    }

    $sql="UPDATE wg_plus SET logs='" . $char . "' WHERE user_id=" . $userId;
    $db->setQuery($sql);
    $db->query();

    $datetime=date("y-m-d H:i:s");
    $sql     ="INSERT INTO wg_gold_logs (`datetime` ,`description`) VALUES ('$datetime', '$des')";
    $db->setQuery($sql);
    $db->query();
}