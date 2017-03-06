(function () {
    $(document).ready(function () {
        $(".form").validate();

        $('.choose-image input[type="file"]').change(function () {
            var inputFile = $(this);
            $('#input-file-name').text(inputFile.val());
        })

    });
}
());





