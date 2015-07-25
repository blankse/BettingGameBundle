<?php

$Module = array('name' => 'Betting Game');

$ViewList = array();

$ViewList['index'] = array(
    'script' => 'index.php',
    'functions' => array( 'read' ),
    'default_navigation_part' => 'bsbettinggamenavigationpart'
);

$ViewList['teams'] = array(
    'script' => 'teams.php',
    'functions' => array( 'read' ),
    'default_navigation_part' => 'bsbettinggamenavigationpart'
);

$ViewList['matches'] = array(
    'script' => 'matches.php',
    'functions' => array( 'read' ),
    'default_navigation_part' => 'bsbettinggamenavigationpart'
);

$FunctionList = array();

$FunctionList['read'] = array();
