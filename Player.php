<?php

declare(strict_types=1);
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

class Player {
    private array $cards = [];
    private bool $lost = false;
    public const TWENTY_ONE = 21;

    /**
     * Player constructor.
     * @param Deck $deck
     */
    public function __construct(Deck $deck)
    {
        $this->cards[] = $deck->drawCard();
        $this->cards[] = $deck->drawCard();
        //var_dump($this->cards);
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function hit($player) {
        $this->cards[] = $_SESSION['blackjack']->getDeck()->drawCard();
        if ($player->getScore($player) > self::TWENTY_ONE) {
            $this->lost = true;
        }
        //var_dump($this->cards);
    }

    public function surrender() {
        return $this->lost = true;
    }

    public function getScore($player) {
        $score = 0;
        $cards = $player->cards;
        foreach ($cards as $card) {
            $score += $card->getValue();
        }
        return $score;
    }

    public function hasLost() {
        return $this->lost;
    }

}

class Dealer extends Player {
    public const FIFTEEN = 15;

    public function hit($dealer){
        while($_SESSION['blackjack']->getDealer()->getScore($dealer) < self::FIFTEEN){
            Parent::hit($dealer);
        }
    }
}