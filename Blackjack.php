<?php

declare(strict_types=1);
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

class Blackjack
{
    private player $player;
    private dealer $dealer;
    private deck $deck;

    public function __construct()
    {
        $deck = new Deck();
        $deck->shuffle();
        $this->deck = $deck;
        $this->player = new Player($this->deck);
        $this->dealer = new Dealer($this->deck);
    }


    public function getPlayer(): object
    {
        return $this->player;
    }

    public function getDealer(): object
    {
        return $this->dealer;
    }

    public function getDeck()
    {
        return $this->deck;
    }

    public function showAll() {
        $scorePlayer = 0;
        $scoreDealer = 0;
        echo "<h2 class='text-center'>Player</h2><br>";
        foreach($this->player->getCards() AS $card)
        {
            echo $card->getUnicodeCharacter(true);
            $scorePlayer += $card->getValue();
        }
        echo "<h3 class='text-center'>Score: {$scorePlayer}</h3><br>";
        echo "<h2 class='text-center'>Dealer</h2><br>";
        foreach($this->dealer->getCards() AS $card) {
            echo $card->getUnicodeCharacter(true);
            $scoreDealer += $card->getValue();
        }
        echo "<h3 class='text-center'>Score: {$scoreDealer}</h3><br>";
    }


}