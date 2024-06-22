<?php

defined('C5_EXECUTE') or die('Access Denied.');

$content = null;

/** @var \Concrete\Core\View\View $view */
/** @var \Concrete\Core\Form\Service\Form $form */
/** @var \Concrete\Core\Search\Pagination\Pagination $pagination  */
?>

<?php
foreach ($questionList as $item) {
  /** @var \Macareux\Boilerplate\Entity\Question $item */
  $id = $item->getId();
  $content = $item->getContent();
?>
  <div>
    <form method="post" action="<?= $view->action('submit_edit', $id); ?>">
      <p class="text-secondary fw-bold">質問<?= $id ?>: </p>
      <?= $form->text("content-{$id}", $content) ?>
      <?= $form->submit('save', 'save', ['class' => 'btn btn-primary']); ?>
      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-question-<?= $id ?>">削除</button>
    </form>
    <form method="post" action="<?= $view->action('delete', $id) ?>">
      <div class="modal fade" id="delete-question-<?= $id ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">削除しますか？</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <?= "質問{$id} : 「{$content}」を" ?>
              本当に削除しますか？
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-danger">削除する</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
<?php
}
?>
<div class="form-group">
  <form method="post" action="<?= $view->action('submit') ?>">
    <fieldset>
      <?= $form->text('content', $content, ['placeholder' => "質問を入力"]) ?>
    </fieldset>
    <?= $form->submit('save', 'save', ['class' => 'btn btn-primary float-end']) ?>
</div>
</form>
</div>