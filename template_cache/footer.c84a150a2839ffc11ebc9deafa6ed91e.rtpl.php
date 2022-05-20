<?php if(!class_exists('Rain\Tpl')){exit;}?><footer class="footer-container">
        <div class="footer-content">
            <div class="box-footer">
                <h1 class="home-content-title">Estatísticas</h1>
                <ul class="statistics">
                    <li><span>Jogadores Online:</span> <hr> <?php echo number_format($playersOnlineNow); ?></li>
                    <li><span>Jogadores Online(24h):</span> <hr> <?php echo number_format($playersOnlineIn24h); ?></li>
                    <br>
                    <li><span>Contas Criadas:</span> <hr> <?php echo number_format($totalAccount); ?></li>
                    <li><span>Personagens Criados:</span> <hr> <?php echo number_format($totalCharacters); ?></li>
                    <li><span>Guildas Criadas:</span> <hr> <?php echo number_format($totalGuilds); ?></li>
                </ul>
            </div>
            <div class="box-footer">
                <h1 class="home-content-title">Links úteis</h1>
                <div class="links-content">
                    <ul class="links-footer">
                        <li><a href="/post/2">Termos de Uso</a></li>
                        <li><a href="/post/3">Políticas de Privacidade</a></li>
                        <li><a href="#">Suporte</a></li>
                        <li><a href="/post/4">Trabalhe Conosco</a></li>
                    </ul>
                    <ul class="social-links">
                        <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href=""><i class="fab fa-discord"></i></a></li>
                        <li><a href=""><i class="fab fa-twitch"></i></a></li>
                        <li><a href=""><i class="fab fa-twitter"></i></a></li>
                        <li><a href=""><i class="fab fa-instagram"></i></a></li>
                        <li><a href=""><i class="fab fa-youtube"></i></a></li>
                    </ul>

                    <a href="https://levmud.com/" class="levmud"><img src="/template/default/images/levmud.png" alt=""></a>
                </div>
            </div>
        </div>
        <span class="copyright"><?php echo htmlspecialchars( $textCopyright, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
    </footer>
    <script src="/template/default/scripts/ckeditor/ckeditor.js"></script>
    <script src="/template/default/scripts/scripts.js"></script>
    
</body>
</html>