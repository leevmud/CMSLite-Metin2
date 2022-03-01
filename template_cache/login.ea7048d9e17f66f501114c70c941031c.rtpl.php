<?php if(!class_exists('Rain\Tpl')){exit;}?>    <main class="main-content">
        <h1 class="main-title">Login</h1>
        <article class="news-post">
            <div class="modal-login form-content" >
                <?php if( $result != '' ){ ?>
                <?php if( $result["1"] == 'success' ){ ?>
                        <p class="user-forms-response success-create"><?php echo htmlspecialchars( $result["0"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                    <?php }else{ ?>
                        <p class="user-forms-response failed-create"><?php echo htmlspecialchars( $result["0"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                    <?php } ?>
                <?php } ?>
                <form name="loginForm" action="/login" method="POST">
                    <input class="form-data" type="text" id="login" name="login" placeholder="Usuário" autocomplete="off" required pattern="[a-zA-Z][A-Za-z0-9]{4,16}"><br>
                    <input class="form-data" type="password" id="password" name="password" placeholder="Senha" required pattern="(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$*%]).{8,16}"><br>
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars( $csrf_token, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                    <a class="recover-pass" href="/forgot-password">Esqueceu a senha?</a>
                    <div class="g-recaptcha captcha-register" data-sitekey="<?php echo PUBLIC_KEY; ?>" data-theme="dark"></div>
                    <button id="btn-send-form-login"></button>
                </form>
            </div>
        </article>
    </main>