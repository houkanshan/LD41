<?php

include "base.php";

header("Access-Control-Allow-Origin: *");

$ip = $_SERVER['REMOTE_ADDR'];
$id = get_id_by_ip($ip);

if ($id) {
  try {
    update_user($ip, $id, STATE_WINNING, '');
    echo "$id";
  } catch (Exception $e) {
    header(':', true, 500);
  }
} else {
  http_response_code(400);
}

?>
