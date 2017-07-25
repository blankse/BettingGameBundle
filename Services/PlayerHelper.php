<?php

namespace Blankse\BettingGameBundle\Services;

use Blankse\BettingGameBundle\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Registry;

class PlayerHelper
{
    /** @var \Doctrine\Bundle\DoctrineBundle\Registry */
    protected $registry;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @return \Blankse\BettingGameBundle\Entity\Player[]
     */
    public function getList()
    {
        $repository = $this->registry->getRepository('BettingGameBundle:Player');
        $return = [];

        foreach ($repository->findAll() as $entity) {
            $return[$entity->id] = $entity;
        }

        return $return;
    }

    /**
     * @param int $id
     * @return \Blankse\BettingGameBundle\Entity\Player
     */
    public function get($id)
    {
        $repository = $this->registry->getRepository('BettingGameBundle:Player');
        return $repository->find($id);
    }

    /**
     * @param string $name
     * @param \Blankse\BettingGameBundle\Entity\Team[] $teams
     */
    public function create($name, $teams)
    {
        $entityManager = $this->registry->getManager();
        $entity = new Player();
        $entity->name = $name;
        $entity->teams = $teams;
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    /**
     * @param int $id
     * @param string $name
     * @param \Blankse\BettingGameBundle\Entity\Team[] $teams
     */
    public function edit($id, $name, $teams)
    {
        $entityManager = $this->registry->getManager();
        $entity = $this->get($id);
        $entity->name = $name;
        $entity->teams = $teams;
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $repository = $this->registry->getRepository('BettingGameBundle:Player');
        $entityManager = $this->registry->getManager();
        $entity = $repository->find($id);
        $entityManager->remove($entity);
        $entityManager->flush();
    }
}
