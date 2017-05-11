var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
function goBack() {
    window.history.back();
}

function resetErrors() {
    $('form input, form select').removeClass('inputTxtError');
    $('div.error-txt').remove();
}
function displayErrorForArrayInput(i, v)
{
	
	var pattern = /[0-9]+/g;
	var matches = i.match(pattern);
	if(matches)
	{
		if(matches==0)
		i = i.replace(matches, "[]");else
			i = i.replace(matches, "[]"+matches);	
	}
	var msg = '<div class="error-txt" for="'+i+'">'+v+'</div>';
    $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
};

function displayError(i, v)
{
	
	var msg = '<div class="error-txt" for="'+i+'">'+v+'</div>';
    $('input[name="' + i + '"], select[name="' + i + '"],textarea[name="' + i + '"]').addClass('inputTxtError').after(msg);
};

function toggleModal(modalID,action)
{
	$(''+modalID+'').modal(''+action+'');
};

function removeRowAndtoggleModal(data,modalID,action)
{
	
	$('#row-'+data.row_id).fadeOut(350);
	//$('#row-app-'+delId).fadeOut(350);
	toggleModal(modalID,action);
};

function FormResponse(action,data,formId)
{
	switch(action)
	{
	case 'processing':
		resetErrors();
		$('#'+formId+'').find('.btn-area').addClass('hide');
		$('#'+formId+'').find('.loading').removeClass('hide');
		break;
	case 'failed':
		var arr = data.errors;
        $.each(arr, function (index, value)
        {	
        	displayError(index, value);
        });
        $('#'+formId+'').find('.btn-area').removeClass('hide');
		$('#'+formId+'').find('.loading').addClass('hide');
		break;
	case 'success':
		$('#'+formId+'').find('.alert-success').removeClass('hide');
		$('#'+formId+' ').find('.alert-success > span').html(data.message);
		 //$('#'+formId+' > .alert-success').removeClass('hide');
    	 //$('#'+formId+' > .alert-success > span').html(data.message);
    	 //$('#'+formId+' > .btn-area').addClass('hide');
 		 $('#'+formId+'').find('.btn-area').addClass('hide');
    	 $('#'+formId+'').find('.loading').addClass('hide');
		break;
	}
};

/*
 * Preview Upload Image
 */
var previewFiles = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('output');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
 };
 
 
 
 
 
 
