var bostag = new function () {

	var self = this;

	self.triggerTagsTypeahead = function () {

		var bostags = $(document).find('.bostag');

		$.each(bostags, function (index, bostag) {

			var bostag_obj = $(bostag);

			var bostag_input = bostag_obj.find('.bostag_input');

			var bostag_add_button = bostag_obj.find('.bostag_add_button');

		    bostag_input.typeahead({

		        name: 'Tag'
		        , valueKey : "name"
		        , minLength: 2
		        , remote : {

		        	url: "tags/?format=json&name=%QUERY",

		        	filter: function(data) {

		        		var tags_multiselect = bostag_obj.find('.bostag_multiselect');

		        		var selectedTags = tags_multiselect.serializeObject();

		        		selectedTags = (selectedTags.tags) ? selectedTags.tags : [];

						var resultList = $(data).filter(function(){

							return $.inArray(this.id, selectedTags) == -1;

						});

		        		return resultList;

		        	}

		        }

		    }).bind("typeahead:selected", function(res, tag_obj, name) {

		    	self.addTag(bostag_obj, bostag_input, tag_obj);

		    });

		    bostag_add_button.on('click', function (e) {

		    	e.preventDefault();

		    	var tag_name = bostag_input[0].value;

		    	if(tag_name != "") {

		    		self.createTag(bostag_obj, bostag_input, tag_name);

		    	}

		    });

		});

	}

	self.createTag = function (bostag_obj, bostag_input, tag_name) {

		$.post(base_url + 'tags', {

			name: tag_name

		})
		.done(function (res) {

			self.addTag(bostag_obj, bostag_input, res);

		})
		.fail(function (){

			bostag_input.typeahead('setQuery', '');

		});

	}

	self.addTag = function (bostag_obj, bostag_input, tag_obj) {

		var tags_labels = bostag_obj.find('.bostag_labels');

		var tags_multiselect = bostag_obj.find('.bostag_multiselect');

		if(tags_multiselect.find('option[value="' + tag_obj.id + '"]').length === 0){

	        bostag_input.typeahead('setQuery', '');

	        var tag_label = $('<span class="label label-success">' + tag_obj.name + ' <i class="fa fa-times tag_remove"></i></span>');

	        var tag_option = $('<option value="' + tag_obj.id + '" selected="selected">' + tag_obj.name + '</option>');

	        tags_labels.append(" ").append(tag_label);

	        tags_multiselect.append(tag_option);

	        tag_label.find(".tag_remove").on('click', function(){

	            $(this).parent().remove();

	            tag_option.remove();

	        });

		}

	}

};