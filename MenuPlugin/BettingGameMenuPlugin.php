<?php

namespace Blankse\BettingGameBundle\MenuPlugin;

use Netgen\Bundle\AdminUIBundle\MenuPlugin\MenuPluginInterface;
use Symfony\Component\HttpFoundation\Request;

class BettingGameMenuPlugin implements MenuPluginInterface
{

    public function getIdentifier()
    {
        return 'betting_game';
    }

    public function getTemplates()
    {
        return [
            'aside' => '@BettingGame/menu/plugins/betting_game/aside.html.twig',
            'left' => '@BettingGame/menu/plugins/betting_game/left.html.twig',
        ];
    }

    public function isActive()
    {
        return true;
    }

    public function matches(Request $request)
    {
        return mb_stripos(
            $request->attributes->get('_route'),
            'betting_game_admin'
        ) === 0;
    }
}
