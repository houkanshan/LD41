<?php

include "base.php";

header("Access-Control-Allow-Origin: *");

$ip = get_ip();
$id = get_id_by_ip($ip);

$comment = str_replace("\n", " ", $_POST["comment"]);

if ($id && $comment) {
  try {
    choose_to_lose($ip, $comment);
    echo "$ip,$comment";
  } catch (Exception $e) {
    header(':', true, 500);
  }
} else {
  http_response_code(400);
}

?>
