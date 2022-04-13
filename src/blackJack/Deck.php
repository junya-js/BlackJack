<?php
// デッキ（52枚）を作成する。デッキからカードを引くクラス
class Deck
{
  public array $cards;

// ['H7', 'C8'], ['C9', 'H10']来る値
  public function __construct()
  {
    foreach (['C', 'H', 'S', 'D'] as $suit) {
      foreach (['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'] as $number) {
        $this->cards[] = sprintf("%s%s", $suit, $number);
      }
    }
    shuffle($this->cards);
  }

  // 配列で返す関数。最初に配られる2枚
  public function drawCardStartPlayer(): array
  {
    return  array_slice($this->cards, 0, 2);
  }

  public function drawCardStartDealer(): array
  {
    return  array_slice($this->cards, 2, 2);
  }

  // 文字列で返す関数。任意で引くカード
  public function drawCard(): string
  {
    $drawString = array_slice($this->cards, 0, 1);
    // 文字列に変換
    array_shift($this->cards);
    return implode($drawString);
  }
}
