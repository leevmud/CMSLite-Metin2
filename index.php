<?php
// session_set_cookie_params(900, null, null, true, true);
session_start();

if(!isset($_SESSION['token']) && empty($_SESSION['token'])){
    $_SESSION['token'] = bin2hex(random_bytes(24));
}
require_once('vendor/autoload.php');
require_once ('vendor/functions.php');

use CMSLite\Page;
use CMSLite\User;
use CMSLite\Admin;
use CMSLite\Database;
use CMSLite\Translate;
use CMSLite\Posts;
use CMSLite\Ranking;
use CMSLite\Statistics;
use CMSLite\Mailer;

try {
    Database::connect();
} catch (PDOException $e) {
    $page = new Page([
        "header" => false,
        "footer" => false
    ]);

    $page->setTpl('offline');//template/default/offline.html
    exit;
}

$app = new \Slim\Slim();

$app->get('/', function(){
    $page = new Page();

    $page->setTpl('home',[
        "listPostHome" => Posts::getPosts(4),
        "top1" => Ranking::getTop1()
    ]);

});

$app->get('/new-account', function(){
    $page = new Page();

    $page->setTpl('new-account', [
        "result" => User::getMsg()
    ]);
});

$app->post('/new-account', function(){
    
    if(!empty($_POST)){

        $username = isValidUsername($_POST['username']);
        $password = isValidPassword($_POST['password']);
        $email = isValidEmail($_POST['email']);
    
        if(!$username){
            User::setMsg([Translate::text('invalid_username'), 'failed']);
        }elseif(!$password){
            User::setMsg([Translate::text('invalid_password'), 'failed']);
        }elseif(hashPassword($_POST['re-password']) !== hashPassword($password)){
            User::setMsg([Translate::text('invalid_match_pw'), 'failed']);
        }elseif(!$email){
            User::setMsg([Translate::text('invalid_email'), 'failed']);
        }elseif($_POST['re-email'] !== $email){
            User::setMsg([Translate::text('invalid_match_email'), 'failed']);
        }elseif($_POST['accept'] !== 'on'){
            User::setMsg([Translate::text('invalidCheckBoxRegister'), 'failed']);
        }elseif(isset($_POST['g-recaptcha-response']) && !verifyCaptcha($_POST['g-recaptcha-response']) && ENABLE_CAPTCHA){
            User::setMsg([Translate::text('error_captcha'), 'failed']);
        }else{
            User::register($username, $password, $email);
        }
    }
    header('Location: /new-account');
    exit;

});

$app->get('/login', function(){
    $page = new Page();

    $page->setTpl('login', [
        "result" => User::getMsg(),
        "csrf_token" => $_SESSION['token']
    ]);
    
});

$app->post('/login', function(){

    if(!empty($_POST)){
        $username = isValidUsername($_POST['login']);
        $password = isValidPassword($_POST['password']);
        
        if(!$username){
            User::setMsg([Translate::text('invalid_username'), 'failed']);
        }elseif(!$password){
            User::setMsg([Translate::text('invalid_password'), 'failed']);
        }elseif(!hash_equals($_SESSION['token'], $_POST['token'])){
            User::setMsg([Translate::text('invalid_csrf_token'), 'failed']);
        }elseif(isset($_POST['g-recaptcha-response']) && !verifyCaptcha($_POST['g-recaptcha-response']) && ENABLE_CAPTCHA){
            User::setMsg([Translate::text('error_captcha'), 'failed']);
        }else{
            if(User::login($username, $password)){
                generateToken();
                header('Location: /my-account');
                exit;
            }
        }
    }
    generateToken();
    header('Location: /login');
    exit;
});


$app->get('/my-account', function(){
    User::isValidLogin();

    $page = new Page();

    $page->setTpl('my-account',[
        "username" => $_SESSION['username'],
        "admin" => User::isAdmin(),
        "result" => User::getMsg()
    ]);
});

$app->get('/logout', function(){
    User::logout();
});

$app->get('/my-account/change-email', function(){
    User::isValidLogin();
    $page = new Page();

    $page->setTpl('change-email', [
        "result" => User::getMsg(),
        "csrf_token" => $_SESSION['token']
    ]);

});

