<div class="bostable" id="wishlistTable" data-resource-uri="<?=base_url()?>wishlist">
    <div class="bostable_head">
        <h1 class="page-header">
            Wishlist
            <div class="pull-right">
                <button class="btn btn-success" data-crud-create="<?=base_url()?>wishlist/createForm"><i class="fa fa-plus"></i> Adicionar desejo</button>
            </div>
            <div class="clearfix"></div>
        </h1>
        <p><small>Gerenciamento dos desejos</small></p>
    </div>
    <table class="table table-hover table-condensed table-striped">
        <thead>
            <th class="col-sm-1" ordenavel>ID</th>
            <th ordenavel>Título</th>
            <th class="col-sm-3" ordenavel>Descrição</th>
            <th class="col-sm-3" ordenavel>País</th>
            <th class="col-sm-3" ordenavel>Prazo</th>
            <th class="col-sm-3" ordenavel>Custo</th>
            <th class="col-sm-3" ordenavel>Status</th>
            <th class="col-sm-1 text-center">Ações</th>
        </thead>
        <tbody>
            <tr>
                <td class="id"></td>
                <td class="title click" data-crud-read="<?=base_url()?>wishlist/readTemplate"></td>
                <td class="short_desc"></td>
                <td class="country_name"></td>
                <td class="deadline"></td>
                <td class="coust"></td>
                <td class="status_title"></td>
                <td class="text-center">
                    <div class="dropdown">
                      <button class="btn btn-default dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown">
                          <i class="fa fa-caret-square-o-down"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
                        <li><a type="javascript:void(0)" class="btn btn-link viewWish" data-crud-read="<?=base_url()?>wishlist/readTemplate" data-toggle="tooltip" title="Abrir desejo"><i class="fa fa-expand text-info"></i> Abrir desejo</a></li>
                        <li><a type="javascript:void(0)" class="btn btn-link editWish" data-crud-update="<?=base_url()?>wishlist/updateForm" data-toggle="tooltip" title="Editar desejo"><i class="fa fa-edit text-success"></i> Editar desejo</a></li>
                        <li><a type="javascript:void(0)" class="btn btn-link deletWish" data-crud-drop="<?=base_url()?>wishlist/deleteForm" data-toggle="tooltip" title="Excluir desejo"><i class="fa fa-trash-o text-danger"></i> Excluir desejo</a></li>
                      </ul>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>