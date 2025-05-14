$(document).ready(function() {
    $('#message_add_form').submit(function(event) {
        document.getElementById('message_text').value = "";
        event.preventDefault();
        $.ajax({
            url: '../../dialog/add_message/message_handle.php',
            type: "POST",
            data: $(this).serialize(),
            dataType: 'JSON',
            success: function(response) {
                if (response["status"] == "error")
                    $('#_danger_throw_message').html(response["message"]);
                else
                    $('#_danger_throw_message').html("");
            }
        });
    });
});