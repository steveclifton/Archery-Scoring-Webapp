$(document).ready(function () {

    //$('#spinning').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');

    var $loading = $('#spinning').hide();
    $(document)
        .ajaxStart(function () {
            $loading.show();
        })
        .ajaxStop(function () {
            $loading.hide();
        });


    // Disables the Add Archer Button by Default
    $('#addArcherButton').prop('disabled', true);


    // Toggles the confirm scores button
    if (!$('#correctScores').is(' :checked')) {
        $('#submit').prop('disabled', true);
    }
    $('#correctScores').change(function() {
        if (!$('#correctScores').is(' :checked')) {
            $('#submit').prop('disabled', true);
        } else {
            $('#submit').prop('disabled', false);
        }
    });



    /***************************************************************
     *       SELECT PICKER CONTROLS
     ****************************************************************/

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


    /**
     * Ajax finds the user if they exist ready to be added to temp scoring
     */
    $('#searcharcher').on('keyup', function () {
        var anzNum = $(this).val();

        $.get("/ajax_searchAnzArcher?anz_num=" + anzNum, function (data) {
            if (data.status == "failed") {
                $('#validation').remove();
                $('<p id="validation" style="color: red; margin-left: 14px">Not Found</p>').insertAfter($('div.validation'));
                $('#addArcherButton').prop('disabled', true);
            } else if (data.status == "success") {
                $('#validation').remove();
                $('<p id="validation" style="color: green; margin-left: 14px">Found</p>').insertAfter($('div.validation'));
                $('#addArcherButton').prop('disabled', false);
            }
        });

    });


    /**
     * Adds a temp association between users
     */
    $('#addArcherButton').on('click', function () {
        var anzNum = $('#searcharcher').val();

        $.ajax({
            type: 'POST',
            url: '/ajax_addTempUser',
            data: {
                'anz_num': anzNum
            },
            success: function (data) {
                var json = $.parseJSON(data);
                if (json.status == 'failed') {
                    alert('Cannot add account');
                } else {
                    location.reload();
                }
            }
        });



    });

    // Method here that when they press 'Add archer for scoring' the post data is sent and the page is refreshed (displaying the new person)


    /**
     *  On Submit button, scores are sent via AJAX to be entered in the DB
     *
     */
    $('#submit').on('click', function () {

        $('tr.archer').each(function () {
            $("#invalidScore").remove();
            $("#invalidXCount").remove();
        });


        $("tr.archer").each(function() {
            $this = $(this);
            var name = $this.find("span.name").html();
            var anz = $this.find("input#anz_num").val();

            var score = $this.find("input#score").val();
            if (score != '' && !checkScore(score)) {
                $('<p id="invalidScore" style="color: red">Invalid Score</p>').insertAfter($($this.find("input#score")));
                return;
            }

            var xcount = $this.find("input#xcount").val();
            if (xcount != '' && !checkXCount(xcount)) {
                $('<p id="invalidXCount" style="color: red">Invalid XCount</p>').insertAfter($($this.find("input#xcount")));
                return;
            }

            if (score == '' && xcount == '') {
                return;
            }

            var div = $this.find("select#div").val();
            var week = $this.find("span.week").html();

            var archer = { "name":name, "anz":anz, "score":score, "xcount":xcount, "div":div, "week":week };


            $.ajax({
                type: 'POST',
                url: '/ajax_submitScore',
                data: {
                    archer:archer
                },
                success: function (data) {
                    var json = $.parseJSON(data);
                    if (json.status == 'failed') {
                        $("tr.archer").each(function() {
                            $this = $(this);
                            var name = $this.find("span.name").html();
                            if (name == archer.name) {
                                $('<p id="invalidXCount" style="color: red">Score already entered</p>').insertAfter($($this.find("span.name")));
                            }

                        });
                    } else {
                        $("tr.archer").each(function() {
                            $this = $(this);
                            var name = $this.find("span.name").html();
                            if (name == archer.name) {
                                $('<p id="invalidXCount" style="color: green">Score Updated</p>').insertAfter($($this.find("span.name")));
                            }
                        });
                    }
                }
            });
        });




        function checkScore(score) {
            if (isNaN(score)) {
                return false;
            } else if (score > 360 || score < 0) {
                return false;
            }

            return true;
        }
        function checkXCount(xcount) {
            if (isNaN(xcount)) {
                return false;
            } else if (xcount > 36 || xcount < 0) {
                return false;
            }

            return true;
        }





    });



    /****************************************************************
     *                      Register Methods                        *
     ****************************************************************/




    /**
     * Alerts the user that the ANZ number needs to be a number
     */
    $('#anz_num').on('focusout', function () {
       var anzNum = $('#anz_num').val();
       reg = /^[0-9]+$/;

       if ($('#validation_anz').length > 0) {
           $('#validation_anz').remove();
       }

       if (anzNum != "") {
           if (!reg.test(anzNum)) {
               $('#anz_num').parent().after("<div id='validation_anz' style='color:red;'>Please enter a valid ANZ Number</div>");
               $('#registerAccount').prop('disabled', true);
           } else {
               $('#registerAccount').prop('disabled', false);
           }
       }
    });


    /**
     * Ensures that the passwords match, disables the submit button if not
     */
    $('#confirm_password').on('focusout', function () {
        var password = $('#password').val();
        var confirmPassword = $('#confirm_password').val();

        if ($('#validation_password').length > 0) {
            $('#validation_password').remove();
        }
        if (password != null && confirmPassword != null) {
            if (password != confirmPassword) {
                $('#confirm_password').parent().after("<div id='validation_password' style='color:red;'>Passwords do not match</div>");
                $('#registerAccount').prop('disabled', true);
            } else {
                $('#registerAccount').prop('disabled', false);
            }
        }
    });

});


