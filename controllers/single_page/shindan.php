<?php

namespace Concrete\Package\V9PackageBoilerplate\Controller\SinglePage;

use Concrete\Core\Http\Response;
use Concrete\Core\Page\Controller\PageController;

class Shindan extends PageController
{
  public function view()
  {
  }

  public function start_shindan()
  {
    return $this->buildRedirect('/shindan/answer');
  }
}
