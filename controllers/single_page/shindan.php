<?php

namespace Concrete\Package\V9PackageBoilerplate\Controller\SinglePage;

use Concrete\Core\Http\Response;
use Concrete\Core\Page\Controller\PageController;

class Shindan extends PageController
{
    public function view()
    {
      $view = $this->getViewObject();
      $contents = $view->render();
      return new Response($contents, 200);
    }

    public function start_shindan(){
      return $this->buildRedirect('/shindan/answer');
    }
}

