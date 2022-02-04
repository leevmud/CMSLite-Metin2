<?php
//////////////////////////////////////////////////////////////
//Definições do Banco de Dados
define('DB_USER', '');
define('DB_HOST', '');
define('DB_PASS', '');
define('DB_NAME', 'account');
define('DB_PORT', '3306');
define('CHARSET', 'utf8');

define('ACCOUNT_DB', 'account');
define('PLAYER_DB', 'player');

define('COINS', 'coins');//Coluna onde as moedas/cash são inseridas.
define('LYCAN', false);//True se o servidor possuir a classe Lycan, False, se não possuir.

//////////////////////////////////////////////////////////////
//Definições da Criação de Conta/Login
define('ENABLE_MAX_ACCOUNTS_PER_EMAIL', false); //Ativa limite de contas por e-mail
define('MAX_ACCOUNTS_PER_EMAIL', 3); //Quantidade máxima de contas por e-mail

define('ENABLE_REGISTER', true);//Ativa a criação de contas

//Defina as chaves do google reCaptcha para evitar ataques no site.
define('PUBLIC_KEY', '');//
define('PRIVATE_KEY', '');//

define('BLOCK_LOGIN_SITE_USER_BAN', true);//Bloqueia login no site se o usuário estiver banido.

//////////////////////////////////////////////////////////////
//Definições da Aplicação
define('SERVER_NAME', 'Metin2');
define('SERVER_LANG', 'pt-br');//Define o idioma das respostas do servidor e HTML se você configurar. apenas PT_BR foi adicionado. 

//////////////////////////////////////////////////////////////
//Definições do Header e Footer
$header = [
    "csrf_token" => $_SESSION['token']
];

$footer = [
    "textCopyright" => "&copy; ".date('Y '). SERVER_NAME . ". O logotipo do ". SERVER_NAME ." é marca registrada da Webzen Inc."
];

//////////////////////////////////////////////////////////////
//Jogadores Online em tempo real
define("USE_REAL_TIME_ONLINE_PLAYERS", false);
//13000 -> first | ch1
//13099 -> game99
define("GAME_PORTS", [
    13000, 
    13099
]);
define("ADMINPAGE_IP", "SEU_IP");//IP da config dos canais.

//////////////////////////////////////////////////////////////
//Definições do Template
define('TPL_NAME', 'default');

define('TPL_DIR', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.TPL_NAME.DIRECTORY_SEPARATOR);
define('TPL_CACHE', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'template_cache'.DIRECTORY_SEPARATOR);

define('APP_LANG', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'Lang'.DIRECTORY_SEPARATOR);

//////////////////////////////////////////////////////////////
//Definição de Mensagens (Retorna como JSON) - Não é necessário alterações
$response = [
    'msg' => 'Erro tente novamente ou entre em contato com o administrador do sistema.',
    'type' => 'failed-create',
    'redirect' => false
];

//////////////////////////////////////////////////////////////
//Configurações do Servidor de E-mail
define("MAIL", [
   "HOST" => "",
   "USERNAME" => "example@example.com",
   "PASSWORD" => "example",
   "PORT" => 465,
   "SMTP_SECURE" => "ssl",

   "REMETENTE" => "suporte@example.com",
   "RE_NOME" => "SUPORTE - SERVERNAME",

   "REPLYTO" => "noreply@servername.com",
   "REPLY_NAME" => "noreply"

]);

define("EMAIL_TPL", $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.TPL_NAME.DIRECTORY_SEPARATOR.'email'.DIRECTORY_SEPARATOR);