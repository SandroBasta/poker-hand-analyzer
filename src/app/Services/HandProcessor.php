<?php

namespace App\Services;

use Exception;

/**
 * Class HandProcessor
 * @package App\Services
 */
class HandProcessor extends PokerRules
{

    const HIGHER_CARD_RANK = 0;

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
     * @param $playerOneHand
     * @param $playerTwoHand
     * @return array
     * @throws Exception
     */
    public function analyze($playerOneHand, $playerTwoHand)
    {
        if (!count($playerOneHand) == 5
            and count($playerOneHand) == count($playerTwoHand)) {
          throw new Exception('Players hands is not valid');
        }
        return $this->processor([
            'player_one_hand' => $playerOneHand,
            'player_two_hand' => $playerTwoHand,
        ]);
    }

    /**
     * @param $request
     * @return array
     * loop will go trough all method in PokerRules class
     * and compere ranks of  players hands
     */
    public function processor($request)
    {
        for ($i = 0; $i < count($this->method); $i++) {

            $method = $this->method[$i];
            $playerOne = $this->$method($request['player_one_hand']);
            $playerTwo = $this->$method($request['player_two_hand']);

            if (isset($playerOne['rank']) or isset($playerTwo['rank'])) {

                $playerOneRank = $playerOne['rank'] ?? null;
                $playerTwoRank = $playerTwo['rank'] ?? null;

                if ($playerOneRank == $playerTwoRank) {
                    //if rank is same we have to processed and check other card value
                    $winner = $this->processHandValue(
                        $request,
                        $playerOne['hand_value'],
                        $playerTwo['hand_value']
                    );
                    return $this->response($request, $winner, $playerOneRank);
                }
                if ($playerOneRank > $playerTwoRank) {
                    return $this->response($request, $this->playerOne, $playerOneRank);

                } elseif ($playerOneRank < $playerTwoRank) {
                    return $this->response($request, $this->playerTwo, $playerTwoRank);
                }
            }
        }

        $winner = $this->processHighCard($request);
        return $this->response($request, $winner, static::HIGHER_CARD_RANK);
    }

    /**
     * @param array $request
     * @return int
     * if rank  does not exist (note a single method  satisfied)
     * if rank  does not exist (note a single method  satisfied)
     * we have to check higher card
     */
    public function processHighCard(array $request)
    {
        $playerOne = $request['player_one_hand'];
        $playerTwo = $request['player_two_hand'];
        $playerOneCard = $this->highCard($playerOne);
        $playerTwoCard = $this->highCard($playerTwo);

        if ($playerOneCard > $playerTwoCard) {
            return $this->playerOne;
        } elseif ($playerOneCard < $playerTwoCard) {
            return $this->playerTwo;
        }
        return 0;
    }

    /**
     * @param $request
     * @param $playerOne
     * @param $playerTwo
     * @return int
     * If ranks is equal we have to proceed and check hand with higher value
     */
    public function processHandValue(array $request, $playerOne, $playerTwo)
    {
        $playerHandOne = array_diff_assoc($playerOne, array_unique($playerOne));
        $playerHandTwo = array_diff_assoc($playerTwo, array_unique($playerTwo));

        if (array_sum($playerHandOne) > array_sum($playerHandTwo)) {
            return $this->playerOne;
        } elseif (array_sum($playerHandOne) < array_sum($playerHandTwo)) {
            return $this->playerTwo;
        }
        return $this->processHighCard($request);
    }

    /**
     * @param $request
     * @param $winner
     * @param $playerRank
     * @return array
     */
    public function response($request, $winner, $playerRank)
    {
        $playerRank = array_search($playerRank, $this->rank);

        return array_merge($request, [
            'winner' => $winner,
            'rank'   => $playerRank
        ]);
    }
}
