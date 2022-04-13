<?php
// 引数をとってそのカードと種類を返すクラス
// 'H7',←これがくる
class Card
{
	public function __construct(public string $hand)
  {
  }
  private const CARD_RANK = [
    //Aは仮実装
    'A' => 1,
    '2' => 2,
    '3' => 3,
    '4' => 4,
    '5' => 5,
    '6' => 6,
    '7' => 7,
    '8' => 8,
    '9' => 9,
    '10' => 10,
    'J' => 10,
    'Q' => 10,
    'K' => 10,
  ];

private const  CARD_TYPE = [
  'D' => 'ダイヤ',
  'C' => 'クローバー',
  'H' => 'ハート',
  'S' => 'スペード'
];

  public function getType(): string
  {
    return self::CARD_TYPE[mb_substr($this->hand, 0, 1)];
  }

  public function getNum(): string
  {
    return mb_substr($this->hand, 1, 2);
  }

  public function getRank(): int
  {
    // $this->cardの右側を取得
    $num = mb_substr($this->hand, 1, 2);
    return self::CARD_RANK[$num];
  }
}
