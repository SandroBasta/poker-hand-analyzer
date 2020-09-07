<?php


namespace App\Http\Controllers;

use App\Round;
use Exception;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\HandProcessor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class AnalysisController
 * @package App\Http\Controllers
 */
class AnalysisController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:txt', 'max:2048']
        ]);

        $this->proceed($request->file('file'));
        return redirect()->route('show');
    }

    /**
     * @param $file
     * @throws Exception
     */
    public function proceed($file)
    {
        // truncating hands table
        Round::truncate();
        $handsProcessor = new HandProcessor();
        $handsTxt = fopen($file, 'r');
        while (!feof($handsTxt)) {
            $hands = trim(fgets($handsTxt));
            if (!empty($hands)) {
                $cards = array_chunk(explode(' ', $hands), 5);
                $playerCards = $handsProcessor->analyze($cards[0], $cards[1]);
                $this->store($playerCards);
            }
        }
    }

    /**
     * @param $playerCards
     * we will store players hands like json array,
     * like this we have possibility to make api features
     * {"player_one":["8C","TS","KC","9H","4S"],"player_two":["7D","2S","5D","3S","AC"]}
     */
    public function store($playerCards)
    {
        $json = json_encode([
            'player_one' => $playerCards['player_one_hand'],
            'player_two' => $playerCards['player_two_hand']
        ]);

        Round::create([
            'cards'  => $json,
            'winner' => $playerCards['winner'],
            'rank'   => $playerCards['rank']
        ]);
    }

    /**
     * @return Application|Factory|View
     * Here we will just take wins of player one
     */
    public function show()
    {
        $playersOneWins = Round::where('winner', 1)->count();
        $playersTwoWins = Round::where('winner', 2)->count();
        return view('show', compact('playersOneWins','playersTwoWins'));
    }
}
