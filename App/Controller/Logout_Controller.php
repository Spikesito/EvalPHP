<?php

// session_destroy();
// session_destroy();
session_unset();
// for ($i = 0; $i < sizeof($_SESSION['data']); $i++) {
//     $_SESSION['data'][$i] = "";
// }
// $_SESSION['data'] = [];
$_SESSION['connected'] = false;
header("Location: /", true, 301);
exit();
