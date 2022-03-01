<?php if(!class_exists('Rain\Tpl')){exit;}?>
    <main class="main-content">
        <h1 class="main-title">Minha Conta </h1>
        <div class="news-post">
            <span class="welcome">Bem vindo(a), <strong><?php echo htmlspecialchars( $username, ENT_COMPAT, 'UTF-8', FALSE ); ?></strong>, se desejar sair, faça <a href="/logout">Logout</a></span>
            <hr>
            <?php if( $result != '' ){ ?>
                <?php if( $result["1"] == 'success' ){ ?>
                    <p class="user-forms-response success-create"><?php echo htmlspecialchars( $result["0"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                <?php }else{ ?>
                    <p class="user-forms-response failed-create"><?php echo htmlspecialchars( $result["0"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                <?php } ?>
            <?php } ?>
            <section class="container-config">
                <div class="box-data">
                    <span>Gerenciar Conta:</span>
                    <a href="/my-account/change-email">Alterar E-mail</a>
                    <a href="/my-account/change-password">Alterar Senha</a>
                    <a onclick="return confirm('Um e-mail será enviado, Deseja continuar?')" href="/my-account/warehouse-pw">Senha do Armazém</a>
                </div>
                <div class="box-data">
                    <span>Gerenciar Personagens:</span>
                    <a onclick="return confirm('Um e-mail será enviado, Deseja continuar?')" href="/my-account/char-pw">Cód. Apagar Personagem</a>
                    <a href="/my-account/unbug-char">Desbugar Personagem</a>
                </div>
                <div class="box-data">
                    <span>Loja:</span>
                    <a href="#">Item Shop</a>
                    <a href="#">Comprar Moedas</a>
                </div>

                <?php if( $admin === true ){ ?>
                <div class="box-data">
                    <span>Administração:</span>
                    <a href="/admin/ban">Banir/Desbanir Conta</a>
                    <a href="/admin/posts">Gerenciar Postagens</a>
                    <a href="/admin/coins">Adicionar Moedas</a>
                </div>
                <?php } ?>
            </section>
        </div>
    </main>