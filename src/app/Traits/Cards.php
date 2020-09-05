<?php

namespace App\Traits;

/**
 * Trait Cards
 * @package App\Traits
 */
trait Cards
{
    /**
     * @param $hand
     * @return array
     * Return only suit from card hand,
     * we can understand is flush
     */
    public function suit($hand)
    {
        $suite = [];
        foreach ($hand as $k => $v) {
            $suite[] = $v[1];
        }
      return $suite;
    }
    /**
     * @param $hand
     * @return array
     * Return only value from card hand,
     * we can understand rank
     */
    public function value($hand)
    {
        $value = [];
        foreach ($hand as $k => $v) {
            $value[] = $v[0];
        }
        return $this->valueToNumber($value);
    }
    /**
     * @param $value
     * @return array
     * We are changing symbol card value to number,
     * and we are returning sorted array - card value number
     */
    public function valueToNumber($value)
    {
        $arr = [];
        foreach ($value as $number) {
            $arr[] = $this->cardsValue()[$number];
        }
        sort($arr);
        return $arr;
    }
    /**
     * @return int[]
     * This function is only for purpose of test,
     * in real env or this array will be in some config file or maybe in  db
     */
    protected function cardsValue()
    {
        return [
            'A' => 14,
            'K' => 13,
            'Q' => 12,
            'J' => 11,
            'T' => 10,
            '9' => 9,
            '8' => 8,
            '7' => 7,
            '6' => 6,
            '5' => 5,
            '4' => 4,
            '3' => 3,
            '2' => 2
        ];
    }
}
