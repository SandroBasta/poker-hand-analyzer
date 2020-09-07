<?php

namespace Tests\Unit;

use App\Services\HandProcessor;
use Exception;
use PHPUnit\Framework\TestCase;

class PokerRulesTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Test higher card in hand
     * @throws Exception
     */
    public function testPlayerHighCard(){

        $playerOneHand = ['2C', '9C', '6H', '3C', '5H'];
        $playerTwoHand = ['8S', '7H', 'TC', '4C', '5C'];

        $cards = new HandProcessor();
        $analyze = $cards->analyze($playerOneHand, $playerTwoHand);
        $this->assertTrue($analyze['winner'] == 2 and $analyze['rank'] == 'Higher_Card');
    }

    /**
     * Test One Pair card in hand
     * @throws Exception
     */
    public function testPlayerOnePair(){

        $playerOneHand = ['2C', '2C', '6H', '3C', '5H'];
        $playerTwoHand = ['8S', '7H', 'TC', '4C', '5C'];

        $cards = new HandProcessor();
        $analyze = $cards->analyze($playerOneHand, $playerTwoHand);
        $this->assertTrue($analyze['winner'] == 1 and $analyze['rank'] == 'One_Pair');
    }

    /**
     * Test Two Pair in hand
     * @throws Exception
     */
    public function testPlayerTwoPair(){

        $playerOneHand = ['2C', '2C', '6H', '3C', '3H'];
        $playerTwoHand = ['8S', '7H', 'TC', '4C', '5C'];

        $cards = new HandProcessor();
        $analyze = $cards->analyze($playerOneHand, $playerTwoHand);
        $this->assertTrue($analyze['winner'] == 1 and $analyze['rank'] == 'Two_Pair');
    }

    /**
     * Test Two Pair in hand
     * @throws Exception
     */
    public function testPlayerTwoPairSameHigherCardWin(){

        $playerOneHand = ['2C', '2C', '6H', '7C', '3H'];
        $playerTwoHand = ['2S', '2H', '3C', '4C', '5C'];

        $cards = new HandProcessor();
        $analyze = $cards->analyze($playerOneHand, $playerTwoHand);
        $this->assertTrue($analyze['winner'] == 1  and $analyze['rank'] == 'One_Pair');
    }

    /**
     * Test Three of Kind in hand
     * @throws Exception
     */
    public function testPlayerThreeOfAKind(){

        $playerOneHand = ['2C', '2C', '2H', '4C', '3H'];
        $playerTwoHand = ['8S', '7H', 'TC', '4C', '5C'];

        $cards = new HandProcessor();
        $analyze = $cards->analyze($playerOneHand, $playerTwoHand);
        $this->assertTrue($analyze['winner'] == 1 and $analyze['rank'] == 'Three_of_Kind');
    }

    /**
     * Test Four of Kind card in hand
     * @throws Exception
     */
    public function testPlayerFourOfAKind(){

        $playerOneHand = ['2C', '2C', '2H', '2C', '3H'];
        $playerTwoHand = ['8S', '7H', 'TC', '4C', '5C'];

        $cards = new HandProcessor();
        $analyze = $cards->analyze($playerOneHand, $playerTwoHand);
        $this->assertTrue($analyze['winner'] == 1 and $analyze['rank'] == 'Four_of_Kind');
    }

    /**
     * Test Full House in hand
     * @throws Exception
     */
    public function testPlayerFullHouse(){

        $playerOneHand = ['2C', '2C', '2H', '3C', '3H'];
        $playerTwoHand = ['8S', '7H', 'TC', '4C', '5C'];

        $cards = new HandProcessor();
        $analyze = $cards->analyze($playerOneHand, $playerTwoHand);
        $this->assertTrue($analyze['winner'] == 1 and $analyze['rank'] == 'Full_House');
    }

    /**
     * Test Straight  in hand
     * @throws Exception
     */
    public function testPlayerStraight(){

        $playerOneHand = ['5C', '6C', '7H', '8C', '9H'];
        $playerTwoHand = ['8S', '7H', 'TC', '4C', '5C'];

        $cards = new HandProcessor();
        $analyze = $cards->analyze($playerOneHand, $playerTwoHand);
        $this->assertTrue($analyze['winner'] == 1 and $analyze['rank'] == 'Straight');
    }

    /**
     * Test higher card in hand
     * @throws Exception
     */
    public function testPlayerSmallAceStraight(){

        $playerOneHand = ['2C', '3C', '4H', '5C', 'AH'];
        $playerTwoHand = ['8S', '7H', 'TC', '4C', '5C'];

        $cards = new HandProcessor();
        $analyze = $cards->analyze($playerOneHand, $playerTwoHand);
        $this->assertTrue($analyze['winner'] == 1 and $analyze['rank'] == 'Straight');
    }

    /**
     * Test Flush d in hand
     * @throws Exception
     */
    public function testPlayerFlush(){

        $playerOneHand = ['5C', '3C', '4C', '5C', 'AC'];
        $playerTwoHand = ['8S', '7H', 'TC', '4C', '5C'];

        $cards = new HandProcessor();
        $analyze = $cards->analyze($playerOneHand, $playerTwoHand);
        $this->assertTrue($analyze['winner'] == 1 and $analyze['rank'] == 'Flush');
    }

    /**
     * Test Straight Flush in hand
     * @throws Exception
     */
    public function testPlayerStraightFlush(){

        $playerOneHand = ['2C', '3C', '4C', '5C', '6C'];
        $playerTwoHand = ['8S', '7H', 'TC', '4C', '5C'];

        $cards = new HandProcessor();
        $analyze = $cards->analyze($playerOneHand, $playerTwoHand);
        $this->assertTrue($analyze['winner'] == 1 and $analyze['rank'] == 'Straight_Flush');
    }

    /**
     * Test Royal Flush in hand
     * @throws Exception
     */
    public function testPlayerRoyalFlush(){

        $playerOneHand = ['TC', 'JC', 'QC', 'KC', 'AC'];
        $playerTwoHand = ['8S', '7H', 'TC', '4C', '5C'];

        $cards = new HandProcessor();
        $analyze = $cards->analyze($playerOneHand, $playerTwoHand);
        $this->assertTrue($analyze['winner'] == 1 and $analyze['rank'] == 'Royal_Flush');
    }
}
