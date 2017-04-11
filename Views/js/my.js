/**
 * Created by Steve on 1/03/2017.
 */

$(document).ready(function () {

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


    // // Toggles the confirm scores button
    // if (!$('#correctScores').is(' :checked')) {
    //     $('#submit').prop('disabled', true);
    // }

    $('#correctScores').change(function () {
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
        if (welcome[3] == 'overall') {
            $('#archeryselect').selectpicker('val', welcome['3']);
        } else if (welcome[3] == 'myscores') {
            $('#archeryselect').selectpicker('val', welcome['3']);
        } else if (welcome[3] == 'week' && !isNaN(welcome[4])) {
            var currentweek = $('#currentWeek').text();
            $('#archeryselect').selectpicker('val', currentweek);
        } else {
            var weekValue = $('#selectedWeek').text();
            $('#archeryselect').selectpicker('val', weekValue);
        }
    });


    /**
     * Redirects the page to the right week after being selected
     */
    $('#archeryselect').on('change', function () {
        var week = $('#archeryselect').children('option').filter(":selected").val();

        if (week == 'overall') {
            window.location = '/overall';
        } else if (week == 'myscores') {
            window.location = '/myscores';
        } else {
            var url = "week?" + week;
            if (url) {
                window.location = url;
            } else {
                window.location = '/myscores';
            }
        }
        return;

    });


    $('#overallSelector').on('change', function () {
        var div = $('#overallSelector').children('option').filter(":selected").val();
        //console.log(div);
        $.ajax({
            type: 'POST',
            url: '/ajax_viewOverall',
            data: {
                division:div
            },
            success: function (data) {
                var json = $.parseJSON(data);

                //console.log(data); return;

                if (json.status == 'failed') {
                    alert('Please try again later');
                    location.reload();
                } else {
                    var tableAverages = "#tableAverages tbody";
                    var tablePoints = "#tablePoints tbody";
                    $(tableAverages).empty();
                    $(tablePoints).empty();
                    var averages = json.averages;
                    var points = json.points;

                    var i = 1;
                    $(averages).each(function() {
                        $(tableAverages).append('<tr>' +
                            '<td> ' + i + '</td>' +
                            '<td> ' + capitalizeFirstLetter(this.first_name) + " " + capitalizeFirstLetter(this.last_name) + '</td>' +
                            '<td> ' + this.average_score + '</td>' +
                            '<td> ' + this.average_x + '</td>' +
                            '<td> ' + this.top10 + '</td>' +
                            '</tr>'
                        );
                        i++;
                    });

                    i = 1;
                    $(points).each(function() {
                        $(tablePoints).append('<tr>' +
                            '<td> ' + i + '</td>' +
                            '<td> ' + capitalizeFirstLetter(this.first_name) + " " + capitalizeFirstLetter(this.last_name) + '</td>' +
                            '<td> ' + this.top_ten_points + '</td>' +
                            '</tr>'
                        );
                        i++;
                    });
                }
            }
        });
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

    function toggleViewScoring(element, button) {
        if ($(button).val() == 'Hide') {
            $(button).prop('value', 'Scoring');
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


    $('#adminEvents').ready(function () {
        var event = $('#adminEvents').children('option').filter(":selected").val();
        if (event > 1) {
            $.ajax({
                type: 'POST',
                url: '/ajax_getEventDetails',
                data: {
                    'id': event
                },
                success: function (data) {
                    var json = $.parseJSON(data);

                    if (json.status == 'failed') {
                        alert('Cannot add account');
                    } else {
                        $('#currentEventWeek').val(json.currentWeek);
                        $('#currentEventNumWeeks').val(json.numWeeks);
                    }
                }
            });
        }
    });

    $('#adminEvents').change(function () {
        var event = $('#adminEvents').children('option').filter(":selected").val();

        $.ajax({
            type: 'POST',
            url: '/ajax_getEventDetails',
            data: {
                'id': event
            },
            success: function (data) {
                var json = $.parseJSON(data);

                if (json.status == 'failed') {
                    alert('Cannot add account');
                } else {
                    $('#currentEventWeek').val(json.currentWeek);
                    $('#currentEventNumWeeks').val(json.numWeeks);
                }
            }
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
     * Displays the scoring tables
     */
    $('#openScoring').ready(function () {
        $('#openScoring').on('click', function () {
            toggleViewScoring('#scoringTable', '#openScoring');
        });
    });

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


    /***********************************************************************************
     * *********************************************************************************
     *
     *                  FOR TESTING
     * *********************************************************************************
     ***********************************************************************************/


    $('#testingButton').on('click', function () {

        $('tr.archer').each(function () {
            $this = $(this);
            var a = Math.floor(Math.random() * 300) + 1;
            var score = $this.find("input#score").val(a);

            var b = Math.floor(Math.random() * 30) + 1;
            var xcount = $this.find("input#xcount").val(b);

        });

    });



    /**
     *  On Submit button, scores are sent via AJAX to be entered in the DB
     *   - If score exists, displays a message below users name to show the mistake
     *   - If score is legit, removes all rows in the table and appends the new data to it
     */
    $('#submit').on('click', function () {

        $('tr.archer').each(function () {
            $("#invalidScore").remove();
            $("#invalidXCount").remove();
            $("#hasscore").remove();
        });

        var failed = [];
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

                    //console.log(data); return;

                    if (json.status == 'failed') {
                        $("tr.archer").each(function() {
                            $this = $(this);
                            var name = $this.find("span.name").html();
                            if (name == archer.name) {
                                failed.push(name);
                                $('<p id="hasscore" style="color: red">Score already entered</p>').insertAfter($($this.find("span.name")));
                            }
                            // $('#submit').prop('disabled', true);
                            $('#correctScores').prop('checked', false);
                        });
                    } else {
                        $("tr.archer").each(function() {
                            $this = $(this);
                            var name = $this.find("span.name").html();
                            var div = $this.find("select#div").val();
                            var score = $this.find("input#score").val('');
                            var xCount = $this.find("input#xcount").val('');
                            if (name == archer.name) {
                                $('<p id="invalidXCount" style="color: green">Score Updated</p>').insertAfter($($this.find("span.name")));
                                return false;
                            }

                        });
                        if (div == 'recurve barebow') {
                            div = 'recurvebb';
                        }
                        var table = "#table-" + div;
                        var tableTBody = "#table-" + div + " tbody";
                        $(tableTBody).empty();
                        var archersScores = json.allScores;

                        var i = 1;
                        $(archersScores).each(function() {
                            $(tableTBody).append('<tr>' +
                                '<td> ' + i + '</td>' +
                                '<td> ' + capitalizeFirstLetter(this.first_name) + " " + capitalizeFirstLetter(this.last_name) + '</td>' +
                                '<td> ' + this.score + '</td>' +
                                '<td> ' + this.xcount + '</td>' +
                                '<td> ' + this.average_score + '</td>' +
                                '<td class="hidden-xs hidden-sm"> ' + this.handicap_score + '</td>' +
                                '<td class="hidden-xs hidden-sm">0</td>' +
                                '</tr>'
                            );
                            i++;
                        });
                    }
                }
            });
        });

        function checkScore(score) {
            if (isNaN(score)) {
                return false;
            } else if (score > 300 || score < 0) {
                return false;
            }

            return true;
        }
        function checkXCount(xcount) {
            if (isNaN(xcount)) {
                return false;
            } else if (xcount > 30 || xcount < 0) {
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
                $('#updateProfile').prop('disabled', true);
            } else {
                $('#registerAccount').prop('disabled', false);
                $('#updateProfile').prop('disabled', false);

            }
        }
    });

}); // end of document ready


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
            'password': values['password'],
            'confirm_password': values['confirm_password'],
            'email': values['email'],
            'first_name': values['first_name'],
            'last_name': values['last_name'],
            'prefered_type': values['prefered_type'],
        },
        success: function (data) {
            var json = $.parseJSON(data);
            //console.log(data);return;

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
            'prefered_type': values['prefered_type']
        },
        success: function (data) {
            var json = $.parseJSON(data);

            //console.log(data);

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
 * Checks the users login details
 */
function checkLogin()
{
    var values = {};
    $.each($('#loginForm').serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });

    if (values['password'] == "" || values['email'] == "") {
        alert('Please check details and try again');
        return false;
    }

    $.ajax({
        type: 'POST',
        url: '/ajaxCheckLogin',
        data: {
            'password': values['password'],
            'email': values['email']
        },
        success: function (data) {
            var json = $.parseJSON(data);
            if (json.status == 'failed') {
                alert(json.message);
            } else {
                window.location.href = "/week?week=" + json.week;
            }

        }
    });
    return false;

}


/**
 * Checks the profile update form
 *
 */
function checkProfileUpdate()
{
    var values = {};
    $.each($('#userprofileform').serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });

    if (values['password'] != values['confirm_password']) {
        return false;
    }

    $.ajax({
        type: 'POST',
        url: '/ajaxUpdateProfile',
        data: {
            'address': values['address'],
            'anz_num': values['anz_num'],
            'club': values['club'],
            'phone': values['phone'],
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
                alert('Profile updated');
                location.reload();
            }

        }
    });
    return false;

}

/**
 *
 */
function submitContactForm()
{
    var values = {};
    $.each($('#contact').serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });

    $.ajax({
        type: 'POST',
        url: '/ajax_submitContact',
        data: {
            'email': values['email'],
            'name' : values['name'],
            'message' : values['message']
        },
        success: function (data) {
            var json = $.parseJSON(data);
            //console.log(data);return;

            if (json.status == 'failed') {
                alert(json.message);
            } else {
                alert(json.message);
                location.reload();
            }

        }
    });
    return false;

}




