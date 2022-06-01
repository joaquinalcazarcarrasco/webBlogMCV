
<main id="formularioFormaciones" class="contenedor ptb-4">
    <section class="heading">
        <svg class="heading__icono" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-prompt" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <polyline points="5 7 10 12 5 17" />
            <line x1="13" y1="17" x2="19" y2="17" />
        </svg>
        <h3 class="heading__texto centrar-texto">Actualizar Formación</h3>
    </section>
    
    <div class="volver">
        <a class="boton boton-azul" href="/formaciones/index">Volver</a>
    </div>

    <form method="POST" class="formulario">
        <?php foreach($errores as $error): ?>
            
            <div class="alerta error">
                <?php echo $error ?>   
            </div>
        
        <?php endforeach; ?>
        <fieldset>
            <legend>Información Principal</legend>
            <label for="subcategoria">Categoría(*)</label>
            <select name="subcategoria" id="subcategoria">
                <option value="">--- Selecciona ---</option>
                <?php foreach($categorias as $categoria): ?>
                    <optgroup label="<?php echo $categoria->nombre; ?>">    
                        <?php foreach($subcategoriasPorCategoria[$categoria->id] as $subcategoria): ?>
                            <option value="<?php echo $subcategoria->id; ?>" <?php echo $formacion->subcategoria===$subcategoria->id ? 'selected' : '' ?>><?php echo $subcategoria->nombre; ?></option>                    
                        <?php endforeach; ?>
                    </optgroup>
                <?php endforeach; ?>
            </select>

            <label for="centro">Centro educativo(*): </label>
            <input type="text" name="centro" id="centro" placeholder="Ej: Universidad de Cádiz" <?php echo $formacion->centro ? "value='$formacion->centro'" : ''; ?>>

            <label for="nombre">Título(*):</label>
            <input type="text" name="nombre" id="nombre" <?php echo $formacion->nombre ? "value='$formacion->nombre'" : ''; ?>>

            <label for="fechaInicio">Fecha de Inicio(*): </label>
            <input type="date" name="fechaInicio" id="fechaInicio" 
                <?php
                    echo $formacion->fechaInicio ? "value='$formacion->fechaInicio'" : '';
                    echo " max='${hoy}'"; 
                ?>>

            <label for="fechaFinal">Fecha de Fin: </label>
            <input type="date" name="fechaFinal" id="fechaFinal" 
                <?php
                    echo $formacion->fechaFinal ? "value='$formacion->fechaFinal'" : '';
                    echo " max='${hoy}'"; 
                ?>>

            <label for="actual">No lo he finalizado aún</label>
            <input type="checkbox" name="actual" id="actual" <?php echo $actual==='on' ? 'checked' : '' ?>>

        </fieldset>
        <fieldset></fieldset>

        <fieldset>
            <legend>Competencias adquiridas</legend>
            <label for="competencias">Puedes escribir una o varias competencias separadas por comas(*):</label>
            <input type="text" name="competencias" id="competencias" placeholder="Ej: Creatividad" <?php echo $competenciasStr ? "value='$competenciasStr'" : ''; ?>>
            
        </fieldset>

        <input class="boton boton-azul" type="submit" value="Actualizar Formación">
    </form>
</main>