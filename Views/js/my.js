$(document).ready(function () {

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
        var confirmPassword = $('#confirm_password').val();

        if ($('#validation_password').length > 0) {
            $('#validation_password').remove();
        }
        if (password != null && confirmPassword != null) {
            if (password != confirmPassword) {
                $('#confirm_password').parent().after("<div id='validation_password' style='color:red;'>Passwords do not match</div>");
            }
        }
    });

});

function checkIfSubmitted() {
    var div = $('div.bow select').val();
    var weekNum = $('#week_num').val();
    console.log(div);

    $.get("/ajax_searchScoreWeekDiv?div=" + div + "&week=" + weekNum, function (data) {
        if (data == 'true') {
            $("#incorrect").html("*Score Already Submitted for this Division");
            $('input[type="submit"]').prop('disabled', true);
        } else {
            $('input[type="submit"]').prop('disabled', false);
        }
    });
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

    var div = $('div.bow select').val();
    var weekNum = $('#week_num').val();
    // var result = false;

    $.get("/ajax_searchScoreWeekDiv?div=" + div + "&week=" + weekNum, function (data) {
        if (data == 'true') {
            alert('Score for this week and division already exists!');
            // result = false;
            return false;
        } else {
            // result = true;
            return true;
        }
    });
    // return result;
}






