<?php

require_once (__DIR__ . '/../blackJack/Card.php');

use PHPUnit\Framework\TestCase;

class CardTest extends TestCase
{
  public function testCard()
  {
    $card = new Card('H7');
    $this->assertSame('ハート', $card->getType());
    $this->assertSame('7', $card->getNum());
    $this->assertSame(7, $card->getRank());
    $card = new Card('C10');
    $this->assertSame('クローバー', $card->getType());
    $this->assertSame('10', $card->getNum());
    $this->assertSame(10, $card->getRank());
    $card = new Card('DQ');
    $this->assertSame('ダイヤ', $card->getType());
    $this->assertSame('Q', $card->getNum());
    $this->assertSame(10, $card->getRank());
    $card = new Card('SA');
    $this->assertSame('スペード', $card->getType());
    $this->assertSame('A', $card->getNum());
    $this->assertSame(1, $card->getRank());
  }
}
