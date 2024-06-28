<?php

defined('C5_EXECUTE') or die('Access Denied.');

$type = null;


/** @var \Concrete\Core\View\View $view */
/** @var \Concrete\Core\Form\Service\Form $form */
/** @var \Concrete\Core\Search\Pagination\Pagination $pagination  */
?>

<pre>
  <?php
  ?>

</pre>
<?php
foreach ($questionList as $item) {
  /** @var \Macareux\Boilerplate\Entity\Question $item */
  $id = $item->getId();
  $order = $item->getDispOrder();
  $options = $item->getOptions();
?>
  <div class="px-5 py-2">
    <div style="border: solid 3px #ddd; border-radius: 8px; padding: 8px;">
      <form method="post" action="<?= $view->action('submit_edit', $id); ?>">
        <p class="text-secondary fw-bold">質問<?= $id ?>: </p>
        <?= $form->label("disp_order-{$id}", "表示順") ?>
        <?= $form->number("disp_order-{$id}", $order, ['placeholder' => "表示順を入力"]) ?>
        <?php
        foreach ($options as $index => $option) {
          /** @var \Macareux\Boilerplate\Entity\Option $option */
          $optionId = $option->getId();
          $optionContent = $option->getContent();
          $pointId = $option->getPointId();
        ?>
          <div class="d-flex">
            <div class="flex-grow-1">

              <?= $form->label("content-{$optionId}", "選択肢{$index}") ?>
              <?= $form->text('option', $optionContent, ['placeholder' => "選択肢を入力"]) ?>
            </div>
            <div>
              <?= $form->label("point_id-{$optionId}", "加点対象") ?>
              <?= $form->number("point_id-{$optionId}", $pointId, ['placeholder' => "加点対象を入力"]) ?>
            </div>
          </div>
        <?php
        }
        ?>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-question-<?= $id ?>">削除</button>
        <?= $form->submit('save', 'save', ['class' => 'btn btn-primary']); ?>
      </form>
    </div>
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
<div class="form-group px-5 py-2 mx-5" style="background-color: #eda;">
  <h4>新しい質問を追加</h4>
  <form method="post" action="<?= $view->action('submit') ?>">
    <fieldset>
      <div class="d-flex">
        <div class="flex-grow-1">
          <?= $form->label("content[]", '選択肢1'); ?>
          <?= $form->text('content[]', null, ['placeholder' => "選択肢を入力(例：自分は感受性が豊かで、ものごとに対する感性を重視する。)"]) ?>
        </div>
        <div>
          <?= $form->label("point_id[]", '加点対象'); ?>
          <?= $form->number('point_id[]', null, ['placeholder' => "加点対象を入力(1~9)"]) ?>
        </div>
      </div>
      <div class="d-flex">
        <div class="flex-grow-1">
          <?= $form->label("content[]", '選択肢2'); ?>
          <?= $form->text('content[]', null, ['placeholder' => "選択肢を入力(例: 自分は目標志向で、成果を出すために効率性を重視する。)"]) ?>
        </div>
        <div>
          <?= $form->label("point_id[]", '加点対象'); ?>
          <?= $form->number('point_id[]', null, ['placeholder' => "加点対象を入力(1~9)"]) ?>
        </div>
      </div>
      <?= $form->label("type", '診断ロジックタイプ'); ?>
      <?= $form->select('type', ['1' => 'エニアグラム', '2' => 'ウェルスダイナミクス'], $type) ?>
      <?= $form->label("disp_order", "表示順") ?>
      <?= $form->number('disp_order', 1) ?>
    </fieldset>
    <?= $form->submit('save', 'save', ['class' => 'btn btn-primary float-end']) ?>
  </form>
</div>