<main class="contenedor w-100 ptb-4">
        <section class="heading">
            <svg class="heading__icono" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-prompt"  viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <polyline points="5 7 10 12 5 17" />
                <line x1="13" y1="17" x2="19" y2="17" />
            </svg>
            <h3 class="heading__texto centrar-texto">Experiencia</h3>
        </section>
        <section class="experiencias">

        <?php foreach($categorias as $categoria): ?>
            <h4 class="experiencias__heading"><?php echo $categoria->nombre; ?></h4>

            <ul class="listado-experiencias">
                <?php foreach($experienciasPorCategoria[$categoria->id] as $experiencia): ?>

                    <li class="experiencia">
                        <div class="experiencia__info">
                            <h5><?php echo $experiencia->empresa; ?></h5>
                            <p class="experiencia__fecha">
                                <?php echo date("M Y", strtotime($experiencia->fechaInicio)) . ' - ';  

                                    if($experiencia->fechaFinal){

                                        echo date("M Y", strtotime($experiencia->fechaFinal));

                                    }else{

                                         echo 'Actualmente';

                                    };
                                
                                ?>
                                
                            </p>
                            <p><?php echo $experiencia->descripcion; ?></p>
                            <?php if($experiencia->clientes): ?>
                                <p><strong>Clientes:</strong> <?php echo $experiencia->clientes; ?></p>
                            <?php endif;
                                if($experiencia->entornos):
                            ?>
                                <p><strong>Entorno tecnológico:</strong> <?php echo $experiencia->entornos; ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="experiencia__competencias">
                            <h6 class="competencias__heading">Competencias adquiridas</h6>
                            <ul class="competencias__listado">
                                <?php foreach($competencias[$experiencia->id] as $competencia): ?>

                                    <li class="competencias__item"><?php echo $competencia->nombre . ', '; ?></li>
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

                <?php endforeach; ?>
            </ul>

        <?php endforeach; ?>

                
            </ul>
        </section>
        
    </main>