<?php

namespace Blankse\BettingGameBundle\Controller;

use Blankse\BettingGameBundle\Services\LeagueHelper;
use Blankse\BettingGameBundle\Services\PlayerHelper;
use Blankse\BettingGameBundle\Services\TeamHelper;
use Blankse\BettingGameBundle\Services\TipHelper;
use Blankse\BettingGameBundle\Services\UserHelper;
use eZ\Bundle\EzPublishCoreBundle\Controller;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends Controller
{
    /** @var \Blankse\BettingGameBundle\Services\LeagueHelper */
    protected $leagueHelper;

    /** @var \Blankse\BettingGameBundle\Services\TeamHelper */
    protected $teamHelper;

    /** @var \Blankse\BettingGameBundle\Services\PlayerHelper */
    protected $playerHelper;

    /** @var \Blankse\BettingGameBundle\Services\UserHelper */
    protected $userHelper;

    /** @var \Blankse\BettingGameBundle\Services\TipHelper */
    protected $tipHelper;

    /** @var string */
    protected $pagelayout;

    public function __construct(
        LeagueHelper $leagueHelper,
        TeamHelper $teamHelper,
        PlayerHelper $playerHelper,
        UserHelper $userHelper,
        TipHelper $tipHelper
    ) {
        $this->leagueHelper = $leagueHelper;
        $this->teamHelper = $teamHelper;
        $this->playerHelper = $playerHelper;
        $this->userHelper = $userHelper;
        $this->tipHelper = $tipHelper;
    }

    /**
     * @param string $pagelayout
     */
    public function setPagelayout($pagelayout)
    {
        $this->pagelayout = $pagelayout;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        if ($request->request->has('Register')) {
            $user = $this->userHelper->create(
                $request->request->get('user_first_name'),
                $request->request->get('user_last_name'),
                $request->request->get('user_address')
            );
            $homeScoreList = $request->request->get('home_score');
            $awayScoreList = $request->request->get('away_score');
            foreach ($homeScoreList as $matchId => $homeScore) {
                $this->tipHelper->create(
                    $user,
                    'match',
                    (int)$matchId,
                    (int)$homeScore . ':' . (int)$awayScoreList[$matchId]
                );
            }
            foreach ($request->request->get('champion', []) as $leagueId => $teamId) {
                $this->tipHelper->create($user, 'champion', (int)$leagueId, (int)$teamId);
            }
            foreach ($request->request->get('promotion', []) as $leagueId => $teamIds) {
                foreach ($teamIds as $teamId) {
                    $this->tipHelper->create($user, 'promotion', (int)$leagueId, (int)$teamId);
                }
            }
            foreach ($request->request->get('promotion_play_offs', []) as $leagueId => $teamIds) {
                foreach ($teamIds as $teamId) {
                    $this->tipHelper->create($user, 'promotion_play_offs', (int)$leagueId, (int)$teamId);
                }
            }
            foreach ($request->request->get('relegation', []) as $leagueId => $teamIds) {
                foreach ($teamIds as $teamId) {
                    $this->tipHelper->create($user, 'relegation', (int)$leagueId, (int)$teamId);
                }
            }
            foreach ($request->request->get('relegation_play_offs', []) as $leagueId => $teamIds) {
                foreach ($teamIds as $teamId) {
                    $this->tipHelper->create($user, 'relegation_play_offs', (int)$leagueId, (int)$teamId);
                }
            }
            foreach ($request->request->get('top_scorers', []) as $teamId => $playerId) {
                $this->tipHelper->create($user, 'top_scorers', (int)$teamId, (int)$playerId);
            }
            return $this->redirectToRoute('betting_game_registered');
        }

        return $this->render(
            '@BettingGame/register.html.twig',
            [
                'leagueList' => $this->leagueHelper->getList(),
                'pagelayout' => $this->pagelayout,
                'location' => $this->getLocationByRoute('betting_game_register'),
            ]
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registeredAction()
    {
        return $this->render(
            '@BettingGame/registered.html.twig',
            [
                'pagelayout' => $this->pagelayout,
                'location' => $this->getLocationByRoute('betting_game_register'),
            ]
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function rankingAction()
    {
        return $this->render(
            '@BettingGame/ranking.html.twig',
            [
                'userList' => $this->userHelper->getList(['position' => 'ASC', 'lastName' => 'ASC']),
                'pagelayout' => $this->pagelayout,
                'location' => $this->getLocationByRoute('betting_game_ranking'),
            ]
        );
    }

    /**
     * @param int $userId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userAction($userId)
    {
        $user = $this->userHelper->get($userId);
        return $this->render(
            '@BettingGame/user.html.twig',
            [
                'user' => $user,
                'leagueList' => $this->leagueHelper->getList(),
                'playerList' => $this->playerHelper->getList(),
                'teamList' => $this->teamHelper->getList(),
                'tipList' => $this->tipHelper->getList($user),
                'pagelayout' => $this->pagelayout,
                'location' => $this->getLocationByRoute('betting_game_ranking'),
            ]
        );
    }

    /**
     * @param string $route
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Location|null
     */
    private function getLocationByRoute($route)
    {
        $repository = $this->getRepository();
        $locationService = $repository->getLocationService();
        $configResolver = $this->getConfigResolver();
        $locationId = $configResolver->getParameter($route . '.location_id', 'betting_game');

        return $locationService->loadLocation($locationId);
    }
}
