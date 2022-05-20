<?php
namespace CMSLite;
use CMSLite\Database;
use CMSLite\Translate;
use CMSLite\Mailer;

class User{

    public static function register($username, $password, $email){
        if(ENABLE_REGISTER === false){
            User::setMsg([Translate::text('disabled_register'), 'failed']);
            return false;
        }

        if(ENABLE_MAX_ACCOUNTS_PER_EMAIL === true){
            $countEmails = Database::count("SELECT email FROM ".ACCOUNT_DB.".account WHERE email = :EMAIL", [
                ":EMAIL" => $email
            ]);

            if($countEmails >= MAX_ACCOUNTS_PER_EMAIL){
                User::setMsg([Translate::text('err_max_account_email'), 'failed']);
                return false;
            }
        }
       
        $result = Database::count("SELECT login FROM ".ACCOUNT_DB.".account WHERE login = :USERNAME", [
            ":USERNAME" => $username
        ]);
        
        if($result > 0){
            User::setMsg([Translate::text('username_not_avail'), 'failed']);
            return false;
        }else{
            $result = Database::count("INSERT INTO ".ACCOUNT_DB.".account (login, password, email, create_time, register_ip) VALUES (:USERNAME, :PASSWORD, :EMAIL, NOW(), :IP)",[
                ":USERNAME" => $username,
                ":PASSWORD" => hashPassword($password),
                ":EMAIL" => $email,
                ":IP" => $_SERVER['REMOTE_ADDR']
            ]);

            if($result > 0){
                User::setMsg([Translate::text('success_register'), 'success']);
                return true;
            }else{
                //??
                User::setMsg([Translate::text('generic_err_register'), 'failed']);
                return false;
            }
        }
    }

    public static function login($username, $password){
        if(BLOCK_LOGIN_SITE_USER_BAN === true){
            $getBanTime = Database::select("SELECT status, availDt FROM ".ACCOUNT_DB.".account WHERE login = :LOGIN", [
                ":LOGIN" => $username
            ]);

            //@fix - error invalid-user
            if(empty($getBanTime)){
                User::setMsg([Translate::text('generic_login_err'), 'failed']);
                return false;
            }

            if($getBanTime[0]['status'] == 'BAN'){
                User::setMsg([Translate::text('cant_login_user_banned2'), 'failed']);
                return false;
            }

            $banTimestamp = strtotime($getBanTime[0]['availDt']);
            $currentTimestamp = (new \DateTime())->getTimestamp();

            if($banTimestamp > $currentTimestamp){
                
                $waitTime = (new \DateTime($getBanTime[0]['availDt']))->format('d/m/Y H:i:s');

                User::setMsg([Translate::text('cant_login_user_banned2'."$waitTime"), 'failed']);
                return false;
            }
        }
        
        $result = Database::select("SELECT id, login, password FROM ".ACCOUNT_DB.".account WHERE login = :LOGIN", [
            ":LOGIN" => $username
        ]);

        if(count($result) > 0){
            if($result[0]['password'] !== hashPassword($password)){

                User::setMsg([Translate::text('generic_login_err'), 'failed']);
                return false;
                
            }else{
                //Let's Login!
                $_SESSION['id'] = $result[0]['id'];
                $_SESSION['username'] = $result[0]['login'];
                return true;
            }
        }else{
            User::setMsg([Translate::text('generic_login_err'), 'failed']);
            return false;
        }
    }

    //Verifica se o ID conectado pertence ao usuário.
    public static function isUserId(){
        $result = Database::count("SELECT id, login FROM ".ACCOUNT_DB.".account WHERE id = :ID and login = :LOGIN", [
            ":ID" => $_SESSION['id'],
            ":LOGIN" => $_SESSION['username']
        ]);

        if($result > 0){
            return true;
        }

        return false;
    }

