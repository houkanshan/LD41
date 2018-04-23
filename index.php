<?php include "base.php"; ?>

<?php
define("VERSION", 1);

$ip = get_ip();
$user_info = get_or_create_user_info($ip);
$id = $user_info[0];
$state = $user_info[1];
$comment = $user_info[2];
$is_active = $state == 0;
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
<body data-state="<?php echo $is_active ? 'active' : 'inactive' ?>">
  <div class="banner"></div>
  <table>
    <tr class="section-win"><td>
      <h1>Winning Condition</h1>
      <p class="intro">Type the following line(s) to secure your win.</p>
      <div id="textarea-win" class="textarea"></div>

      <div class="actions">
        <button type="button" id="btn-win" <?php echo $is_active ? '' : 'disabled' ?>>
          I’m ready to confirm my win.</button>
      </div>
    </td></tr>

    <tr class="section-lose"><td>
      <section class="section-billboard">
        <p>
          ANNOUNCEMENT: ### players have played this game so far,
          among which ### players have won this game.
          The latest win was achieved ## hours and ## mins ago.
          Refresh the page to have the statistics updated.
        </p>
      </section>

      <div class="section-lose-inner">
        <p class="intro">
          Alternatively. If win is not what you seek,
          you can also write something here for the future win-seekers to see:
        </p>
        <div id="textarea-lose" class="textarea"></div>

        <div class="actions">
          <button type="button" id="btn-lose" <?php echo $is_active ? '' : 'disabled' ?>>
            I’m confident this is what I’m intended to say.</button>
        </div>
      </div>
    </td></tr>

    <tr class="section-lose-comment"><td>
      <section></section>
      <section></section>
    </td></tr>


  </table>

</div>
</div>
</div>

<script>
  var Data = {
    a: '<?php echo $user_id ?>'
  }
</script>

<script src="dist/js/index.js?v=<?php echo VERSION ?>"></script>
</body>
</html>
