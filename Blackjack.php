<?php

class Blackjack
{
    public function scoreHand(array $hand): string
    {
        $totalScore = 0;
        foreach ($hand as $cardInt => $card) {
            $totalScore += $card -> score();
        }
        if ($totalScore > 21) {
            return "Busted";
        } else if ($totalScore == 21 && count($hand) == 2) {
            return "Blackjack";
        } else if ($totalScore < 21 && count($hand) == 5) {
            return "Five Card Charlie";
        } else if ($totalScore == 21) {
            return "Twenty-One";
        } else {
            return $totalScore;
        }
    }
}

?>