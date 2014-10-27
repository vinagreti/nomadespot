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
                $thumbnail = '<div class="col-xs-8 col-sm-6 col-md-4 col-lg-3" style="word-break:break-all;">';
                $thumbnail .= '<div class="thumbnail">';
                $thumbnail .= '<a href="'.$img->uri.'" alt="'.$img->name.'" target="_blank"><img src="http://imagestore.nomadespot.com/150/'.$img->uri.'" alt="'.$img->name.'"></a>';
                $thumbnail .= '</div>';
                $thumbnail .= '</div>';
                echo $thumbnail;
                if($index % 4 == 0)
                    echo '<div class="clearfix"></div>';
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
                        <span id="uploadButton" class="btn btn-success btn-file btn-block">
                            <i class="fa fa-upload"></i>
                            Selecionar imagens
                            <input type="file" id="image" name="images[]" multiple="multiple" accept="image/*" capture="camera" />
                        </span>
                    </div>

                    <progress></progress>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    window.onload = function(){

        var miniatatures = $('#miniatures');

        $('#upload_img_form').on('submit', function (e) {

            e.preventDefault();

            var spinner = $('<i class="fa fa-spinner fa-spin"></i>');

            var formData = new FormData($(this)[0]);

            formData.append("csrf_token", csrf_token);

            $.ajax({
                url:'images_upload',
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
                                $('progress').attr({value:e.loaded,max:e.total});
                            }
                        }, false); // For handling the progress of the upload
                    }
                    return myXhr;
                },
                beforeSend: function () {
                    spinner.insertBefore($('#uploadButton'));
                    $('#uploadButton').attr('disabled', true);
                },
                complete: function () {
                    spinner.remove();
                    $('#uploadButton').attr('disabled', false);
                },
            })
            .done(function (data) {
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
