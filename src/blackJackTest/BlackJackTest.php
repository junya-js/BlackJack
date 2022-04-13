<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../blackJack/BlackJack.php');
require_once(__DIR__ . '/../blackJack/Card.php');

class BlackJackTest extends TestCase
{
  public function testCalCards()
  {
    $blackJack = new BlackJack(['H7', 'C8'], ['C9', 'H10']);
    $this->assertSame(15, $blackJack->culCards([new Card('H7'), new Card('H8')]));
    $blackJack = new BlackJack(['HA', 'C8'], ['C9', 'H10']);
    $this->assertSame([9, 19], $blackJack->culCards([new Card('HA'), new Card('H8')]));
    $blackJack = new BlackJack(['HA', 'CK'], ['C9', 'H10']);
    $this->assertSame(21, $blackJack->culCards([new Card('HA'), new Card('HK')]));
  }
}
