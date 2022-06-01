/********* CRUD */

if(document.querySelector('#formularioExperiencias')){

    //Para comprobar si ya se había seleccionado previamente (formulario enviado, algún error en el formulario, etc..) /también checbox fecha actual
    document.addEventListener('DOMContentLoaded', () =>{  

        comprobarCategoria();
        comprobarActual();

    })

    //Según categoría mostrar fieldset o no
    const categoria = document.querySelector('#categoria');
    const fieldsetInfoComplementaria = document.querySelector('fieldset:nth-of-type(2)');
    
    //Cuando se use el combo
    categoria.addEventListener('change', comprobarCategoria);

    //Trabajo actual
    const checkboxActual = document.querySelector('#actual');
    checkboxActual.addEventListener('change', comprobarActual);


    //Sugerencia competencias
    const competencias = document.querySelector('#competencias');
    competencias.addEventListener('input', comprobarCompetencias);

    //Función comprobar categoría seleccionada
    function comprobarCategoria(){

    if(categoria.value === "1"){

        //añadir .mostrar
        if(!fieldsetInfoComplementaria.classList.contains('mostrar')){
            
            fieldsetInfoComplementaria.classList.add('mostrar');
        }

        //habilitar los campos
        if(fieldsetInfoComplementaria.getAttribute('disabled')){

            fieldsetInfoComplementaria.removeAttribute('disabled');
        }
        

    }else{
        
        //quitar .mostar
        if(fieldsetInfoComplementaria.classList.contains('mostrar')){

            fieldsetInfoComplementaria.classList.remove('mostrar');
        }

        //deshabilitar los campos
        if(!fieldsetInfoComplementaria.getAttribute('disabled')){

            fieldsetInfoComplementaria.setAttribute('disabled', true);
        
        }

    }

    }

    //Función comprobar checkbox
    function comprobarActual(){

    const fechaFinal = document.querySelector('#fechaFinal');
    checkboxActual.checked ? fechaFinal.disabled = true : fechaFinal.disabled = false;

    }

    //función para sugerencias competencias
    function comprobarCompetencias(){

        const sugerencias = document.querySelector('.sugerencias');
        sugerencias.textContent = competencias.value;

    }

}

if(document.querySelector('#formularioFormaciones')){

    //Para comprobar si ya se había seleccionado previamente (formulario enviado, algún error en el formulario, etc..) /también checbox fecha actual
    document.addEventListener('DOMContentLoaded', () =>{  

        comprobarActual();

    })

    //Trabajo actual
    const checkboxActual = document.querySelector('#actual');
    checkboxActual.addEventListener('change', comprobarActual);


    //Función comprobar checkbox
    function comprobarActual(){

    const fechaFinal = document.querySelector('#fechaFinal');
    checkboxActual.checked ? fechaFinal.disabled = true : fechaFinal.disabled = false;

    }

}


