   <main class="contenedor w-100 ptb-4">
        <section class="heading">
            <svg class="heading__icono" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-prompt" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <polyline points="5 7 10 12 5 17" />
                <line x1="13" y1="17" x2="19" y2="17" />
            </svg>
            <h3 class="heading__texto centrar-texto">Formación</h3>
        </section>
        <section class="experiencias">
            <?php foreach($categorias as $categoria): ?>

                <h4 class="experiencias__heading"><?php echo $categoria->nombre; ?></h4>
                <ul class="listado-experiencias">
                    <li class="experiencia">
                        <div class="experiencia__info">

                            <?php foreach($subcategoriasPorCategoria[$categoria->id] as $subcategoria): ?>

                                <h5><?php echo $subcategoria->nombre; ?></h5> 
                                <p>
                                    <?php foreach($formacionesPorSubcategoria[$subcategoria->id] as $formacion): ?>
                                        <span class="experiencia__fecha">
                                            <?php echo date("Y", strtotime($formacion->fechaInicio));  

                                            if($formacion->fechaFinal){

                                                if(date("Y", strtotime($formacion->fechaInicio)) === date("Y", strtotime($formacion->fechaFinal))){
                                                    echo '';
                                                }else{
                                                    echo ' - ' . date("Y", strtotime($formacion->fechaFinal));
                                                }

                                            }else{

                                                echo ' - Actual';

                                            };

                                            ?>
                                        </span>. <?php echo $formacion->nombre; ?>. <strong><?php echo $formacion->centro; ?></strong>
                                        <?php if($formacion->infoExtra): ?>
                                            <em>(<?php echo $formacion->infoExtra; ?>)</em>
                                        <?php endif; ?>
                                        <br>
                                    <?php endforeach; ?><!--formaciones-->
                                </p>
                            <?php endforeach; ?><!-- subcategorias - formaciones-->
                        
                        </div>
                        <div class="experiencia__competencias">
                            <h6 class="competencias__heading">Competencias adquiridas</h6>
                            <?php foreach($subcategoriasPorCategoria[$categoria->id] as $subcategoria): ?>
                                <ul class="competencias__listado">
                                    <?php foreach($competenciasPorSubcategoria[$subcategoria->id] as $competencia):
                                        
                                        if($competencia===end($competenciasPorSubcategoria[$subcategoria->id])):

                                        ?>
                                            <li class="competencias__item"><?php echo $competencia->nombre; ?></li>
                                    <?php else: ?>
                                        <li class="competencias__item"><?php echo $competencia->nombre. ', '; ?></li>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                    <li class="competencias__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cursor-text" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M10 12h4" />
                                            <path d="M9 4a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3" />
                                            <path d="M15 4a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3" />
                                        </svg>
                                    </li>
                                </ul>
                            <?php endforeach; ?><!--subcategorias - competencias-->
                        </div>
                    </li>
                </ul>
            <?php endforeach; ?><!-- categorias -->
        </section>
        
    </main>