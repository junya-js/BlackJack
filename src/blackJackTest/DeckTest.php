<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../blackJack/Deck.php');

class DeckTest extends TestCase
{
  public function testDeck()
  {
    $deck = new Deck();

    $a = $deck->drawCardStartPlayer();
    $this->assertSame(2, count($a));

    $b = $deck->drawCardStartDealer();
    $this->assertSame(2, count($b));

    $c = $deck->drawCard();
    $this->assertSame(1, count([$c]));
  }
}
