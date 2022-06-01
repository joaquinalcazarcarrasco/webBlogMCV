            <h1>ADMIN</h1>
        </div>
    </header><!-- .header -->
    <div class="main">
        <main class="container main-content">

            <?php
                $alert = showAlert($resultGET);
                if($alert):
            ?>
                <div class="alert green">
                    <p><?php echo $alert; ?></p>
                </div>
            <?php endif; ?>

            <div class="mb2">
                <a class="button green" href="/admin/crear">Crear entrada</a>
            </div>

   
            <form method="GET" class="search-bar">
                <input type="text" name="search" id="search" placeholder="Buscar..." />
                <input class="button" type="submit" name="search-button" id="search-button" value="Buscar" />
            </form>
   
            <?php if($search): ?>
                <div class="search-result">
                    <p>El restultado para <span><?php echo $search; ?></span> es:</p>

                </div>

                <?php if(empty($allNews)): ?>
                    <section class="alert gray">
                        <p>No hay resultados para esta búsqueda</p>
                    </section>
                <?php endif; ?>

            <?php else: ?>
                <?php if(empty($allNews)): ?>
                    <section class="alert gray">
                        <p>No hay entradas creadas</p>
                    </section>
                <?php endif; ?>

            <?php endif; ?>
            <article class="list-news-admin">

                <?php foreach($allNews as $news): ?>
                    <section class="news">
                        <div class="news-content">
                            <h2><?php echo $news->title; ?></h2>
                            <p class="news-date"><?php echo $news->publishDate; ?></p>
                            
                            <p><?php echo strip_tags(substr($news->entry, 0, 200)) . '...'; ?></p>
                        </div>
                        <div class="news-buttons">
                            <a href="/admin/actualizar?id=<?php echo $news->id; ?>" class="button">Actualizar</a>
                            <form method="POST" action="/admin/eliminar">
                                <input type="hidden" name="id" value="<?php echo $news->id; ?>">
                                <input class="button red" type="submit" value="Eliminar">
                            </form>
                        </div>
                    </section><!--.news-->
                <?php endforeach; ?>
            </article>
        </main>
    </div><!-- .main -->
    <?php if(isset($totalPages)): ?>

<div class="paging">
    <div class="container">
        <ul class="paging-list">
        <?php
            
            if($totalPages > 1):
                if($page != 1):
            
        ?>

            <li><a href="?<?php echo $search ? 'search=' . $search . '&' : ''; ?>page=<?php echo $page-1; ?>"><</a></li>
        
        <?php 

                endif;
                for($i=1;$i<=$totalPages;$i++):
                    if($page == $i):
        ?>

                    <li><a class="current" href="#"><?php echo $page; ?></a></li>
                
        <?php 
                    
                    else:

        ?>

                    <li><a href="?<?php echo $search ? 'search=' . $search . '&' : ''; ?>page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    
        <?php             

                    endif;

                endfor;

                if($page != $totalPages):
        ?>

                    <li><a href="?<?php echo $search ? 'search=' . $search . '&' : ''; ?>page=<?php echo $page+1; ?>">></a></li>
        <?php
                    

                endif;
            endif;

        ?> 
             
        </ul>
    </div>
</div><!-- .paging -->
<?php endif; ?>
</body>
</html>