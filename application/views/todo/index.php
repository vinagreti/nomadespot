<div class="bostable" id="todoTable" data-resource-uri="<?=base_url()?>todo">
    <div class="bostable_head">
        <h1 class="page-header">
            Lista de tarefas
            <div class="pull-right">
                <button class="btn btn-success" data-crud-create="<?=base_url()?>todo/createForm"><i class="fa fa-plus"></i> Adicionar tarefa</button>
            </div>
            <div class="clearfix"></div>
        </h1>
        <p><small>Gerenciamento das tarefas</small></p>
    </div>
    <table class="table table-hover table-condensed table-striped">
        <thead>
            <th class="col-sm-1" ordenavel>ID</th>
            <th ordenavel>Título</th>
            <th ordenavel>Descrição</th>
            <th class="col-sm-4" ordenavel>Responsável</th>
            <th class="col-sm-4" ordenavel>País</th>
            <th class="col-sm-1 text-center">Ações</th>
        </thead>
        <tbody>
            <tr>
                <td class="id"></td>
                <td class="title click" data-crud-read="<?=base_url()?>todo/readTemplate"></td>
                <td class="short_desc"></td>
                <td class="user_name"></td>
                <td class="country_name"></td>
                <td class="text-center"><a class="link" href="" target='_blank'></a></td>
                <td class="text-center">
                    <div class="dropdown">
                      <button class="btn btn-default dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown">
                          <i class="fa fa-caret-square-o-down"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
                        <li><a type="javascript:void(0)" class="btn btn-link viewInspiration" data-crud-read="<?=base_url()?>todo/readTemplate" data-toggle="tooltip" title="Abrir tarefa"><i class="fa fa-expand text-info"></i> Abrir tarefa</a></li>
                        <li><a type="javascript:void(0)" class="btn btn-link editInspiration" data-crud-update="<?=base_url()?>todo/updateForm" data-toggle="tooltip" title="Editar tarefa"><i class="fa fa-edit text-success"></i> Editar tarefa</a></li>
                        <li><a type="javascript:void(0)" class="btn btn-link deletInspiration" data-crud-drop="<?=base_url()?>todo/deleteForm" data-toggle="tooltip" title="Excluir tarefa"><i class="fa fa-trash-o text-danger"></i> Excluir tarefa</a></li>
                      </ul>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>