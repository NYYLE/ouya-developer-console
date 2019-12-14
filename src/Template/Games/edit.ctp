<!-- File: src/Template/Games/edit.ctp -->

<h1>Edit Game</h1>

<p>
Please fill in the form below with the changes to your game. Make sure your APK has a valid package name, versionName and versionCode and that your videos are MP4 files.
</p>
<?php

    $errors = $session->read('Session_errors');
    $display = $session->read('Session_display');

    echo $this->Form->create(false, array('type' => 'file'));

  //  debug($game);

    echo $this->Form->control('title', array('type' => 'textare', 'required' => false, 'autocomplete' => 'off', "placeholder" => $game['title']));
    if (!empty($errors['title'])) {
      echo "<label>" . $errors['title'][0] . "</label>";
    }

    echo $this->Form->control('description', array('type' => 'textarea', 'rows' => 5, 'required' => false, 'autocomplete' => 'off', "placeholder" => $game['description']));
    if (!empty($errors['description'])) {
      echo "<label>" . $errors['description'][0] . "</label>";
    }

    ?>
    <label for="id_label" class="select-input-label required">
      Players
      <select class="players-input" name="players[]" multiple="multiple", error=<?php echo $errors['players'] ?>>
        <option value=1>1</option>
        <option value=2>2</option>
        <option value=3>3</option>
        <option value=4>4</option>
      </select>
    </label>
    <?php

    echo $this->Form->label('content_rating', 'Content Rating', array('style' => 'font-weight: bold', 'id' => 'content_rating_id'));
    echo $this->Form->select('content_rating', array('Everybody', '9+', '12+', '17+'), array('required' => false));

    ?>
    <label for="id_label" class="genre-input-label">
      Genres

      <select class="genre-input" name="genres[]" multiple="multiple", error=<?php echo $errors['genre'] ?>>
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

    // media
    echo $this->Form->control('discover', array('label' => 'Discover Image', 'type' => 'file', 'required' => false));
    if (!empty($errors['discover'])) {
      echo "<label class='error-label'>" . $errors['discover']['validExtension'] . "</label>";
    }

    echo $this->Form->control('video', array('label' => 'Video', 'type' => 'file', 'required' => false));
    if (!empty($errors['video'])) {
      echo "<label class='error-label'>" . $errors['video']['validExtension'] . "</label>";
    }

    echo $this->Form->control('screenshot[]', array('label' => 'Screenshots', 'type' => 'file', 'multiple' => 'multiple', 'required' => false));
    if (!empty($errors['screenshot'])) {
      echo "<label class='error-label'>" . $errors['screenshot']['validExtension'] . "</label>";
    }

    echo $this->Form->control('apk', array('label' => 'APK File', 'type' => 'file', 'required' => false));
    if (!empty($errors['apk'])) {
      echo "<label class='error-label'>" . $errors['apk']['validExtension'] . "</label>";
    }

    echo $this->Form->control('website', array('required' => false, 'autocomplete' => 'off'));
    if (!empty($errors['website'])) {
      echo "<label class='error-label'>" . $errors['website'][0] . "</label>";
    }

    echo $this->Form->button('Save Game', array('class' => 'btn btn-success', 'type' => 'submit'));
    echo $this->Form->end();
?>

<script>

$(document).ready(function() {
    $('.genre-input').select2();
    $('.players-input').select2();
});

</script>
