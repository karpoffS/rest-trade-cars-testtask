<?php

namespace App\Repository;

use App\Application\DTO\CreditProgram as CreditProgramDto;
use App\Domain\Model\Entry\CreditProgramEntry;
use App\Entity\CreditProgram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CreditProgram>
 *
 * @method CreditProgram|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreditProgram|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreditProgram[]    findAll()
 * @method CreditProgram[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreditProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreditProgram::class);
    }

    public function add(CreditProgram $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CreditProgram $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param $id
     * @return CreditProgramEntry|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findById($id)
    {
        $res = current($this->createQueryBuilder('c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getArrayResult());
        return !is_array($res) ? null : new CreditProgramEntry((array)$res);
    }

    /**
     * @param CreditProgramDto $dto
     * @return \Doctrine\DBAL\Result
     * @throws \Doctrine\DBAL\Exception
     */
    public function fetchByParams(CreditProgramDto $dto)
    {
        $sql = "SELECT * FROM credit_program WHERE id >= FLOOR(2 + RAND() * (SELECT MAX(id) FROM credit_program WHERE ";
        $params = [];

        if (!is_null($dto->getLoanTerm()) && !is_null($dto->getInitialPayment())) {
            if ($dto->getLoanTerm()->getValue() <= 60 && $dto->getInitialPayment()->getValue() >= 200000) {
                $sql = "SELECT * FROM credit_program WHERE id = 1";
                $params = [];
            } else {
                $sql .= "(JSON_VALUE(credit_program.conditions , '$.loanTerm[1]') <= :loanTerm AND JSON_VALUE(credit_program.conditions , '$.initialPayment[0]') >= :initialPayment)";
                $sql .= " OR !(JSON_VALUE(credit_program.conditions , '$.loanTerm[1]') <= :loanTerm AND JSON_VALUE(credit_program.conditions , '$.initialPayment[0]') >= :initialPayment))";
                $sql .= ") LIMIT 1";

                $params['loanTerm'] = $dto->getLoanTerm()->getValue();
                $params['initialPayment'] = $dto->getInitialPayment()->getValue();
            }
        } else {
            if ($dto->getLoanTerm() && is_null($dto->getInitialPayment())) {

                $sql .= "(JSON_VALUE(credit_program.conditions , '$.loanTerm[1]') <= :loanTerm)";
                $params['loanTerm'] = $dto->getLoanTerm()->getValue();
            }
            if ($dto->getInitialPayment() && is_null($dto->getLoanTerm())) {
                $sql .= " AND (JSON_VALUE(credit_program.conditions , '$.initialPayment[0]'))";
                $params['initialPayment'] = $dto->getInitialPayment()->getValue();
            }
        }

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $res = $stmt->executeQuery($params)->fetchAssociative();
        return !is_array($res) ? null : new CreditProgramEntry($res);
    }

//    /**
//     * @return CreditProgram[] Returns an array of CreditProgram objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CreditProgram
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
