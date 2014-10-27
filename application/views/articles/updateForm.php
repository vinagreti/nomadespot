<h1 class="page-header">
    Editar artigo
    <div class="pull-right visible-sm-block">
        <a class="btn btn-primary" data-form-action="close" href="javascript:void(0)"><i class="fa fa-arrow-left"></i> Voltar</a>
    </div>
    <div class="clearfix"></div>
</h1>

<p><small>Preencha o formulário abaixo e clique em "Salvar" para editar este artigo.</small></p>

<form id="articlesUpdateForm" method="PATCH" class="form" role="form">

    <div class="form-group">
        <input id="title" name="title" type="text" class="form-control" placeholder="Insira o título do artigo">
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" name="updateSlug"> Atualizar slug
        </label>
    </div>

    <div class="form-group">
        <textarea class="form-control" id="editor1"></textarea>
        <textarea class="hide" name="content" id="content"></textarea>
    </div>

    <div class="form-group bostag">
        <div class="row">
            <div class="col-xs-20">
                <input class="form-control bostag_input" type="text" placeholder="Digite o nome da tag" autocomplete="off">
                <div class="bostag_labels"></div>
                <select class="bostag_multiselect hide" name="tags" multiple></select>
            </div>
            <div class="col-xs-4">
                <button type="button" class="bostag_add_button btn btn-success btn-block"><i class="fa fa-plus"></i> Criar tag</button>
            </div>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" name="submit" class="btn btn-success" data-form-action="submit"><i class="fa fa-check"></i> Salvar</button>
        <a class="btn btn-link" data-form-action="close" href="javascript:void(0)"> Cancelar</a>
    </div>

</form>

<script type="text/javascript">

    nsp_articles.triggerUpdateForm();

    bostag.triggerTagsTypeahead();

</script>