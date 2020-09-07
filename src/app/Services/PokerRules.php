<?php

namespace App\Services;

use App\Traits\Cards;

/**
 * Class PokerRules
 * @package App\Services
 */
class PokerRules
{
    use Cards;

    const ACE = 14;

    /**
     * @var int[]
     * rank of hand, biggest rank is royal flush
     */
    protected $rank = [
        'Royal_Flush'    => 10,
        'Straight_Flush' => 9,
        'Four_of_Kind'   => 8,
        'Full_House'     => 7,
        'Flush'          => 6,
        'Straight'       => 5,
        'Three_of_Kind'  => 3,
        'Two_Pair'       => 2,
        'One_Pair'       => 1,
        'Higher_Card'    => 0
    ];

    /**
     * @param $hand
     * @return array|false
     * First we will check is flush, we are counting or values off array,
     * and if in array 5  have all 5 suits same
     * if is flush we have to check is maybe royal, straight or just flash
     * each of this hand has different rank
     */
    public function flush($hand)
    {
        $flush = $this->suit($hand);
        $result = array_count_values($flush);

        if (in_array(5, $result)) {

            if ($this->royalFlush($hand) != false) {
                return $this->rank($this->rank['Royal_Flush'], $hand);
            }
            if ($this->straightFlush($hand) != false) {
                return $this->rank($this->rank['Straight_Flush'], $hand);
            }
            return $this->rank($this->rank['Flush'], $hand);
        }
        return false;
    }

    /**
     * @param $hand
     * @return bool
     * Royal Flush function will receive sorted array of 5 cards,
     * Hand is sorted  array and if start with 10 array is royal flash
     */
    public function royalFlush($hand)
    {
        $hand = $this->value($hand);
        if (reset($hand) == 10) {
            return true;
        }
        return false;
    }

    /**
     * @param $hand
     * @return bool
     * Pass to straight function array
     */
    public function straightFlush($hand)
    {
        if ($this->straight($hand) != false) {
            return true;
        }
        return false;
    }

    /**
     * @param $hand
     * @return array|false
     * here we have check if array values are consecutive
     *
     */
    public function straight($hand)
    {
        $hand = $this->value($hand);
        $rank = $this->rank($this->rank['Straight'], $hand);
        if (reset($hand) == 10) {
            // array is sorted, if start with element = 10 is straight
            return $rank;
        }
        if (in_array(static::ACE, $hand)) {
            //we have to take scenario  2,3,4,5,14
            $hand[array_search(static::ACE, $hand)] = 1;
            sort($hand);
        }
        for ($i = 0; $i < count($hand); $i++) {
            if ($i > 0) {
                if ($hand[$i] - $hand[$i - 1] != 1) {
                    return false;
                }
            }
        }
        return $rank;
    }

    /**
     * @param $hand
     * @return array|false
     * array_count_values() returns an array using the values of array
     * as keys and their frequency in array as values.
     * Full house can be only if we have 2 and 3
     */
    public function fullHouse($hand)
    {
        $hand = $this->value($hand);
        $fullHouse = array_count_values($hand);
        if (in_array(2, $fullHouse) and in_array(3, $fullHouse)) {
            return $this->rank($this->rank['Full_House'], $hand);
        }
        return false;
    }

    /**
     * @param $hand
     * @return array|false
     * array_count_values() returns an array using the values of array
     * as keys and their frequency in array as values.
     * For of kind  can be only if we have 4
     */
    public function fourOfKind($hand)
    {
        $hand = $this->value($hand);
        $fourOfKind = array_count_values($hand);
        if (in_array(4, $fourOfKind)) {
            return $this->rank($this->rank['Four_of_Kind'], $hand);
        }
        return false;
    }

    /**
     * @param $hand
     * @return array|false
     * array_count_values() returns an array using the values of array
     * as keys and their frequency in array as values.
     * Three of kind  can be only if we have 3 in array of 3
     */
    public function threeOfAKind($hand)
    {
        $hand = $this->value($hand);
        $threeOfAKind = array_count_values($hand);
        if (count($threeOfAKind) == 3 and in_array(3, $threeOfAKind)) {
            return $this->rank($this->rank['Three_of_Kind'], $hand);
        }
        return false;
    }

    /**
     * @param $hand
     * @return array|false
     * array_count_values() returns an array using the values of array
     * as keys and their frequency in array as values.
     * Two pairs  can be only if we have 2 in array of 3
     */
    public function twoPair($hand)
    {
        $hand = $this->value($hand);
        $handPairs = array_count_values($hand);
        if (count($handPairs) == 3 and in_array(2, $handPairs)) {
            return $this->rank($this->rank['Two_Pair'], $hand);
        }
        return false;
    }

    /**
     * @param $hand
     * @return array|false
     * array_count_values() returns an array using the values of array
     * as keys and their frequency in array as values.
     * One pair   can be only if we have 2 in array of 4
     */
    public function onePair($hand)
    {
        $hand = $this->value($hand);
        $handPairs = array_count_values($hand);
        if (count($handPairs) == 4 and in_array(2, $handPairs)) {
            return $this->rank($this->rank['One_Pair'], $hand);
        }
        return false;
    }

    /**
     * @param $hand
     * @return mixed
     * return max card
     */
    public function highCard($hand)
    {
        return max($this->value($hand));
    }

    /**
     * @param $rank
     * @param $hand
     * @return array
     */
    public function rank($rank, $hand): array
    {
        return [
            'rank'       => $rank,
            'hand_value' => $hand
        ];
    }
}
