    
    <main class="contenedor ptb-4">
        <div class="heading">
            <svg class="heading__icono" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-prompt" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <polyline points="5 7 10 12 5 17" />
                <line x1="13" y1="17" x2="19" y2="17" />
            </svg>
            <h3 class="heading__texto centrar-texto">Contacto</h3>
        </div>
        <div class="contenido">
            <div class="contenedor contacto">
            <?php foreach($errores as $error): ?>
                    
                    <div class="alerta error">
                        <?php echo $error ?>   
                    </div>
                
                <?php endforeach;
                    if($mensajeResultado!==''):
                ?>
                    <div class="alerta exito">
                        <?php echo $mensajeResultado ?>   
                    </div>
                <?php endif; ?>
            <h4 class="contacto__heading centrar-texto mt-4">Puedes enviarme un mensaje a través del siguiente formulario.</h4>

            <form method="POST" class="formulario mt-4" action="/contacto">

                <fieldset>
                    <legend>Información Principal</legend>
                    <p><?php echo $contacto['nombre'] ?>

                    <label for="nombre">Nombre(*): </label>
                    <input type="text" id="nombre" name="contacto[nombre]" placeholder="Escribe tu nombre" value="<?php echo $contacto['nombre'] ? $contacto['nombre'] : ''; ?>">

                    <label for="email">E-mail(*): </label>
                    <input type="mail" id="email" name="contacto[email]" placeholder="Ej: nombre@dominio.es" value="<?php echo $contacto['email'] ? $contacto['email'] : ''; ?>">

                    <label for="asunto">Asunto(*): </label>
                    <input type="text" id="asunto" name="contacto[asunto]" placeholder="Escribe un asunto" value="<?php echo $contacto['asunto'] ? $contacto['asunto'] : ''; ?>">

                    <label for="mensaje">Mensaje(*):</label>
                    <textarea name="contacto[mensaje]" id="mensaje"><?php echo $contacto['mensaje'] ? $contacto['mensaje'] : ''; ?></textarea>

                </fieldset>

                <input class="boton boton-azul" type="submit" value="Enviar mensaje">
            </form>
                <h4 class="contacto__heading centrar-texto mt-4">O puedes contactarme a través de cualquiera de estas vías.</h4>
                <ul class="contacto__listado no-margin no-padding">
                    <li class="item-contacto">
                        <a href="tel:+34630168373" class="contacto-enlace" title="630168373">
                            <div class="contacto-enlace__icono">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="88" height="88" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                </svg>
                            </div>
                            <p class="contacto-enlace__texto centrar-texto">630168373</p>
                        </a>
                    </li>
                    <li class="item-contacto">
                        <a class="contacto-enlace" href="mailto:joaquinalcazarcarrasco@gmail.com" title="Enlace correo electrónico" target="_blank">
                            <div class="contacto-enlace__icono">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="88" height="88" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <rect x="3" y="5" width="18" height="14" rx="2" />
                                    <polyline points="3 7 12 13 21 7" />
                                </svg>
                            </div>
                            <p class="contacto-enlace__texto centrar-texto">Correo electrónico</p>
                        </a>
                    </li>
                    <li class="item-contacto">
                        <a class="contacto-enlace" href="https://www.linkedin.com/in/joaquinalcazarcarrasco/" title="Enlace a perfil de Linkedin" target="_blank">
                            <div class="contacto-enlace__icono">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-linkedin" width="88" height="88" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <rect x="4" y="4" width="16" height="16" rx="2" />
                                    <line x1="8" y1="11" x2="8" y2="16" />
                                    <line x1="8" y1="8" x2="8" y2="8.01" />
                                    <line x1="12" y1="16" x2="12" y2="11" />
                                    <path d="M16 16v-3a2 2 0 0 0 -4 0" />
                                </svg>
                            </div>
                            <p class="contacto-enlace__texto centrar-texto">Perfil de Linkedin</p>
                        </a>
                    </li>
                    <li class="item-contacto">
                        <a class="contacto-enlace" href="https://europa.eu/europass/eportfolio/api/eprofile/shared-profile/9a397a0d-485a-4e6d-aec4-d2571c1800b8?view=html" title="Enlace a CV Europass" target="_blank">
                            <div class="contacto-enlace__icono">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-text" width="88" height="88" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                    <line x1="9" y1="9" x2="10" y2="9" />
                                    <line x1="9" y1="13" x2="15" y2="13" />
                                    <line x1="9" y1="17" x2="15" y2="17" />
                                </svg>
                            </div>
                            <p class="contacto-enlace__texto centrar-texto">CV Europass</p>
                        </a>
                    </li>
                    
                </ul>
            </div>
            
        </div>
        
    </main>
