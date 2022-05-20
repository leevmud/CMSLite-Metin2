<?php
namespace CMSLite;

use CMSLite\Database;
use CMSLite\User;
use CMSLite\Translate;

class Admin{

    public static function banAccount($login, $banTime){
        $isBan = Database::select("SELECT status, availDt FROM ".ACCOUNT_DB.".account WHERE login = :LOGIN", [
            ":LOGIN" => $login
        ]);

        if($isBan[0]['status'] === 'BAN'){
            //Desbloqueio da conta
            $unBann = Database::count("UPDATE ".ACCOUNT_DB.".account SET status = 'OK' WHERE login = :LOGIN", [
                ":LOGIN" => $login
            ]);

            if($unBann > 0){
                User::setMsg([Translate::text('user_unbanned'), 'success']);
                return true;
            }else{
                User::setMsg([Translate::text('err_unbann_user'), 'failed']);
                return false;
            }

        }elseif($isBan[0]['status'] === 'OK' && $banTime === 0){
            //Bloqueio permanente da conta
            $permBanUser = Database::count("UPDATE ".ACCOUNT_DB.".account SET status = 'BAN' WHERE login = :LOGIN", [
                ":LOGIN" => $login
            ]);

            if($permBanUser > 0){
                User::setMsg([Translate::text('user_perma_ban'), 'success']);
                return true;
            }else{
                User::setMsg([Translate::text('err_user_perma_ban'), 'failed']);
                return false;
            }
        }elseif($isBan[0]['status'] === 'OK' && $banTime !== 0){
            //Bloqueio temporario
            $tempBanUser = Database::count("UPDATE ".ACCOUNT_DB.".account SET availDt = :TIME WHERE login = :LOGIN", [
                ":LOGIN" => $login,
                ":TIME" => $banTime
            ]);

            if($tempBanUser > 0){
                User::setMsg([Translate::text('user_temp_ban'), 'success']);
                return true;
            }else{
                User::setMsg([Translate::text('err_user_perma_ban'), 'failed']);
                return false;
            }
        }

        User::setMsg([Translate::text('generic_err_user_ban'), 'failed']);
        return false;

    }

    public static function userExist($login){
        $result = Database::count("SELECT login FROM ".ACCOUNT_DB.".account WHERE login = :LOGIN", [
            ":LOGIN" => $login
        ]);
        
        if($result > 0){
            return true;
        }

        return false;
    }

    public static function insertCoins($login, $coins){
        $result = Database::count("UPDATE ".ACCOUNT_DB.".account SET ".COINS." = ".COINS." + :QTD WHERE login = :LOGIN", [
            ":LOGIN" => $login,
            ":QTD" => $coins
        ]);
        
        if($result > 0){
            User::setMsg([number_format($coins).Translate::text('coins_added')."$login", 'success']);
            return true;
        }

        User::setMsg([Translate::text('err_add_coins'), 'failed']);
        return false;
    }

}