<?php if(!class_exists('Rain\Tpl')){exit;}?>
    <main class="main-content">
        <h1 class="main-title">Ranking de Jogadores</h1>
        <div class="news-post">
            <div class="links-pagination">
                <?php echo generateLinksPagination($pAtual, $totalPages); ?>
            </div>
            <table class="ranking">
                <tr>
                    <th>Rank</th>
                    <th>Classe</th>
                    <th>Nome</th>
                    <th>Nível</th>
                    <th>Reino</th>
                    <th>Guilda</th>
                    <th>EXP</th>
                </tr>
                <?php $counter1=-1;  if( isset($players) && ( is_array($players) || $players instanceof Traversable ) && sizeof($players) ) foreach( $players as $key1 => $value1 ){ $counter1++; ?>
                <tr>
                    <td><?php echo htmlspecialchars( $counter1+$contador, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo getPlayerJob($value1["job"]); ?></td>
                    <td><?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["level"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo getPlayerEmpire($value1["empire"]); ?></td>
                    <td><?php echo htmlspecialchars( $guildName->getGuildName($value1["id"]), ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["exp"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                </tr>
                <?php } ?>
            </table>
            
        </div>
    </main>
