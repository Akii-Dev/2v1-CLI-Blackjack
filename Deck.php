<?php

class Deck
{
    private array $cards = [];

    public function __construct()
    {
        $suitArray = ["klaveren", "harten", "schoppen", "ruiten"];
        $valueArray = ["boer", "vrouw", "heer", "aas", "2", "3", "4", "5", "6", "7", "8", "9", "10"];

        foreach ($suitArray as $suitInt => $suit) {
            foreach ($valueArray as $valueInt => $cardValue) {
                $card = new Card($suit, $cardValue);
                array_push($this -> cards, $card); 
            }
        }
        shuffle($this -> cards);
    }

    public function drawCard(): Card
    {
        if (count($this->cards) === 0) {
            throw new Exception('No more cards left in deck.');
        }

        return array_shift($this->cards);
    }
}
?>
