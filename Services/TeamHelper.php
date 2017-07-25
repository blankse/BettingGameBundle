<?php

namespace Blankse\BettingGameBundle\Services;

use Blankse\BettingGameBundle\Entity\League;
use Blankse\BettingGameBundle\Entity\Match;
use Blankse\BettingGameBundle\Entity\Player;
use Blankse\BettingGameBundle\Entity\Team;
use Blankse\BettingGameBundle\Entity\Tip;
use Blankse\BettingGameBundle\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Registry;

class TeamHelper
{
    /** @var \Doctrine\Bundle\DoctrineBundle\Registry */
    protected $registry;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @return \Blankse\BettingGameBundle\Entity\Team[]
     */
    public function getList()
    {
        $repository = $this->registry->getRepository('BettingGameBundle:Team');
        $return = [];

        foreach ($repository->findAll() as $entity) {
            $return[$entity->id] = $entity;
        }

        return $return;
    }

    /**
     * @param int $id
     * @return \Blankse\BettingGameBundle\Entity\Team
     */
    public function get($id)
    {
        $repository = $this->registry->getRepository('BettingGameBundle:Team');
        return $repository->find($id);
    }

    /**
     * @param string $name
     * @param \Blankse\BettingGameBundle\Entity\League $league
     */
    public function create($name, League $league)
    {
        $entityManager = $this->registry->getManager();
        $entity = new Team();
        $entity->name = $name;
        $entity->league = $league;
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    /**
     * @param int $id
     * @param string $name
     * @param \Blankse\BettingGameBundle\Entity\League $league
     */
    public function edit($id, $name, League $league)
    {
        $entityManager = $this->registry->getManager();
        $entity = $this->get($id);
        $entity->name = $name;
        $entity->league = $league;
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $repository = $this->registry->getRepository('BettingGameBundle:Team');
        $entityManager = $this->registry->getManager();
        $entity = $repository->find($id);
        $entityManager->remove($entity);
        $entityManager->flush();
    }
}
