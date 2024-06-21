<?php

namespace Concrete\Package\V9PackageBoilerplate\Controller\SinglePage\Dashboard\Shindan;

use Concrete\Core\Filesystem\ElementManager;
use Concrete\Core\Http\Request;
use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Search\Pagination\PaginationFactory;
use Macareux\Boilerplate\Entity\Question;
use Macareux\Boilerplate\Entity\QuestionRepository;
use Macareux\Boilerplate\Search\ProductList;
use Macareux\Boilerplate\Search\QuestionList;

class Edit extends DashboardPageController
{
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

    //新規追加
    public function submit(){
      $content = $this->get('content');
      $question = new Question((string) $content);
      $this->entityManager->persist($question);
      $this->entityManager->flush();
      $this->flash('success', "保存しました!!!!!!!!!!!!!!!!!!!!!!!");
      return $this->buildRedirect('/dashboard/shindan/edit');
    }

    //編集
    public function submit_edit($id){
      $content = $this->get("content-{$id}");
      $question = $this->getEntity((int) $id);
      $question->setContent($content);
      $this->entityManager->persist($question);
      $this->entityManager->flush();
      $this->flash('success', "$content, $id");
      return $this->buildRedirect('/dashboard/shindan/edit');
    }
    
    //削除
    public function delete($id){
      $question = $this->getEntity($id);
      $this->entityManager->remove($question);
      $this->entityManager->flush();
      $this->flash('success', '正常に削除しました!');
      return $this->buildRedirect('/dashboard/shindan/edit');
    }

    protected function getQuestionList(){
      $repository = $this->entityManager->getRepository(Question::class);
      return $repository->findAll();
    }

    protected function getEntity(int $id): ?Question{
      $repository = $this->entityManager->getRepository(Question::class);
      return $repository->find($id);
    }
}
