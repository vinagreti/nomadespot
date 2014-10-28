<h1 class="page-header">
    Imagens
    <span class="pull-right">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addImgModal"><i class="fa fa-upload"></i> Upload</button>
    </span>
    <div class="clearfix"></div>
</h1>

<div id="miniatures" class="row">
    <?php
        if(count($gpa) > 0 ){
            foreach($gpa as $index => $img){
                $thumbnail = "";
                if($index == 0 || ($index) % 6 == 0) $thumbnail .= '<div class="row">';
                $thumbnail .= '<div class="col-sm-4">';
                $thumbnail .= '<div class="thumbnail">';
                $thumbnail .= '<a href="'.$img->uri.'" alt="'.$img->name.'" target="_blank"><img src="http://imagestore.nomadespot.com/150/'.$img->uri.'" alt="'.$img->name.'" ></a>';
                $thumbnail .= '<div class="caption">';
                $thumbnail .= '<p>'.$img->desc.'</p>';
                if($img->privacy){
                    $thumbnail .= '<p><button type="button" class="btn btn-success btn-block" role="button" value="0" data-id="'.$img->id.'" data-loading-text="Alterando...">Publico</button></p>';
                    $thumbnail .= '<p><button type="button" class="btn btn-danger btn-block hidden" role="button" value="1" data-id="'.$img->id.'" data-loading-text="Alterando...">Privado</button></p>';
                } else {
                    $thumbnail .= '<p><button type="button" class="btn btn-success btn-block hidden" role="button" value="0" data-id="'.$img->id.'" data-loading-text="Alterando...">Publico</button></p>';
                    $thumbnail .= '<p><button type="button" class="btn btn-danger btn-block" role="button" value="1" data-id="'.$img->id.'" data-loading-text="Alterando...">Privado</button></p>';
                }
                $thumbnail .= '</div>';
                $thumbnail .= '</div>';
                $thumbnail .= '</div>';
                if(($index + 1) % 6 == 0) $thumbnail .= '</div>';
                echo $thumbnail;
            }
        } else {
            echo '<div class="col-xs-24 miniatures_text">Sem imagens</div>';
        }
    ?>
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

<script type="text/javascript">
    window.onload = function(){

        $(".thumbnail button").on("click", function (e) {

            var button = $(this);

            button.button('loading');

            var privacy = $(this).val();

            var id = $(this).data('id');

            $.ajax({

                url: "?id="+id

                , type: "PATCH"

                , data: {

                    privacy: privacy

                }

            })

            .done(function (res) {

                var privacy = res.privacy == 1 ? 0 : 1;

                button.parents('.thumbnail').find('button').addClass("hidden");

                button.parents('.thumbnail').find('button[value="'+privacy+'"]').removeClass("hidden");

            })

            .always(function (res) {

                button.button('reset');

            });

        });

        var miniatatures = $('#miniatures');

        $('#upload_img_form').on('submit', function (e) {

            e.preventDefault();

            var formData = new FormData($(this)[0]);

            formData.append("csrf_token", csrf_token);

            $.ajax({
                url:'',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                dataType:'json',
                xhr: function() {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if(myXhr.upload){ // Check if upload property exists
                        myXhr.upload.addEventListener('progress', function (e){
                            if(e.lengthComputable){
                                var percentage = 100/(e.total/e.loaded);
                                $('#upload_img_form .progress-bar')
                                    .attr('aria-valuenow', percentage)
                                    .css('width', percentage+"%")
                                    .text(percentage+"%");

                                if(percentage > 99){

                                    $('#upload_img_form .progress-bar').text("Aguarde! Processando...");

                                }
                            }
                        }, false); // For handling the progress of the upload
                    }
                    return myXhr;
                },
                beforeSend: function () {
                    $('#upload_img_form .form-group').addClass('hidden');
                    $('#upload_img_form .progress').removeClass('hidden');
                    $('#upload_img_form [type="submit"]').button('loading');
                },
                complete: function () {
                    $('#upload_img_form .progress').addClass('hidden');
                    $('#upload_img_form .form-group').removeClass('hidden');
                    $('#upload_img_form [type="submit"]').button('reset');
                },
            })
            .done(function (data) {

                $("#addImgModal").modal('hide');

                $('#upload_img_form')[0].reset();

                bosalert('Ops', data.msg, 'success');

                $.each(data.files, function (index, file) {

                    var thumbnail = $('<div class="col-xs-8 col-sm-6 col-md-4 col-lg-3">')
                        .css('word-break', 'break-all')
                        .append($('<div class="thumbnail">')
                            .append($('<a>').attr('href', file.uri).attr('alt', file.name)
                                .append('<img src="http://imagestore.nomadespot.com/150/' + file.uri + '">')
                            )
                    );

                    miniatatures.find("#miniatures_text").remove();

                    miniatatures.append(thumbnail);

                });
            })
            .fail(function (a, b, c) {
                bosalert('Ops', a.responseText);
            });

            return false;

        });
    }
</script>