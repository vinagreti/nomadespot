$.fn.dataBind = function(data) {

	var element = this;

	var doDataBind = function (attr_name, attr_val){

	    var formItem = element.find('[name="'+attr_name+'"]');

	    if(formItem.length > 0) {

	    	fillForm(formItem, attr_val);

	    }
	    
	    var elementItem = element.find('.'+attr_name);

	    if(elementItem.length > 0) {

	    	fillScreen(elementItem, attr_val);

	    }

	}

	var fillScreen = function (elementItem, data) {

	    var type = elementItem.get(0).tagName;
	    
        switch(type){
                
            case 'img':
                elementItem.attr('src', data);
                elementItem.wrap( "<a href='"+value+"' target='_blank'></a>" );
                break;
            case 'iframe':
                elementItem.attr('src', data);
                break;
            case 'a':
			    elemento.attr("href", value );
			    elemento.html('<i class="fa fa-external-link-square"></i>');
                break;
            default:
                elementItem.html(data);
                
        }

	}

	var fillForm = function (formItem, data) {

	    var type = formItem.get(0).tagName.toLowerCase();

	    if(type == "input")
	        type = formItem.attr('type')

        switch(type){
                
            case 'checkbox':
            case 'radio':
				// reset checkoxes
				formItem.prop('checked', false);
				formItem.filter('[value="'+data+'"]').prop('checked', true);
                break;
            case 'SELECT':
				// reset selects
				formItem.prop("selected", false);
                formItem.find('option[value="'+data+'"]').prop('selected', true);
                break;
            default:
                formItem.val(data);
                
        }

	}

	$.each(data, function(attr_name, attr_val){
	    
	    if( attr_val && typeof attr_val === "object"){

	        element.dataBind(attr_val);
	        
	    } else {
	        
	        doDataBind(attr_name, attr_val);
	        
	    }
	    
	});

	return false;

}