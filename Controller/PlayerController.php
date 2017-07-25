<?php

namespace Blankse\BettingGameBundle\Controller;

use Blankse\BettingGameBundle\Services\PlayerHelper;
use Blankse\BettingGameBundle\Services\TeamHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PlayerController extends Controller
{
    /** @var \Blankse\BettingGameBundle\Services\PlayerHelper */
    protected $playerHelper;

    /** @var \Blankse\BettingGameBundle\Services\TeamHelper */
    protected $teamHelper;

    public function __construct(PlayerHelper $playerHelper, TeamHelper $teamHelper)
    {
        $this->playerHelper = $playerHelper;
        $this->teamHelper = $teamHelper;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction()
    {
        return $this->render(
            '@BettingGame/admin/players.html.twig',
            [
                'playerList' => $this->playerHelper->getList(),
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
        if ($request->request->has('CreatePlayer')) {
            $teams = [];
            foreach ($request->request->get('player_teams') as $teamId) {
                $teams[] = $this->teamHelper->get($teamId);
            }
            $this->playerHelper->create(
                $request->request->get('player_name'),
                $teams
            );
        }

        return $this->redirectToRoute('betting_game_admin_players');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        if ($request->request->has('EditPlayer')) {
            $teams = [];
            foreach ($request->request->get('player_teams') as $teamId) {
                $teams[] = $this->teamHelper->get($teamId);
            }
            $this->playerHelper->edit(
                $id,
                $request->request->get('player_name'),
                $teams
            );
            return $this->redirectToRoute('betting_game_admin_players');
        }

        return $this->render(
            '@BettingGame/admin/player_edit.html.twig',
            [
                'teamList' => $this->teamHelper->getList(),
                'player' => $this->playerHelper->get($id),
            ]
        );
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        $this->playerHelper->delete($id);

        return $this->redirectToRoute('betting_game_admin_players');
    }
}
