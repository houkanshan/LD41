<?php include "base.php"; ?>

<?php
define("VERSION", 1);
$ip = $_SERVER['REMOTE_ADDR'];
$user_id = get_id_by_ip($ip);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>LD41</title>
  <link rel="stylesheet" href="dist/css/index.css?v=<?php echo VERSION ?>">
  <link rel="shortcut icon" href="http://serotoninphobia.info/favicon.ico"/>
  <meta name="viewport" content="user-scalable=no, width=540">
</head>
<body data-state="title">

<div id="computer">
<div id="screen-wrapper" class="crt-container">
<div id="screen">


  <div id="stage-title" class="stage">
  </div>

  <div id="stage-login" class="stage">
  </div>

  <div id="stage-main" class="stage">
  </div>

  <div id="stage-end" class="stage">
  </div>

  <p id="last-comments-wrapper"></p>

  <form class="post-form">
    <div class="comment-wrapper">
      <input type="text" name="comment" placeholder="Leave your message here" autocomplete="off" maxlength="143">
    </div>
  </form>
  <div class="preload">
    <img src="dist/pics/title1.png?v=2" alt="">
    <img src="dist/pics/title2.png?v=2" alt="">
  </div>
</div>
</div>
</div>

<?php
// a userId
// b brithTime
// c deathTime
// d life
// e canExtend
?>

<script>
  var Data = {
    a: '<?php echo $user_id ?>'
  }
</script>

<script src="dist/js/index.js?v=<?php echo VERSION ?>"></script>
</body>
</html>
