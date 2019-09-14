jQuery(document).ready(function($)
	{
	// Create array of all required fields on the page to make validation more universal.
	var form_fields_required = [];
	var rFields = $('input,textarea,select').filter('[required]');
	for (var k = 0; k <rFields.length; ++k)
		{
		form_fields_required.push(rFields[k].name);
		}
	var form_group = 'div.form-group';
	var form_input = '.form-signin input';
	var form_submit_button = '.form-signin button[type="submit"]';
	var errorMessage = 'div.errorMessage';
	if ($(form_submit_button).hasClass('disabled') == false)
		{
		$(form_submit_button).addClass('disabled');
		$(form_submit_button).prop('disabled', 'disabled');
		}
	if ($(errorMessage).hasClass('d-none') == false)
		{
		$(errorMessage).addClass('d-none');
		$(errorMessage).text('');
		}


$(form_input).on("input", function(event) 
	{
	if ($(form_submit_button).hasClass('disabled') == false)
		{
		$(form_submit_button).addClass('disabled');
		$(form_submit_button).prop('disabled', 'disabled');
		}
	var errorField = $(this).closest(form_group).find(errorMessage);
	if ($(errorField ).hasClass('d-none') == false)
		{
		$(errorField ).addClass('d-none');
		$(errorField ).text('');
		}
	try
		{
		if ($(this).val() == '')
			{
			throw 'Field can not be empty.';
			}

			for (var i = 0; i < form_fields_required.length; i++)
				{
				var err_current_field = $('#' + form_fields_required[i]).closest(form_group).find(errorMessage);
				if ($(err_current_field).text() == '' && $(err_current_field).hasClass('d-none') == false)
					{
					$(err_current_field).addClass('d-none');
					}
				}
			for (var i = 0; i < form_fields_required.length; i++)
				{
				var err_current_field = $('#' + form_fields_required[i]).closest(form_group).find(errorMessage);
				if ($(err_current_field).text() != '')
					{
					return false;
					}
				if ($('#' + form_fields_required[i]).val() == '')
					{
					return false;
					}
				}
				$(form_submit_button).prop('disabled', false);
				$(form_submit_button).removeClass('disabled');
				return true;
				}
			catch (err)
				{
				$(errorField).removeClass('d-none');
				$(errorField).text(err);
				return false;
				}
	});
});