<?php

namespace Concrete\Package\V9PackageBoilerplate\Controller\SinglePage\Dashboard;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Url\Resolver\Manager\ResolverManagerInterface;

class Shindan extends DashboardPageController
{
    // /dashboard/shindanにアクセスした時にここに来てなさそう
    public function view()
    {
        /** @var ResolverManagerInterface $resolver */
        $resolver = $this->app->make(ResolverManagerInterface::class);

        return $this->buildRedirect($resolver->resolve(['/dashboard/shindan/edit']));
    }
}
