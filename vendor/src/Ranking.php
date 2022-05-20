<?php
namespace CMSLite;

use CMSLite\Database;

class Ranking{

    public static function getTop1(){

        if(LYCAN === true){
            $lycan = Database::select('SELECT name, job, level FROM '.PLAYER_DB.'.player WHERE job = 8 AND player.name NOT LIKE "[%]%" ORDER BY level DESC, playtime DESC LIMIT 1');
        }
        
        $warrior = Database::select('SELECT name, job, level FROM '.PLAYER_DB.'.player WHERE job IN (0, 4) AND player.name NOT LIKE "[%]%" ORDER BY level DESC, playtime DESC LIMIT 1');
        $assassin = Database::select('SELECT name, job, level FROM '.PLAYER_DB.'.player WHERE job IN (1, 5) AND player.name NOT LIKE "[%]%" ORDER BY level DESC, playtime DESC LIMIT 1');
        $sura = Database::select('SELECT name, job, level FROM '.PLAYER_DB.'.player WHERE job IN (2, 6) AND player.name NOT LIKE "[%]%" ORDER BY level DESC, playtime DESC LIMIT 1');
        $shaman = Database::select('SELECT name, job, level FROM '.PLAYER_DB.'.player WHERE job IN (3, 7) AND player.name NOT LIKE "[%]%" ORDER BY level DESC, playtime DESC LIMIT 1');

        if(!isset($warrior[0])){
            $warrior[0] = [
                "name" => "-",
                "level" => '-',
                "job" => 0
            ];
        }

        if(!isset($assassin[0])){
            $assassin[0] = [
                "name" => "-",
                "level" => '-',
                "job" => 0
            ];
        }
        if(!isset($sura[0])){
            $sura[0] = [
                "name" => "-",
                "level" => '-',
                "job" => 0
            ];
        }
        if(!isset($shaman[0])){
            $shaman[0] = [
                "name" => "-",
                "level" => '-',
                "job" => 0
            ];
        }
        if(!isset($lycan[0]) && LYCAN === true){
            $lycan[0] = [
                "name" => "-",
                "level" => '-',
                "job" => 0
            ];
        }
        
        $result = [
            "warrior" => $warrior[0],
            "assassin" => $assassin[0],
            "sura" => $sura[0],
            "shaman" => $shaman[0],
        ];
        
        if(!empty($lycan)){
            array_push($result, $lycan[0]);
        }

        return $result;

    }

    public static function rankingWithPagination($inicio = 1, $quantidade = 20){

        $start = $inicio - 1;

        $start = $start * $quantidade;

        $result = Database::select('SELECT SQL_CALC_FOUND_ROWS
        player.id, player.name, player.job, player.level, player.exp, player_index.empire
        FROM '.PLAYER_DB.'.player, '.PLAYER_DB.'.player_index
        WHERE player.account_id = player_index.id
        AND player.name NOT LIKE "[%]%"
        ORDER BY level DESC, exp DESC, playtime DESC LIMIT :INICIO, :QTD', [
            ":INICIO" => $start,
            ":QTD" => $quantidade
        ]);

        $resultTotal = Database::select('SELECT FOUND_ROWS() AS totalPages');

        return [
            "players" => $result,
            "pages" => ceil((int)$resultTotal[0]['totalPages'] / $quantidade)
        ];
    }

    public static function guildWithPagination($inicio = 1, $quantidade = 20){

        $start = $inicio - 1;

        $start = $start * $quantidade;

        $result = Database::select('SELECT SQL_CALC_FOUND_ROWS
        guild.name, guild.master, guild.win, guild.draw, guild.loss, guild.ladder_point, guild.master, player_index.empire
        FROM '.PLAYER_DB.'.guild, '.PLAYER_DB.'.player_index
        WHERE player_index.pid1 = guild.master or
        player_index.pid2 = guild.master or
        player_index.pid3 = guild.master or
        player_index.pid4 = guild.master
        ORDER BY win DESC, ladder_point DESC LIMIT :INICIO, :QTD', [
            ":INICIO" => $start,
            ":QTD" => $quantidade
        ]);

        $resultTotal = Database::select('SELECT FOUND_ROWS() AS totalPages');

        return [
            "guildas" => $result,
            "pages" => ceil((int)$resultTotal[0]['totalPages'] / $quantidade)
        ];
    }

    public function getGuildName($playerID){
        $result = Database::select('SELECT guild_member.guild_id, guild.name 
        FROM '.PLAYER_DB.'.guild_member, '.PLAYER_DB.'.guild
        WHERE guild_member.pid = :PID AND guild_member.guild_id = guild.id', [
            ":PID" => $playerID
        ]);

        if(count($result) > 0){
            return $result[0]['name'];
        }else{
            return '-';
        }
    }
}