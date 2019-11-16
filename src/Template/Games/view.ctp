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
.video-container {
  position: relative;
  padding-bottom: 56.25%;
  padding-top: 30px; height: 0; overflow: hidden;
}

.video-container iframe,
.video-container object,
.video-container embed {
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



<div class="container" style="padding-top: 50px">
  <h1 class="col-sm-12" style="padding-bottom: 50px; color: #fc4422; font-size: 55px;"><b><?= mb_strtoupper($game['title']); ?></b></h1>

  <div class="video-container"><iframe width="853" height="480" src="https://www.youtube.com/embed/z9Ul9ccDOqE" frameborder="0" allowfullscreen></iframe></div>

  <div class="col-sm-5">
    <p><?= $game['description']; ?></p>
    <p><small>Created: <?= $game['firstPublishedAt'] ?></small></p>
    <p><?= $this->Html->link('Edit', ['action' => 'edit', $game['packageName']]) ?></p>
  </div>

  <div class="col-sm-7">
    <div class="w3-content w3-display-container">
      <?php
      foreach ($game['media']['screenshots'] as $screenshot) {
        ?>
            <img class="mySlides w3-animate-opacity" src="<?php echo $screenshot; ?>" style="border-width: 10px;">
            <?php
      }
      ?>
      <div class="w3-center w3-container w3-section w3-large w3-text-white w3-display-bottommiddle" style="width:100%">
        <div class="w3-left w3-hover-text-khaki" onclick="plusDivs(-1)">&#10094;</div>
        <div class="w3-right w3-hover-text-khaki" onclick="plusDivs(1)">&#10095;</div>

        <?php
        $i = 1;
        foreach ($game['media']['screenshots'] as $screenshot) {
          ?>
          <span class="w3-badge demo w3-border" onclick="currentDiv(<?php echo $i; ?>)"></span>
          <?php
          $i++;
        }
        ?>
      </div>
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
