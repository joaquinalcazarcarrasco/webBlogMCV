<?php
    use Model\Users;
?>
           
           <h1>Blog</h1>
        </div>
    </header><!-- .header -->
    <div class="main">
        <main class="container main-content">
            <?php foreach($errors as $error): ?>
                <div class="alert red">
                    <p><?php echo $error; ?></p>
                </div>
            <?php endforeach; ?>

            <?php
                if($resultGET):
            ?>
                <div class="alert green">
                    <p>Comentario insertado correctamente</p>
                </div>
            <?php endif; ?>

            <div class="mb2">
                <a class="button" href="/blog">Volver</a>
            </div>
            
            <article class="entry">
                <h2><?php echo $news->title; ?></h2>
                <p class="entry__info"><?php echo $news->publishDate; ?><span><?php echo $user->nickname; ?></span></p>
                <div class="entry__img"><img loading="lazy" src="/images/imgNews/<?php echo $news->image; ?>" alt="Imagen de entrada"/></div>
                <?php echo $news->entry; ?>
            </article>
            <article class="comments">
                
                <?php
                    
                    $nComments = count($comments);
                    if($nComments > 0): 
                
                ?>

                    <h3><?php echo ($nComments>1) ? $nComments . ' comentarios' : $nComments . ' comentario'; ?></h3>
                
                <?php else: ?>

                    <div class="alert gray">No hay comentarios para esta entrada</div>
                
                <?php endif; ?>

                <?php foreach($comments as $comment): ?>

                    <section class="comment">
                        <?php 
                        
                            $userComment = Users::find($comment->user_id);

                        ?>
                        <p><?php echo $comment->comment; ?></p>
                        <p class="comment__info"><?php echo $comment->publishDate; ?><span><?php echo $userComment->nickname; ?></span></p>
                    </section>

                <?php endforeach; ?>

                <?php if($_SESSION['login']): ?>

                    <form method="POST" class="comments__form">
                        <fieldset>
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['id']; ?>">
                            <input type="hidden" name="news_id" id="news_id" value="<?php echo $news->id; ?>">
                            <label for="comment"><span><?php echo $_SESSION['nickname']; ?></span> - comentario:</label>
                            <textarea id="comment" name="comment"></textarea>
                            <input class="button mt2" type="submit" id="send_comment" name="send_comment" value="Enviar" />
                        </fieldset>
                    </form>

                <?php else: ?>

                    <div class="mt2 text-right">
                        <a class="button" href="/blog/login?from=1&id=<?php echo $id; ?>">Inicia sesión para dejar un comentario</a>
                    </div>

                <?php endif; ?>
            </article>
            <div class="mt2">
                <a class="button" href="/blog">Volver</a>
            </div>
        </main>
    </div><!-- .main -->
    
</body>
</html>