<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="<?php echo SERVER_LANG; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1280, maximum-scale=1">
    <meta name="description" content="Agora disponível uma nova CMS para seu servidor de Metin2! Faça o download gratuito agora mesmo, um novo site para seu servidor com diversas funcionalidades! Aproveite!">
    <link rel="stylesheet" href="/template/default/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Josefin+Sans:wght@100;300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="shortcut icon" href="/template/default/favicon.ico" type="image/x-icon">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title><?php echo SERVER_NAME; ?></title>
</head>
<body>
    <header class="header-content">
        <nav>
            <ul class="menu">
                <li><a class="item" href="/"><?php echo htmlspecialchars( $text->textHTML('btn_home'), ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                <?php if( !isset($_SESSION['id']) ){ ?>
                <li><a class="item" href="/new-account"><?php echo htmlspecialchars( $text->textHTML('btn_register'), ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                <?php }else{ ?>
                <li><a class="item " href="/my-account"><?php echo htmlspecialchars( $text->textHTML('btn_my_account'), ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                <?php } ?>
                <li><a class="item" tabindex="0"><?php echo htmlspecialchars( $text->textHTML('btn_ranking'), ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
                    <ul class="submenu">
                        <li><a href="/ranking-players"><?php echo htmlspecialchars( $text->textHTML('btn_ranking_player'), ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                        <li><a href="/ranking-guilds"><?php echo htmlspecialchars( $text->textHTML('btn_ranking_guild'), ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                    </ul>
                </li>
                <li><a class="item" href="/downloads"><?php echo htmlspecialchars( $text->textHTML('btn_download'), ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
            </ul>
        </nav>
        <section class="top-content">
            <div class="login">
                <a class="btn-download-header" href="/downloads">
                    <img src="/template/default/images/btn-download.webp" alt="Download">
                </a>
                <div class="box-login">
                    <?php if( !isset($_SESSION['id']) ){ ?>
                    <a class="btn-login-header btn-login" href="/login">Acesse sua conta</a>
                    <span class="box-login-question">Não tem uma conta? <a class="btn-register" href="/new-account">Criar conta!</a></span>
                    <?php }else{ ?>
                    <a class="btn-login-header" href="/my-account">Gerencie sua conta</a>
                    <span class="box-login-question">Você está logado, para sair faça <a href="/logout">Logout</a></span>
                    <?php } ?>
                </div>
            </div>
            <div class="logo">
                <a href="/">
                    <img src="/template/default/images/logo.webp" alt="Logo">
                </a>
            </div>
            <div class="class-header">
                <img src="/template/default/images/ranking_race_render_warrior.webp" alt="Warrior-img">
            </div>
        </section>
    </header>