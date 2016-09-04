function Letras(e){
    tecla = e.keyCode || e.which;
    base =/[a-zñ ]/;
    teclado = String.fromCharCode(tecla).toLowerCase();
    return base.test(teclado);
}

function Vacios(e){
    tecla = e.keyCode || e.which; 
    base =/[a-zñ]/; 
    teclado = String.fromCharCode(tecla).toLowerCase(); 
    return base.test(teclado); 
}


function Numeros(e){
    tecla = e.keyCode || e.which;
    base =/[0-9]/;
    teclado = String.fromCharCode(tecla).toLowerCase();
    return base.test(teclado);
}

function Numeros_otro(e){
    tecla = e.keyCode || e.which;
    base =/[0-9-.,]/;
    teclado = String.fromCharCode(tecla).toLowerCase();
    return base.test(teclado);
}