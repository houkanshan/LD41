<?php

include "base.php";

header("Access-Control-Allow-Origin: *");

$ip = get_ip();
$id = get_id_by_ip($ip);

if ($id) {
  try {
    choose_to_win($ip);
    echo "$id";
  } catch (Exception $e) {
    header(':', true, 500);
  }
} else {
  http_response_code(400);
}

?>
