<?php

namespace Blankse\BettingGameBundle\Services;

use Blankse\BettingGameBundle\Entity\League;
use Doctrine\Bundle\DoctrineBundle\Registry;

class LeagueHelper
{
    /** @var \Doctrine\Bundle\DoctrineBundle\Registry */
    protected $registry;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @return \Blankse\BettingGameBundle\Entity\League[]
     */
    public function getList()
    {
        $repository = $this->registry->getRepository('BettingGameBundle:League');
        $return = [];

        foreach ($repository->findAll() as $entity) {
            $return[$entity->id] = $entity;
        }

        return $return;
    }

    /**
     * @param int $id
     * @return \Blankse\BettingGameBundle\Entity\League
     */
    public function get($id)
    {
        $repository = $this->registry->getRepository('BettingGameBundle:League');
        return $repository->find($id);
    }

    /**
     * @param string $name
     * @param int $promotionCount
     * @param int $promotionPlayOffsCount
     * @param int $relegationCount
     * @param int $relegationPlayOffsCount
     */
    public function create(
        $name,
        $promotionCount,
        $promotionPlayOffsCount,
        $relegationCount,
        $relegationPlayOffsCount
    ) {
        $entityManager = $this->registry->getManager();
        $entity = new League();
        $entity->name = $name;
        $entity->promotionCount = $promotionCount;
        $entity->promotionPlayOffsCount = $promotionPlayOffsCount;
        $entity->relegationCount = $relegationCount;
        $entity->relegationPlayOffsCount = $relegationPlayOffsCount;
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    /**
     * @param int $id
     * @param string $name
     * @param int $promotionCount
     * @param int $promotionPlayOffsCount
     * @param int $relegationCount
     * @param int $relegationPlayOffsCount
     */
    public function edit(
        $id,
        $name,
        $promotionCount,
        $promotionPlayOffsCount,
        $relegationCount,
        $relegationPlayOffsCount
    ) {
        $entityManager = $this->registry->getManager();
        $entity = $this->get($id);
        $entity->name = $name;
        $entity->promotionCount = $promotionCount;
        $entity->promotionPlayOffsCount = $promotionPlayOffsCount;
        $entity->relegationCount = $relegationCount;
        $entity->relegationPlayOffsCount = $relegationPlayOffsCount;
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $repository = $this->registry->getRepository('BettingGameBundle:League');
        $entityManager = $this->registry->getManager();
        $entity = $repository->find($id);
        $entityManager->remove($entity);
        $entityManager->flush();
    }
}
