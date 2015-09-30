$(document).ready(function () {
    var loader = '<img class="loader-image" src="' + host_path + '/public/images/loader.gif" />';

    $('.reg-btn').on('click', function(e){
        e.preventDefault();
        $('.error-container, .submit-form-state').remove();
        var form_data = $('#reg-user').serialize();
        var is_valid_form = isValidRegisterForm();

        if(is_valid_form === true){
            $.ajax({
                url: host_path + '/ajax/save_user.php',
                type: 'post',
                dataType: 'json',
                data: { form_data:form_data },
                beforeSend: function () {
                    $('.btn-area').append(loader);
                }
            }).success(function (result) {
                $('.loader-image').remove();
                $('.submit-form-state.state-success, .submit-form-state.state-error').remove();

                //success - registered user
                if(result.state === true){
                    $('#reg-user h2').after('<div class="submit-form-state state-success">Successfully registered User '+result.user_email+'</div>');
                    $('#reg-user input[type="text"], ' +
                        '#reg-user input[type="email"], ' +
                        '#reg-user input[type="password"]').each(function() {
                        $(this).val('');
                    });
                }else{
                    //Error state - correct errors
                    $('#reg-user h2').after('<div class="submit-form-state state-error">Please correct errors</div>');
                    showErrors(result.errors);
                }
            }).fail(function () {
                $('#reg-user h2').after('<div class="submit-form-state state-error">Somethings wrong. Please try again!</div>');
            });
        }
    });

});

/**
 * Function to validate registration form
 * @returns {boolean}
 */
function isValidRegisterForm(){
    var errors = {};

    if (!validateUsername()) {
        errors.username = "You must enter a username.";
    }

    if (!validateFirstName()) {
        errors.first_name = "You must enter first name";
    }

    if (!validateLastName()) {
        errors.last_name = "You must enter last name";
    }

    //validate email
    var email = $('input[name="email"]').val();
    if(email == ''){
        errors.email = "You must enter email.";
    }else if(email.length > 0){
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)){
            errors.email = "You must enter a valid email.";
        }
    }

    //validate password
    if($('input[name="password1"]').val() == ''){
        errors.password = "Please insert password";
    }else if ($('input[name="password2"]').val() == ''){
        errors.password = "Please confirm your password";
    }else if($('input[name="password1"]').val() != $('input[name="password2"]').val()){
        errors.password = "Passwords don't match";
    }

    if (Object.keys(errors).length > 0) {
        showErrors(errors);
        return false;
    }

    return true;
}

function checkLength(field_data, min_value, max_value){
    min_value = min_value || 1;
    max_value = max_value || 50;

    if (field_data.length < min_value || field_data.length > max_value) {
        return false;
    }
    return true;
}

/**
 * Show errors to DOM element. Used for server side and client side errors.
 * @param Object errors
 */
function showErrors(errors){
    var msg = '<div class="error-container">';
    msg += '<p>Please correct errors:</p><ul>';

    for (var key in errors) {
        if (Object.prototype.hasOwnProperty.call(errors, key)) {
            msg += '<li class="class-error">' + errors[key] + '</li>';
        }
    }
    msg += '</ul></div>';
    $('.btn-area').before(msg);
}


function validateUsername(){
    return checkLength($('input[name="username"]').val());
}


function validateFirstName(){
    return checkLength($('input[name="first-name"]').val());
}

function validateLastName(){
    return checkLength($('input[name="last-name"]').val());
}
