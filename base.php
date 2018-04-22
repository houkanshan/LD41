<?php
include "lib.php";

define("FILE_LOG", "data/log.txt");
define("FILE_GLOBAL_ID", "data/global_id.txt");
define("DIR_USERS", "data/users/");
define("FILE_COMMENTS", "data/comments.txt");
define("FILE_TOTAL_WIN", "data/total_win.txt");

define("STATE_INIT", 0);
define("STATE_WINNING", 1);
define("STATE_LOSING", 2);


date_default_timezone_set('UTC');


function safe_get_contents($filename) {
  $res = file_get_contents($filename);
  if (!$res) {
    raise_e("Get $filename error: $res");
  } else {
    return $res;
  }
}

function read_last_lines($f, $line_count) {
  $cursor = -1;
  fseek($f, $cursor, SEEK_END);
  $char = fgetc($f);

  $lines = [];
  while($line_count > 0) {
    $line_count -= 1;
    $line = '';
    while ($char === "\n" || $char === "\r") {
      fseek($f, $cursor--, SEEK_END);
      $char = fgetc($f);
    }
    while ($char !== false && $char !== "\n" && $char !== "\r") {
      $line = $char . $line;
      fseek($f, $cursor--, SEEK_END);
      $char = fgetc($f);
    }
    array_unshift($lines, $line);
  }

  return $lines;
}

function get_last_comments($count) {
  $comments_file = @fopen(FILE_COMMENTS, "r");
  if ($comments_file) {
    $comments = read_last_lines($comments_file, $count);
    fclose($comments_file);
    return $comments;
  }
}

function create_user_file($ip, $id) {
  file_put_contents(DIR_USERS.$ip.'.txt', "$id,0,".PHP_EOL , FILE_APPEND | LOCK_EX);
}

function register_user($ip) {
  $handle = fopen(FILE_GLOBAL_ID, "r+");
  if (!flock($handle, LOCK_EX)) { exit(); }

  $id = intval(trim(fgets($handle)));
  // echo "old id:".$id."\n";
  $id += 1;
  // echo "new id:".$id."\n";
  fseek($handle, 0);
  fwrite($handle, $id);
  clearstatcache();
  fflush($handle);
  flock($handle, LOCK_UN);
  create_user_file($ip, $id);
  return $id;
}

function get_or_create_user_info($ip) {
  $file_user = DIR_USERS.$ip.".txt";
  $handle = @fopen($file_user, "r");

  clearstatcache();
  if (file_exists($file_user)) {
    # User existed
    $user_info = safe_get_contents($file_user);
    $user_info = explode(",", trim($user_info), 3);
    $user_info[1] = (int)$user_info[1];
    fclose($handle);
    return $user_info;
  } else {
    # User not existed
    return [register_user($ip), STATE_INIT, ''];
  }
}

function get_id_by_ip($ip) {
  $user_info = get_or_create_user_info($ip);
  return $user_info[0];
}

function update_user($ip, $id, $state, $comment) {
  $file_user = DIR_USERS.$ip.".txt";
  return file_put_contents($file_user, "$id,$state,$comment", LOCK_EX);
}

function choose_to_win($ip) {
  $user_info = get_or_create_user_info($ip);
  $id = $user_info[0];
  $state = $user_info[1];
  if ($state == 0) {
    update_user($ip, $id, STATE_WINNING, '');
  }
}
function choose_to_lose($ip, $comment) {
  $user_info = get_or_create_user_info($ip);
  $id = $user_info[0];
  $state = $user_info[1];
  if ($state == 0) {
    update_user($ip, $id, STATE_LOSE, $comment);
    file_put_contents(FILE_COMMENTS, $ip.",".$comment.PHP_EOL, FILE_APPEND | LOCK_EX);
  }
}

function write_log($log) {
   file_put_contents(FILE_LOG, $log."\n",  FILE_APPEND | LOCK_EX);
}
function raise_e($log) {
  write_log($log);
  throw new Exception($log);
}

?>
