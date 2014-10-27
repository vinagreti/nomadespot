$(document).ready(function(){

    $(document).on('submit', '#loginForm', function( e ) {

        e.preventDefault();

        var user = $(this).serializeObject();

        $.post(base_url+'login', user)
        .done(function (res) {
            bosalert('Yeah!', res, 'success');
            setTimeout(function () {
                window.location = url_parameter('redirect_url') ? url_parameter('redirect_url') : base_url;
            }, 600)
        })
        .fail(function (a , b, res) {
            bosalert('Ops!', res, 'danger');
        });

        return false;

    });

    $(document).on('submit', '#retrievePasswordForm', function( e ) {

        e.preventDefault();

        var user = $(this).serializeObject();

        $.post(base_url+'retrievePassword', user)
        .done(function (res) {
            bosalert('Yeah!', res, 'success');
        })
        .fail(function (a , b, res) {
            bosalert('Ops!', res, 'danger');
        });

        return false;

    });

    $(document).on('submit', '#changePasswordForm', function( e ) {

        e.preventDefault();
        
        var passwords = $(this).serializeObject();

        $.post(base_url+'changePassword', user)
        .done(function (res) {
            bosalert('Yeah!', res, 'success');
        })
        .fail(function (a , b, res) {
            bosalert('Ops!', res, 'danger');
        });

        return false;

    });

});

if (typeof url_parameter != 'function'){
    // Get parameters from url
    function url_parameter(sParam)
    {
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) 
        {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam) 
            {
                return sParameterName[1];
            }
        }
    }
}