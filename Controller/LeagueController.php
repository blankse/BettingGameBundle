<?php

namespace Blankse\BettingGameBundle\Controller;

use Blankse\BettingGameBundle\Services\LeagueHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LeagueController extends Controller
{
    /** @var \Blankse\BettingGameBundle\Services\LeagueHelper */
    protected $leagueHelper;

    public function __construct(LeagueHelper $leagueHelper)
    {
        $this->leagueHelper = $leagueHelper;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction()
    {
        return $this->render(
            '@BettingGame/admin/leagues.html.twig',
            [
                'leagueList' => $this->leagueHelper->getList(),
            ]
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        if ($request->request->has('CreateLeague')) {
            $this->leagueHelper->create(
                $request->request->get('league_name'),
                (int)$request->request->get('league_promotion_count'),
                (int)$request->request->get('league_promotion_play_offs_count'),
                (int)$request->request->get('league_relegation_count'),
                (int)$request->request->get('league_relegation_play_offs_count')
            );
        }

        return $this->redirectToRoute('betting_game_admin_leagues');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        if ($request->request->has('EditLeague')) {
            $this->leagueHelper->edit(
                $id,
                $request->request->get('league_name'),
                (int)$request->request->get('league_promotion_count'),
                (int)$request->request->get('league_promotion_play_offs_count'),
                (int)$request->request->get('league_relegation_count'),
                (int)$request->request->get('league_relegation_play_offs_count')
            );
            return $this->redirectToRoute('betting_game_admin_leagues');
        }

        return $this->render(
            '@BettingGame/admin/league_edit.html.twig',
            [
                'league' => $this->leagueHelper->get($id),
            ]
        );
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        $this->leagueHelper->delete($id);

        return $this->redirectToRoute('betting_game_admin_leagues');
    }
}
