<?php if(!class_exists('Rain\Tpl')){exit;}?><section class="home-ranking">
        <div class="section-title">
            <h1 class="home-ranking-title">Top Jogadores</h1>
            <span class="home-ranking-subtitle">Por Classe</span>
        </div>
        <div class="home-ranking-container">
            <div class="home-ranking-content-lycan">
                <ul>
                    <?php if( $top1['warrior']["job"] === 0 ){ ?>
                    <li class="bg-ranking-home-lycan warrior-m">
                    <?php }else{ ?>
                    <li class="bg-ranking-home-lycan warrior-f">
                    <?php } ?>
                        <p class="player-name"><?php echo htmlspecialchars( $top1['warrior']["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                        <p class="player-level">Nível: <?php echo htmlspecialchars( $top1['warrior']["level"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                    </li>
                    <?php if( $top1['assassin']["job"] === 5 ){ ?>
                    <li class="bg-ranking-home-lycan ninja-m">
                    <?php }else{ ?>
                    <li class="bg-ranking-home-lycan ninja-f">
                    <?php } ?>
                        <p class="player-name"><?php echo htmlspecialchars( $top1['assassin']["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                        <p class="player-level">Nível: <?php echo htmlspecialchars( $top1['assassin']["level"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                    </li>
                    <?php if( $top1['sura']["job"] === 2 ){ ?>
                    <li class="bg-ranking-home-lycan shura-m">
                    <?php }else{ ?>
                    <li class="bg-ranking-home-lycan shura-f">
                    <?php } ?>
                        <p class="player-name"><?php echo htmlspecialchars( $top1['sura']["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                        <p class="player-level">Nível: <?php echo htmlspecialchars( $top1['sura']["level"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                    </li>
                    <?php if( $top1['shaman']["job"] === 7 ){ ?>
                    <li class="bg-ranking-home-lycan shaman-m">
                    <?php }else{ ?>
                    <li class="bg-ranking-home-lycan shaman-f">
                    <?php } ?>
                        <p class="player-name"><?php echo htmlspecialchars( $top1['shaman']["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                        <p class="player-level">Nível: <?php echo htmlspecialchars( $top1['shaman']["level"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                    </li>
                    <?php if( isset($top1['0']) ){ ?>
                    <li class="bg-ranking-home-lycan lycan-m">
                        <p class="player-name"><?php echo htmlspecialchars( $top1['0']["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                        <p class="player-level">Nível: <?php echo htmlspecialchars( $top1['0']["level"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </section>
    <main class="home-container">
        <div class="home-content">
            <div class="box-news">
                <h1 class="home-content-title">Notícias <a href="/news">+</a></h1>
                <ul class="news-list">
                    <?php $counter1=-1;  if( isset($listPostHome) && ( is_array($listPostHome) || $listPostHome instanceof Traversable ) && sizeof($listPostHome) ) foreach( $listPostHome as $key1 => $value1 ){ $counter1++; ?>
                    <li><a href="/post/<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><b class="post-type">[<?php echo htmlspecialchars( $value1["category"], ENT_COMPAT, 'UTF-8', FALSE ); ?>]</b><?php echo htmlspecialchars( $value1["title"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a> <b class="post-datetime"><?php echo date('d/m/Y', strtotime($value1["date"])); ?></b></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="box-news">
                <h1 class="home-content-title">Apresentação <a href="/post/1">+</a></h1>
                <div class="events-slide">
                    <a href="/post/1">
                        <p class="event-title">Descubra o <?php echo SERVER_NAME; ?>!</p>
                        <img src="/template/default/images/background-top.webp" alt="">
                    </a>
                </div>
            </div>
        </div>
    </main>