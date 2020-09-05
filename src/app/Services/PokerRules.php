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

    /**
     * @var int[]
     * rank of hand, biggest rank is royal flush
     */
    protected $rank = [
        'royal_flush'    => 10,
        'straight_flush' => 9,
        'four_of_kind'   => 8,
        'full_house'     => 7,
        'flush'          => 6,
        'straight'       => 5,
        'three_of_kind'  => 3,
        'two_pair'       => 2,
        'one_pair'       => 1
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

            $hand = $this->value($hand);

            if ($this->royalFlush($hand) != false) {
                return $this->rank($this->rank['royal_flush']);
            }
            if ($this->straightFlush($hand) != false) {
                return $this->rank($this->rank['straight_flush']);
            }
            return $this->rank($this->rank['flush']);
        }
        return false;
    }
    /**
     * @param $hand
     * @return bool
     * Royal Flush function will receive sorted array of 5 cards,
     * if array start with 10 array is royal flash
     */
    public function royalFlush($hand)
    {
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
     * we will use algorithm  (max element of array - min element of array + 1) == array.length
     * if true, then it is consecutive other wise false
     *
     */
    public function straight($hand)
    {   $hand = $this->value($hand);
        if ((max($hand) - min($hand) + 1) == count($hand)) {
           return $this->rank($this->rank['straight']);
        }
        return false;
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
            return $this->rank($this->rank['full_house']);
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
            return $this->rank($this->rank['four_of_kind']);
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
            return $this->rank($this->rank['three_of_kind']);
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
            return $this->rank($this->rank['two_pair']);
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
            return $this->rank($this->rank['one_pair']);
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
     * @return array
     */
    public function rank($rank): array
    {
        return [
            'rank' => $rank
        ];
    }
}
