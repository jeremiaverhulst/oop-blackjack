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
                    <a class="nav-link btn btn-outline-dark" type="button" href="index.php?action=new_game" data-toggle="tooltip" data-placement="bottom" title="Start a new game">New game</a>
                </li>
                <li class="nav-item nav-moves">
                    <a class="nav-link btn btn-outline-dark" type="button" href="index.php?action=hit" data-toggle="tooltip" data-placement="bottom" title="Player draws another card">Hit</a>
                </li>
                <li class="nav-item nav-moves">
                    <a class="nav-link btn btn-outline-dark" type="button" href="index.php?action=stand" data-toggle="tooltip" data-placement="bottom" title="Player passes, dealer draws another card">Stand</a>
                </li>
                <li class="nav-item nav-moves">
                    <a class="nav-link btn btn-outline-dark" type="button" href="index.php?action=surrender" data-toggle="tooltip" data-placement="bottom" title="Player surrenders">Surrender</a>
                </li>
            </ul>
        </nav>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
    </html>
<?php


if (!isset($_SESSION['blackjack'])) {
    $_SESSION['blackjack'] = new Blackjack();
}

$getSessionPlayer = $_SESSION['blackjack']->getPlayer();
$getSessionDealer = $_SESSION['blackjack']->getDealer();

if($getSessionPlayer->getScore($getSessionPlayer) > Player::TWENTY_ONE){
    $getSessionPlayer->hasLost();
}
elseif($getSessionDealer->getScore($getSessionDealer) > Player::TWENTY_ONE){
    $getSessionDealer->hasLost();
}
elseif($getSessionPlayer->getScore($getSessionPlayer) > Player::TWENTY_ONE && $getSessionDealer->getScore($getSessionDealer) > Player::TWENTY_ONE){
    $getSessionPlayer->hasLost();
}

if(isset($_GET['action'])){
    if ($_GET['action'] === 'new_game') {
        $_SESSION['blackjack'] = new Blackjack();
    }
    if ($_GET['action'] === 'hit') {
        $getSessionPlayer->hit($getSessionPlayer);
    }
    if ($_GET['action'] === 'stand') {
        $getSessionDealer->hit($getSessionDealer);
        if($getSessionPlayer->getScore($getSessionPlayer) < $getSessionDealer->getScore($getSessionDealer)){
            echo "<h4 class='text-center text-danger'>You lose, the dealer wins.</h4>";
            session_destroy();
        }
        elseif($getSessionPlayer->getScore($getSessionPlayer) === $getSessionDealer->getScore($getSessionDealer)){
            echo "<h4 class='text-center text-danger'>You lose, the dealer wins.</h4>";
            session_destroy();
        }
        elseif($getSessionPlayer->getScore($getSessionPlayer) > $getSessionDealer->getScore($getSessionDealer)){
            echo "<h4 class='text-center text-success'>You win, the dealer loses.</h4>";
            session_destroy();
        }
    }
    if ($_GET['action'] === 'surrender') {
        $getSessionPlayer->surrender();
    }
}
if ($getSessionPlayer->hasLost()) {
    echo "<h4 class='text-center text-danger'>You lose, the dealer wins.</h4>";
    session_destroy();
}
if ($getSessionDealer->hasLost()) {
    echo "<h4 class='text-center text-success'>You win, the dealer loses.</h4>";
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