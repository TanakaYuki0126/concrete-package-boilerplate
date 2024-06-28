<?php
//診断結果の画面
namespace Concrete\Package\V9PackageBoilerplate\Controller\SinglePage\Shindan;

use Concrete\Core\Page\Controller\PageController;

/**
 * 診断結果を表示する画面。
 * ログインしていなければログインページに飛ばす。
 * $typeで、診断結果の108タイプのうちどれを取得するか決めて診断結果のコンテンツをDBから取得する
 */
class Result extends PageController
{
  public function view($type = null)
  {
    $this->set('result', $type);
  }
}
