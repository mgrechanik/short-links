jQuery( document ).ready(function() {
    let $form = $('#short-link-form');
    $form.on('beforeSubmit', function() {
        let data = $form.serialize();
        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: data,
            success: function (data) {
                $('#shortlink-long_url').attr('disabled', 'disabled');
                $form.find('[type=submit]').attr('disabled', 'disabled');
                $('#res-url').html(data.link);
                $('#res-qr').html(data.qr);
                //console.log(data);
            },
            error: function(jqXHR, errMsg) {
                alert(errMsg);
            }
        });
        return false; // prevent default submit
    });
});

