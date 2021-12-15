$(document).ready(function function_name(e) {
    $('body').off('click', '.find-btn').on('click', '.find-btn', function function_name(e) {
        e.preventDefault();
        var btn = $(this);
        var form = btn.closest('form');
        var formData = new FormData(form[0]);
        console.log(form);
        var url = form.attr('action');
        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.btn').attr("disabled", "disabled");
                $('#location-table').html('');
                $('#location-table').html("<h4 class='text-center'>Loading...</h4>");
            },
            success: function(result) {
                $('.btn').removeAttr("disabled");
                if (result.status == 'success') {
                    $('#location-table').html(result.data);
                } else {
                    alert(result.message);
                    $('#location-table').html('');
                }
            },
            error: function(err) {
                $('.btn').removeAttr("disabled");
                alert('something went wrong!');
                $('#location-table').html('');
            }
        });
    })
})