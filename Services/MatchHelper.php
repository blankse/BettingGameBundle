<?php

namespace Blankse\BettingGameBundle\Services;

use Blankse\BettingGameBundle\Entity\Match;
use Blankse\BettingGameBundle\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Registry;

class MatchHelper
{
    /** @var \Doctrine\Bundle\DoctrineBundle\Registry */
    protected $registry;

    /** @var \Blankse\BettingGameBundle\Services\TipHelper */
    protected $tipHelper;

    public function __construct(Registry $registry, TipHelper $tipHelper)
    {
        $this->registry = $registry;
        $this->tipHelper = $tipHelper;
    }

    /**
     * @return \Blankse\BettingGameBundle\Entity\Match[]
     */
    public function getList()
    {
        $repository = $this->registry->getRepository('BettingGameBundle:Match');
        $return = [];

        foreach ($repository->findAll() as $entity) {
            $return[$entity->id] = $entity;
        }

        return $return;
    }

    /**
     * @param int $id
     * @return \Blankse\BettingGameBundle\Entity\Match
     */
    public function get($id)
    {
        $repository = $this->registry->getRepository('BettingGameBundle:Match');
        return $repository->find($id);
    }

    /**
     * @param \Blankse\BettingGameBundle\Entity\Team $homeTeam
     * @param \Blankse\BettingGameBundle\Entity\Team $awayTeam
     * @param \DateTime|null $date
     *
     * @throws \Exception
     */
    public function create(Team $homeTeam, Team $awayTeam, \DateTime $date = null)
    {
        if ($homeTeam->id === $awayTeam->id) {
            throw new \Exception('Mannschaften dürfen nicht die selben sein');
        }
        if ($homeTeam->league->id !== $awayTeam->league->id) {
            throw new \Exception('Mannschaften müssen in der selben Liga spielen');
        }
        $entityManager = $this->registry->getManager();
        $entity = new Match();
        $entity->date = $date;
        $entity->league = $homeTeam->league;
        $entity->homeTeam = $homeTeam;
        $entity->awayTeam = $awayTeam;
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    /**
     * @param int $id
     * @param \Blankse\BettingGameBundle\Entity\Team $homeTeam
     * @param \Blankse\BettingGameBundle\Entity\Team $awayTeam
     * @param \DateTime|null $date
     * @param int|null $homeScore
     * @param int|null $awayScore
     *
     * @throws \Exception
     */
    public function edit($id, Team $homeTeam, Team $awayTeam, \DateTime $date = null, $homeScore = null, $awayScore = null)
    {
        if ($homeTeam->id === $awayTeam->id) {
            throw new \Exception('Mannschaften dürfen nicht die selben sein');
        }
        if ($homeTeam->league->id !== $awayTeam->league->id) {
            throw new \Exception('Mannschaften müssen in der selben Liga spielen');
        }
        $entityManager = $this->registry->getManager();
        $entity = $this->get($id);
        $entity->date = $date;
        $entity->league = $homeTeam->league;
        $entity->homeTeam = $homeTeam;
        $entity->awayTeam = $awayTeam;
        $entity->homeScore = $homeScore;
        $entity->awayScore = $awayScore;
        $entityManager->persist($entity);
        $entityManager->flush();
        $this->tipHelper->updateMatchTipScores($entity);
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $repository = $this->registry->getRepository('BettingGameBundle:Match');
        $entityManager = $this->registry->getManager();
        $entity = $repository->find($id);
        $entityManager->remove($entity);
        $entityManager->flush();
    }
}