    public static function isUserEmail($email){
        $result = Database::count("SELECT email FROM ".ACCOUNT_DB.".account WHERE id = :ID AND login = :LOGIN AND email = :EMAIL", [
            ":ID" => $_SESSION['id'],
            ":LOGIN" => $_SESSION['username'],
            ":EMAIL" => $email
        ]);

        if($result > 0){
            return true;
        }

        return false;
    }

    public static function isUserPassword($userPassword){
        $result = Database::count("SELECT password FROM ".ACCOUNT_DB.".account WHERE id = :ID AND login = :LOGIN AND password = :PASSWORD", [
            ":ID" => $_SESSION['id'],
            ":LOGIN" => $_SESSION['username'],
            ":PASSWORD" => hashPassword($userPassword)
        ]);

        if($result > 0){
            return true;
        }

        return false;
    }

    public static function isValidLogin(){
        if(empty($_SESSION['id']) || !isset($_SESSION['id']) || !(int)$_SESSION['id'] 
        || empty($_SESSION['username']) || !isset($_SESSION['username']) || !(string)$_SESSION['username'] 
        || !self::isUserId()){
            self::logout();
        }

        return true;
    }

    public static function isAdmin(){
        $result = Database::select("SELECT web_admin FROM ".ACCOUNT_DB.".account WHERE id = :ID AND login = :LOGIN", [
            ":ID" => $_SESSION['id'],
            ":LOGIN" => $_SESSION['username']
        ]);

        if($result[0]['web_admin'] !== 1){
            return false;
        }
        return true;
    }

    public static function logout(){
        session_destroy();
        header("Location: /");
        exit;
    }

    public static function goHome(){
        header("Location: /");
        exit;
    }

    public static function setMsg($msg = array()){
        $_SESSION['msg'] = $msg;
    }

    public static function getMsg(){
        $msg = (isset($_SESSION['msg'])) ? $_SESSION['msg'] : '';
        self::clearMsg();

        return $msg;
    }

    public static function clearMsg(){
        $_SESSION['msg'] = null;
    }

    public static function changeEmail($newEmail){
        $result = Database::count("UPDATE ".ACCOUNT_DB.".account SET email = :NEWEMAIL WHERE id = :ID AND login = :LOGIN", [
            ":NEWEMAIL" => $newEmail,
            ":ID" => $_SESSION['id'],
            ":LOGIN" => $_SESSION['username']
        ]);

        if($result > 0){
            User::setMsg([Translate::text('success_change_email'), "success"]);
            return true;
        }

        User::setMsg([Translate::text('generic_err_change_email'), "failed"]);
        return false;
    }

    public static function changePassword($newPassword){
        $result = Database::count("UPDATE ".ACCOUNT_DB.".account SET password = :NEWPASSWORD WHERE id = :ID AND login = :LOGIN", [
            ":NEWPASSWORD" => hashPassword($newPassword),
            ":ID" => $_SESSION['id'],
            ":LOGIN" => $_SESSION['username']
        ]);

        if($result > 0){
            User::setMsg([Translate::text('success_change_password'), "success"]);
            return true;
        }

        User::setMsg([Translate::text('generic_err_change_password'), "failed"]);
        return false;
    }

    public static function getCharacters(){
        $result = Database::select("SELECT id, name, level FROM ".PLAYER_DB.".player WHERE account_id = :ID", [
            ":ID" => $_SESSION['id']
        ]);

        if(count($result) == 0){
            User::setMsg([Translate::text('no_characters_found'), 'failed']);
            return false;
        }

        return $result;
    }
    
