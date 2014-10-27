<h1 class="page-header">
    Adicionar inspiração
    <div class="pull-right visible-sm-block">
        <a class="btn btn-primary" data-form-action="close" href="javascript:void(0)"><i class="fa fa-arrow-left"></i> Voltar</a>
    </div>
    <div class="clearfix"></div>
</h1>

<p><small>Preencha o formulário abaixo e clique em "Salvar" para adicionar uma inspiração.</small></p>

<form id="inspirationsCreateForm" method="POST" class="form-horizontal" role="form">

    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Título</label>
        <div class="col-sm-22">
            <input id="title" name="title" type="text" class="form-control" placeholder="Digite o título da inspiração">
        </div>
    </div>

    <div class="form-group">
        <label for="link" class="col-sm-2 control-label">Link</label>
        <div class="col-sm-22">
            <input id="link" name="link" type="text" class="form-control" placeholder="Digite o link da inspiração">
        </div>
    </div>

    <div class="form-group">
        <label for="desc" class="col-sm-2 control-label">Descrição</label>
        <div class="col-sm-22">
            <textarea id="desc" name="desc" class="form-control" placeholder="Descreva da inspiração"></textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="country_typeahead" class="col-sm-2 control-label">País</label>
        <div class="col-sm-10">
            <input id="country_typeahead" type="text" class="form-control" placeholder="Digite o nome do país" autocomplete="off">
            <input id="country_id" name="country_id" type="hidden">
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

    nsp_inspirations.triggerCreateForm();

    bostag.triggerTagsTypeahead();

</script>