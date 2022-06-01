<main class="contenedor w-100 ptb-4">
        <section class="heading">
            <svg class="heading__icono" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-prompt"  viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <polyline points="5 7 10 12 5 17" />
                <line x1="13" y1="17" x2="19" y2="17" />
            </svg>
            <h3 class="heading__texto centrar-texto">Administración Formaciones</h3>
        </section>
        <?php if($registroResultado): ?>
            <div class="alerta exito">
                <?php echo $registroResultado; ?>   
            </div>
        <?php endif; ?>

        <div class="volver">
            <a class="boton boton-azul" href="/formaciones/crear">Crear Formación</a>
        </div>
        <section class="experiencias">
        <?php foreach($categorias as $categoria): ?>

            <h4 class="experiencias__heading"><?php echo $categoria->nombre; ?></h4>
            <ul class="listado-experiencias">
                <?php foreach($subcategoriasPorCategoria[$categoria->id] as $subcategoria): ?>
                    <?php foreach($formacionesPorSubcategoria[$subcategoria->id] as $formacion): ?>
                        <li class="experiencia">
                            <div class="experiencia__info">

                                <h5><?php echo $subcategoria->nombre; ?></h5> 
                                <p>
                                    
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
                                    
                                </p>
                                <div class="espacio"></div>

                                <div class="botones-experiencia">

                                    <a class="boton boton-azul" href="/formaciones/actualizar?id=<?php echo $formacion->id; ?>">Actualizar</a>

                                    <form method="POST" action="/formaciones/eliminar">
                                        <input type="hidden" name="id" value="<?php echo $formacion->id; ?>">
                                        <input type="submit" class="boton boton-rojo" value="Eliminar">
                                    </form>              

                                </div>
                            
                            </div>
                            <div class="experiencia__competencias">
                            <h6 class="competencias__heading">Competencias adquiridas</h6>
                                <ul class="competencias__listado">
                                    <?php foreach($competenciasPorFormacion[$formacion->id] as $competencia): ?>
                                        <li class="competencias__item"><?php echo $competencia->nombre; ?></li>
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
                            </div>
                        </li>
                    <?php endforeach; ?><!--formaciones-->
                <?php endforeach; ?><!-- subcategorias - formaciones-->
            </ul>
            <?php endforeach; ?><!-- categorias -->
        </section>
        
    </main>