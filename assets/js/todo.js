var nsp_todo = new function () {

	var self = this;

	self.triggerCreateForm = function() {

	    $('#todoCreateForm #deadline').datepicker({
	        format: 'dd/mm/yyyy'
	        , language: "pt-BR"
	        , todayHighlight: true
	        , keyboardNavigation: true
	    }).on('changeDate', function(e){
	        $(this).datepicker('hide');
	    });

	    $('#todoCreateForm #country_typeahead').typeahead({
	        name: 'Country'
	        , valueKey : "name"
	        , remote : "countries/?format=json&name=%QUERY"
	    }).bind("typeahead:selected", function(res, obj, name) {
	        $('#todoCreateForm #country_id').val(obj.id);;
	        $('#todoCreateForm .currency_alphabetic_code').html(obj.alphabetic_code + " - " + obj.currency);
	    });

	    $('#todoCreateForm #user_typeahead').typeahead({
	        name: 'User'
	        , valueKey : "name"
	        , remote : "users/?format=json&name=%QUERY"
	    }).bind("typeahead:selected", function(res, obj, name) {
	        $('#todoCreateForm #user_id').val(obj.id);;
	    });

	}

	self.triggerUpdateForm = function() {

	    $('#todoUpdateForm #deadline').datepicker({
	        format: 'dd/mm/yyyy'
	        , language: "pt-BR"
	        , todayHighlight: true
	        , keyboardNavigation: true
	    }).on('changeDate', function(e){
	        $(this).datepicker('hide');
	    });

	    $('#todoUpdateForm #country_typeahead').typeahead({
	        name: 'Country'
	        , valueKey : "name"
	        , remote : "countries/?format=json&name=%QUERY"
	    }).bind("typeahead:selected", function(res, obj, name) {
	        $('#todoUpdateForm #country_id').val(obj.id);;
	        $('#todoUpdateForm .currency_alphabetic_code').html(obj.alphabetic_code + " - " + obj.currency);
	    });

	    $('#todoUpdateForm #user_typeahead').typeahead({
	        name: 'User'
	        , valueKey : "name"
	        , remote : "users/?format=json&name=%QUERY"
	    }).bind("typeahead:selected", function(res, obj, name) {
	        $('#todoUpdateForm #user_id').val(obj.id);;
	    });

	}

}