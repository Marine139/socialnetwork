<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Mur</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <header>
            <img src="resoc.jpg" alt="Logo de notre réseau social"/>
            <nav id="menu">
                <a href="news.php">Actualités</a>
                <a href="wall.php?user_id=5">Mur</a>
                <a href="feed.php?user_id=5">Flux</a>
                <a href="tags.php?tag_id=1">Mots-clés</a>
            </nav>
            <nav id="user">
                <a href="#">Profil</a>
                <ul>
                    <li><a href="settings.php?user_id=5">Paramètres</a></li>
                    <li><a href="followers.php?user_id=5">Mes suiveurs</a></li>
                    <li><a href="subscriptions.php?user_id=5">Mes abonnements</a></li>
                </ul>

            </nav>
        </header>
        <div id="wrapper">
            <?php
            /**
             * Etape 1: Le mur concerne un utilisateur en particulier
             * La première étape est donc de trouver quel est l'id de l'utilisateur
             * Celui ci est indiqué en parametre GET de la page sous la forme user_id=...
             * Documentation : https://www.php.net/manual/fr/reserved.variables.get.php
             * ... mais en résumé c'est une manière de passer des informations à la page en ajoutant des choses dans l'url
             */
            $userId = $_GET['user_id'];
            ?>
            <?php
            /**
             * Etape 2: se connecter à la base de donnée
             */
            $mysqli = new mysqli("localhost", "root", "", "socialnetwork");
            ?>

            <aside>
                <?php
                /**
                 * Etape 3: récupérer le nom de l'utilisateur
                 */
                $laQuestionEnSql = "SELECT * FROM `users` WHERE id=" . intval($userId);
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
                //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
                //echo "<pre>" . print_r($user, 1) . "</pre>";
                ?>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les message de l'utilisatrice : <?php echo $user['alias'] ?>
                        (n° <?php echo $_GET['user_id'] ?>)
                    </p>
                </section>
            </aside>
            <main>
                <?php
                /**
                 * Etape 3: récupérer tous les messages de l'utilisatrice
                 */
                $laQuestionEnSql = "SELECT `posts`.`content`,"
                        . "`posts`.`created`,"
                        . "`users`.`alias` as author_name,  "
                        . "count(`likes`.`id`) as like_number,  "
                        . "GROUP_CONCAT(`tags`.`label`) AS taglist "
                        . "FROM `posts`"
                        . "JOIN `users` ON  `users`.`id`=`posts`.`user_id`"
                        . "LEFT JOIN `posts_tags` ON `posts`.`id` = `posts_tags`.`post_id`  "
                        . "LEFT JOIN `tags`       ON `posts_tags`.`tag_id`  = `tags`.`id` "
                        . "LEFT JOIN `likes`      ON `likes`.`post_id`  = `posts`.`id` "
                        . "WHERE `posts`.`user_id`='" . intval($userId) . "' "
                        . "GROUP BY `posts`.`id`"
                        . "ORDER BY `posts`.`created` DESC  "
                ;
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }

                /**
                 * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                 */
                while ($post = $lesInformations->fetch_assoc())
                {

                    echo "<pre>" . print_r($post, 1) . "</pre>";
                    ?>                
                    <article>
                        <h3>
                            <time datetime='2020-02-01 11:12:13' ><?php echo $post['created'] ?></time>
                        </h3>
                        <address><?php echo $post['author_name'] ?></address>
                        <div>
                            <p><?php echo $post['content'] ?></p>

                        </div>                                            
                        <footer>
                            <small>♥ <?php echo $post['like_number'] ?></small>
                            <a href="">#<?php echo $post['taglist'] ?></a>

                        </footer>
                    </article>
                <?php } ?>


            </main>
        </div>
    </body>
</html>
