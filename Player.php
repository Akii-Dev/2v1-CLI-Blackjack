<?php

class Player
{
    private string $name;
    private array $hand = [];

    public function __construct(string $name)
	{
        $this->name = $name;
	}

    public function addCard(Card $card): void
    {
        array_push($this->hand, $card);
    }

    public function showHand(): string
    {
        $cardshow = [];
        foreach ($this->hand as $card) {
            array_push($cardshow, $card->show());
        }
        return $this->name . " has " . implode(' ', $cardshow);
    }

    public function returnHand(): array
    {
        return $this -> hand;
    }

    public function returnName(): string
    {
        return $this -> name;
    }
}

?>
