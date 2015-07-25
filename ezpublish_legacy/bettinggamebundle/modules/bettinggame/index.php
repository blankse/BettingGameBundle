<?php

$module = $Params[ 'Module' ];
$tpl = eZTemplate::factory();

$Result = array();
$Result['content'] = $tpl->fetch('design:bettinggame/index.tpl');
$Result['path'] = array(
    array(
        'url' => false,
        'text' => ezpI18n::tr('bettinggame', 'Betting Game')
    )
);
