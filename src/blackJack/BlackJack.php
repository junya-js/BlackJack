
<?php

require_once(__DIR__ . '/Card.php');
require_once(__DIR__ . '/Deck.php');

// Aを1点あるいは11点のどちらかで扱うようにプログラムを修正しましょう。Aはカードの合計値が21以内で最大となる方で数えるようにします。

class BlackJack
{
    public function start()
    {
        $deck = new Deck();
        $playerCards = $deck->drawCardStartPlayer();
        $dealerCards = $deck->drawCardStartDealer();
        echo 'ブラックジャックを開始します。' . PHP_EOL;

        $playerHand = array_map(fn ($hand) => new Card($hand), $playerCards); //Cardインスタンス
        echo "あなたの引いたカードの1枚目は{$playerHand[0]->getType()}の{$playerHand[0]->getNum()}です。" . PHP_EOL;
        echo "あなたの引いたカードの2枚目は{$playerHand[1]->getType()}の{$playerHand[1]->getNum()}です。" . PHP_EOL;

        $playerTotal = $this->culCards($playerHand);

        if ($playerTotal === 21) {
            echo 'ブラックジャックです' . PHP_EOL;
        }

        $dealerHand = array_map(fn ($hand) => new Card($hand), $dealerCards);
        $dealerTotal = $this->culCards($dealerHand);

        echo "ディーラーの引いたカードの1枚目は{$dealerHand[0]->getType()}の{$dealerHand[0]->getNum()}です。" . PHP_EOL;

        // プレイヤーが初手ブラックジャックの場合
        if ($playerTotal === 21) {
            if ($dealerTotal === 21) {
                echo "ディーラーの引いた2枚目のカードは{$dealerHand[1]->getType()}の{$dealerHand[1]->getNum()}でした。" . PHP_EOL;
                echo 'ブラックジャックです' . PHP_EOL;
                goto judgement;
            }
            echo "ディーラーの引いた2枚目のカードは{$dealerHand[1]->getType()}の{$dealerHand[1]->getNum()}でした。" . PHP_EOL;

            // ディーラーがカードを引くところまでgoto
            goto dealerDraw;
        } elseif (($dealerTotal === 21)) {
            echo "ディーラーの引いた2枚目のカードは{$dealerHand[1]->getType()}の{$dealerHand[1]->getNum()}でした。" . PHP_EOL;
            echo 'ブラックジャックです' . PHP_EOL;
            goto judgement;
        }

        // プレイヤーがブラックジャックでは無く、ディーラーもブラックジャックではない ↓↓----------------------
        echo "ディーラーの引いたカードの2枚目は分かりません" . PHP_EOL;

        while ($playerTotal < 21 || $playerTotal[0] < 21) {
            if (is_int($playerTotal)) {
                echo "あなたの現在の得点は{$playerTotal}です。カードを引きますか？(y/n)" . PHP_EOL;
            } elseif (is_array($playerTotal)) {
                echo "あなたの現在の得点は{$playerTotal[0]}、もしくは{$playerTotal[1]}です。カードを引きますか？(y/n)" . PHP_EOL;
            }

            $drawOrStop = trim(fgets(STDIN));
            if ($drawOrStop === 'y') {
                $playerHand[] = new Card($deck->drawCard());
                $drawType = end($playerHand)->getType();
                $drawCard = end($playerHand)->getNum();
                echo "あなたの引いたカードは{$drawType}の{$drawCard}です。" . PHP_EOL;

                $playerTotal = $this->culCards($playerHand);

                // ブラックジャックであるか
                if ($playerTotal === 21) {
                    echo 'ブラックジャックです' . PHP_EOL;
                    // goto ディーラーがカードを引く
                }
                // ドボンであるかどうかの判定する
                if ($playerTotal >= 22) {
                    echo "21点を超えました。あなたの負けです" . PHP_EOL;
                    goto goodbye;
                }
            } elseif ($drawOrStop === 'n') {
                break;
            } else {;
                //それ以外 ループ先頭に戻る
            }
        }

        dealerDraw:
        echo "ディーラーの引いた2枚目のカードは{$dealerHand[1]->getType()}の{$dealerHand[1]->getNum()}でした。" . PHP_EOL;

        $dealerTotal = $this->culCards($dealerHand);

        if (is_array($dealerTotal)) {
            $dealerTotal = $dealerTotal[0];
        }

        while (($dealerTotal < $playerTotal)) {
            while ($dealerTotal <= 17) {
                $dealerTotal = $this->culCards($dealerHand);
                $this->isArrayOrInt($dealerTotal);

                $dealerHand[] = new Card($deck->drawCard());
                $drawType = end($dealerHand)->getType();
                $drawCard = end($dealerHand)->getNum();
                echo "ディーラーの引いたカードは{$drawType}の{$drawCard}です。" . PHP_EOL;

                $dealerTotal = $this->culCards($dealerHand);

                if ($dealerTotal === 21) {
                    echo 'ブラックジャックです' . PHP_EOL;
                    goto judgement;
                }
                // ドボンであるかどうかの判定する
                if ($dealerTotal >= 22) {
                    echo "21点を超えました。" . PHP_EOL;
                    $dealerTotal = 22;
                    goto judgement;
                }

                if (is_array($dealerTotal)) {
                    $dealerTotal = $dealerTotal[1];
                }
            }
        }

        judgement:
        $this->judge($playerTotal, $dealerTotal);

        goodbye:
        echo 'ブラックジャックを終了します' . PHP_EOL;
        exit;
    }

    // ------------------------------------------------------------------------------------------------↓関数

    public function culCards(array $cards)
    {
        foreach ($cards as $card) {
            $getRankHand[] = $card->getRank();
            $getNumHand[] = $card->getNum();
        }
        $playerTotal = array_sum($getRankHand);
        // 手札にAがある場合の処理
        if (in_array('A', $getNumHand)) {
            if (($playerTotal === 11) || ($playerTotal === 21)) {
                return 21;
            } elseif ($playerTotal <= 10) {
                return  [$playerTotal, ($playerTotal + 10)];
                // Aを１点として扱う$playerTotalと$playerTotal　＋　１０の配列で返却
            }
        }
        return  $playerTotal;
    }

    public function judge($player, $dealer): void
    {
        if (is_array($player)) {
            $player = end($player);
        }
        echo "あなたの得点は{$player}です。" . PHP_EOL;

        if (is_array($dealer)) {
            $dealer = end($dealer);
        }
        echo "ディーラーの得点は{$dealer}です。" . PHP_EOL;

        if ((($player < 22) && ($player > $dealer)) || ($player <= 21 && $dealer >= 22)) {
            echo 'あなたの勝ちです' . PHP_EOL;
        } elseif (($dealer < 22) && ($player < $dealer)) {
            echo 'ディーラーの勝ちです' . PHP_EOL;
        } elseif ($player === $dealer) {
            echo '引き分けです' . PHP_EOL;
        }
    }

    public function isArrayOrInt($total)
    {
        if (is_array($total)) {
            echo "ディーラーの現在の得点は{$total[0]}、もしくは{$total[1]}です。ディーラーがカードを引きます。" . PHP_EOL;
        }
        if (is_int($total)) {
            echo "ディーラーの現在の得点は{$total}です。ディーラーがカードを引きます。" . PHP_EOL;
        }
    }
}
