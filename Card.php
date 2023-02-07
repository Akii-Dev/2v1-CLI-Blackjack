<?php

class Card
{
    private string $suit;
    private string $value;

	public function __construct($suit, $value)
	{
		$this -> validateSuit($suit);
		$this -> validateValue($value);
	}

	private function validateSuit($suit): void
	{
		switch ($suit) {
			case "klaveren":
                $this -> suit = "♣";
				break;
			case "harten":
                $this -> suit = "♡";
				break;
			case "schoppen":
                $this -> suit = "♣";
				break;
			case "ruiten":
                $this -> suit = "♢";
				break;
			default:
				throw new InvalidArgumentException("Invalid suit given: $suit");
				break;
        }
	}

	private function validateValue($value): void
	{
		switch ($value) {
            case "boer":
                $this -> value = "B";
				return;
            case "vrouw":
                $this -> value = "V";
				return;
            case "heer":
                $this -> value = "H";
				return;
            case "aas":
                $this -> value = "A";
				return;
			default:
				break;
        }

		if (is_numeric($value)) {
            $val = intval($value);
            if ($val <= 1 || $val >= 11) {
                throw new InvalidArgumentException("Getal is te groot of te klein");
            } else {
                $this -> value = $value;
            }
        } else {
            throw new InvalidArgumentException("Invalid value given: $value");
        }
	}

	public function show(): string
	{
		return $this -> suit . " " . $this -> value;
	}

	public function score(): int
	{
		$cardVal = 0;
		if ($this -> value == "A") {
			$cardVal = 11;
		} else if ($this -> value == "B" || $this -> value == "V" || $this -> value == "H") {
			$cardVal = 10;
		} else {
			$cardVal = intval($this -> value);
		}
		return $cardVal;
	}
}

?>
