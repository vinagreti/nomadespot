<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="raodtrip site">
    <meta name="author" content="Bruno da Silva Joao">

    <!-- ****** favicons do faviconit.com ****** -->
    <link rel="shortcut icon" href="<?=base_url()?>assets/img/favicons/favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="<?=base_url()?>assets/img/favicons/favicon.ico">
    <link rel="icon" type="image/png" sizes="196x196" href="<?=base_url()?>assets/img/favicons/favicon-196.png">
    <link rel="icon" type="image/png" sizes="160x160" href="<?=base_url()?>assets/img/favicons/favicon-160.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=base_url()?>assets/img/favicons/favicon-96.png">
    <link rel="icon" type="image/png" sizes="64x64" href="<?=base_url()?>assets/img/favicons/favicon-64.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=base_url()?>assets/img/favicons/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>assets/img/favicons/favicon-16.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=base_url()?>assets/img/favicons/favicon-152.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=base_url()?>assets/img/favicons/favicon-144.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=base_url()?>assets/img/favicons/favicon-120.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=base_url()?>assets/img/favicons/favicon-114.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url()?>assets/img/favicons/favicon-76.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=base_url()?>assets/img/favicons/favicon-72.png">
    <link rel="apple-touch-icon" href="<?=base_url()?>assets/img/favicons/favicon-57.png">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="<?=base_url()?>assets/img/favicons/favicon-144.png">
    <meta name="msapplication-config" content="<?=base_url()?>assets/img/favicons/browserconfig.xml">
    <!-- ****** favicons do faviconit.com ****** -->

    <title>Guarani por aí</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url()?>assets/third-party/bootstrap-3.2.0-24grid/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome core CSS -->
    <link rel="stylesheet" href="<?=base_url()?>assets/third-party/font-awesome-4.1.0/css/font-awesome.min.css">

    <!-- Custom CSS guarani por ai - gpa.css -->
    <link href="<?=base_url()?>assets/css/default.css" rel="stylesheet">

    <!-- Carrega css dinamicamente -->
    <?php if( isset($arquivos_css) ) foreach( $arquivos_css as $key => $css ) echo '<link href="'.base_url().'assets/'.$css.'.css" rel="stylesheet">'; ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <nav class="navbar navbar-fixed-top navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-24 col-md-offset-1 col-md-22">
                     <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu_collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" rel="home" href="<?=base_url()?>" title="nomadespot.com">
                            <img id="nav_logo" src="<?=base_url()?>assets/img/logo.png">
                        </a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="menu_collapse">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">O Projeto <span class="caret"></span></a>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li class="<?php if($this->router->class == 'project') echo 'active'; ?>"><a href="<?=base_url()?>project">História</a></li>
                                    <li class="<?php if($this->router->class == 'sponsorship') echo 'active'; ?>"><a href="<?=base_url()?>sponsorship">Patrocínio e Apoio</a></li>
                                    <li class="<?php if($this->router->class == 'car') echo 'active'; ?>"><a href="<?=base_url()?>car">O carro</a></li>
                                    <li class="<?php if($this->router->class == 'crew') echo 'active'; ?>"><a href="<?=base_url()?>crew">Tripulação</a></li>
                                    <li class="<?php if($this->router->class == 'itinerary') echo 'active'; ?>"><a href="<?=base_url()?>itinerary">Percurso</a></li>
                                    <li class="<?php if($this->router->class == 'donate') echo 'active'; ?>"><a href="<?=base_url()?>donate">Doação</a></li>
                                    <li class="<?php if($this->router->class == 'accounting') echo 'active'; ?>"><a href="<?=base_url()?>accounting">Contabilidade</a></li>
                                    <li class="<?php if($this->router->class == 'wishlist') echo 'active'; ?>"><a href="<?=base_url()?>wishlist">Lista de desejos</a></li>
                                    <li class="<?php if($this->router->class == 'inspirations') echo 'active'; ?>"><a href="<?=base_url()?>inspirations">Inspirações</a></li>
                                    <li class="<?php if($this->router->class == 'hostus') echo 'active'; ?>"><a href="<?=base_url()?>hostus">Hospede-nos</a></li>
                                </ul>
                            </li>
                            <li class="<?php if($this->router->class == 'articles') echo 'active'; ?>"><a href="<?=base_url()?>articles">Artigos</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Galeria <span class="caret"></span></a>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li><a href="<?=base_url()?>audios">Audio</a></li>
                                    <li><a href="<?=base_url()?>images">Imagem</a></li>
                                    <li><a href="<?=base_url()?>videos">Vídeo</a></li>
                                </ul>
                            </li>                    <li class="<?php if($this->router->class == 'contact') echo 'active'; ?>"><a href="<?=base_url()?>contact">Contato</a></li>
                            <li class="<?php if($this->router->class == 'services') echo 'active'; ?>"><a href="<?=base_url()?>services">Serviços</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?=base_url()?>login"><i class="fa fa-sign-in"></i></a></li>
                        </ul>
                        <div class="col-sm-6 col-md-6 pull-right">
                            <form class="navbar-form" role="search">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
                                    <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.navbar-collapse -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </nav>

    <div id="template-content" class="container-fluid">
        <?= $content ?>
    </div>

    <div id="template_footer" class="container-fluid">
        <div class="col-sm-24 col-md-offset-1 col-md-22">
            <div class="row">
                <div class="col-sm-6 text-center">
                    <p><a class="btn btn-success btn-lg " href="<?=base_url()?>services">Serviços</a></p>
                </div>
                <div class="col-sm-6 text-center">
                    <p><a class="btn btn-info btn-lg " href="<?=base_url()?>donate">Doação</a></p>
                </div>
                <div class="col-sm-6 text-center">
                    <p><a class="btn btn-warning btn-lg " href="<?=base_url()?>hostus">Hospede-nos</a></p>
                </div>
                <div class="col-sm-6 text-center">
                    <p><a class="btn btn-primary btn-lg " href="<?=base_url()?>contact">Contato</a></p>
                </div>
            </div>
            <p class="text-center">
                <a class="btn btn-default btn-xs text-info" href=""><i class="fa fa-facebook-square fa-2x"></i></a>
                <a class="btn btn-default btn-xs text-info" href=""><i class="fa fa-twitter-square fa-2x"></i></a>
                <a class="btn btn-default btn-xs text-info" href=""><i class="fa fa-google-plus-square fa-2x"></i></a>
                <a class="btn btn-default btn-xs text-info" href=""><i class="fa fa-github-square fa-2x"></i></a>
                <a class="btn btn-default btn-xs text-info" href=""><i class="fa fa-instagram fa-2x"></i></a>
                <a class="btn btn-default btn-xs text-info" href=""><i class="fa fa-linux fa-2x"></i></a>
                <a class="btn btn-default btn-xs text-info" href=""><i class="fa fa-vimeo-square fa-2x"></i></a>
                <a class="btn btn-default btn-xs text-info" href=""><i class="fa fa-youtube fa-2x"></i></a>
                <a class="btn btn-default btn-xs text-info" href=""><i class="fa fa-pinterest fa-2x"></i></a>
            </p>
            <address class="text-center">
                <strong>Desenvolvido por:</strong>
                <a class"text-warning" href="mailto:bruno@tzadi.com">Bruno da Silva João</a>
            </address>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="<?=base_url()?>assets/third-party/jquery/jquery.min.js"></script>

    <!-- Core twitter bootstrap -->
    <script type="text/javascript" src="<?=base_url()?>assets/third-party/bootstrap-3.2.0-24grid/js/bootstrap.min.js"></script>

    <!-- bosalert.js -->
    <script type="text/javascript" src="<?=base_url()?>assets/third-party/bosalert/bosalert.js"></script>

    <!-- jquery-data-bin.js -->
    <script type="text/javascript" src="<?=base_url()?>assets/third-party/jquery-data-bind/jquery-data-bind.js"></script>

    <!-- jquery-serialize-object.js -->
    <script type="text/javascript" src="<?=base_url()?>assets/third-party/jquery-serialize-object/jquery-serialize-object.js"></script>

    <!-- definindo token para evitar CSRF - Cross Site Request Forgery -->
    <script type="text/javascript"> var csrf_token = "<?=$this->security->get_csrf_hash()?>";</script>

    <!-- csrf.js -->
    <script type="text/javascript" src="<?=base_url()?>assets/js/csrf.js"></script>

    <!-- Define a url do root_path -->
    <script type="text/javascript"> var base_url = "<?=base_url()?>"</script>

    <!-- Carrega scripts dinamicamente -->
    <?php if( isset($arquivos_js) ) foreach( $arquivos_js as $key => $script ) echo '<script src="'.base_url().'assets/'.$script.'.js"></script>'; ?>

    <!-- Google analytics -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-42648751-2', 'auto');
        ga('send', 'pageview');
    </script>
</body>

</html>