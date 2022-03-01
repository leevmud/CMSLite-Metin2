<?php if(!class_exists('Rain\Tpl')){exit;}?>
    <main class="main-content">
        <h1 class="main-title">Nova Postagem</h1>
        <div class="news-post">
            
            <section class="container-config">
                <div class="box-user-forms">
                    <!-- <span>Digite o login para banir/desbanir:</span> -->
                    <br>
                    <form action="/admin/posts/newpost" method="POST" class="site-posts">
                        <input type="text" name="postTitle" id="postTitle" placeholder="Título" autocomplete="off">
                        <br>
                        <input type="text" name="postCategory" id="postCategory" placeholder="Categoria (ex. Evento)">
                        <br>
                        <textarea name="textEditor" id="textEditor"></textarea>
                        <input type="hidden" name="__token" value="<?php echo htmlspecialchars( $csrf_token, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                        <button >Criar Postagem</button>
                    </form>
                </div>
            </section>
        </div>
    </main>