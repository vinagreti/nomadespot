<h1 class="page-header">Alterar senha</h1>

<div class="col-md-offset-4 col-md-4 well">

  <form id="changePasswordForm" role="form">

    <div class="form-group">

      <label for="password1">Nova password</label>

      <input type="password" class="form-control" id="password1" name="password1" placeholder="informe a nova senha">

    </div>

    <div class="form-group">

      <label for="password2">Confirmação da nova senha</label>

      <input type="password" class="form-control" id="password2" name="password2" placeholder="repita a nova senha">

    </div>

    <div class="pull-right">

      <button id="changePassword" type="submit" class="btn btn-primary" data-loading-text="Alterando...">Alterar senha</button>

      <a href="<?=base_url()?>" class="btn btn-default">Cancelar</a>

    </div>

  </form>

</div>