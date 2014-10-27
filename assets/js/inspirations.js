var nsp_inspirations = new function () {

	var self = this;

	self.triggerCreateForm = function() {

	    $('#inspirationsCreateForm #country_typeahead').typeahead({
	        name: 'Country'
	        , valueKey : "name"
	        , remote : "countries/?format=json&name=%QUERY"
	    }).bind("typeahead:selected", function(res, obj, name) {
	        $('#inspirationsCreateForm #country_id').val(obj.id);;
	        $('#inspirationsCreateForm .currency_alphabetic_code').html(obj.alphabetic_code + " - " + obj.currency);
	    });

	}

	self.triggerUpdateForm = function() {

	    $('#inspirationsUpdateForm #country_typeahead').typeahead({
	        name: 'Country'
	        , valueKey : "name"
	        , remote : "countries/?format=json&name=%QUERY"
	    }).bind("typeahead:selected", function(res, obj, name) {
	        $('#inspirationsUpdateForm #country_id').val(obj.id);;
	        $('#inspirationsUpdateForm .currency_alphabetic_code').html(obj.alphabetic_code + " - " + obj.currency);
	    });

	}

}