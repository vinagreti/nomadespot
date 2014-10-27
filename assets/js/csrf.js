$(document).ready(function(){

    // define o token a ser enviado nas requisicoes ajax evitando CSRF - Cross Site Request Forgery
    $.ajaxSetup({
        data: { csrf_token: csrf_token }
    });

});