$app->post('/my-account/change-email', function(){
    User::isValidLogin();

    if(!empty($_POST)){
        $oldEmail = isValidEmail($_POST['emailAtual']);
        $newEmail = isValidEmail($_POST['novoEmail']);

        if(!$oldEmail){
            User::setMsg([Translate::text('invalid_email'), "failed"]);
        }elseif(!User::isUserEmail($oldEmail)){
            User::setMsg([Translate::text('invalid_user_email'), "failed"]);
        }elseif(!$newEmail){
            User::setMsg([Translate::text('invalid_email'), "failed"]);
        }elseif($_POST['re-novoEmail'] !== $newEmail){
            User::setMsg([Translate::text('invalid_match_email'), "failed"]);
        }elseif(!hash_equals($_SESSION['token'], $_POST['__token'])){
            User::setMsg([Translate::text('invalid_csrf_token'), "failed"]);
        }elseif(isset($_POST['g-recaptcha-response']) && !verifyCaptcha($_POST['g-recaptcha-response']) && ENABLE_CAPTCHA){
            User::setMsg([Translate::text("error_captcha"), "failed"]);
        }else{
            User::changeEmail($newEmail);
        }
    }

    generateToken();
    header("Location: /my-account/change-email");
    exit;
});

$app->get('/my-account/change-password', function(){
    User::isValidLogin();

    $page = new Page();

    $page->setTpl('change-password',[
        "result" => User::getMsg(),
        "csrf_token" => $_SESSION['token']
    ]);
    
});

$app->post('/my-account/change-password', function(){
    User::isValidLogin();

    if(!empty($_POST)){
        $oldPassword = isValidPassword($_POST['senhaAtual']);
        $newPassword = isValidPassword($_POST['novaSenha']);

        if(!$oldPassword){
            User::setMsg([Translate::text('invalid_password'), "failed"]);
        }elseif(!User::isUserPassword($oldPassword)){
            User::setMsg([Translate::text("wrong_user_pw"), "failed"]);
        }elseif(!$newPassword){
            User::setMsg([Translate::text('invalid_password'), "failed"]);
        }elseif(hashPassword($_POST['re-novaSenha']) !== hashPassword($newPassword)){
            User::setMsg([Translate::text('invalid_match_pw'), "failed"]);
        }elseif(!hash_equals($_POST['__token'], $_SESSION['token'])){
            User::setMsg([Translate::text('invalid_csrf_token'), "failed"]);
        }elseif(isset($_POST['g-recaptcha-response']) && !verifyCaptcha($_POST['g-recaptcha-response']) && ENABLE_CAPTCHA){
            User::setMsg([Translate::text("error_captcha"), "failed"]);
        }else{
            User::changePassword($newPassword);
        }
    }

    generateToken();
    header("Location: /my-account/change-password");
    exit;
});

$app->get('/my-account/unbug-char', function(){
    User::isValidLogin();
    
    $page = new Page();

    $characters = User::getCharacters();

    $page->setTpl('unbug-character',[
        "result" => User::getMsg(),
        "characters" => $characters
    ]);

});

$app->get('/my-account/unbug-char/:id', function($id){
    User::isValidLogin();

    User::moveCharacter($id);

    header("Location: /my-account/unbug-char");
    exit;

});

$app->get('/admin/ban', function(){
    User::isValidLogin();
    if(!User::isAdmin()){
        User::goHome();
    }

    $page = new Page();
    $page->setTpl('admin-ban',[
        "result" => User::getMsg(),
        "csrf_token" => $_SESSION['token']
    ]);
});

$app->post('/admin/ban', function(){
    User::isValidLogin();
    if(!User::isAdmin()){
        User::goHome();
    }

    if(!empty($_POST)){
        $username = isValidUsername($_POST['ban-username']);
        $banTime = (int)$_POST['ban-time'];

        if($banTime !== 0){
            $formatedBanTime = (new DateTime("now +{$banTime} days"))->format('Y-m-d H:i:s');
        }else{
            $formatedBanTime = 0;
        }

        if(!$username){
            User::setMsg([Translate::text('invalid_username'), 'failed']);
        }elseif(!Admin::userExist($username)){
            User::setMsg([Translate::text('user_dont_exist'), 'failed']);
        }elseif(!hash_equals($_POST['__token'], $_SESSION['token'])){
            User::setMsg([Translate::text('invalid_csrf_token'), "failed"]);
        }else{
            Admin::banAccount($username, $formatedBanTime);
        }
    }
    generateToken();
    header("Location: /admin/ban");
    exit;

});

$app->get('/admin/coins', function(){
    User::isValidLogin();
    if(!User::isAdmin()){
        User::goHome();
    }

    $page = new Page();
    $page->setTpl('admin-coins',[
        "result" => User::getMsg(),
        "csrf_token" => $_SESSION['token']
    ]);
});

