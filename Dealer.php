<?php

class Dealer
{
    private Blackjack $blackjack;
    private Deck $deck;
    private array $players = [];
    private array $playerScores = [null, null, null];
    private int $activePlayers = 0;
    

    public function __construct(Blackjack $blackjack, Deck $deck)
	{
        $this -> deck = $deck;
        $this->addPlayer(new Player('Dealer'));
        $this -> blackjack = $blackjack;
	}

    public function addPlayer(Player $player): void
    {
        array_push($this -> players, $player); 
    }

    public function playGame(): void
    {
        // Hier begint het spel: iedereen krijgt 2 kaarten en daarna wordt er gekeken of iemand gewonnen heeft of dat iemand busted is.

        foreach ($this -> players as $id => $enkeleSpeler) {
            $enkeleSpeler->addCard($this -> deck->drawCard());
            $enkeleSpeler->addCard($this -> deck->drawCard());
            $this -> checkOpeningHand($enkeleSpeler, $id);
        }

        $this -> activePlayers = count($this -> players);
        while ($this -> activePlayers !== 0) {
            foreach ($this -> players as $id => $player) {
                $score = $this -> blackjack -> scoreHand($player -> returnHand());
                if ($player -> returnName() == "Dealer") {
                    $this -> dealerLogic($player, $score, $id);
                } else {
                    $this -> playerLogic($player, $score, $id);
                }
            }
        }
        

        $this -> compareScore($this -> playerScores[0], $this -> playerScores[1]);
        $this -> compareScore($this -> playerScores[0], $this -> playerScores[2]);
    }

    public function playerLogic(Player $player, $score, $id): void
    {
        if (is_numeric($score)) {
            echo $player -> returnName() . "'s turn. " . $player -> showHand() . ". ";
            $antwoord = readline("'draw' or 'stop'?... ");
            if ($antwoord == "d" || $antwoord == "draw") {
                $gepakteKaart = $this -> deck->drawCard();
                $player->addCard($gepakteKaart);
                echo $player -> returnName() . " drew " . $gepakteKaart->show() . PHP_EOL;
                $this -> playerScores[$id] = $player;
            } else {
                echo $player -> returnName() . " stops." . PHP_EOL;
                $this -> playerScores[$id] = $player;
                unset($this->players[$id]);
                $this -> activePlayers--;
            }
        } else {
            switch ($score) {
                case "Busted":
                    echo $player -> returnName() . " is busted!: " . $player -> showHand() . PHP_EOL;
                    unset($this->players[$id]);
                    $this -> activePlayers--;
                    break;
                case "Five Card Charlie":
                    echo $player -> returnName() . " wins! " . $score . "!" . PHP_EOL;
                    foreach ($this -> playerScores as $allespelers) {
                        echo $allespelers -> showHand() . " -> " . $this -> blackjack -> scoreHand($allespelers -> returnHand()) . PHP_EOL;
                    }
                    exit();
                    break;
                case "Twenty-One":
                    $this -> playerScores[$id] = $player;
                    unset($this->players[$id]);
                    $this -> activePlayers--;
                    break;
            }
        }
    }

    public function dealerLogic(Player $player, $score, $id): void
    {
        if (is_numeric($score)) {
            echo $player -> showHand() . PHP_EOL;
            if ($score < 18) {
                $gepakteKaart = $this -> deck->drawCard();
                $player->addCard($gepakteKaart);
                echo $player -> returnName() . " drew " . $gepakteKaart->show() . PHP_EOL;
                $this -> playerScores[$id] = $player;
            } else {
                echo $player -> returnName() . " stops." . PHP_EOL;
                $this -> playerScores[$id] = $player;
                unset($this->players[$id]);
                $this -> activePlayers--;
            }
        } else {
            switch ($score) {
                case "Busted":
                    echo $player -> returnName() . " is busted!: " . $player -> showHand() . PHP_EOL;
                    unset($this->players[$id]);
                    foreach ($this -> playerScores as $allespelers) {
                        if ($this -> blackjack -> scoreHand($allespelers -> returnHand()) !== "Busted") {
                            echo $allespelers -> returnName() . " wins!" . PHP_EOL;
                        }
                    }
                    foreach ($this -> playerScores as $allespelers) {
                        echo $allespelers -> showHand() . " -> " . $this -> blackjack -> scoreHand($allespelers -> returnHand()) . PHP_EOL;
                    }
                    exit();
                    break;
                case "Five Card Charlie":
                case "Twenty-One":
                    echo $player -> returnName() . " wins! " . $score . "!" . PHP_EOL;
                    foreach ($this -> playerScores as $allespelers) {
                        echo $allespelers -> showHand() . " -> " . $this -> blackjack -> scoreHand($allespelers -> returnHand()) . PHP_EOL;
                    }
                    exit();
                    break;
            }
        }
    }

    private function compareScore(Player $dealer, Player $speler): void
    {

        $dealerHandVal = $this -> blackjack -> scoreHand($dealer -> returnHand());
        $spelerHandVal = $this -> blackjack -> scoreHand($speler -> returnHand());

        if ($spelerHandVal == "Twenty-One" || intval($spelerHandVal) > intval($dealerHandVal)) {
            echo $speler -> returnName() . " wins against " . $dealer -> returnName() . "! || " . $spelerHandVal . " > " . $dealerHandVal . PHP_EOL;
        } else {
            echo $dealer -> returnName() . " wins against " . $speler -> returnName() . "! || " . $dealerHandVal . " > " . $spelerHandVal . PHP_EOL;
        }
    }

    private function checkOpeningHand(Player $player, $id): void
    {
        $score = $this -> blackjack -> scoreHand($player -> returnHand());

        if (!is_numeric($score)) {
            if ($score !== "Busted") {
                echo $player -> returnName() . " wins! " . $score . "!" . PHP_EOL;
                foreach ($this -> players as $allespelers) {
                    echo $allespelers -> showHand() . " -> " . $this -> blackjack -> scoreHand($allespelers -> returnHand()) . PHP_EOL;
                }
                exit();
            } else {
                echo $player -> returnName() . " is busted!: " . $player -> showHand() . PHP_EOL;
                unset($this->players[$id]);
            }
        }
    }
}

?>
