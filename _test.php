<?php
include "base.php";
$ip = get_ip();
$id = get_id_by_ip($ip);
$totals = get_totals();
$last_winner = get_last_winner();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>LD41</title>
</head>
<body>
  <p>Your ID / IP: #<?php echo $id ?> / <?php echo $ip ?></p>
  <p>Total: <?php echo $totals[0] ?></p>
  <p>Total winner: <?php echo $totals[1] ?></p>
  <p>Last winner: #<?php echo $last_winner[0] ?> at <?php echo date(DATE_RFC2822, $last_winner[2]) ?></p>

  <p>Your state: <?php echo join(',', get_or_create_user_info($ip)); ?></p>

  <!-- <p>Last comments are:
    <ul>
      <li>
        <?php echo join('</li><li>', get_last_comments(2)); ?>
      </li>
    </ul>
  </p> -->
  <p>
    Choose to win:
    <form action="choose_to_win.php" method="post">
      <button type="submit">submit</button>
    </form>
  </p>
  <p>
    Choose to lose:
    <form action="choose_to_lose.php" method="post">
      <input type="text" name="comment">
      <button type="submit">submit</button>
    </form>
  </p>

  <?php /* phpinfo() */ ?>
</body>
</html>
