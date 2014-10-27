<h1 class="page-header">Entrar</h1>

<div class="col-md-offset-4 col-md-16 well clearfix">

    <form id="loginForm" class="form" role="form" method="POST" action="<?=base_url()?>login">

        <div class="form-group">

            <label for="email">Email</label>

            <input type="text" class="form-control" id="email" name="email" placeholder="Qual seu email?">

        </div>

        <div class="form-group">

            <label for="password">Senha</label>

            <input type="password" class="form-control" id="password" name="password" placeholder="Qual sua password?">

        </div>

        <div><small><a href="<?=base_url()?>retrievePassword">Recuperar password</a></small></div>

        <span class="pull-right">

            <button id="entrar" type="submit" class="btn btn-primary" data-loading-text="Entrando...">Entrar</button>

            <a href="<?=base_url()?>" class="btn btn-link">Cancelar</a>

        </span>

    </form>

</div>
