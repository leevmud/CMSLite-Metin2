<?php
include('init.php');

function isValidUsername($username){
    $username = htmlspecialchars($username);

    if(!preg_match("/^[a-zA-Z][A-Za-z0-9]{4,16}$/", $username)){
        return false;
    }

    return $username;
}

function isValidEmail($email){
    $email = htmlspecialchars($email);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return false;
    }

    return $email;
}

function isValidPassword($password){
    $password = htmlspecialchars($password);
    /*
    /^              -> Inicio da expressão.
    (?=.*[A-Z])     -> Ao menos 1 letra maiúscula 
    (?=.*[!@#$&*%]) -> Ao menos 1 caractere especial
    (?=.*[0-9])     -> Ao menos 1 número
    (?=.*[a-z])     -> Ao menos 1 letra minúscula
    .{8,16}         -> Entre 8 e 16 caracteres
    $/              -> Final da expressão
    */
    if(!preg_match("/^(?=.*[A-Z])(?=.*[!@#$*%])(?=.*[0-9])(?=.*[a-z]).{8,16}$/", $password)){
        return false;
    }

    return $password;
}

function verifyCaptcha($responseToken){
    $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".PRIVATE_KEY."&response=$responseToken");
    $responseData = json_decode($verifyResponse);

    if($responseData->success){
        return true;
    }

    return false;
}

function hashPassword($password){
    $password = "*".sha1(sha1($password, true));
    return strtoupper($password);
}

function generateToken(){
    return $_SESSION['token'] = bin2hex(random_bytes(24));
}

function getPlayerEmpire($empire){

    switch ($empire) {
        case 1:
            echo '<img src="/template/default/images/icons/shinso.jpg" alt="Shinso">';
            break;
        case 2:
            echo '<img src="/template/default/images/icons/chunjo.jpg" alt="Chunjo">';
        break;
        case 3:
            echo '<img src="/template/default/images/icons/jinno.jpg" alt="Jinno">';
            break;
        default:
        echo '<img src="/template/default/images/icons/0.jpg" alt="">';
            break;
    }
}

function getPlayerJob($job){

    switch ($job) {
        case 0:
            echo '<img style="width:20%;" src="/template/default/images/icons/0.webp" alt="Guerreiro-M">';
            break;
        
        case 1:
            echo '<img style="width:20%;" src="/template/default/images/icons/1.webp" alt="Ninja-F">';
            break;

        case 2:
            echo '<img style="width:20%;" src="/template/default/images/icons/2.webp" alt="Shura-M">';
            break;
        
        case 3:
            echo '<img style="width:20%;" src="/template/default/images/icons/3.webp" alt="Shaman-F">';
            break;

        case 4:
            echo '<img style="width:20%;" src="/template/default/images/icons/4.webp" alt="Guerreiro-F">';
            break;
            
        case 5:
            echo '<img style="width:20%;" src="/template/default/images/icons/5.webp" alt="Ninja-M">';
            break;

        case 6:
            echo '<img style="width:20%;" src="/template/default/images/icons/6.webp" alt="Shura-F">';
            break;

        case 7:
            echo '<img style="width:20%;" src="/template/default/images/icons/7.webp" alt="Shaman-M">';
            break;    
        
        case 8:
            echo '<img style="width:20%;" src="/template/default/images/icons/8.webp" alt="Lycan">';
            break; 

        
        default:
        echo '<img style="width:20%;" src="/template/default/images/icons/0.webp" alt="">';
            break;
    }
}

function generateLinksPagination($pAtual, $total, $pagina = 'ranking-players'){

    $prox = $pAtual+1;
    $ant = $pAtual-1;

    $ultima = $total;
    $primeira = 1;
    
    if($pAtual != $total){
        if($pAtual > 1){
            echo " <a href='/$pagina?p=$ant'><< $ant</a> ";
        }
        if($pAtual > 0){
            echo " <a class='p-atual' tabindex='-1'>$pAtual</a> ";
            echo " <a href='/$pagina?p=$prox'>$prox >></a> ";
        }
    }elseif($pAtual == $total && $pAtual == 1){
        echo " <a class='p-atual' tabindex='-1'>$pAtual</a> ";

    }else{
        echo " <a href='/$pagina?p=1'><<</a> ";
        echo " <a href='/$pagina?p=$ant'>$ant</a> ";
        echo " <a class='p-atual' tabindex='-1'>$pAtual</a> ";
        
    }

}

function generatePassword(){
    $chars = [
        "abcdefghijklmnopqrstuvwxyz",
        "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
        "0123456789",
        "!@#$*%"
    ];

    $pass = '';

    foreach ($chars as $value) {
        $pass .= substr(str_shuffle($value), 0, 3);
    }
    
    return str_shuffle($pass);
}

function generateSocialID(){
    return rand(0000000, 9999999);
}

function generateWarehousePW(){
    return rand(000000, 999999);
}