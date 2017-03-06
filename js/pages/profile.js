(function () {

    $('#show-recipes-btn').on('click', function () {
        var id = $(this).attr('data-id');
        $.ajax({
            url: '?c=recipe&a=usersAll&id=' + id,
            type: 'Get',
            contentType: 'application/json',
            success: function (recipes) {
                $('#user-recipes-wrap').html(recipes);
            },
            error: function () {
                $('#error').html("Error happened: " + err)
            }
        });

    });
}
());