    public static function moveCharacter($id){
        $canMove = Database::count("SELECT id FROM ".PLAYER_DB.".player WHERE id = :ID AND account_id = :ACCOUNT_ID",[
            ":ID" => (int)$id,
            ":ACCOUNT_ID" => $_SESSION['id']
        ]);

        if($canMove > 0){
            $result = Database::select("SELECT empire FROM ".PLAYER_DB.".player_index WHERE id = :ID", [
                ":ID" => $_SESSION['id']
            ]);
    
            $empire = $result[0]['empire'];
    
            if($empire === 1){
                $map_index = 1;
                $x = 468779;
                $y = 962107;
            }elseif($empire === 2){
                $map_index = 21;
                $x = 55700;
                $y = 157900;
            }elseif($empire === 3){
                $map_index = 41;
                $x = 969066;
                $y = 278290;
            }
    
            $move = Database::count("UPDATE ".PLAYER_DB.".player SET x = :X, y = :Y, map_index = :MAP_INDEX WHERE id = :ID",[
                ":X" => $x,
                ":Y" => $y,
                ":MAP_INDEX" => $map_index,
                ":ID" => (int)$id
            ]);
    
            if($move > 0){
                User::setMsg([Translate::text('character_moved'), "success"]);
                return true;
            }
        }else{
            User::setMsg([Translate::text('no_character_moved'), "failed"]);
            return false;
        }

        User::setMsg([Translate::text('character_in_town'), "failed"]);
        return false;
    }

    public static function recoverPassword($user, $mail, $mailContent, $newPassword){
        $check = Database::count("SELECT login, email FROM ".ACCOUNT_DB.".account WHERE login = :LOGIN AND email = :MAIL",[
            ":LOGIN" => $user,
            ":MAIL" =>$mail,
        ]);

        if($check > 0){
            //Update account password
            $queryPassword = Database::count("UPDATE ".ACCOUNT_DB.".account SET password = :NEWPW WHERE login = :LOGIN AND email = :MAIL", [
                ":NEWPW" => hashPassword($newPassword),
                ":LOGIN" => $user,
                ":MAIL" => $mail
            ]);

            if($queryPassword > 0){
                //Send email with new password
                $mail = new Mailer($mail, $user, Translate::text('title_new_password'), $mailContent);

                return $mail;
            }else{
                User::setMsg([Translate::text('fail_to_update_new_pass'), 'failed']);
                return false;
            }

        }else{
            User::setMsg([Translate::text('notfound_user_email'), 'failed']);
            return false;
        }
    }

    public static function sendSocialID($socialID, $mailContent){
        $userEmail = Database::select("SELECT email FROM ".ACCOUNT_DB.".account WHERE id = :ID AND login = :LOGIN", [
            ":ID" => $_SESSION['id'],
            ":LOGIN" => $_SESSION['username']
        ]);

        if(count($userEmail) == 0){
            User::setMsg([Translate::text('failed_to_get_user_email'), 'failed']);
            return false;
        }

        $result = Database::count("UPDATE ".ACCOUNT_DB.".account SET social_id = :SID WHERE id = :ID AND login = :LOGIN",[
            ":SID" => $socialID,
            ":ID" => $_SESSION['id'],
            ":LOGIN" => $_SESSION['username']
        ]);

        if($result > 0){
            $mail = new Mailer($userEmail[0]['email'], $_SESSION['username'], Translate::text('title_social_id'), $mailContent);
            
            return $mail;
        }
        else{
            User::setMsg([Translate::text('fail_to_update_new_pass'), 'failed']);
            return false;
        }
    }   

    public static function sendWarehousePW($warehousePW, $mailContent){
        $userEmail = Database::select("SELECT email FROM ".ACCOUNT_DB.".account WHERE id = :ID AND login = :LOGIN", [
            ":ID" => $_SESSION['id'],
            ":LOGIN" => $_SESSION['username']
        ]);

        if(count($userEmail) == 0){
            User::setMsg([Translate::text('failed_to_get_user_email'), 'failed']);
            return false;
        }

        $result = Database::count("UPDATE ".PLAYER_DB.".safebox SET password = :PW WHERE account_id = :ID", [
            ":PW" => $warehousePW,
            ":ID" => $_SESSION['id']
        ]);

        if($result > 0){
            $mail = new Mailer($userEmail[0]['email'], $_SESSION['username'], Translate::text('title_warehouse_pw'), $mailContent);

            return $mail;
        }else{
            User::setMsg([Translate::text('fail_to_update_new_pass'), 'failed']);
            return false;
        }
    }
}