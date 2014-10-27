<h1 class="page-header">Recuperar senha</h1>

<div class="col-md-offset-8 col-md-8 well">

    <form id="retrievePasswordForm" role="form">

      <div class="form-group">

        <label for="email">Informe o e-mail cadastrado:</label>

        <input type="text" class="form-control" id="email" name="email" placeholder="Qual seu e-mail?">

      </div>

      <div class="pull-right">

        <button id="retrievePassword" type="submit" class="btn btn-primary" data-loading-text="Recuperando...">Recuperar senha</button>

        <a href="<?=base_url()?>login" class="btn btn-default">Cancelar</a>

      </div>

    </form>

</div>