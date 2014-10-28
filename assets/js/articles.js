var nsp_articles = new function () {

	var self = this;

	var getHtmlFormated = function ( html ) {

		var editorText = $('#editor1').code();

		var newText = $('<div>').append(editorText);

		newText.find('img').addClass('img-responsive');

		newText.find('img').removeAttr('style');

		newText.find('iframe').removeAttr('width');

		newText.find('iframe').removeAttr('height');

		newText.find('iframe').removeAttr('style');

		newText.find('iframe').removeAttr('style');

		newText.find('iframe').attr('webkitallowfullscreen', true);

		newText.find('iframe').attr('mozallowfullscreen', true);

		newText.find('iframe').attr('allowfullscreen', true);

		newText.find('iframe').wrap('<div class="row"><div class="col-xs-24"><div class="flex-video widescreen">');

		return newText.prop('outerHTML');

	}

	self.triggerCreateForm = function() {

		$('#editor1').summernote({
			height: 300
			, minHeight: 100
			, airPopover: [
				['color', ['color']],
				['font', ['bold', 'underline', 'clear']],
				['para', ['ul', 'paragraph']],
				['table', ['table']],
				['insert', ['link', 'picture', 'video', 'table', 'hr']]
			]
			, onChange: function(e) {

				var article_html = getHtmlFormated();

				$('#articlesCreateForm #content').val(article_html);

			}
		});

	}

	self.triggerUpdateForm = function() {

		$('#editor1').summernote({
			height: 300
			, minHeight: 100
			, onChange: function(e) {

				var article_html = getHtmlFormated();

				$('#articlesUpdateForm #content').val(article_html);

			}
		});

		var content = $('#articlesUpdateForm #content').val();

		$('#editor1').code(content);

	}

	self.triggerPublicView = function() {

		var itemHtmlCopy = $('.articlePublicListItem').clone().removeClass('hidden');

		$('.articlePublicListItem').remove();

		$.get(base_url+'articles?page=1&limit=50&format=json')
		.done( function ( res ) {

			$.each(res, function (index, article) {

				var itemHtml = itemHtmlCopy.clone();

				switch (article.media_kind) {
					case "img" :
						itemHtml.find('iframe').parent().addClass('hidden');
					break;
					case "iframe" :
						itemHtml.find('img').addClass('hidden');
					break;
					default :
					itemHtml.find('iframe').parent().addClass('hidden');
					itemHtml.find('img').addClass('hidden');
				}

				itemHtml.dataBind(article);

				$('.articlePublicList').append(itemHtml);

			});

		});

	}
}