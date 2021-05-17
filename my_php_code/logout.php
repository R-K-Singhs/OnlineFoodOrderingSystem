<?php
require "db_manager.php";
$db = new DbManager;
$_SESSION["postpage"] = "exit";
$db->connDatabase();
$db->closeDatabase();
session_destroy();
