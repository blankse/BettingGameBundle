<?php

namespace Blankse\BettingGameBundle\Services;

use Blankse\BettingGameBundle\Entity\Match;
use Blankse\BettingGameBundle\Entity\Tip;
use Blankse\BettingGameBundle\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Registry;

class TipHelper
{
    /** @var \Doctrine\Bundle\DoctrineBundle\Registry */
    protected $registry;

    /** @var \Blankse\BettingGameBundle\Services\UserHelper */
    protected $userHelper;

    public function __construct(Registry $registry, UserHelper $userHelper)
    {
        $this->registry = $registry;
        $this->userHelper = $userHelper;
    }

    /**
     * @param \Blankse\BettingGameBundle\Entity\User $user
     * @return array
     */
    public function getList(User $user)
    {
        $repository = $this->registry->getRepository('BettingGameBundle:Tip');
        $return = [];

        foreach ($repository->findBy(['user' => $user]) as $entity) {
            if (!isset($return[$entity->type])) {
                $return[$entity->type] = [];
            }
            if (!isset($return[$entity->type][$entity->reference])) {
                $return[$entity->type][$entity->reference] = [];
            }
            $return[$entity->type][$entity->reference][] = $entity;
        }

        return $return;
    }

    /**
     * @param \Blankse\BettingGameBundle\Entity\User $user
     * @param string $type
     * @param string $reference
     * @param string $value
     */
    public function create(User $user, $type, $reference, $value)
    {
        $entityManager = $this->registry->getManager();
        $entity = new Tip();
        $entity->user = $user;
        $entity->type = $type;
        $entity->reference = $reference;
        $entity->value = $value;
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    /**
     * @param Match $match
     */
    public function updateMatchTipScores(Match $match)
    {
        $repository = $this->registry->getRepository('BettingGameBundle:Tip');
        $entityManager = $this->registry->getManager();

        /** @var \Blankse\BettingGameBundle\Entity\Tip $tip */
        foreach ($repository->findBy(['type' => 'match', 'reference' => $match->id]) as $tip) {
            $tip->score = 0;
            if ($match->homeScore !== null && $match->awayScore !== null) {
                if ($tip->value === $match->homeScore . ':' . $match->awayScore) {
                    $tip->score = 3;
                } else {
                    $value = explode(':', $tip->value);
                    if (
                        ($value[0] < $value[1] && $match->homeScore < $match->awayScore) ||
                        ($value[0] === $value[1] && $match->homeScore === $match->awayScore) ||
                        ($value[0] > $value[1] && $match->homeScore > $match->awayScore)
                    ) {
                        $tip->score = 1;
                    }
                }
            }
            $entityManager->persist($tip);
        }

        $entityManager->flush();
        $this->userHelper->updateScores();
    }
}
