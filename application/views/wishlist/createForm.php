<h1 class="page-header">
    Adicionar desejo
    <div class="pull-right visible-sm-block">
        <a class="btn btn-primary" data-form-action="close" href="javascript:void(0)"><i class="fa fa-arrow-left"></i> Voltar</a>
    </div>
    <div class="clearfix"></div>
</h1>

<p><small>Preencha o formulário abaixo e clique em "Salvar" para adicionar um desejo.</small></p>

<form id="wishlistCreateForm" method="POST" class="form-horizontal" role="form">

    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Título</label>
        <div class="col-sm-22">
            <input id="title" name="title" type="text" class="form-control" placeholder="Digite o título do desejo">
        </div>
    </div>

    <div class="form-group">
        <label for="country_typeahead" class="col-sm-2 control-label">País</label>
        <div class="col-sm-10">
            <input id="country_typeahead" type="text" class="form-control" placeholder="Digite o nome do país" autocomplete="off">
            <input id="country_id" name="country_id" type="hidden">
        </div>
    </div>

    <div class="form-group">
        <label for="coust" class="col-sm-2 control-label">Custo</label>
        <div class="col-sm-10">
            <input id="coust" name="coust" type="number" min="0" class="form-control" placeholder="Digite o custo">
        </div>
        <div class="col-sm-10">
            <p class="form-control-static currency_alphabetic_code"></p>
        </div>
    </div>

    <div class="form-group">
        <label for="desc" class="col-sm-2 control-label">Descrição</label>
        <div class="col-sm-22">
            <textarea id="desc" name="desc" class="form-control" placeholder="Descreva do desejo"></textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="status" class="col-sm-2 control-label">Status</label>
        <div class="col-sm-10">
            <label class="radio-inline">
                <input type="radio" name="status" value="1">
                Realizado
            </label>
            <label class="radio-inline">
                <input type="radio" name="status" value="0">
                Não Realizado
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="deadline" class="col-sm-2 control-label">Data limite</label>
        <div class="col-sm-6">
            <div class="input-group">
                <input class="form-control" id="deadline" name="deadline" type="email" placeholder="ex: 31/12/9999" readonly="">
                <div id="select_deadline" class="input-group-addon"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
    </div>

    <div class="form-group bostag">
        <label for="tags_typeahead" class="col-sm-2 control-label">Tags</label>
        <div class="col-sm-22">
            <div class="row">
                <div class="col-sm-20">
                    <input class="form-control bostag_input" type="text" placeholder="Digite o nome da tag" autocomplete="off">
                </div>
                <div class="col-sm-4">
                    <button type="button" class="bostag_add_button btn btn-success btn-block"><i class="fa fa-plus"></i> Criar tag</button>
                </div>
            </div>
            <div class="bostag_labels"></div>
            <select class="bostag_multiselect hide" name="tags" multiple></select>
        </div>
    </div>

    <div class="form-group">
        <label for="" class="col-sm-2 control-label"></label>
        <div class="col-sm-10">
            <button type="submit" name="submit" class="btn btn-success" data-form-action="submit"><i class="fa fa-check"></i> Salvar</button>
            <a class="btn btn-link" data-form-action="close" href="javascript:void(0)"> Cancelar</a>
        </div>
    </div>

</form>

<script type="text/javascript">

    nsp_wishlist.triggerCreateForm();

    bostag.triggerTagsTypeahead();

</script>