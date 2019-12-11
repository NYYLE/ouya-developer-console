<!-- File: src/Template/Users/games.ctp -->
<style>
.gameslist {
    list-style-type: none;
    padding: 0;
    margin: 30px 0 30px 0;
    background: url(/web/20190522062303im_/https://www.ouya.tv/wp-content/themes/ouya/images/games-top-border.png) no-repeat scroll 0 top;
}

.gameslist li {
    margin: 0;
    padding-bottom: 5;
    height: 195px;
    /* background: #fff; */
    position: relative;
    overflow: hidden;
    border-radius: 10px;
}

.gameslist .posterImage {
    position: absolute;
    top: 27px;
    left: 30px;
}

.gameslist .gamelistDetails {
    position: absolute;
    left: 300px;
    top: 31px;
}

.gamelistTitle {
    font-family: 'Futura W01 Bold', sans-serif;
    font-size: 24px;
    line-height: 25px;
    color: #fc4422;
    margin: 0 0 4px 0;
}

span.stars, span.stars span {
    display: block;
    background: url(/web/20190522062303im_/https://www.ouya.tv/wp-content/themes/ouya/images/star-20x20.png) 0 -20px repeat-x;
    width: 100px;
    height: 20px;
    float: left;
}

span.ratingCount {
    float: left;
    line-height: 24px;
    font-size: .9em;
    margin: 4px 0;
    color: #3E3D45;
}

.gamelistRelease {
    font-family: 'Proxima N W01 Reg', sans-serif;
    font-size: 18px;
    line-height: 18px;
    color: #3e3d45;
    margin: 0 0 6px 0;
    clear: both;
}

.gamelistDeveloper {
    font-family: 'Proxima N W01 Reg', sans-serif;
    font-size: 14px;
    line-height: 14px;
    color: #3e3d45;
    margin: 9px 0 0 0;
}

.gameslist .gameTaglist {
    padding-top: 10px;
    padding-bottom: 10px;
}

.gameTag {
    float: left;
    background: #aeaeae;
    color: #333;
    font-size: 10px;
    padding: 3px 8px 0;
    font-family: 'Proxima N W01 Bold', helvetica, arial, sans-serif;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    margin-right: 14px;
}
</style>

<h1>Rejected Games</h1>

<!-- Here's where we iterate through our $games query object, printing out article info -->
<ul class="gameslist">
<?php
$i = 0;
if ($rejected_games != null && count($rejected_games) > 0) {
  foreach ($rejected_games as $game) {
    //debug($game);
    if ($i % 2) {
      $style = "background-color: #b1b1b1; border-radius: 10px;";
    } else {
      $style = "background-color: #f5f5f5; border-radius: 10px;";
    }
    ?>
  <li style="<?php echo $style ?>">
    <a href="../games/view/<?php echo $game['game_data']['packageName']; ?>">
      <img class="posterImage" src="<?php echo $game['game_data']['media']['discover'] ?>" data-original="<?php echo $game['game_data']['media']['discover'] ?>" width="235" height="132" alt="<?php echo $game['game_data']['title'] ?>" style="display: block;">
      <noscript><img class="posterImage" src="<?php echo $game['game_data']['media']['discover'] ?>" width="235" height="132" alt="100 Rogues"></noscript>
      <div class="gamelistDetails">
        <h3 class="gamelistTitle"><?php echo $game['game_data']['title'] ?></h3>

        <h4 class="gamelistDeveloper">Developer: Fusion Reactions</h4>
        <div class="gameTaglist">
          <div class="gameTag">Retro</div>
          <div class="gameTag">Role-Playing</div>
          <div class="gameTag">Arcade/Pinball</div>
        <div class="clearfix">
        </div>
      </div>
      <?php echo $this->html->link('Edit', array('controller' => 'games', 'action' => 'edit', $game['game_data']['packageName']), array('class' => 'btn btn-secondary')); ?>
    </div>
  </a>
  </li>
  <?php
  $i++;
  }
} else {
  ?>
  <p>
  You have no rejected games.
  </p>
  <?php
} ?>
</ul>

<h1>Submitted Games</h1>

<!-- Here's where we iterate through our $games query object, printing out article info -->
<ul class="gameslist">
<?php
$i = 0;
if ($submitted_games != null && count($submitted_games) > 0) {
  foreach ($submitted_games as $game) {
  //  debug($game);
    if ($i % 2) {
      $style = "border-radius: 10px;";
    } else {
      $style = "background-color: #ffffff; border-radius: 10px;";
    }
    ?>
  <li style="<?php echo $style ?>">
    <a href="games/view/<?php echo $game['packageName'] ?>">
      <img class="posterImage" src="<?php echo str_replace('http://', 'https://', $game['game_data']['discover']) ?>" data-original="<?php echo $game['game_data']['discover'] ?>" width="235" height="132" alt="<?php echo $game['title'] ?>" style="display: block;">
      <noscript><img class="posterImage" src="<?php echo str_replace('http://', 'https://', $game['game_data']['discover']) ?>" width="235" height="132" alt="100 Rogues"></noscript>
      <div class="gamelistDetails">
        <h3 class="gamelistTitle"><?php echo $game['game_data']['title'] ?></h3>
        <h4 class="gamelistRelease"><?php echo explode(' by ', $game['game_data']['overview'])[0] ?></h4>
        <h4 class="gamelistDeveloper"><?php echo $game['game_data']['developer']['name'] ?></h4>
        <div class="gameTaglist">
          <?php foreach ($game['game_data']['genres'] as $tag) {
            ?>
            <div class="gameTag"><?php echo $tag ?></div>
            <?php
          }
          ?>
        <div class="clearfix">
        </div>
      </div>
    </div>
  </a>
  </li>
  <?php
  $i++;
  }
} else {
  ?>
  <p>
  You have not submitted any games.
  </p>
  <?php
}?>
</ul>
