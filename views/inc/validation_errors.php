<?php
$errors = $model->getValidationErrors();
if (count($errors) > 0) {
    echo '<div class="errors">';
    foreach ($errors as $value) {
        echo '<p>' . $value . '</p>';
    }
    echo '</div>';
}
?>