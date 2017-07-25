<?php

namespace Blankse\BettingGameBundle\Controller;

use Blankse\BettingGameBundle\Services\LeagueHelper;
use Blankse\BettingGameBundle\Services\MatchHelper;
use Blankse\BettingGameBundle\Services\TeamHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MatchController extends Controller
{
    /** @var \Blankse\BettingGameBundle\Services\TeamHelper */
    protected $teamHelper;

    /** @var \Blankse\BettingGameBundle\Services\MatchHelper */
    protected $matchHelper;

    public function __construct(TeamHelper $teamHelper, MatchHelper $matchHelper)
    {
        $this->teamHelper = $teamHelper;
        $this->matchHelper = $matchHelper;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction()
    {
        return $this->render(
            '@BettingGame/admin/matches.html.twig',
            [
                'matchList' => $this->matchHelper->getList(),
                'teamList' => $this->teamHelper->getList(),
            ]
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        if ($request->request->has('CreateMatch')) {
            if ($request->request->get('match_date')) {
                $date = new \DateTime($request->request->get('match_date'));
            } else {
                $date = null;
            }
            $homeTeam = $this->teamHelper->get($request->request->get('match_home_team'));
            $awayTeam = $this->teamHelper->get($request->request->get('match_away_team'));
            $this->matchHelper->create(
                $homeTeam,
                $awayTeam,
                $date
            );
        }

        return $this->redirectToRoute('betting_game_admin_matches');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        if ($request->request->has('EditMatch')) {
            if ($request->request->get('match_date')) {
                $date = new \DateTime($request->request->get('match_date'));
            } else {
                $date = null;
            }
            $homeTeam = $this->teamHelper->get($request->request->get('match_home_team'));
            $awayTeam = $this->teamHelper->get($request->request->get('match_away_team'));
            if ($request->request->get('match_home_score') !== '') {
                $homeScore = (int)$request->request->get('match_home_score');
            } else {
                $homeScore = null;
            }
            if ($request->request->get('match_away_score') !== '') {
                $awayScore = (int)$request->request->get('match_away_score');
            } else {
                $awayScore = null;
            }
            $this->matchHelper->edit(
                $id,
                $homeTeam,
                $awayTeam,
                $date,
                $homeScore,
                $awayScore
            );
            return $this->redirectToRoute('betting_game_admin_matches');
        }

        return $this->render(
            '@BettingGame/admin/match_edit.html.twig',
            [
                'teamList' => $this->teamHelper->getList(),
                'match' => $this->matchHelper->get($id),
            ]
        );
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        $this->matchHelper->delete($id);

        return $this->redirectToRoute('betting_game_admin_matches');
    }
}
