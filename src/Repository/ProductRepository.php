<?php

namespace App\Repository;

use App\Entity\Product;
use App\Services\Constants;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

final class ProductRepository
{
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Product::class);
    }


    /**
     * @param \Doctrine\ORM\EntityRepository $repository
     * @return $this
     */
    public function setRepository(\Doctrine\ORM\EntityRepository $repository): ProductRepository
    {
        $this->repository = $repository;
        return $this;
    }


    /**
     * @param $page
     * @param $orderBy
     * @return Paginator
     */
    public function getProducts($page, $orderBy)
    {
        $offset = ($page - 1) * Constants::PRODUCT_PER_PAGE;
        $queryBuilder = $this->repository->createQueryBuilder("p")
            ->setFirstResult($offset)
            ->setMaxResults(Constants::PRODUCT_PER_PAGE);
        switch ($orderBy) {
            case "name":
                $queryBuilder->addOrderBy("p.name");
                break;
            case "price":
                $queryBuilder->addOrderBy("p.price");
                break;
            default:
                $queryBuilder->addOrderBy("p.name");
                break;
        }
        return (new Paginator($queryBuilder));
    }
}