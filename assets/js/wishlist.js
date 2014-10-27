var nsp_wishlist = new function () {

	var self = this;

	self.triggerCreateForm = function() {

	    $('#wishlistCreateForm #deadline').datepicker({
	        format: 'dd/mm/yyyy'
	        , language: "pt-BR"
	        , todayHighlight: true
	        , keyboardNavigation: true
	    }).on('changeDate', function(e){
	        $(this).datepicker('hide');
	    });

	    $('#wishlistCreateForm #select_deadline').on('click', function () {
	        $('#wishlistCreateForm #deadline').datepicker('show');
	    });

	    $('#wishlistCreateForm #country_typeahead').typeahead({
	        name: 'Country'
	        , valueKey : "name"
	        , remote : "countries/?format=json&name=%QUERY"
	    }).bind("typeahead:selected", function(res, obj, name) {
	        $('#wishlistCreateForm #country_id').val(obj.id);;
	        $('#wishlistCreateForm .currency_alphabetic_code').html(obj.alphabetic_code + " - " + obj.currency);
	    });

	}

	self.triggerUpdateForm = function() {

	    $('#wishlistUpdateForm #deadline').datepicker({
	        format: 'dd/mm/yyyy'
	        , language: "pt-BR"
	        , todayHighlight: true
	        , keyboardNavigation: true
	    }).on('changeDate', function(e){
	        $(this).datepicker('hide');
	    });

	    $('#wishlistUpdateForm #select_deadline').on('click', function () {
	        $('#wishlistUpdateForm #deadline').datepicker('show');
	    });

	    $('#wishlistUpdateForm #country_typeahead').typeahead({
	        name: 'Country'
	        , valueKey : "name"
	        , remote : "countries/?format=json&name=%QUERY"
	    }).bind("typeahead:selected", function(res, obj, name) {
	        $('#wishlistUpdateForm #country_id').val(obj.id);;
	        $('#wishlistUpdateForm .currency_alphabetic_code').html(obj.alphabetic_code + " - " + obj.currency);
	    });

	}

}