//     $('div.bow select').ready(function () {
//         checkIfSubmitted();
//     });
//
//     $('div.bow select').on('change', function () {
//         $("#incorrect").html("");
//         checkIfSubmitted();
//     });
//
//
//
// function checkIfSubmitted() {
//     // var div = $('div.bow select').val();
//     // var weekNum = $('#week_num').val();
//     // console.log(div);
//     //
//     // $.get("/ajax_searchScoreWeekDiv?div=" + div + "&week=" + weekNum, function (data) {
//     //     if (data == 'true') {
//     //         div = capitalizeFirstLetter(div);
//     //         $("#incorrect").html("Score Submitted for " + div + " Division");
//     //         $('input[type="submit"]').prop('disabled', true);
//     //     } else {
//     //         $('input[type="submit"]').prop('disabled', false);
//     //     }
//     // });
// }


/**
 * Capitalises the first letter of a string
 */
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}




/**
 * Checks the register account form, if correct, AJAX Sends the data to be added
 */
function checkAccountForm()
{
    var values = {};
    $.each($('#formAccount').serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });

    if (values['password'] != values['confirm_password']) {
        return false;
    }

    $.ajax({
        type: 'POST',
        url: '/ajax_createaccount',
        data: {
            'anz_num': values['anz_num'],
            'club': values['club'],
            'password': values['password'],
            'confirm_password': values['confirm_password'],
            'email': values['email'],
            'first_name': values['first_name'],
            'last_name': values['last_name'],
            'prefered_type': values['prefered_type'],
            'gender': values['gender']
        },
        success: function (data) {
            var json = $.parseJSON(data);
            if (json.status == 'failed') {
                alert(json.message);
            } else {
                alert('Profile created');
                location.reload();
            }

        }
    });
    return false;

}

/**
 *
 * Checks the Profile Form data and if correct, AJAX sends to be created in system
 */

function checkProfileForm()
{
    var values = {};
    $.each($('#formProfile').serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });

    if (values['password'] != values['confirm_password']) {
        return false;
    }

    $.ajax({
        type: 'POST',
        url: '/ajax_createprofile',
        data: {
            'anz_num': values['anz_num'],
            'email': values['email'],
            'first_name': values['first_name'],
            'last_name': values['last_name'],
            'prefered_type': values['prefered_type'],
            'gender': values['gender']
        },
        success: function (data) {
            var json = $.parseJSON(data);
            if (json.status == 'failed') {
                alert(json.message);
            } else {
                alert('Profile created');
                location.reload();
            }
        }
    });
    return false;

}






