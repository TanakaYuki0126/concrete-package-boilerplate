<?php

//診断の質問に答える画面

defined('C5_EXECUTE') or die('Access Denied.');
/** @var \Concrete\Core\View\View $view */
/** @var \Concrete\Core\Form\Service\Form $form */
?>

<div>
  <h1>下記の質問に答えてください。</h1>
  <form method="post" action="<?= $view->action('to_result') ?>">
    <div>
      <?php
      /** @var \Macareux\Boilerplate\Entity\Question $q */
      $i = 0;
      foreach ($questionList as $q) {
        $id = $q->getId();
        $i++;
      ?>
        <div>
          <h5>質問<?= $i ?></h5>
          <div class="d-flex gap-1">
            <?php
            $options = $q->getOptions();
            foreach ($options as $option) {
              /** @var \Macareux\Boilerplate\Entity\Option $option */
              $optionId = $option->getId();
              $content = $option->getContent();
            ?>
              <?= $form->radio("select-{$id}", $optionId) ?>
              <?= $form->label("select-{$id}", $content) ?>
            <?php
            }
            ?>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
    <button type="submit" class="btn btn-primary">結果を見る</button>
  </form>
</div>