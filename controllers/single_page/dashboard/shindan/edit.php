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
    $list->sortBy('p.disp_order', 'asc');
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
    $this->flash('success', t('Question added successfully'));
    return $this->buildRedirect('/dashboard/shindan/edit');
  }

  //質問の編集
  public function submit_edit($id)
  {
    $dispOrder = $this->get("disp_order-{$id}");
    $type = $this->get("type-{$id}");
    $question = $this->getEntity((int) $id);
    $question->setDispOrder($dispOrder);
    $question->setType($type);
    $options = $question->getOptions();
    $debug = "";
    foreach ($options as $option) {
      $optionId = $option->getId();
      $content = $this->get("option-{$optionId}");
      $pointId = $this->get("point_id-{$optionId}");
      $debug .= $content . ", " . $pointId . "<br>";
      $option->setContent($content);
      $option->setPointId($pointId);
      $this->entityManager->persist($option);
    }
    $this->entityManager->persist($question);
    $this->entityManager->flush();
    $this->flash('success', t('Question updated successfully'));
    return $this->buildRedirect('/dashboard/shindan/edit');
  }

  //削除
  public function delete($id)
  {
    $question = $this->getEntity($id);
    $this->entityManager->remove($question);
    $this->entityManager->flush();
    $this->flash('success', t('Question deleted successfully'));
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
