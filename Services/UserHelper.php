<?php

namespace Blankse\BettingGameBundle\Services;

use Blankse\BettingGameBundle\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Registry;

class UserHelper
{
    /** @var \Doctrine\Bundle\DoctrineBundle\Registry */
    protected $registry;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param array $sortBy
     * @return \Blankse\BettingGameBundle\Entity\User[]
     */
    public function getList($sortBy = [])
    {
        $repository = $this->registry->getRepository('BettingGameBundle:User');
        $return = [];

        foreach ($repository->findBy([], $sortBy) as $entity) {
            $return[$entity->id] = $entity;
        }

        return $return;
    }

    /**
     * @param int $id
     * @return \Blankse\BettingGameBundle\Entity\User
     */
    public function get($id)
    {
        $repository = $this->registry->getRepository('BettingGameBundle:User');
        return $repository->find($id);
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $address
     *
     * @return \Blankse\BettingGameBundle\Entity\User
     */
    public function create($firstName, $lastName, $address)
    {
        $entityManager = $this->registry->getManager();
        $entity = new User();
        $entity->firstName = $firstName;
        $entity->lastName = $lastName;
        $entity->address = $address;
        $entity->score = 0;
        $entity->paid = false;
        $entityManager->persist($entity);
        $entityManager->flush();
        $this->updatePositions();
        return $entity;
    }

    /**
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param string $address
     * @param bool $paid
     */
    public function edit($id, $firstName, $lastName, $address, $paid)
    {
        $entityManager = $this->registry->getManager();
        $entity = $this->get($id);
        $entity->firstName = $firstName;
        $entity->lastName = $lastName;
        $entity->address = $address;
        $entity->paid = $paid;
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $userRepository = $this->registry->getRepository('BettingGameBundle:User');
        $entityManager = $this->registry->getManager();
        $user = $userRepository->find($id);
        $tipRepository = $this->registry->getRepository('BettingGameBundle:Tip');

        foreach ($tipRepository->findBy(['user' => $user]) as $tip) {
            $entityManager->remove($tip);
        }

        $entityManager->remove($user);
        $entityManager->flush();
    }

    /**
     * Aktualisiert alle Positions
     */
    protected function updatePositions()
    {
        $repository = $this->registry->getRepository('BettingGameBundle:User');
        $entityManager = $this->registry->getManager();
        $users = $repository->findBy([], ['score' => 'DESC']);
        $score = null;
        $position = 0;

        foreach ($users as $user) {
            if ($user->score !== $score) {
                $position++;
            }

            $score = $user->score;
            $user->position = $position;
            $entityManager->persist($user);
        }

        $entityManager->flush();
    }

    /**
     * Aktualisiert alle Scores
     */
    public function updateScores()
    {
        $tipRepository = $this->registry->getRepository('BettingGameBundle:Tip');
        $entityManager = $this->registry->getManager();
        $users = $this->getList();

        foreach ($users as $user) {
            $score = 0;
            foreach ($tipRepository->findBy(['user' => $user]) as $tip) {
                $score += $tip->score;
            }
            $user->score = $score;
            $entityManager->persist($user);
        }

        $entityManager->flush();
        $this->updatePositions();
    }
}
