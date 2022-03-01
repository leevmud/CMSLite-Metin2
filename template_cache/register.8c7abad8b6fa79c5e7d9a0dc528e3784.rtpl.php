<?php if(!class_exists('Rain\Tpl')){exit;}?>
    <div class="form-content" >
        <h1 class="home-content-title">Nova Conta</h1><span>Já possui uma conta?</span><a class="btn-login" tabindex="0">Faça Login!</a>
        <i class="fas fa-times"></i>
        <p class="response-form"></p>
        <form name="registerForm" action="/new-account" method="POST">
            <input class="form-data tags" type="text" id="username" name="username" placeholder="Usuário" autocomplete="off" required pattern="[a-zA-Z][A-Za-z0-9]{4,16}"><a class="tip" tabindex="-1">?<span>- Preenchimento obrigatório. <br><br>- Mínimo de 4 e máximo de 16 caracteres. <br><br>- Permitido apenas letras e números, sem caracteres especiais ou espaço.<br><br>- Não pode começar com um número.</span></a><br>
            <input class="form-data" type="password" id="password" name="password" placeholder="Senha" required pattern="(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$*%]).{8,16}" ><a class="tip" tabindex="-1"> ?<span>- Mínimo de 8 e máximo de 16 caracteres. <br><br>- Obrigatório ao menos um número. <br><br>- Obrigatório ao menos uma letra minúscula. <br><br>- Obrigatório ao menos uma letra maiúscula. <br><br>- Obrigatório ao menos um caractere especial.</span></a><br>
            <input class="form-data" type="password" id="re-password" name="re-password" placeholder="Confirme a Senha" required pattern="(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$&*%]).{8,16}"><br>
            <input class="form-data" type="email" id="email" name="email" placeholder="E-mail" autocomplete="off" required><a class="tip" tabindex="-1"> ?<span>- E-mail precisa ser válido. <br><br>- Permitido apenas domínios de e-mail conhecidos.</span></a><br>
            <input class="form-data" type="email" id="re-email" name="re-email" placeholder="Confirme o E-mail" autocomplete="off" required><br>
            <input type="checkbox" id="accept" required ><span>Li e Aceito os <a href="/post/2">Termos de Uso</a> e as <a href="/post/3">Políticas de Privacidade</a>.</span><br>
            <div id='captcha-register'></div>
            
            <button id="btn-send-form-register" ></button>
        </form>
    </div>
