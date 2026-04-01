<?php

namespace App\Repository;

use App\Entity\Task;
use App\Enum\TaskPriority;
use App\Enum\TaskStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findRecent(int $limit = 5): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findByStatusFilter(?string $status, ?string $priority): array
    {
        $qb = $this->createQueryBuilder('t');

        if ($status && TaskStatus::tryFrom($status) !== null) {
            $qb->andWhere('t.status = :status')
               ->setParameter('status', $status);
        }

        if ($priority && TaskPriority::tryFrom($priority) !== null) {
            $qb->andWhere('t.priority = :priority')
               ->setParameter('priority', $priority);
        }

        return $qb->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function countByStatus(): array
    {
        $results = $this->createQueryBuilder('t')
            ->select('t.status, COUNT(t.id) as count')
            ->groupBy('t.status')
            ->getQuery()
            ->getResult();

        $counts = [
            'total' => 0,
            TaskStatus::Todo->value => 0,
            TaskStatus::InProgress->value => 0,
            TaskStatus::Done->value => 0,
        ];

        foreach ($results as $row) {
            $counts[$row['status']->value] = (int) $row['count'];
            $counts['total'] += (int) $row['count'];
        }

        return $counts;
    }

    public function countByPriority(): array
    {
        $results = $this->createQueryBuilder('t')
            ->select('t.priority, COUNT(t.id) as count')
            ->groupBy('t.priority')
            ->getQuery()
            ->getResult();

        $counts = [
            TaskPriority::Low->value => 0,
            TaskPriority::Medium->value => 0,
            TaskPriority::High->value => 0,
        ];

        foreach ($results as $row) {
            $counts[$row['priority']->value] = (int) $row['count'];
        }

        return $counts;
    }
}
