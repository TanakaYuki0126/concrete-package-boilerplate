<?php

namespace Macareux\Boilerplate\Search;

use Concrete\Core\Search\ItemList\EntityItemList;
use Concrete\Core\Search\Pagination\PaginationProviderInterface;
use Concrete\Core\Support\Facade\Application;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Macareux\Boilerplate\Entity\Question;
use Pagerfanta\Doctrine\ORM\QueryAdapter;

class QuestionList extends EntityItemList implements PaginationProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getEntityManager()
    {
        $app = Application::getFacadeApplication();

        return $app->make(EntityManagerInterface::class);
    }

    public function createQuery()
    {
        $this->query->select('q')->from(Question::class, 'q');
    }

    public function getResult($result)
    {
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalResults()
    {
        $count = 0;
        $query = $this->query->select('count(distinct q.id)')
            ->setMaxResults(1)->resetDQLParts(['groupBy', 'orderBy']);

        try {
            $count = $query->getQuery()->getSingleScalarResult();
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }

        return $count;
    }

    /**
     * {@inheritdoc}
     */
    public function getPaginationAdapter()
    {
        return new QueryAdapter($this->deliverQueryObject());
    }
}
