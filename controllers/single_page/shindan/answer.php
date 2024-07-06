<?php
//ユーザーが診断を実施する画面
namespace Concrete\Package\V9PackageBoilerplate\Controller\SinglePage\Shindan;

use Concrete\Core\Page\Controller\PageController;
use Doctrine\ORM\EntityManagerInterface;
use Macareux\Boilerplate\Entity\Option;
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
    // 診断の回答をもとに、各タイプに加点し、タイプを特定する
    // A:問題ごとの結果を受けとる{a:1,b:2,c:3}
    $answers = array();
    // B:対象診断システムの全タイプを配列で取得する
    // Aの配列をForeachしながら、
    foreach ($answers as $key) {
      $this->addScore();
    }

    //--7/10に生稲さんからもらう資料&
    //1. ウェルスの同点ロジック (10日にもらえるかは未定)
    //2. ウェルスの質問、選択肢の文章
    //3. ウェルスの加点ロジック

    //来週のゴール: 
    //再現性高く正しい診断結果。この土日で実装
    //エニアの診断ロジック
    //開発環境の構築

    //ポイントを加算していく配列
    $pointArray1 = array_fill(0, 9, 0);
    /** @var \Macareux\Boilerplate\Entity\Question $q */
    foreach ($this->questionList as $q) {
      $id = $q->getId();
      //それぞれの質問に対するユーザーの選択を取得
      $selectedOptionId = $this->get("select-{$id}");
      if ($selectedOptionId) {
        /** @var \Macareux\Boilerplate\Entity\Option $option */
        $option = $this->getOptionEntity($selectedOptionId);
        $point  = $option->getPointId();
        $pointArray1[$point - 1]++;
      }
    }
    //ポイントの配列の最大値が診断結果のIDになる
    //pointArr配列の最大値を$typeに代入
    $type = array_keys($pointArray1, max($pointArray1))[0] + 1;

    //------同点ロジックの挿入-----------
    // 一番大きな点数に該当するタイプが二つあるかどうかを判別
    $isSame = false;

    // 同点ロジック
    if ($isSame) {
      $same1 = '';
      $same2 = '';
      $sindanType = ''; //ウェルスなのか、エニアなのか
      $resultType = $this->getTieSetting($same1, $same2, $sindanType);
    }
    //ユーザー属性：タイプ：
    //ユーザー属性に診断結果タイプを登録する→CMSの管理画面でできるよ

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

  protected function getOptionEntity($id)
  {
    $repository = $this->entityManager->getRepository(Option::class);
    return $repository->find($id);
  }

  //
  protected function addScore()
  {
  }

  //同点のタイプを引数にする
  protected function getTieSetting()
  {
  }
}
