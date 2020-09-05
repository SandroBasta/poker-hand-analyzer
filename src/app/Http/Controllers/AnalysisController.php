<?php


namespace App\Http\Controllers;

use App\Hand;
use App\Services\HandProcessor;
use App\Services\PokerRules;
use Illuminate\Http\Request;

/**
 * Class AnalysisController
 * @package App\Http\Controllers
 */
class AnalysisController extends Controller
{
    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:txt', 'max:2048']
        ]);

        $this->proceed($request->file('file'));
    }

    /**
     * @param $file
     */
    public function proceed($file)
    {
        //todo
    }


    public function store($playerOneHands,$playerTwoHands)
    {
        //todo
    }

}
