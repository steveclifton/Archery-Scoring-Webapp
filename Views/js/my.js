$(document).ready(function () {


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


});


