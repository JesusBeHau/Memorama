<?php
/**
 * Created by IntelliJ IDEA.
 * User: jonathaneduardo
 * Date: 09/04/2016
 * Time: 12:35 PM
 */
include_once("MateriaManagerComplet.php");
require_once("DataBaseManager.php");

$dbManager = DataBaseManager::getInstance();
$materiaManager = new MateriaManagerComplet($dbManager);
echo $materiaManager->getAllMateriaComplet();