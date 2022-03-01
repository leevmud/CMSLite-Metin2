<?php if(!class_exists('Rain\Tpl')){exit;}?>
    <main class="main-content">
        <h1 class="main-title">Gerenciar Postagens</h1>
        <div class="news-post">
            
            <section class="container-config">
                <div class="box-user-forms">
                    <a class="new-posts-btn" href="/admin/posts/newpost">Nova Postagem</a>
                    <?php if( $result != false ){ ?>
                        <?php if( $result["1"] == 'success' ){ ?>
                            <p class="user-forms-response success-create"><?php echo htmlspecialchars( $result["0"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                        <?php }else{ ?>
                            <p class="user-forms-response failed-create"><?php echo htmlspecialchars( $result["0"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                        <?php } ?>
                    <?php } ?>
                   
                    <table class="posts">
                        <tr>
                            <th>ID</th>
                            <th>Categoria</th>
                            <th>Título</th>
                            <th>Data</th>
                            <th>Autor</th>
                            <th>Ações</th>
                        </tr>
                        <?php $counter1=-1;  if( isset($listPosts) && ( is_array($listPosts) || $listPosts instanceof Traversable ) && sizeof($listPosts) ) foreach( $listPosts as $key1 => $value1 ){ $counter1++; ?>
                        <tr>
                            <td><?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                            <td><?php echo htmlspecialchars( $value1["category"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                            <td><a href="/post/<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" target="__blank"><?php echo htmlspecialchars( $value1["title"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a></td>
                            <td><?php echo date('d/m/Y', strtotime($value1["date"])); ?></td>
                            <td><?php echo htmlspecialchars( $value1["author"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                            <td>
                                <a href="/admin/posts/editpost/<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" title="Editar"><i class="fas fa-edit"></i></a>
                                <a href="/admin/posts/deletepost/<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" title="Apagar" onclick="return confirm('Deseja apagar a postagem?')"><i class="fas fa-times"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
            
                </div>
            </section>
        </div>
    </main>