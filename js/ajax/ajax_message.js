function _update() {
    $.ajax({
        url: '../../dialog/update_message/update_handle.php',
        type: 'POST',
        dataType: 'JSON',
        success: function(response) {
            document.getElementById("add_messages").innerHTML = response.message;
            setTimeout(_update, 100);
        }
    });
}

$(document).ready(function() {
    _update();
});