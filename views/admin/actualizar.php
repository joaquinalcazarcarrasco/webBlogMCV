
            <h1>ADMIN</h1>
        </div>
    </header><!-- .header -->
    <div class="main">
        <main class="container creating-news">
            <div class="mb2">
                <a class="button" href="/admin">Volver</a>
            </div>

            <!-- Mostrar errores o confirmación de registro creado -->
            <?php foreach($errors as $error): ?>
                <div class="alert red">
                    <p><?php echo $error; ?></p>
                </div>
            <?php endforeach; ?>

            <?php 
                echo '<pre>';
                var_dump(sanitise($news->title));
                echo '</pre>';
                exit;
            ?>

            <form class="form-creating-news" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Actualizando entrada</legend>
                    <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['id']; ?>" />
                    <label for="title">Título*</label>
                    <input type="text" id="title" name="title" placeholder="Tu título..." value="<?php echo sanitise($news->title); ?>"/>
                    <label for="image">Sube tu imagen*</label>
                    <input type="file" id="image" name="image" accept="image/jpeg, image/png" />
                    <?php if($news->image && file_exists(DIR_IMAGES . $news->image)): ?>
        
                        <img loading="lazy" src="/images/imgNews/<?php echo $news->image; ?>" class="uploaded-image" alt="Imagen de entrada">

                    <?php endif; ?>
                    <label>Contenido*</label>
                    <?php
                        $data = str_replace( '&', '&amp;', $news->entry);
                    ?>                
                    <textarea name="entry" id="editor">
                        <?= $data ?>
                    </textarea>

                    <div class="text-right mt2">
                        <input type="submit" id="submitNews" name="submitNews" class="button green" value="Submit">
                    </div>
                </fieldset>
            </form><!--.news-->
            <div class="mt2">
                <a class="button" href="/admin">Volver</a>
            </div>
        </main>
    </div><!-- .main -->
    <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
    <script src="/js/scripts.js"></script>
</body>
</html>