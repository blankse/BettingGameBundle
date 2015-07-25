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

if ($http->hasVariable('CreateTeamButton')) {
    $team = new \Blankse\BettingGameBundle\Entity\Team();
    $team->name = $http->postVariable('name');
    $entityManager->persist($team);
    $entityManager->flush();
    return $module->redirectToView('teams');
}
elseif ($http->hasVariable('DeleteTeamButton')) {
    $team = $teamRepository->find($http->postVariable('id'));
    $entityManager->remove($team);
    $entityManager->flush();
    return $module->redirectToView('teams');
}

$teams = [];

/** @var \Blankse\BettingGameBundle\Entity\Team $team */
foreach ($teamRepository->findAll() as $team) {
    $teams[] = array(
        'id' => $team->id,
        'name' => $team->name,
        'match_count' => count($team->matches)
    );
}
$tpl->setVariable('teams', $teams);

$Result = array();
$Result['content'] = $tpl->fetch('design:bettinggame/teams.tpl');
$Result['path'] = array(
    array(
        'url' => 'bettinggame/index',
        'text' => ezpI18n::tr('bettinggame', 'Betting Game')
    ),
    array(
        'url' => false,
        'text' => ezpI18n::tr('bettinggame', 'Teams')
    )
);
