<div class="bostable" id="articlesTable" data-resource-uri="<?=base_url()?>articles">
    <div class="bostable_head">
        <h1 class="page-header">
            Artigos
            <div class="pull-right">
                <button class="btn btn-success" data-crud-create="<?=base_url()?>articles/createForm"><i class="fa fa-plus"></i> Criar artigo</button>
            </div>
            <div class="clearfix"></div>
        </h1>
        <p><small>Gerenciamento dos artigos</small></p>
    </div>
    <table class="table table-hover table-condensed table-striped">
        <thead>
            <th class="col-sm-1" ordenavel>ID</th>
            <th ordenavel>Título</th>
            <th class="col-sm-3" ordenavel>Descrição</th>
            <th class="col-sm-3" ordenavel>País</th>
            <th class="col-sm-2 text-center">Ações</th>
        </thead>
        <tbody>
            <tr>
                <td class="id"></td>
                <td><span class="title click" data-crud-read="<?=base_url()?>articles/readTemplate" data-toggle="tooltip" title="Abrir artigo"></span></td>
                <td class="desc"></td>
                <td class="countrie_name"></td>
                <td class="text-center">
                    <div class="dropdown">
                      <button class="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                          <i class="fa fa-caret-square-o-down"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
                        <li><a type="javascript:void(0)" class="btn btn-link viewArticle" data-crud-read="<?=base_url()?>articles/readTemplate" data-toggle="tooltip" title="Abrir artigo"><i class="fa fa-expand text-info"></i> Abrir artigo</a></li>
                        <li><a type="javascript:void(0)" class="btn btn-link editArticle" data-crud-update="<?=base_url()?>articles/updateForm" data-toggle="tooltip" title="Editar artigo"><i class="fa fa-edit text-success"></i> Editar artigo</a></li>
                        <li><a type="javascript:void(0)" class="btn btn-link deletArticle" data-crud-drop="<?=base_url()?>articles/deleteForm" data-toggle="tooltip" title="Excluir artigo"><i class="fa fa-trash-o text-danger"></i> Excluir artigo</a></li>
                      </ul>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>