<?php
namespace CMSLite;

use CMSLite\Database;

class Statistics{

    public static function getOnlinePlayers($port){

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        if(!$socket){
            echo 'Definição inválida do socket.';
            return false;
        }

        $conn = socket_connect($socket, ADMINPAGE_IP, $port);

        if(!$conn)
        {
            echo "Connection Error. Error : ".socket_strerror($conn);
            return false;
        }

        $string = "@USER_COUNT\n";

        $stringResult = socket_write($socket, $string, strlen($string));

        if(!$stringResult){
            echo "ERROR: ".socket_strerror($stringResult);
            return false;
        }

        $result = socket_recv($socket, $total, 256, 0);

        $total = trim($total);
        $total = explode(' ', $total);

        //$count[0] = users on channel online
	    //$count[1] = users in red kingdom online
	    //$count[2] = users in yellow kingdom online
	    //$count[3] = users in blue kingdom online
	    //$count[4] = users on core online

        socket_close($socket);

        return $total[1] + $total[2] + $total[3];
    }

    public static function getFinalOnlinePlayers(){

        $total = 0;

        foreach (GAME_PORTS as $port) {
           $total += self::getOnlinePlayers($port);
        }

        return $total;
    }

    public static function getStatistics($interval = 24){
        $playersIn24h = Database::count('SELECT * FROM '.PLAYER_DB.'.player WHERE DATE_SUB(NOW(), INTERVAL :INTERVAL HOUR) < last_play', [
            ":INTERVAL" => $interval
        ]);
        $totalAccount = Database::count('SELECT * FROM '.ACCOUNT_DB.'.account');
        $totalCharacters = Database::count('SELECT * FROM '.PLAYER_DB.'.player');
        $totalGuilds = Database::count('SELECT * FROM '.PLAYER_DB.'.guild');

        if(!USE_REAL_TIME_ONLINE_PLAYERS){
            $onlinePlayers = Database::count('SELECT * FROM '.PLAYER_DB.'.player WHERE DATE_SUB(NOW(), INTERVAL :INTERVAL MINUTE) < last_play', [
                ":INTERVAL" => 5
            ]);
        }else{
            $onlinePlayers = self::getFinalOnlinePlayers();
        }

        return [
            "playersOnlineNow" => $onlinePlayers,
            "playersOnlineIn24h" => $playersIn24h,
            "totalAccount" => $totalAccount,
            "totalCharacters" => $totalCharacters,
            "totalGuilds" => $totalGuilds
        ];
    }
}