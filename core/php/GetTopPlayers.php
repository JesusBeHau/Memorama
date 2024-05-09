<?php

include_once("PlayersTop.php");
require_once("DataBaseManager.php");

$dbManager = DataBaseManager::getInstance();
$players = new PlayersTop($dbManager);
echo $players->getTopTenPuntajes();