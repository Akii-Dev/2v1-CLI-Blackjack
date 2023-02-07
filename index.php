<?php

require_once 'BlackJack.php';
require_once 'Card.php';
require_once 'Dealer.php';
require_once 'Deck.php';
require_once 'Player.php';

$dealer = new Dealer(new BlackJack(), new Deck());
$dealer->addPlayer(new Player('Alpha'));
$dealer->addPlayer(new Player('Bravo'));
$dealer->playGame();
?>