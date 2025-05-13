<?php
session_start();
session_destroy();
header("Location: ../vista/index.php");
exit;
?>
