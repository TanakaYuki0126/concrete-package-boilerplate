<?php
//ユーザーが診断を実施する画面
namespace Concrete\Package\V9PackageBoilerplate\Controller\SinglePage\Shindan;

use Concrete\Core\Page\Controller\PageController;
use Doctrine\ORM\EntityManagerInterface;
use Macareux\Boilerplate\Entity\Question;

class Answer extends PageController
{
  /**
   *
   * @var \Doctorine\ORM\EntityManagerInterface|null
   */
  protected $entityManager;

  //DBから取得した質問一覧を取得
  protected $questionList;

  // $form変数を有効化
  public $helpers = ['form'];


  public function view()
  {
    $this->set('questionList', $this->questionList);
  }

  //始めに行われる処理
  public function on_start()
  {
    $this->entityManager = $this->app->make(EntityManagerInterface::class);
    $this->questionList = $this->getQuestionList();
  }

  /**
   * ユーザーが診断結果を見るというボタンを押した時の処理。
   * ユーザーの入力を取得後、診断ロジックに照らし合わせて108通りのうちの結果$typeを算出。
   * $typeをURLに入れてリダイレクト。
   */
  public function to_result()
  {
    $result = [];
    /** @var \Macareux\Boilerplate\Entity\Question $q */
    foreach ($this->questionList as $q) {
      $id = $q->getId();
      //それぞれの質問に対するユーザーの選択を取得
      $userSelect = $this->get("select-{$id}");
      if ($userSelect) {
        $result[] = ['id' => $id, 'select' => $userSelect];
      }
    }
    $this->flash('success', json_encode($result));
    $type = 1;
    return $this->buildRedirect("/shindan/result/{$type}");
  }

  /**
   * 質問の一覧をDBから取得する
   */
  protected function getQuestionList()
  {
    $repository = $this->entityManager->getRepository(Question::class);
    return $repository->findAll();
  }
}
