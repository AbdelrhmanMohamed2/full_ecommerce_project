<!-- check for errors -->
<?php if (isset($_SESSION['errors'])) :
    foreach ($_SESSION['errors'] as $error) :
?>
        <div class="alert alert-danger"><?= $error ?></div>

<?php
    endforeach;
    unset($_SESSION['errors']);

endif ?>

<!-- check for success massages -->
<?php if (isset($_SESSION['success'])) :

?>
    <div class="alert alert-success"><?= $_SESSION['success'] ?></div>

<?php

    unset($_SESSION['success']);
endif ?>