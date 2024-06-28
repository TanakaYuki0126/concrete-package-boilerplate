<?php

namespace Concrete\Package\V9PackageBoilerplate\Controller\SinglePage\Dashboard\Shindan;

use Concrete\Core\Page\Controller\DashboardPageController;
use Macareux\Boilerplate\Entity\Option;
use Macareux\Boilerplate\Entity\Question;
use Macareux\Boilerplate\Search\QuestionList;

class Edit extends DashboardPageController
{
  /**
   * 診断の質問内容を管理する画面
   */
  public function view()
  {
    /** @var QuestionList $list */
    $list = $this->app->make(QuestionList::class);
    $list->sortBy('q.id', 'desc');
    $count = $list->getTotalResults();
    $question = $this->getEntity($count);
    $questionList = $this->getQuestionList();
    $optionList = $this->getOptionList();
    $this->set('list', $list);
    $this->set('count', $count);
    $this->set('question', $question);
    $this->set('questionList', $questionList);
    $this->set('optionList', $optionList);
    $this->setThemeViewTemplate('full.php');
  }

  //質問の新規追加
  public function submit()
  {
    $contentArr = $this->get('content');
    $pointIdArr = $this->get('point_id');
    $type = $this->get('type');
    $disp_order = $this->get('disp_order');
    $question = new Question($disp_order, $type);
    foreach ($contentArr as $index => $content) {
      $option = new Option((string) $content, (int) $pointIdArr[$index]);
      $question->addOption($option);
      $this->entityManager->persist($option);
    }
    $this->entityManager->persist($question);
    $this->entityManager->flush();
    $this->flash('success', $this->entityManager->getUnitOfWork()->size());
    return $this->buildRedirect('/dashboard/shindan/edit');
  }

  //質問の編集
  public function submit_edit($id)
  {
    $content = $this->get("content-{$id}");
    $question = $this->getEntity((int) $id);
    $this->entityManager->persist($question);
    $this->entityManager->flush();
    $this->flash('success', "$content, $id");
    return $this->buildRedirect('/dashboard/shindan/edit');
  }

  //削除
  public function delete($id)
  {
    //質問に紐づく選択肢の削除
    // $deleteOptions = $this->getOptionEntityByQuestionId($id);
    // foreach ($deleteOptions as $option) {
    //   $this->entityManager->remove($option);
    // }
    $question = $this->getEntity($id);
    $this->entityManager->remove($question);
    $this->entityManager->flush();
    return $this->buildRedirect('/dashboard/shindan/edit');
  }

  protected function getQuestionList()
  {
    $repository = $this->entityManager->getRepository(Question::class);
    return $repository->findAll();
  }

  protected function getOptionList()
  {
    $repository = $this->entityManager->getRepository(Option::class);
    return $repository->findAll();
  }

  protected function getEntity(int $id): ?Question
  {
    $repository = $this->entityManager->getRepository(Question::class);
    return $repository->find($id);
  }
}
