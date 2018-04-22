<?php
include "base.php";


header("Access-Control-Allow-Origin: *");


echo join('\n', get_last_comments(2));

?>
