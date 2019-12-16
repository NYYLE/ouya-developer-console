<!-- File: src/Template/Games/index.ctp -->
<style>
.gameslist {
    list-style-type: none;
    padding: 0;
    margin: 30px 0 30px 0;
    background: url(/web/20190522062303im_/https://www.ouya.tv/wp-content/themes/ouya/images/games-top-border.png) no-repeat scroll 0 top;
}

.gameslist li {
    margin: 0;
    padding-bottom: 5px;
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
    object-fit: contain;
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
    margin: 0;
}

span.stars, span.stars span {
    display: block;
    background: url(img/star-20x20.png) 0 -20px repeat-x;
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

.gamelistDetails .stars {
    margin: 4px 0 4px 0;
}

span.ratingCount {
    float: left;
    line-height: 24px;
    font-size: .9em;
    margin: 4px 0;
    color: #3E3D45;
}

span.stars span {
    background-position: 0 0;
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
    margin: 0;
}

.gameslist .gameTaglist {
    padding-top: 10px;
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

<h1>Games</h1>

<!-- Here's where we iterate through our $games query object, printing out article info -->
<ul class="gameslist">
<?php
$i = 0;
if ($games != null && count($games) > 0) {
  foreach ($games as $game) {
  //  debug($game);
    if ($i % 2) {
      $style = "border-radius: 10px;";
    } else {
      $style = "background-color: #ffffff; border-radius: 10px;";
    }
    ?>
  <li style="<?php echo $style ?>">
    <a href="games/view/<?php echo $game['packageName'] ?>">
      <img class="posterImage" src="<?php echo str_replace('http://', 'https://', $game['discover']) ?>" data-original="<?php echo $game['discover'] ?>" width="235" height="132" alt="<?php echo $game['title'] ?>" style="display: block; width:235; height:132;">
      <noscript><img class="posterImage" src="<?php echo str_replace('http://', 'https://', $game['discover']) ?>" width="235" height="132" alt="100 Rogues"></noscript>
      <div class="gamelistDetails">
        <h3 class="gamelistTitle"><?php echo $game['title'] ?></h3>
        <?php
        if (!empty($game['rating'])) {
        ?>
        <span class="stars"><span style="width: <?php echo $game['rating']['average'] * 20 ?>px;"></span></span>
        <span class="ratingCount">&nbsp;(<?php echo $game['rating']['count'] ?>)</span>
        <?php
        }

        if (!empty($game['rating'])) {
        ?>
        <h4 class="gamelistRelease"><?php echo explode(' by ', $game['overview'])[0] ?></h4>
        <?php
        }
        ?>
        <h4 class="gamelistDeveloper"><?php echo $game['developer']['name'] ?></h4>
        <div class="gameTaglist">
          <?php foreach ($game['genres'] as $tag) {
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
  No games to show.
  </p>
  <?php
}?>
</ul>

<ul class="pagination">
    <li><a href="?page=1">First</a></li>
    <li class="<?php if($page <= 1){ echo 'disabled'; } ?>">
        <a href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1); } ?>">Prev</a>
    </li>

    <li style="float: right;"><a href="?page=<?php echo $total_pages; ?>">Last</a></li>
    <li class="<?php if($page >= $total_pages){ echo 'disabled'; } ?>" style="float: right;">
        <a href="<?php if($page >= $total_pages){ echo '#'; } else { echo "?page=".($page + 1); } ?>">Next</a>
    </li>
</ul>
