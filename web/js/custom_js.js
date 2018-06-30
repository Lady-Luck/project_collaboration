$( document ).ready(function() {

    $(document).on('click', '.js-invite-user-form', function () {
        var url = $(this).data('url');

        $.ajax({
            url: url,
            method: "POST",
            success: function(data){
                var element =  $("#invite_user_form");
                console.log(data);
                element.html(data);
                element.removeClass('hidden');
            }
        });
    });

    $(document).on('submit', 'form[name="invite_form"]', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: "POST",
            data: $(this).serialize(),
            success: function (data) {
                if (data.error) {
                    $('#invite_form_message').html(data.message).addClass('alert-danger').show();
                } else {
                    $('#invite_form_message').html(data.message).addClass('alert-success').show();
                    $('#input_email').val('');
                }
            }
        });
    });

    $(document).on('submit', 'form[id="job_apply"]', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: "POST",
            data: $(this).serialize(),
            success: function (data) {
                if (data.error) {
                    $('#success_messages').html(data.message).addClass('alert-danger').show();
                } else {
                    $('#success_messages').html(data.message).addClass('alert-success').show();
                }
            }
        });
    });

});