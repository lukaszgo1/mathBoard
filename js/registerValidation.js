var userExistInDB = "0";

jQuery(document).ready(function($)
	{
	var form_fields_required = ['registerUsername', 'typePassword', 'retypePassword'];
	var form_group = 'div.form-group';
	var form_input = '#register-form input';
	var form_submit_button = '#register-form button[type="submit"]';
	var errorMessage = 'div.errorMessage';
	if ($(form_submit_button).hasClass('btnDisabled') == false)
		{
		$(form_submit_button).addClass('btnDisabled');
		$(form_submit_button).attr('aria-disabled', 'true');
		}
	if ($(errorMessage).hasClass('d-none') == false)
		{
		$(errorMessage).addClass('d-none');
		$(errorMessage).text('');
		}


$(form_input).on("focusout", function(event) 
	{
	if ($(form_submit_button).hasClass('btnDisabled') == false)
		{
		$(form_submit_button).addClass('btnDisabled');
		$(form_submit_button).attr('aria-disabled', 'true');
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
	switch (event.target.id) {
		case 'registerUsername':
			if ($('#registerUsername').val().length < 6)
				{
				throw 'Username is to short. At least 6 characters.';
				}
			var username_regex = /^[A-Za-z0-9]*$/;
			if (username_regex.test($('#registerUsername').val()) == false)
				{
				throw 'Username can consist of latin letters and arabic digits.';
				}
				if (userExistInDB == "1")
					{
					throw 'This user name is currently used. Choose another.';
					}
				break;

		case 'typePassword':
			if ($('#typePassword').val().length < 8) 
				{
				throw 'Password must have atleast 8 characters.';
				}
			var password_regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{6,}$/;
			if (password_regex.test($('#typePassword').val()) == false) 
				{
				throw 'Such password is insecure.';
				}
			break;

		case 'retypePassword':
		if ($('#typePassword').val() !== $('#retypePassword').val()) 
			{
			throw 'Passwords do not match.';
			}
		break;
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

$(form_submit_button).attr('aria-disabled', 'false');
$(form_submit_button).removeClass('btnDisabled');
return true;
}
catch (err) {
$(errorField).removeClass('d-none');
$(errorField).text(err);
return false;
}
});

$('input#registerUsername.form-control').on("input", function(event)
	{
		var curValue = $(this).val();
			$.ajax({
		type: "post",
		url: "php/getUser.php",
		data: {
			username: curValue
			},
		cache:false,
		success: function(response)
			{
			userExistInDB = response;
			},
			error: function(jqXHR, exception) {
				console.log(jqXHR);
			},
			});
});

$(form_submit_button).on("click", function(event)
	{
	if ($(this).hasClass("btnDisabled"))
		{
		event.preventDefault();
		}
	});
	});