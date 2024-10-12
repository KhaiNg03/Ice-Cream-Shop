<?php
if (isset($success_msg)) {
    foreach ($success_msg as $msg) {
        echo "<script>showAlert('$msg');</script>"; // Sử dụng hàm showAlert
    }
}

if (isset($warning_msg)) {
    foreach ($warning_msg as $msg) {
        echo "<script>showAlert('$msg');</script>"; // Sử dụng hàm showAlert
    }
}

if (isset($info_msg)) {
    foreach ($info_msg as $msg) {
        echo "<script>showAlert('$msg');</script>"; // Sử dụng hàm showAlert
    }
}

if (isset($error_msg)) {
    foreach ($error_msg as $msg) {
        echo "<script>showAlert('$msg');</script>"; // Sử dụng hàm showAlert
    }
}
?>
