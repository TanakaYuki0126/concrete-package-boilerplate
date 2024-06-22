
<?php
defined('C5_EXECUTE') or die('Access Denied.');

/** @var \Concrete\Core\View\View $view */
?>

<form method="post" action="<?= $view->action('start_shindan'); ?>">
  <button type="submit" class="btn btn-primary">診断を始める</button>
</form>