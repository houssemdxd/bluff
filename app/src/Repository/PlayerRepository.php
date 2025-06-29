<?php

namespace App\Repository;
use App\Entity\Room;
use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Player>
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }
    public function findPlayersInRoomWithNoWinner(Room $room): array
    {
        // Create a QueryBuilder instance
        $qb = $this->createQueryBuilder('p')
            ->where('p.room = :room') // Filter by room
            ->andWhere('p.winner != :winner') // Filter by winner not equal to 1
            ->setParameter('room', $room)
            ->setParameter('winner', 1)
            ->orderBy('p.id', 'ASC'); // Optional: order by player ID or other criteria

        return $qb->getQuery()->getResult(); // Execute the query and return the result
    }
    //    /**
    //     * @return Player[] Returns an array of Player objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Player
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


    public function countWinnersInRoom($room): int
{
    // Create a QueryBuilder instance
    $qb = $this->createQueryBuilder('p')
        ->select('COUNT(p.id)') // Count the player IDs
        ->where('p.room = :room') // Filter by room
        ->andWhere('p.winner = :winner') // Filter by winner equals 1
        ->setParameter('room', $room) // Bind room parameter
        ->setParameter('winner', 1); // Bind winner parameter

    return (int) $qb->getQuery()->getSingleScalarResult(); // Execute the query and return the count
}
public function updateWinnerWithQueryBuilder(int $playerId, int $rank): void
{
    $qb = $this->createQueryBuilder('p');

    $qb->update()
       ->set('p.winner', ':winner')      // Set the winner column
       ->set('p.rank', ':rank')          // Set the rank column
       ->where('p.id = :id')             // Filter by the player's ID
       ->setParameter('winner', 1)       // Set value for winner
       ->setParameter('rank', $rank)     // Set value for rank
       ->setParameter('id', $playerId);  // Set value for the player ID

    $qb->getQuery()->execute(); // Execute the update query
}

    
}
