<?php

namespace Concrete\Package\V9PackageBoilerplate\Controller\SinglePage\Dashboard\Shindan;

use Concrete\Core\Page\Controller\DashboardPageController;
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
    $this->set('list', $list);
    $this->set('count', $count);
    $this->set('question', $question);
    $this->set('questionList', $questionList);
    $this->setThemeViewTemplate('full.php');
  }

  //質問の新規追加
  public function submit()
  {
    $content = $this->get('content');
    $question = new Question((string) $content);
    $this->entityManager->persist($question);
    $this->entityManager->flush();
    $this->flash('success', "保存しました!!!!!!!!!!!!!!!!!!!!!!!");
    return $this->buildRedirect('/dashboard/shindan/edit');
  }

  //質問の編集
  public function submit_edit($id)
  {
    $content = $this->get("content-{$id}");
    $question = $this->getEntity((int) $id);
    $question->setContent($content);
    $this->entityManager->persist($question);
    $this->entityManager->flush();
    $this->flash('success', "$content, $id");
    return $this->buildRedirect('/dashboard/shindan/edit');
  }

  //削除
  public function delete($id)
  {
    $question = $this->getEntity($id);
    $this->entityManager->remove($question);
    $this->entityManager->flush();
    $this->flash('success', '正常に削除しました!');
    return $this->buildRedirect('/dashboard/shindan/edit');
  }

  protected function getQuestionList()
  {
    $repository = $this->entityManager->getRepository(Question::class);
    return $repository->findAll();
  }

  protected function getEntity(int $id): ?Question
  {
    $repository = $this->entityManager->getRepository(Question::class);
    return $repository->find($id);
  }
}
