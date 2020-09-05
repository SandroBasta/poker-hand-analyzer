<?php

namespace App\Services;

/**
 * Class HandProcessor
 * @package App\Services
 */
class HandProcessor extends PokerRules
{
    /**
     * @var string[]
     */
    protected $method = [
        'flush',
        'fourOfKind',
        'fullHouse',
        'straight',
        'threeOfAKind',
        'twoPair',
        'onePair'
    ];
    /**
     * @var int
     */
    protected $playerOne = 1;
    /**
     * @var int
     */
    protected $playerTwo = 2;
    /**
     * @var
     */
    protected $roundId;

    /**
     * HandProcessor constructor.
     */
    public function __construct()
    {
        $this->roundId = time();
    }

    /**
     * @param $playerOneHand
     * @param $playerTwoHand
     * @return array
     */
    public function analyze($playerOneHand, $playerTwoHand)
    {
        return $this->processor([
            'player_one_hand' => $playerOneHand,
            'player_two_hand' => $playerTwoHand,
        ]);
    }

    /**
     * @param $array
     * @return array
     * loop will go trough all method in PokerRules class
     * and compere ranks of  players hands
     */
    public function processor($array)
    {
        for ($i = 0; $i < count($this->method); $i++) {

            $method = $this->method[$i];
            $playerOne = $this->$method($array['player_one_hand']);
            $playerTwo = $this->$method($array['player_two_hand']);

            if (isset($playerOne['rank']) or isset($playerTwo['rank'])) {
                $playerOneRank = $playerOne['rank'] ?? null;
                $playerTwoRank = $playerTwo['rank'] ?? null;
                if ($playerOneRank > $playerTwoRank) {
                    return array_merge($array, [
                        'winner'   => $this->playerOne,
                        'round_id' => $this->roundId,
                        'rank'     => array_search($playerOneRank, $this->rank)
                    ]);
                } elseif ($playerOneRank < $playerTwoRank) {
                    return array_merge($array, [
                        'winner'   => $this->playerTwo,
                        'round_id' => $this->roundId,
                        'rank'     => array_search($playerTwoRank, $this->rank)
                    ]);
                }
                $this->processHighCard($array);
            }
        }

        return $this->processHighCard($array);
    }

    /**
     * @param array $array
     * @return array
     * if rank is equal or does not exist (note a single method  satisfied)
     * we have to check higher card
     */
    public function processHighCard(array $array)
    {
        $rank = 'high_card';
        $playerOne = $array['player_one_hand'];
        $playerTwo = $array['player_two_hand'];
        $playerOneCard = $this->highCard($playerOne);
        $playerTwoCard = $this->highCard($playerTwo);

        if ($playerOneCard > $playerTwoCard) {
            return array_merge($array, [
                'winner'   => $this->playerOne,
                'round_id' => $this->roundId,
                'rank'     => $rank
            ]);
        } elseif ($playerOneCard < $playerTwoCard) {
            return array_merge($array, [
                'winner' => $this->playerTwo,
                'rank'   => $rank
            ]);
        }
        //scenario where is high card equal
        // we will not consider in this test
        return array_merge($array, [
            'winner' => 0,
            'rank'   => $rank
        ]);
    }
}
