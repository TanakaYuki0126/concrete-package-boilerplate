<?php

defined('C5_EXECUTE') or die('Access Denied.');

$type = null;


/** @var \Concrete\Core\View\View $view */
/** @var \Concrete\Core\Form\Service\Form $form */
/** @var \Concrete\Core\Search\Pagination\Pagination $pagination  */
?>

<pre>
  <?php
  var_dump($questionList);
  var_dump($optionList);
  ?>

</pre>
<?php
foreach ($questionList as $item) {
  /** @var \Macareux\Boilerplate\Entity\Question $item */
  $id = $item->getId();
  $options = $item->getOptions();
?>
  <div>
    <form method="post" action="<?= $view->action('submit_edit', $id); ?>">
      <p class="text-secondary fw-bold">質問<?= $id ?>: </p>
      <?= $form->text('option', "", ['placeholder' => "選択肢を入力"]) ?>
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
              <?= "質問{$id}を" ?>
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
      <div class="d-flex">
        <div class="flex-grow-1">
          <?= $form->text('content[]', null, ['placeholder' => "選択肢を入力(例：自分は感受性が豊かで、ものごとに対する感性を重視する。)"]) ?>
        </div>
        <div>
          <?= $form->number('point_id[]', null, ['placeholder' => "加点対象を入力(1~9)"]) ?>
        </div>
      </div>
      <div class="d-flex">
        <div class="flex-grow-1">
          <?= $form->text('content[]', null, ['placeholder' => "選択肢を入力(例: 自分は目標志向で、成果を出すために効率性を重視する。)"]) ?>
        </div>
        <div>
          <?= $form->number('point_id[]', null, ['placeholder' => "加点対象を入力(1~9)"]) ?>
        </div>
      </div>
      <?= $form->select('type', ['1' => 'エニアグラム', '2' => 'ウェルスダイナミクス'], $type) ?>
      <?= $form->label("disp_order", "表示順") ?>
      <?= $form->number('disp_order', 1) ?>
    </fieldset>
    <?= $form->submit('save', 'save', ['class' => 'btn btn-primary float-end']) ?>
</div>
</form>
</div>