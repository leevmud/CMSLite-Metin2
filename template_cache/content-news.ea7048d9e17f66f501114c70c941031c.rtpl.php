<?php if(!class_exists('Rain\Tpl')){exit;}?>
    <main class="main-content">
        <h1 class="main-title">Últimas postagens</h1>
        <div class="news-post">
            
                <?php $counter1=-1;  if( isset($listAllPosts) && ( is_array($listAllPosts) || $listAllPosts instanceof Traversable ) && sizeof($listAllPosts) ) foreach( $listAllPosts as $key1 => $value1 ){ $counter1++; ?>
                <ul class="news-list-full">
                    <li>[<?php echo htmlspecialchars( $value1["category"], ENT_COMPAT, 'UTF-8', FALSE ); ?>] <a href="/post/<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["title"], ENT_COMPAT, 'UTF-8', FALSE ); ?>  </a>(<?php echo date('d/m', strtotime($value1["date"])); ?>)</li>
                    <hr>
                </ul>
                <?php } ?>
          
        </div>
    </main>