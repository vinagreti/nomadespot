// Alerta
// Classe responsável pela exibição de alertas
// Author: Bruno da Silva João
// https://github.com/vinagreti
function bosalert(titulo, mensagem, tipo_alerta, tempo) {

    // tipos de alerta disponíveis
    var tipos_alerta = ['success', 'info', 'warning', 'danger'];

    // define o titulo do alerta
    titulo = titulo ? titulo : '';

    // define a mensagem do alerta
    mensagem = mensagem ? mensagem : '';

    // verifica se o tipo de alerta passado é valido e se não for seta como alerta de danger
    tipo_alerta = (tipos_alerta.indexOf(tipo_alerta) > -1) ? tipo_alerta : 'danger';

    // define o tempo do alerta
    tempo = tempo ? tempo : 5000;

    // monta o html do alerta
    var alerta = $('<div class="alert alert-block alert-' + tipo_alerta + '" data-dismiss="alert"><strong>' + titulo + '</strong> <small>' + mensagem + '</small></div>');

    alerta.css('position', 'fixed');
    alerta.css('top', '2px');
    alerta.css('left', '0.2%');
    alerta.css('z-index', '9999');
    alerta.css('width', '99.6%');
    alerta.css('min-height', '46px');
    
    // remove os alertas antigos
    $(".alert").remove();

    // insere o alerta no modal
    $(document.body).prepend( alerta );

    // após 5 segundos
    setTimeout(function(){

        // remove o alerta do corpo do documento
        //alerta.remove();

    }, tempo);

    return mensagem;
        
}