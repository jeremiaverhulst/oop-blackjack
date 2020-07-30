<?php

declare(strict_types=1);
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

class Card
{
    private const ACE_VALUE = 11;
    private const FACE_VALUE = 10;

    /** @var Suit */
    private $suit;

    /** @var int */
    private $value;

    public function __construct(Suit $suit, int $value)
    {
        $this->suit = $suit;
        $this->value = $value;
    }

    public function getSuit(): Suit
    {
        return $this->suit;
    }

    public function getValue()
    {
        if($this->value === 1) {
            return self::ACE_VALUE;
        }
        if($this->value >= 10) {
            return self::FACE_VALUE;
        }

        return $this->value;
    }

    private function getRawValue(): int
    {
        return $this->value;
    }

    public function getUnicodeCharacter(bool $includeColor=false) {
        $value = '&#'. ($this->suit->getStartValue() + $this->getRawValue()) .';';

        if($includeColor) {
            $value = sprintf('<span class="blackjack-card" style="color: %s;">%s</span>',
                $this->suit->getColor(),
                $value
            );
        }

        return $value;
    }
}