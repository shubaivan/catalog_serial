<?php

namespace App\Repository;

use App\Entity\Serial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Serial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serial[]    findAll()
 * @method Serial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerialRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Serial::class);
    }

    /**
     * @param ParamFetcher $paramFetcher
     * @param bool $count
     * @return Serial[]|int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getSerials(ParamFetcher $paramFetcher, $count = false)
    {

        $qb = $this->createQueryBuilder('s');

        if ($count) {
            $qb
                ->select('COUNT(s.id)')
                ->orderBy('s.createdAt', Criteria::DESC);
            $query = $qb->getQuery();
            $result = $query->getSingleScalarResult();
        } else {
            $qb
                ->orderBy('s.'.$paramFetcher->get('sort_by'), $paramFetcher->get('sort_order'))
                ->setFirstResult($paramFetcher->get('count') * ($paramFetcher->get('page') - 1))
                ->setMaxResults($paramFetcher->get('count'))
                ->orderBy('s.createdAt', Criteria::DESC);
            $query = $qb->getQuery();
            $result = $query->getResult();
        }

        return $result;
    }

    /**
     * @param Serial $serial
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Serial $serial)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($serial);
        $entityManager->flush();
    }
}
