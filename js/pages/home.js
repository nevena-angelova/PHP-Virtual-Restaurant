(function () {

    $('#contact-form').on('submit', function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url: '?c=home&a=sendMail',
            type: 'Post',
            data: data,
            success: function (result) {
                $('#send-msg-result').html(result);
            },
            error: function () {
                $('#error').html("Error happened: " + err)
            }
        });

    });
}
());