$(document).ready(function () {
    $('#email').change(function () {
        let email = $(this).val();
        if (email.length > 8) {
            $('#val').html("<span class='check'>Checking availability...</span>");

            $.ajax({
                type: "get",
                url: "check-email-ajax.php",
                data: "email=" + email,
                success: function (response) {
                    if (response == 'yes') {
                        $('#val').html("<span class='avai'>Email is available.</span>");
                    } else if (response == 'no') {
                        $('#val').html("<span class='not-avai'>Email is not available.</span>");
                    }
                }
            })
        } else {
            $('#val').html("<span class='short'>Email is too short.</span>");
        }
    });
});