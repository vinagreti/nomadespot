var images = new function () {

    var images_url = base_url+"images";
    var images_raw = false;
    var screen_container = $('#miniatures');
    var gallery_thumb = $("#gallery-thumb-sample").clone().removeClass("hide");;
    $("#gallery-thumb-sample").remove();

    var imagesClass = {

        refresh: (function () {

            if (!images_raw) {

                $.ajax({
                    url: images_url
                    , type: "GET"
                    , data: { format: 'json' }
                }).done(function (res) {

                    images_raw = res;

                    imagesClass.refreshScreen();

                }).fail(function (res) {

                    var response = res.responseJSON ? res.responseJSON : res.responseText;

                    bosalert('Ops', res.responseText);

                });

            } else {

                imagesClass.refreshScreen();

            }

            return this;

        })()
        , refreshScreen: function () {

            $.each(images_raw, function (index, image) {

                imagesClass.insertOnScreen(image);

            });

        }

        , insertOnScreen: function(image) {

            var galleryThumb = gallery_thumb.clone();

            galleryThumb.find('img').attr("src", "http://imagestore.nomadespot.com/200/"+image.uri);

            galleryThumb.find('a').attr("href", image.uri);

            galleryThumb.find('.gallery-thumb-title').text(image.desc);

            galleryThumb.find('button').attr('data-id', image.id);

            galleryThumb.find('.change-privacy').attr('value', image.private);

            if (image.private == 1) {

                galleryThumb
                    .find('.change-privacy')
                        .removeClass('btn-success')
                        .addClass('btn-danger')
                    .find('i')
                        .removeClass('fa-thumbs-up')
                        .addClass('fa-thumbs-down');

            } else {

                galleryThumb
                    .find('.change-privacy')
                        .removeClass('btn-danger')
                        .addClass('btn-success')
                    .find('i')
                        .removeClass('fa-thumbs-down')
                        .addClass('fa-thumbs-up');

            }

            screen_container.append(galleryThumb);

        }
        , insertRemote: function (formData) {

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
            }).done(function (data) {

                $("#addImgModal").modal('hide');

                $('#upload_img_form')[0].reset();

                bosalert('', data.msg, 'success');

                $.each(data.files, function (index, file) {

                    images.insertOnScreen(file);

                });
            }).fail(function (a, b, c) {

                var response = a.responseJSON ? a.responseJSON : a.responseText

                bosalert('Ops', response);

            });

        }
        , changePrivacy: function(id, private) {

            var button = screen_container.find('.change-privacy[data-id="'+ id +'"]');

            $.ajax({

                url: "?id="+id

                , type: "PATCH"

                , data: {

                    private: private

                }

            }).done(function (res) {

                if (res.private == 1) {

                    button
                        .val(res.private)
                        .removeClass('btn-success')
                        .addClass('btn-danger')
                        .html($('<i>').addClass('fa fa-thumbs-down'));

                } else {

                    button
                        .val(res.private)
                        .removeClass('btn-danger')
                        .addClass('btn-success')
                        .html($('<i>').addClass('fa fa-thumbs-up'));

                }

            }).always(function (res) {

                button.button('complete');

            });

        }
        , removeFromRemote: function(id) {

            console.log(id);

            var button = screen_container.find('.delete-img[data-id="'+ id +'"]');

            console.log(button[0]);

            $.ajax({

                url: "?id="+id

                , type: "DELETE"

            }).done(function (res) {

                console.log('deletou');

                button.parents('.gallery-thumb').remove();

            }).always(function (res) {

                button.button('complete');

            }).fail(function (a, b, c) {

                var response = a.responseJSON ? a.responseJSON : a.responseText

                bosalert('Ops', response);

            });

        }

    };

    // triggers
    screen_container.on("click", '.delete-image', function (e) {

        var button = $(this);

        button.button('loading');

        var id = $(this).data('id');

        images.removeFromRemote(id);

    });

    screen_container.on("click", '.change-privacy', function (e) {

        var button = $(this);

        button.button('loading');

        var privacy = button.val() == 1 ? 0 : 1;

        var id = button.data('id');

        images.changePrivacy(id, privacy);

    });

    return imagesClass;

}

$('#upload_img_form').on('submit', function (e) {

    e.preventDefault();

    var formData = new FormData($(this)[0]);

    images.insertRemote(formData);

    return false;

});