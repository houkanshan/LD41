<?php include "base.php"; ?>

<?php
define("VERSION", 1);

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
  <title>LD41</title>
  <link rel="stylesheet" href="dist/css/index.css?v=<?php echo VERSION ?>">
  <link rel="shortcut icon" href="http://serotoninphobia.info/favicon.ico">
  <meta name="viewport" content="user-scalable=no, width=540">
</head>
<body data-state="<?php echo $is_active ? 'active' : 'inactive' ?>">
  <div class="banner"></div>
  <table>
    <tr class="section-win"><td>
      <label>figure 1</label>
      <h1>Winning Condition</h1>
      <p class="intro">Type the following line(s) to secure your win.</p>
      <div id="textarea-win" class="textarea"></div>

      <div class="actions">
        <button type="button" id="btn-win" disabled>
          I’m ready to confirm my win.</button>
      </div>
    </td></tr>

    <tr class="section-lose"><td>
      <section id="section-billboard">
        <p>
          ANNOUNCEMENT: <?php echo $total?> players have played this game so far,
          among which <?php echo $total_winners?> players have won this game.
          The latest win was achieved <?php echo formatDateDiff($last_winner_time, $now)?>.
          Refresh the page to have the statistics updated.
        </p>
      </section>

      <div class="section-lose-inner">
        <label>figure 2</label>
        <p class="intro">
          Alternatively. If win is not what you seek,
          you can also write something here for the future win-seekers to see:
        </p>
        <div id="textarea-lose" class="textarea"></div>

        <div class="actions">
          <button type="button" id="btn-lose" disabled>
            I’m confident this is what I’m intended to say.</button>
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

</div>
</div>
</div>

<script>
  var Data = {
    id: '<?php echo $id ?>',
    idStr: '<?php echo $id_str ?>'
  }
</script>

<script src="dist/js/index.js?v=<?php echo VERSION ?>"></script>
</body>
</html>