$app->post('/admin/coins', function(){
    User::isValidLogin();
    if(!User::isAdmin()){
        User::goHome();
    }

    if(!empty($_POST)){
        $username = isValidUsername($_POST['coins-username']);
        $coins = (int)$_POST['coins-amount'];

        if(!$username){
            User::setMsg([Translate::text('invalid_username'), 'failed']);
        }elseif(!Admin::userExist($username)){
            User::setMsg([Translate::text('user_dont_exist'), 'failed']);
        }elseif(!hash_equals($_POST['__token'], $_SESSION['token'])){
            User::setMsg([Translate::text('invalid_csrf_token'), "failed"]);
        }elseif($coins === 0){
            User::setMsg([Translate::text('invalid_value'), "failed"]);
        }else{
            Admin::insertCoins($username, $coins);
        }
    }

    generateToken();
    header("Location: /admin/coins");
    exit;
    
});

$app->get('/admin/posts', function(){
    User::isValidLogin();
    if(!User::isAdmin()){
        User::goHome();
    }

    $page = new Page();
    $page->setTpl('posts',[
        "result" => User::getMsg(),
        "listPosts" => Posts::getPosts()
    ]);
});

$app->get('/admin/posts/newpost', function(){
    User::isValidLogin();
    if(!User::isAdmin()){
        User::goHome();
    }

    $page = new Page();

    $page->setTpl('new-post',[
        "csrf_token" => $_SESSION['token']
    ]);

});

$app->post('/admin/posts/newpost', function(){
    User::isValidLogin();
    if(!User::isAdmin()){
        User::goHome();
    }

    if(!empty($_POST)){
        $title = htmlspecialchars($_POST['postTitle']);
        $category = htmlspecialchars($_POST['postCategory']);
        $content = htmlspecialchars($_POST['textEditor']);

        if(!hash_equals($_SESSION['token'],$_POST['__token'])){
            User::setMsg([Translate::text('invalid_csrf_token'), "failed"]);
        }else{
            Posts::newPost($category, $title, $content);
        }

    }

    generateToken();
    header("Location: /admin/posts");
    exit;
});

$app->get('/admin/posts/editpost/:id', function($id){
    User::isValidLogin();
    if(!User::isAdmin()){
        User::goHome();
    }
    $post = Posts::showPost($id);

    $page = new Page();

    if(!$post){
        header("Location: /admin/posts");
        exit;
    }

    $page->setTpl('edit-post',[
        "csrf_token" => $_SESSION['token'],
        "post" => $post
    ]);

});

$app->post('/admin/posts/editpost/:id', function($id){
    User::isValidLogin();
    if(!User::isAdmin()){
        User::goHome();
    }
    
    if(!empty($_POST)){
        $title = htmlspecialchars($_POST['postTitle']);
        $category = htmlspecialchars($_POST['postCategory']);
        $content = htmlspecialchars($_POST['textEditor']);

        if(!hash_equals($_SESSION['token'],$_POST['__token'])){
            User::setMsg([Translate::text('invalid_csrf_token'), "failed"]);
        }else{
            Posts::newPost($category, $title, $content, (int)$id);
        }

    }

    generateToken();
    header("Location: /admin/posts");
    exit;

});

$app->get('/admin/posts/deletepost/:id', function($id){
    User::isValidLogin();
    if(!User::isAdmin()){
        User::goHome();
    }
    
    Posts::deletePost($id);

    header("Location: /admin/posts");
    exit;

});

$app->get('/post/:id', function($id){
    $page = new Page();

    $post = Posts::showPost($id);

    if(!$post){
        User::goHome();
    }

    $page->setTpl('post-content', [
        "post" => $post
    ]);
});

$app->get('/news', function(){
    $page = new Page();

    $page->setTpl('content-news',[
        "listAllPosts" => Posts::getPosts()
    ]);
});


$app->get('/ranking-players', function(){
    $page = new Page();

    $paginaAtual = (isset($_GET['p'])) ? (int)$_GET['p'] : 1;
    $paginaAtual = $paginaAtual < 1 ? 1 : $paginaAtual;

    $ranking = Ranking::rankingWithPagination($paginaAtual);

    $contador = 20 * $paginaAtual - 20 + 1;

    $page->setTpl('ranking-player', [
        "players" => $ranking['players'],
        "contador" => $contador,
        "pAtual" => $paginaAtual, 
        "totalPages" => $ranking['pages'],
        "guildName" => new Ranking()
    ]);
});

