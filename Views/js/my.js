$(document).ready(function () {

    /****************************************************************
     *                      Admin Methods                           *
     ****************************************************************/

    /**
     * Hides/Shows the pending users table
     */
    $('#pendingbutton').ready(function () {
        $('#pendingusers').toggle();

        $('#pendingbutton').on('click', function () {
            if ($(this).val() == 'Hide') {
                $('#pendingbutton').prop('value', 'Show');
            } else {
                $('#pendingbutton').prop('value', 'Hide');
            }
            $('#pendingusers').toggle();

        });
    });

    /****************************************************************
     *                      Profile Methods                           *
     ****************************************************************/

    /**
     * Checks that the phone number is only digits
     */
    $('#phone').on('change', function () {
        var phone = $(this).val();
        reg = /^[0-9]+$/;

        $('#valid_phone').remove();
        if (!reg.test(phone)) {
            $('#phone').parent().after("<div id='valid_phone' style='color:red;'>Numbers only</div>");
        }
    });



    $('#profileformbutton').ready(function () {

        $('#profileformbutton').on('click', function () {
            if ($(this).val() == 'Hide') {
                $('#profileformbutton').prop('value', 'Show');
            } else {
                $('#profileformbutton').prop('value', 'Hide');
            }
            $('#userprofileform').toggle();

        });
    });

    /****************************************************************
     *                      Score Methods                           *
     ****************************************************************/

    /**
     * Checks the Score to ensure the user only enters
     *    - Valid digits 0-9
     *    - A score between 0 - 360
     */
    $('#score').on('keyup', function() {
        var score = $('#score').val();
        reg = /^[0-9]+$/;

        if (score != "") {
            if (!reg.test(score)) {
                $("#incorrect").html("*Please enter numbers only!");
            } else {
                $("#incorrect").html("");
            }
        }

        if (Number(score) > 360 || Number(score) < 0) {
            $("#incorrect").html("*Invalid Score");
        }
    });

    /**
     * Checks the X-Count to ensure the user only enters
     *    - Valid digits 0-9
     *    - An X-Count between 0-36
     */
    $('#xcount').on('keyup', function () {
        var xcount = $('#xcount').val();
        reg = /^[0-9]+$/;

        if (xcount != "") {
            if (!reg.test(xcount)) {
                $("#incorrect").html("*Please enter numbers only!");
            } else {
                $("#incorrect").html("");
            }
        }

        if (Number(xcount) > 36 || Number(xcount) < 0) {
            $("#incorrect").html("*Invalid X-Count");
        }
    });

    /**
     * Selects the users 'prefered bow type' as a default
     */
    $(function () {
        var preferedType = $('#prefered_type').val();
        $('div.bow select').val(preferedType);
    });



    /****************************************************************
     *                      Register Methods                        *
     ****************************************************************/

    $('#anz_num').on('focusout', function () {
       var anzNum = $('#anz_num').val();
       reg = /^[0-9]+$/;

       if ($('#validation_anz').length > 0) {
           $('#validation_anz').remove();
       }

       if (anzNum != "") {
           if (!reg.test(anzNum)) {
               $('#anz_num').parent().after("<div id='validation_anz' style='color:red;'>Please enter a valid ANZ Number</div>");
           }
       }
    });

    $('#confirm_password').on('focusout', function () {
        var password = $('#password').val();
        var confirmPassword = $(this).val();

        if ($('#validation_password').length > 0) {
            $(this).remove();
        }
        if (password != null && confirmPassword != null) {
            if (password != confirmPassword) {
                $('#confirm_password').parent().after("<div id='validation_password' style='color:red;'>Passwords do not match</div>");
            }
        }
    });

    $('div.bow select').ready(function () {
        checkIfSubmitted();
    });

    $('div.bow select').on('change', function () {
        $("#incorrect").html("");
        checkIfSubmitted();
    });

});

function checkIfSubmitted() {
    var div = $('div.bow select').val();
    var weekNum = $('#week_num').val();
    console.log(div);

    $.get("/ajax_searchScoreWeekDiv?div=" + div + "&week=" + weekNum, function (data) {
        if (data == 'true') {
            div = capitalizeFirstLetter(div);
            $("#incorrect").html("Score Submitted for " + div + " Division");
            $('input[type="submit"]').prop('disabled', true);
        } else {
            $('input[type="submit"]').prop('disabled', false);
        }
    });
}


/**
 * Capitalises the first letter of a string
 */
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}


/**
 * Validates form, pretty ugly but it works
 */
function validateForm(form) {
    var score = document.forms["scoreform"]["score"].value;
    var xcount = document.forms["scoreform"]["xcount"].value;
    reg = /^[0-9]+$/;

    if  ((score > 360 || score < 0)
        || (!reg.test(score))
        || (xcount > 36 || xcount < 0)
        || (!reg.test(xcount))
        ) {
            $("#incorrect").html("*Please check details and try again");
            return false;
    }

}






