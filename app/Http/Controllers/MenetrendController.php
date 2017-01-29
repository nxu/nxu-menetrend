<?php
/**
 * Created by PhpStorm.
 * User: nabun
 * Date: 2015. 12. 22.
 * Time: 14:01
 */

namespace App\Http\Controllers;

use App\Api\Schedule;
use App\Api\SettlementSearch;
use Normalizer;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MenetrendController extends Controller
{
    /**
     * @var SettlementSearch
     */
    private $settlementApi;

    /**
     * @var Schedule
     */
    private $schedule;

    public function __construct(SettlementSearch $settlementSearch,
                                Schedule $schedule)
    {
        $this->settlementApi = $settlementSearch;
        $this->schedule = $schedule;
    }

    /**
     * Shows the home page.
     *
     * @return $this
     */
    public function showHomepage()
    {
        return view('home')->with([
            'bgId'  => rand(1, 2)
        ]);
    }

    /**
     * Provides autocomplete for the bus station selection.
     *
     * @param string $term  Term to autocomplete.
     * @return string  Station list in a JSON array.
     */
    public function autocompleteStations($term)
    {
        $term = urldecode($term);
        $settlements = $this->settlementApi->getSettlementsByName($term);

        foreach ($settlements as $name => $settlementId) {
            $results[] = [
                'name' => $name,
                'settlement_id' => $settlementId
            ];
        }

        return response()->json($results);
    }

    /**
     * Gets the schedule for a given route and date.
     *
     * @param Request $request  Request object.
     * @return Response
     */
    public function getMenetrend(Request $request)
    {
        // Validate
        $this->validate($request, [
            'from_text'  => 'required|min:2',
            'to_text'    => 'required|min:2',
            'when'  => 'required|date_format:Y-m-d'
        ]);

        return response()->json($this->schedule->getSchedule(
            $request->get('from'),
            $request->get('to'),
            $request->get('when')));
    }

    /**
     * Processes the schedule request and displays it on the view
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function postScheduleRequest(Request $request)
    {
        // Validate
        $this->validate($request, [
            'from_text'  => 'required|min:2',
            'to_text'    => 'required|min:2',
            'when'  => 'required|date_format:Y-m-d'
        ]);

        $schedule = $this->schedule->getSchedule(
            $request->get('from') ?: $request->get('from_text'),
            $request->get('to') ?: $request->get('to_text'),
            $request->get('when'));

        if (is_null($schedule)) {
            return redirect('/')->with('errorMessage', 'A megadott útvonalon a megadott időben nem található járat.');
        } else {
            $from = $schedule[0]->from;
            $to = $schedule[0]->to;
            $when = new \DateTime($request->get('when'));
            $when = $when->format('Y. m. d.');
            return view('schedule')->with(compact('from', 'to', 'when', 'schedule'));
        }
    }
}
