<?php if(!class_exists('Rain\Tpl')){exit;}?>
    <main class="main-content">
        <h1 class="main-title">[<?php echo htmlspecialchars( $post["category"], ENT_COMPAT, 'UTF-8', FALSE ); ?>] <?php echo htmlspecialchars( $post["title"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
        <article class="news-post">
            <p><?php echo htmlspecialchars_decode($post["content"]); ?></p>
        </article>
    </main>