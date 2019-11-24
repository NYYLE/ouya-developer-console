<!-- File: src/Template/Games/index.ctp -->
<style>
.gameslist {
    list-style-type: none;
    padding: 0;
    margin: 30px 0 165px 0;
    background: url(/web/20190522062303im_/https://www.ouya.tv/wp-content/themes/ouya/images/games-top-border.png) no-repeat scroll 0 top;
}

.gameslist li {
    margin: 0;
    padding: 0;
    height: 195px;
    /* background: #fff; */
    position: relative;
    overflow: hidden;
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
    margin: 0;
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
foreach ($games as $game) {
  if ($i % 2) {
    $style = "background-color: #f5f5f5;";
  } else {
    $style = "";
  }
  ?>
<li style="<?php echo $style ?>">
  <a href="../games/view/<?php echo $game['packageName'] ?>">
    <img class="posterImage" src="<?php echo $game['media']['discover'] ?>" data-original="<?php echo $game['media']['discover'] ?>" width="235" height="132" alt="<?php echo $game['title'] ?>" style="display: block;">
    <noscript><img class="posterImage" src="<?php echo $game['media']['discover'] ?>" width="235" height="132" alt="100 Rogues"></noscript>
    <div class="gamelistDetails">
      <h3 class="gamelistTitle"><?php echo $game['title'] ?></h3>
      <span class="stars"><span style="width: 80px;"></span></span>
      <span class="ratingCount">&nbsp;(215)</span>
      <h4 class="gamelistRelease">Released: August 2013</h4>
      <h4 class="gamelistDeveloper">Developer: Fusion Reactions</h4>
      <div class="gameTaglist">
        <div class="gameTag">Retro</div>
        <div class="gameTag">Role-Playing</div>
        <div class="gameTag">Arcade/Pinball</div>
      <div class="clearfix">
      </div>
    </div>
  </div>
</a>
</li>
<?php
$i++;
} ?>
</ul>
