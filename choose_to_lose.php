<?php

include "base.php";

header("Access-Control-Allow-Origin: *");

$ip = get_ip();
$id = get_id_by_ip($ip);

$comment = str_replace("\n", " ", $_POST["comment"]);

if ($id && $comment) {
  try {
    update_user($ip, $id, STATE_LOSING, $comment);
    file_put_contents(FILE_COMMENTS, $ip.",".$comment.PHP_EOL, FILE_APPEND | LOCK_EX);
    echo "$ip,$comment";
  } catch (Exception $e) {
    header(':', true, 500);
  }
} else {
  http_response_code(400);
}

?>
