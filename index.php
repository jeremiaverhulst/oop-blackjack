<?php

declare(strict_types=1);
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

require 'Suit.php';
require 'Card.php';
require 'Deck.php';
require 'Player.php';
require 'Blackjack.php';

session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">

    <title>OOP - Blackjack</title>
</head>
<body>
<header>
    <div class="container">
        <h1 class="text-center">Blackjack</h1>
        <p class="text-center subtitle"><span>—</span> made with OOP PHP <span>—</span></p>
    </div>
</header>
<div class="container">
<nav class="mx-auto">
    <ul class="nav nav-pills d-flex flex-row justify-content-around">
        <li class="nav-item nav-moves">
            <a class="nav-link btn btn-outline-dark" type="button" href="index.php?action=hit">Hit</a>
        </li>
        <li class="nav-item nav-moves">
            <a class="nav-link btn btn-outline-dark" type="button" href="index.php?action=stand">Stand</a>
        </li>
        <li class="nav-item nav-moves">
            <a class="nav-link btn btn-outline-dark" type="button" href="index.php?action=surrender">Surrender</a>
        </li>
    </ul>
</nav>
</div>
</body>
</html>
<?php


if (!isset($_SESSION['blackjack'])) {
    $_SESSION['blackjack'] = new Blackjack();
}

$getSessionPlayer = $_SESSION['blackjack']->getPlayer();
$getSessionDealer = $_SESSION['blackjack']->getDealer();

if ($_GET['action'] === 'hit') {
    $getSessionPlayer->hit($getSessionPlayer);
}
if ($_GET['action'] === 'stand') {
    $getSessionDealer->hit($getSessionDealer);
    if($getSessionPlayer->getScore($getSessionPlayer) < $getSessionDealer->getScore($getSessionDealer)){
        $getSessionPlayer->hasLost();
    }
    elseif($getSessionPlayer->getScore($getSessionPlayer) === $getSessionDealer->getScore($getSessionDealer)){
        echo "<h4 class='text-center text-danger'>You lose</h4>";
        session_destroy();
    }
    elseif($getSessionPlayer->getScore($getSessionPlayer) > $getSessionDealer->getScore($getSessionDealer)){
        echo "<h4 class='text-center text-success'>You win</h4>";
        session_destroy();
    }
}
if ($_GET['action'] === 'surrender') {
    $getSessionPlayer->surrender();
}
if ($getSessionPlayer->hasLost()) {
    echo "<h4 class='text-center text-danger'>You lose, the dealer wins.</h4>";
    session_destroy();
}
elseif($getSessionDealer->hasLost() && !$getSessionPlayer->hasLost()) {
    echo "<h4 class='text-center text-success'>You win, the dealer loses.</h4>";
    session_destroy();
}
elseif($getSessionPlayer->hasLost() && $getSessionDealer->hasLost()) {
    echo "<h4 class='text-center text-danger'>You lose, the dealer wins.</h4>";
    session_destroy();
}

$_SESSION['blackjack']->showAll();
?>