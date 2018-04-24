<?php include "base.php"; ?>

<?php
define("VERSION", 6);

$ip = get_ip();
$user_info = get_or_create_user_info($ip);
$id = $user_info[0];
$id_str = formatId($id);
$state = $user_info[1];
$comment = $user_info[2];
$is_active = $state == 0;

$totals = get_totals();
$total = $totals[0];
$total_winners = $totals[1];
$last_winner = get_last_winner();
$last_winner_id = $last_winner[0];
$last_winner_ip = $last_winner[1];
$last_winner_time = $last_winner[2];
$now = time();

$comments = get_last_comments(2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Winning Condition</title>
  <link rel="stylesheet" href="dist/css/index.css?v=<?php echo VERSION ?>">
  <link rel="shortcut icon" href="http://serotoninphobia.info/favicon.ico">
  <meta name="viewport" content="user-scalable=no, width=540">
</head>
<body data-state="<?php echo $is_active ? 'active' : 'inactive' ?>">
  <div class="banner">
    <a target="_blank" href="http://lab.serotoninphobia.info/centrifuge/completeguide.html">
      <img src="./pics/banner.png" width="683px" height="84px">
      </a>
    <div class="close"></div>
  </div>
  <table>
    <tr class="section-win"><td>
      <label>figure 1</label>
      <h1>Winning Condition</h1>
      <p class="intro">Type in the following line to claim your win.</p>
      <div id="textarea-win" class="textarea"></div>

      <div class="actions">
        <button type="button" id="btn-win" disabled>
          I’m ready to claim my win.</button>
        <span id="count-wrong"></span>
      </div>
      <div class='end-overlay'>
        <div class="message">Your Session Has Expired</div>
      </div>
      <div class="win-overlay cong">
        <div class="cong-message">CONGRATULATIONS!</div>
      </div>
    </td></tr>

    <tr><td>
      <section id="section-billboard">
        <div class="wrapper">
          <p>
            ANNOUNCEMENT: <?php echo $total?> players have played this game so far,
            among which <?php echo $total_winners?> players have won this game.
            The latest win was achieved <?php echo formatDateDiff($last_winner_time, $now)?> ago.
            Refresh the page to have the statistics updated.
          </p>
        </div>
      </section>
    </td></tr>
    <tr class="section-lose"><td>

      <div class="section-lose-inner">
        <label>figure 2</label>
        <p class="intro">
          Alternatively, if win is not what you seek,
          you may also write something here for the future win-seekers to see:
        </p>
        <div id="textarea-lose" class="textarea"></div>

        <div class="actions">
          <button type="button" id="btn-lose" disabled>
            I’m confident this is what I’m intended to say.</button>
        </div>
        <div class='end-overlay'>
          <div class="message">Your Session Has Expired</div>
        </div>
        <div class="win-overlay">
          <div class="message">
            You are the winner #<span class="winner-number"></span>
            <br>
            Your completion time is <span class="elapsed">0.000</span>s
          </div>
        </div>
      </div>
    </td></tr>

    <tr class="section-lose-comment"><td>
      <?php for($i = 0; $i < 2; $i++): ?>
        <?php
          $comment = $comments[$i];
          $_data = explode(',', $comment, 3);
          $_id = $_data[0];
          $_ip = $_data[1];
          $_comment = $_data[2];
        ?>
        <section class="comment">
          <label>figure 3-<?php echo $i == 0 ? 'a' : 'b' ?></label>
          Player #<?php echo formatId($_id) ?> (<?php echo formatIp($_ip) ?>) Said: "<?php echo $_comment ?>"
        </section>
      <?php endfor; ?>
    </td></tr>
  </table>
  <footer>
    <div class="left">
      Time Elapsed: <span class="elapsed">0.000</span>s
      <br/>
      Player Statues: *<?php echo $is_active ? 'Active' : 'Inactive' ?>
      <br/>
      * This game is read-only for inactive players.
    </div>
    <div class="right">
      Copyright &copy; <?php echo date("Y"); ?> Zerotonin &amp; Houkanshan<br/>
      Created for The Ludum Dare 41
    </div>
  </footer>

</div>
</div>
</div>

<script>
  var Data = {
    id: '<?php echo $id ?>',
    idStr: '<?php echo $id_str ?>',
    isActive: <?php echo $is_active ? 'true' : 'false' ?>
  }
</script>

<script src="dist/js/index.js?v=<?php echo VERSION ?>"></script>
</body>
</html>
