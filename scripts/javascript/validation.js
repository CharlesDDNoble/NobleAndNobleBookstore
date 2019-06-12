var form = $("form").eq(0);

form.submit(function(submission) {
	var inputs = $("input");
	var isValid = true;
	//check for blanks
	for (var i = 0; i < inputs.length; i++) {
		if (!validate(i,1,64)) {
			isValid = false;
		}
	}
	//if passwords dont match
	if ( inputs.eq(3).val() !== inputs.eq(4).val() ) {
		isValid = false;
		$("label").eq(3).css("font-style","italic");
		$("label").eq(3).css("color","red");
		$("label").eq(4).css("font-style","italic");
		$("label").eq(4).css("color","red");
	}

	//dont submit if form is not valid
	if(!isValid) {
		submission.preventDefault();
	}
});

function validate(index, minLength, maxLength) {
    var regex;
    
    switch (index) {
        case 0:
        case 1:
            regex = /^([a-zA-Z]{1,64})?$/;
            break;
        case 2:
            regex = /^([a-zA-Z0-9]{1,}[@]{1}[a-zA-Z0-9]{1,}[.]{1}[a-zA-Z0-9]{3})?$/;
            break;
        case 3:
        case 4:
             regex = /^([a-zA-Z0-9]{6,12})?$/;
             break;
        case 7:
            regex = /^([A-Z]{2})?$/;
            break;
        case 8:
            regex = /^([0-9]{5})?$/;
            break;
        case 9:
            return validatePhone();
        default:
            regex = null;
            break;
    }
    
    var val = ($("input").eq(index)).val();
    
    //truncate input to appropriate length
	if (maxLength !== null && val.length > maxLength)
        $("input").eq(index).val(val.substring(0,maxLength));
    
	val = ($("input").eq(index)).val();
	var label = $("label").eq(index);
	
	if ( (regex !== null && !val.match(regex)) 
		 || (minLength !== null && val.length < minLength) ) {
		label.css("font-style","italic");
		label.css("color","red");
		return false;
	} else {
		label.css("font-style","normal");
		label.css("color","black");
		return true;
	}
}

function validatePhone(){
	var val = ($("input").eq(9)).val();
	var label = $("label").eq(9);
	var phoneRegex = /[0-9]{3}[-]{1}[0-9]{3}[-]{1}[0-9]{4}/;
	if (val.length == 3 || val.length == 7) {
	    $("input").eq(9).val(val+"-");
	    val = ($("input").eq(9)).val();
	}
	for (var i = 0; i < val.length; i++) {
		if (val[i].match("[a-zA-Z]") || i > 11 || (i === 3 && val[i] != "-")
									 || (i === 7 && val[i] != "-")) {
			$("input").eq(9).val(val.substring(0,i));
		} 
	}
	if (!val.match(phoneRegex)) {
		label.css("font-style","italic");
		label.css("color","red");
		return false;
	} else {
		label.css("font-style","normal");
		label.css("color","black");
		return true;
	}
}

function resetForm() {
    var labels = $("label");
	//check for blanks
	for (var i = 0; i < labels.length; i++) {
	    var label = labels.eq(i);
		label.css("font-style","normal");
		label.css("color","black");
	}
}
