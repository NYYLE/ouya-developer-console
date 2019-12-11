<!-- File: src/Template/Games/add.ctp -->

<style>
#content_rating_id::after {
  content: " *";
  color: #C3232D;
}
</style>

<h1>Add Game</h1>

<p>
Please fill in the form below with all the relavant details to your game. Make sure your APK has a valid package name, versionName and versionCode.
</p>
<?php

    $errors = $session->read('Session_errors');
    $display = $session->read('Session_display');

    echo $this->Form->create($game, array('type' => 'file'));

    echo $this->Form->control('title', array('type' => 'text', 'required' => true, 'value' => $display['title'], 'autocomplete' => 'off'));
    if (!empty($errors['title'])) {
      echo "<label>" . $errors['title'][0] . "</label>";
    }

    echo $this->Form->control('description', array('type' => 'text', 'rows' => 5, 'required' => true, 'value' => $display['description'], 'autocomplete' => 'off'));
    if (!empty($errors['description'])) {
      echo "<label>" . $errors['description'][0] . "</label>";
    }

    ?>
    <label for="id_label" class="select-input-label required" style="color: #4d4d4d; font-weight: bold;">
      Players<span style="color: #C3232D;"> * </span>
      <select class="players-input" name="players[]" multiple="multiple" required value=<?php echo $display['players'] ?>, error=<?php echo $errors['players'] ?>>
        <option value=1>1</option>
        <option value=2>2</option>
        <option value=3>3</option>
        <option value=4>4</option>
      </select>
    </label>
    <?php

    echo $this->Form->label('content_rating', 'Content Rating', array('style' => 'font-weight: bold', 'id' => 'content_rating_id'));
    echo $this->Form->select('content_rating', array('Everybody', '9+', '12+', '17+'), array('required' => true));
    if (!empty($errors['players'])) {
      echo "<label>" . $errors['content_rating'][0] . "</label>";
    }

    ?>
    <label for="id_label" class="select-input-label required" style="color: #4d4d4d; font-weight: bold;">
      Genres<span style="color: #C3232D;"> * </span>

      <select class="genre-input" name="genre[]" multiple="multiple" required value=<?php echo $display['genre'] ?>, error=<?php echo $errors['genre'] ?>>
        <?php
        foreach ($genres as $genre) {
        ?>
        <option value="<?php echo $genre['name'] ?>"><?php echo $genre['name'] ?></option>
        <?php
        }
        ?>
      </select>
    </label>
    <?php
    if (!empty($errors['genre'])) {
      echo "<label class='error-label'>" . $errors['genre'][0] . "</label>";
    }
    // media
    echo $this->Form->control('discover', array('label' => 'Discover Image', 'type' => 'file', 'required' => true, 'value' => $display['discover']));
    if (!empty($errors['discover'])) {
      echo "<label class='error-label'>" . $errors['discover']['validExtension'] . "</label>";
    }

    echo $this->Form->control('video', array('label' => 'Video', 'type' => 'file', 'required' => false, 'value' => $display['video']));
    if (!empty($errors['video'])) {
      echo "<label class='error-label'>" . $errors['video']['validExtension'] . "</label>";
    }

    echo $this->Form->control('screenshot[]', array('label' => 'Screenshots', 'type' => 'file', 'multiple' => 'multiple', 'required' => true, 'value' => $display['screenshot']));
    if (!empty($errors['screenshot'])) {
      echo "<label class='error-label'>" . $errors['screenshot']['validExtension'] . "</label>";
    }

    echo $this->Form->control('apk', array('label' => 'APK File', 'type' => 'file', 'required' => true, 'value' => $display['apk']));
    if (!empty($errors['apk'])) {
      echo "<label class='error-label'>" . $errors['apk']['validExtension'] . "</label>";
    }

    echo $this->Form->control('website', array('required' => false, 'value' => $display['website'], 'autocomplete' => 'off'));
    if (!empty($errors['website'])) {
      echo "<label class='error-label'>" . $errors['website'][0] . "</label>";
    }

    echo $this->Form->button('Add Game', array('class' => 'btn btn-success', 'type' => 'submit'));
    echo $this->Form->end();
?>

<script>

$(document).ready(function() {
  console.log('test');
  $('.genre-input').select2();
    console.log('test');
    $('.players-input').select2();

});




</script>