$app->get('/ranking-guilds', function(){
    $page = new Page();

    $paginaAtual = (isset($_GET['p'])) ? (int)$_GET['p'] : 1;
    $paginaAtual = $paginaAtual < 1 ? 1 : $paginaAtual;

    $ranking = Ranking::guildWithPagination($paginaAtual);

    $contador = 20 * $paginaAtual - 20 + 1;//20 é a qtd de registros por página

    $page->setTpl('ranking-guildas', [
        "guildas" => $ranking['guildas'],
        "contador" => $contador,
        "pAtual" => $paginaAtual, 
        "totalPages" => $ranking['pages']
    ]);
});

$app->get('/downloads', function(){
    $page = new Page();

    $page->setTpl('downloads');
});

$app->get("/forgot-password", function(){
 
    $page = new Page();

    $page->setTpl('recover-password', [
        "result" => User::getMsg() 
    ]);
});

$app->get("/my-account/warehouse-pw", function(){
    User::isValidLogin();

    $currentTime = (new DateTime())->getTimeStamp();
    $timeInMin = (new DateTime("+".MAIL_TIMER." minutes"))->getTimeStamp();

    if(isset($_SESSION['mail_timer']) && $_SESSION['mail_timer'] > $currentTime){
        User::setMsg([Translate::text('send_email_timer'), "failed"]);
        header("Location: /my-account");
        exit;
    }

    $newWarehousePW = generateWarehousePW();

    $emailBody = file_get_contents(EMAIL_TPL."send-warehousepw.html");
    $emailBody = str_replace("#name#", $_SESSION['username'], $emailBody);
    $emailBody = str_replace("#senha#", $newWarehousePW, $emailBody);
    $emailBody = str_replace("#server_link#", $_SERVER['SERVER_NAME'], $emailBody);

    $_SESSION['mail_timer'] = $timeInMin;
    User::sendWarehousePW($newWarehousePW, $emailBody);
    
    header("Location: /my-account");
    exit;
});

$app->get("/my-account/char-pw", function(){
    User::isValidLogin();

    $currentTime = (new DateTime())->getTimeStamp();
    $timeInMin = (new DateTime("+".MAIL_TIMER." minutes"))->getTimeStamp();

    if(isset($_SESSION['mail_timer']) && $_SESSION['mail_timer'] > $currentTime){
        User::setMsg([Translate::text('send_email_timer'), "failed"]);
        header("Location: /my-account");
        exit;
    }
    
    $newSocialID = generateSocialID();
    
    $emailBody = file_get_contents(EMAIL_TPL."send-socialid.html");
    $emailBody = str_replace("#name#", $_SESSION['username'], $emailBody);
    $emailBody = str_replace("#senha#", $newSocialID, $emailBody);
    $emailBody = str_replace("#server_link#", $_SERVER['SERVER_NAME'], $emailBody);

    $_SESSION['mail_timer'] = $timeInMin;

    User::sendSocialID($newSocialID, $emailBody);

    header("Location: /my-account");
    exit;
});

$app->post("/forgot-password", function(){

    $currentTime = (new DateTime())->getTimeStamp();
    $timeInMin = (new DateTime("+".MAIL_TIMER." minutes"))->getTimeStamp();

    if(isset($_SESSION['mail_timer']) && $_SESSION['mail_timer'] > $currentTime){
        User::setMsg([Translate::text('send_email_timer'), "failed"]);
        header("Location: /my-account");
        exit;
    }
 
    if(!empty($_POST)){
        $username = isValidUsername($_POST['login']);
        $email = isValidEmail($_POST['email']);

        $novaSenha = generatePassword();

        $emailBody = file_get_contents(EMAIL_TPL."recover-pw.html");
        $emailBody = str_replace("#name#", $username, $emailBody);
        $emailBody = str_replace("#ip#", $_SERVER['REMOTE_ADDR'], $emailBody);
        $emailBody = str_replace("#senha#", $novaSenha, $emailBody);
        $emailBody = str_replace("#server_link#", $_SERVER['SERVER_NAME'], $emailBody);

        if(!$username){
            User::setMsg([Translate::text("invalid_username"), "failed"]);
        }elseif(!$email){
            User::setMsg([Translate::text("invalid_email"), "failed"]);
        }elseif(isset($_POST['g-recaptcha-response']) && !verifyCaptcha($_POST['g-recaptcha-response']) && ENABLE_CAPTCHA){
            User::setMsg([Translate::text("error_captcha"), "failed"]);
        }else{
            $_SESSION['mail_timer'] = $timeInMin;
            User::recoverPassword($username, $email, $emailBody, $novaSenha);
        }
    }

    header("Location: /forgot-password");
    exit;
});



$app->run();
