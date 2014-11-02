<h1 class="page-header">
    Imagens
    <span class="pull-right">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addImgModal"><i class="fa fa-upload"></i> Upload</button>
    </span>
    <div class="clearfix"></div>
</h1>

<div id="miniatures" class="row">
    <div class="col-sm-4 hide gallery-thumb">
        <div class="thumbnail">
            <a href="" alt="" target="_blank"><img src="http://imagestore.nomadespot.com/150" alt="" ></a>
            <div class="caption">
                <p class="gallery-thumb-title"></p>
                <div class="row gallery-thumb-buttons">
                    <div class="col-xs-8">
                        <button type="button" class="btn btn-success btn-block change-privacy" role="button" value="0" data-id="" data-loading-text="<i class='fa fa-spin fa-circle-o-notch'></i>"><i class="fa fa-thumbs-up"></i></button>
                    </div>
                    <div class="col-xs-8">
                        <button type="button" class="btn btn-primary btn-block edit-image" role="button" value="0" data-id="" data-loading-text="<i class='fa fa-spin fa-circle-o-notch'></i>"><i class="fa fa-pencil"></i></button>                                        
                    </div>
                    <div class="col-xs-8">
                        <button type="button" class="btn btn-default btn-block delete-image" role="button" value="1" data-id="" data-loading-text="<i class='fa fa-spin fa-circle-o-notch'></i>"><i class="fa fa-times"></i></button>                                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="addImgModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method='post' action="images_upload" role="form" enctype="multipart/form-data" id="upload_img_form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">fechar</span></button>
                    <h4 class="modal-title">Adicionar imagens</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="desc">Descrição</label>
                        <input type="text" class="form-control" name="desc" placeholder="Insira uma descrição breve" />
                    </div>

                    <div class="form-group">
                        <span class="btn btn-success btn-file btn-block">
                            <i class="fa fa-upload"></i>
                            Selecionar imagens
                            <input type="file" id="image" name="images[]" multiple="multiple" accept="image/*" capture="camera" />
                        </span>
                    </div>

                    <div class="progress hidden">
                      <div id="upload_img_progress" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        0%
                      </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-loading-text="Enviando...">Salvar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->