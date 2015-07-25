<?php

/** @var eZModule $module */
$module = $Params[ 'Module' ];
$tpl = eZTemplate::factory();
$http = eZHTTPTool::instance();

$container = ezpKernel::instance()->getServiceContainer();
/** @var \Doctrine\Bundle\DoctrineBundle\Registry $doctrine */
$doctrine = $container->get('doctrine');
$entityManager = $doctrine->getManager();
$teamRepository = $doctrine->getRepository('BettingGameBundle:Team');
$matchRepository = $doctrine->getRepository('BettingGameBundle:Match');

if ($http->hasVariable('CreateMatchButton')) {
    $match = new \Blankse\BettingGameBundle\Entity\Match();
    $match->date = new DateTime($http->postVariable('date'));
    $match->team = $teamRepository->find($http->postVariable('team_id'));
    $match->opponent = $http->postVariable('opponent');
    $match->awayGame = $http->postVariable('away_game');
    $entityManager->persist($match);
    $entityManager->flush();
    return $module->redirectToView('matches');
}
elseif ($http->hasVariable('DeleteMatchButton')) {
    $team = $matchRepository->find($http->postVariable('id'));
    $entityManager->remove($team);
    $entityManager->flush();
    return $module->redirectToView('matches');
}

$teams = [];

/** @var \Blankse\BettingGameBundle\Entity\Team $team */
foreach ($teamRepository->findAll() as $team) {
    $teams[] = array(
        'id' => $team->id,
        'name' => $team->name
    );
}
$tpl->setVariable('teams', $teams);

$matches = [];

/** @var \Blankse\BettingGameBundle\Entity\Match $match */
foreach ($matchRepository->findAll() as $match) {
    $matches[] = array(
        'id' => $match->id,
        'date' => $match->date->getTimestamp(),
        'team' => $match->team->name,
        'opponent' => $match->opponent,
        'away_game' => (int)$match->awayGame
    );
}
$tpl->setVariable('matches', $matches);

$Result = array();
$Result['content'] = $tpl->fetch('design:bettinggame/matches.tpl');
$Result['path'] = array(
    array(
        'url' => 'bettinggame/index',
        'text' => ezpI18n::tr('bettinggame', 'Betting Game')
    ),
    array(
        'url' => false,
        'text' => ezpI18n::tr('bettinggame', 'Matches')
    )
);
