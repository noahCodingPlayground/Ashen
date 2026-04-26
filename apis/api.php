<?php

header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();

define('BASE_PATH',realpath(__DIR__ . '/../../'));
include_once BASE_PATH . '/env.php';
include_once BASE_PATH . '/config.php';
include_once BASE_PATH . '/api/utilities.php';

if (isset($_REQUEST['f']) && !empty($_REQUEST['f'])){
    if (__FILE__ ==realpath($_SERVER['SCRIPT_FILENAME'])){
        $requestedFunction = $_REQUEST['f'];
        unset($_REQUEST['f']);

        if(!util_security_isuserfctn(['f'=>$requestedFunction])){
            die("API function not recognized.");
        }
        if(!function_exists($requestedFunction)){
            die("API function not recognized.");
        }

        call_user_func($requestedFunction,$_REQUEST);
        exit;
    }
}

//uwu
function validateAccount($data){
    $mysqli=util_db_conn();
    if(!$mysqli){
        echo "db error";
        return;
    }
    if (empty($data['username']) || empty($data['password']) || empty($data['licenseKey'])){
        echo "missing parameters";
        return;
    }

    $username = trim($data['username']);
    $password=$data['password'];
    $licenseKey = trim($data['licenseKey']);

    $stmt=$mysqli->prepare(
        "SELECT password, licenseKey
        FROM ashenLicenses
        WHERE username = ?
        LIMIT 1"
    );
    if (!$stmt){
        echo"invalid account";
        return;
    }

    $stmt->bind_param("s",$username);
    $stmt->execute();
    $stmt->bind_result($storedPassword,$storedLicense);

    if(!$stmt->fetch()){
        echo "invalid account";
        $stmt->close();
        return;
    }
    $stmt->close();

    if($password!==$storedPassword){
        echo"wrong password";
        return;
    }
    if ($licenseKey!==$storedLicense){
        echo"invalid license";
        return;    
    }
    echo"success";
}

function sendVerificationEmail($data){
    $mysqli=util_db_conn();
    if(!$mysqli){
        echo"db error";
        return;
    }
    if(
        empty($data['username'])
    ){
        echo"missing params";
        return;
    }

    $username=trim($data['username']);

    $stmt=$mysqli->prepare(
        "SELECT email
        FROM ashenLicenses
        WHERE username = ?
        LIMIT 1"
    );

    if(!$stmt){
        echo"invalid account";
        return;
    }

    $stmt->bind_param("s",$username);
    $stmt->execute();
    $stmt->bind_result($storedEmail);
    if (!$stmt->fetch()){
        echo"invalid account";
        $stmt->close();
        return;
    }

    $stmt->close();

    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $code = '';
    for ($i = 0; $i < 8; $i++){
        $code .= $characters[random_int(0, strlen($characters) - 1)];
    }

    $stmt=$mysqli->prepare(
        "UPDATE ashenLicenses
        SET verifyCode = ?
        WHERE username = ?"
    );

    if (!$stmt){
        echo"server error";
        return;
    }

    $stmt->bind_param("ss",$code,$username);
    $stmt->execute();
    $stmt->close();

    util_mail_send([
        'to' => $storedEmail,
        'subject' => 'Ashen Verification Code',
        'body' => 'Your verification code is: ' . $code
    ]);

    echo "success";
}

function verifyCode($data){
    $mysqli=util_db_conn();
    if(!$mysqli){
        echo"db error";
        return;
    }
    if (
        empty($data['username'])||empty($data['verifyCode'])
    ){
        echo"missing params";
        return;
    }

    $username=trim($data['username']);
    $inputCode=trim($data['verifyCode']);

    $stmt=$mysqli->prepare(
        "SELECT verifyCode
        FROM ashenLicenses
        WHERE username = ?
        LIMIT 1"
    );
    if (!$stmt){
        echo"invalid account";
        return;
    }

    $stmt->bind_param("s",$username);
    $stmt->execute();
    $stmt->bind_result($storedCode);

    if (!$stmt->fetch()){
        echo"invalid account";
        $stmt->close();
        return;
    }
    $stmt->close();

    if(empty($storedCode)){
        echo"no code set";
        return;
    }
    if ($inputCode!==$storedCode){
        echo"invalid code";
        return;
    }

    $stmt=$mysqli->prepare(
        "UPDATE ashenLicenses
        SET verifyCode = ''
        WHERE username = ?"
    );

    if (!$stmt){
        echo"server error";
        return;
    }
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $stmt->close();

    echo"success";
}

?>