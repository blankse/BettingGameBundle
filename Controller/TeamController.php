<?php

namespace Blankse\BettingGameBundle\Controller;

use Blankse\BettingGameBundle\Services\LeagueHelper;
use Blankse\BettingGameBundle\Services\TeamHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TeamController extends Controller
{
    /** @var \Blankse\BettingGameBundle\Services\LeagueHelper */
    protected $leagueHelper;

    /** @var \Blankse\BettingGameBundle\Services\TeamHelper */
    protected $teamHelper;

    public function __construct(LeagueHelper $leagueHelper, TeamHelper $teamHelper)
    {
        $this->leagueHelper = $leagueHelper;
        $this->teamHelper = $teamHelper;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction()
    {
        return $this->render(
            '@BettingGame/admin/teams.html.twig',
            [
                'leagueList' => $this->leagueHelper->getList(),
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
        if ($request->request->has('CreateTeam')) {
            $league = $this->leagueHelper->get($request->request->get('team_league'));
            $this->teamHelper->create($request->request->get('team_name'), $league);
        }

        return $this->redirectToRoute('betting_game_admin_teams');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        if ($request->request->has('EditTeam')) {
            $league = $this->leagueHelper->get($request->request->get('team_league'));
            $this->teamHelper->edit($id, $request->request->get('team_name'), $league);
            return $this->redirectToRoute('betting_game_admin_teams');
        }

        return $this->render(
            '@BettingGame/admin/team_edit.html.twig',
            [
                'leagueList' => $this->leagueHelper->getList(),
                'team' => $this->teamHelper->get($id),
            ]
        );
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        $this->teamHelper->delete($id);

        return $this->redirectToRoute('betting_game_admin_teams');
    }
}
