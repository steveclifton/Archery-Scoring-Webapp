$(document).ready(function () {

    /**
     * Ajax form checking
     */
    $('#formAccount').submit(function () {
        var values = {};
        $.each($('#formAccount').serializeArray(), function (i, field) {
            values[field.name] = field.value;
        });

        $.ajax({
            type: 'POST',
            url: '/ajax_createaccount',
            data: {
                'anz_num' : values['anz_num'],
                'club' : values['club'],
                'password' : values['password'],
                'confirm_password' : values['confirm_password'],
                'email' : values['email'],
                'first_name' : values['first_name'],
                'last_name' : values['last_name'],
                'prefered_type' : values['prefered_type'],
                'gender' : values['gender']
            },
            success: function(msg){
                alert(msg);
            }
        });
    });



    /**
     * Sets the button display to be where the url is
     */
    $('#archeryselect').ready(function () {
        var url = window.location.href;
        var data = url.split('?');
        var welcome = url.split('/');
        if (welcome[3] == 'welcome') {
            $('#archeryselect').selectpicker('val', welcome['3']);
        } else if (welcome[3] == 'login') {
            var currentweek = $('#currentWeek').text();
            $('#archeryselect').selectpicker('val', currentweek);
        } else {
            $('#archeryselect').selectpicker('val', data);
        }


    });

    /**
     * Redirects the page to the right week after being selected
     */
    $('#archeryselect').on('change', function () {
        var week = $('#archeryselect').children('option').filter(":selected").val();
        //console.log(week);
        var url = "week?" + week;
        if (url) {
            window.location = url;
        }
    });

    /**
     * Function to toggle the view
     */
    function toggleView(element, button) {
        if ($(button).val() == 'Hide') {
            $(button).prop('value', 'Show');
        } else {
            $(button).prop('value', 'Hide');
        }
        $(element).toggleClass('hidden');
    }


    /****************************************************************
     *                      Admin Methods                           *
     ****************************************************************/

    /**
     * Hides/Shows the pending users table
     */
    $('#pendingbutton').ready(function () {
        $('#pendingbutton').on('click', function () {
            toggleView('#pendingusers', '#pendingbutton');
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


    /**
     * Toggles the view of profile form button
     */
    $('#profileformbutton').ready(function () {
        $('#profileformbutton').on('click', function () {
            toggleView('#userprofileform', '#profileformbutton');
        });
    });




    /****************************************************************
     *                      Scoring Methods                           *
     ****************************************************************/


    $('#searcharcher').on('keyup', function () {
        var anzNum = $(this).val();
        if ($('#validation_anz').length > 0) {
            $('#validation_anz').remove();
        }

        $.get("/ajax_searchAnzArcher?anz_num=" + anzNum, function (data) {
            if (data.status == "failed") {
                $('#searcharcher').parent().after("<div id='validation_anz' style='color:red;'>ANZ Number Not Found</div>");
                $('#addsubmit').prop('disabled', true);
            } else if (data.status == "success") {
                $('#searcharcher').parent().after("<div id='validation_anz' style='color:green;'>Found Archer</div>");
                $('#addsubmit').prop('disabled', false);
            }
        });


    });


    /**
     * Toggles the search archer form
     */
    $('#searcharcherform').ready(function () {
        $('#addarcherbutton').click(function () {
            $('#searcharcherform').toggleClass('hidden');
        });
    });



    /**
     * Checks the Score to ensure the user only enters
     *    - Valid digits 0-9
     *    - A score between 0 - 360
     */
    // $('#score').on('keyup', function() {
    //     var score = $('#score').val();
    //     reg = /^[0-9]+$/;
    //
    //     if (score != "") {
    //         if (!reg.test(score)) {
    //             $("#incorrect").html("*Please enter numbers only!");
    //         } else {
    //             $("#incorrect").html("");
    //         }
    //     }
    //
    //     if (Number(score) > 360 || Number(score) < 0) {
    //         $("#incorrect").html("*Invalid Score");
    //     }
    // });

    /**
     * Checks the X-Count to ensure the user only enters
     *    - Valid digits 0-9
     *    - An X-Count between 0-36
     */
    // $('#xcount').on('keyup', function () {
    //     var xcount = $('#xcount').val();
    //     reg = /^[0-9]+$/;
    //
    //     if (xcount != "") {
    //         if (!reg.test(xcount)) {
    //             $("#incorrect").html("*Please enter numbers only!");
    //         } else {
    //             $("#incorrect").html("");
    //         }
    //     }
    //
    //     if (Number(xcount) > 36 || Number(xcount) < 0) {
    //         $("#incorrect").html("*Invalid X-Count");
    //     }
    // });

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

    $('div.bow select').ready(function () {
        checkIfSubmitted();
    });

    $('div.bow select').on('change', function () {
        $("#incorrect").html("");
        checkIfSubmitted();
    });

});

function checkIfSubmitted() {
    // var div = $('div.bow select').val();
    // var weekNum = $('#week_num').val();
    // console.log(div);
    //
    // $.get("/ajax_searchScoreWeekDiv?div=" + div + "&week=" + weekNum, function (data) {
    //     if (data == 'true') {
    //         div = capitalizeFirstLetter(div);
    //         $("#incorrect").html("Score Submitted for " + div + " Division");
    //         $('input[type="submit"]').prop('disabled', true);
    //     } else {
    //         $('input[type="submit"]').prop('disabled', false);
    //     }
    // });
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
    // var score = document.forms[this]["score"].value;
    // var xcount = document.forms[this]["xcount"].value;
    // reg = /^[0-9]+$/;
    //
    // if  ((score > 360 || score < 0)
    //     || (!reg.test(score))
    //     || (xcount > 36 || xcount < 0)
    //     || (!reg.test(xcount))
    //     ) {
    //         $("#incorrect").html("*Please check details and try again");
    //         return false;
    // }
    return true;

}






