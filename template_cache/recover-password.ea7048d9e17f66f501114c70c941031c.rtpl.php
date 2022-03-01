<?php if(!class_exists('Rain\Tpl')){exit;}?>
    <main class="main-content">
        <h1 class="main-title">Recuperar Senha</h1>
        <div class="news-post">
            <section class="container-config">
                <div class="box-user-forms">
                    <span>Preencha para recuperar a senha:</span>
                    <?php if( $result != '' ){ ?>
                        <?php if( $result["1"] == 'success' ){ ?>
                            <p class="user-forms-response success-create"><?php echo htmlspecialchars( $result["0"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                        <?php }else{ ?>
                            <p class="user-forms-response failed-create"><?php echo htmlspecialchars( $result["0"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                        <?php } ?>
                    <?php } ?>
                    <form action="/forgot-password" method="POST" class="user-forms"
                    onsubmit="document.getElementById('submit').disabled=true;
                        document.getElementById('submit').value='Recuperar Senha';"
                    >
                        <input type="text" id="login" name="login" placeholder="Usuário" autocomplete="off" required><br>
                        <input type="email" id="email" name="email" placeholder="E-mail" autocomplete="off" required>
                        <br>
                        <div id='captcha-forgot'></div>
                        <button id="submit" onclick="return confirm('Confirmar o a solicitação?')">Recuperar Senha</button>
                    </form>
                </div>
                
            </section>
        </div>
    </main>