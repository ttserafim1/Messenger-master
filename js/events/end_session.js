function _exit() {
    if (confirm("Вы уверены, что хотите выйти?"))
        window.location.href = "../dialog/exit_handler.php";
}