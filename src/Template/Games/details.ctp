<!-- File: src/Template/Games/view.ctp -->

<style>
.mySlides {
  display:none
}
.w3-left, .w3-right, .w3-badge {
  cursor:pointer
}
.w3-badge {
  height:13px;width:13px;padding:0
}
.videowrapper {
    float: none;
    clear: both;
    width: 100%;
    position: relative;
    padding-left: 2.5%;
    padding-bottom: 56.25%;
    padding-top: 25px;
    height: 0;
}
.videowrapper iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

</style>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<?php
//debug($game);
?>


<div class="" style="padding-top: 50px">
  <h1 class="col-sm-12" style="padding-bottom: 50px; color: #fc4422; font-size: 55px;"><b><?= mb_strtoupper($game['title']); ?></b></h1>

  <?php
  //debug($game);
  if (isset($game['media']['video'])) {
    ?>
    <div class="videowrapper">
        <iframe class="col-sm-12" style="padding-bottom: 50px;" width="420" height="315" src="<?php echo $game['video']; ?>" frameborder="0" allowfullscreen></iframe>
    </div>
    <?php
    unset($game['media']['video']);
  }
  ?>

  <div class="col-sm-5">
    <p><?= $game['description']; ?></p>
    <p><small>Created: <?= $game['firstPublishedAt'] ?></small></p>
    <?php if ((!empty($User_admin) && $User_admin == '1') || (!empty($User_admin) && $User_admin == '1')) { ?>
    <p><?= $this->Html->link('Edit', ['action' => 'edit', $game['packageName']]) ?></p>
    <?php } ?>
  </div>

  <div class="col-sm-7">
    <div class="w3-content w3-display-container">
      <?php
      foreach ($game['media'] as $screenshot) {
        ?>
            <img class="mySlides w3-animate-opacity" src="<?php echo $screenshot['url']; ?>" style="border-width: 10px;">
            <?php
      }
      ?>
      <div class="w3-center w3-container w3-section w3-large w3-text-white w3-display-bottommiddle" style="width:100%">
        <div class="w3-left w3-hover-text-khaki" onclick="plusDivs(-1)">&#10094;</div>
        <div class="w3-right w3-hover-text-khaki" onclick="plusDivs(1)">&#10095;</div>

        <?php
        $i = 1;
        foreach ($game['media'] as $screenshot) {
          ?>
          <span class="w3-badge demo w3-border" onclick="currentDiv(<?php echo $i; ?>)"></span>
          <?php
          $i++;
        }
        ?>
      </div>
    </div>
  </div>
  <br>
  <div class="panel panel-default">
    <div class="panel-body">
  <?php
    if ((!empty($User_admin) && $User_admin == '1') || (!empty($User_admin) && $User_admin == '1')) {
      echo json_encode($game);
    }
  ?>
  </div>
</div>
</div>

<script>
  var slideIndex = 1;
  showDivs(slideIndex);

  function plusDivs(n) {
    showDivs(slideIndex += n);
  }

  function currentDiv(n) {
    showDivs(slideIndex = n);
  }

  function showDivs(n) {
    var i;
    var x = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("demo");
    if (n > x.length) {slideIndex = 1}
    if (n < 1) {slideIndex = x.length}
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" w3-white", "");
    }
    x[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " w3-white";
  }
</script>
