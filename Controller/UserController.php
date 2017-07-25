<?php

namespace Blankse\BettingGameBundle\Controller;

use Blankse\BettingGameBundle\Services\UserHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /** @var \Blankse\BettingGameBundle\Services\UserHelper */
    protected $userHelper;

    public function __construct(UserHelper $userHelper)
    {
        $this->userHelper = $userHelper;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction()
    {
        return $this->render(
            '@BettingGame/admin/users.html.twig',
            [
                'userList' => $this->userHelper->getList(),
            ]
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        if ($request->request->has('EditUser')) {
            $this->userHelper->edit(
                $id,
                $request->request->get('user_first_name'),
                $request->request->get('user_last_name'),
                $request->request->get('user_address'),
                (bool)$request->request->get('user_paid')
            );
            return $this->redirectToRoute('betting_game_admin_users');
        }

        return $this->render(
            '@BettingGame/admin/user_edit.html.twig',
            [
                'user' => $this->userHelper->get($id),
            ]
        );
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        $this->userHelper->delete($id);

        return $this->redirectToRoute('betting_game_admin_users');
    }
}
