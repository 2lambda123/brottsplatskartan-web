<?php

namespace App\Http\Controllers;

use App\CrimeEvent;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

/**
 * Startsidan
 */
class StartController extends Controller
{

    /**
     * startpage: visa senaste händelserna, datum/dag-versionen
     * URL är som
     * https://brottsplatskartan.se/handelser/15-januari-2018
     * eller som startsida, då blir datum dagens datum
     * https://brottsplatskartan.se/
     *
     * @param string $year Year in format "december-2017"
     */
    public function day(Request $request, $date = null)
    {
        $date = \App\Helper::getdateFromDateSlug($date);

        if (!$date) {
            abort(500, 'Knas med datum hörru');
        }

        // Hämnta events från denna dag
        $events = CrimeEvent::
            whereDate('created_at', $date['date']->format('Y-m-d'))
            ->orderBy("created_at", "desc")
            ->with('locations')
            ->get();

        // $introtext_key = "introtext-start";
        // if ($page == 1) {
        //     $data["introtext"] = Markdown::parse(Setting::get($introtext_key));
        // }

        // @TODO:

        // nästa dag som har händelser
        // hämta dag + antal händelser

        // aktuellt datum + 1 dag
        // om dag är nyare än dagens datum = false
        // annars: hämta antal händelser
        $prevDaysNavInfo = \App\Helper::getPrevDaysNavInfo($date['date']);
        $nextDaysNavInfo = \App\Helper::getNextDaysNavInfo($date['date']);

        $prevDayLink = null;
        if ($prevDaysNavInfo->count()) {
            $firstDay = $prevDaysNavInfo->first();
            $firstDayDate = Carbon::parse($firstDay['dateYMD']);
            $formattedDate = trim(str::lower($firstDayDate->formatLocalized('%e-%B-%Y')));
            $formattedDateFortitle = trim($firstDayDate->formatLocalized('%A %e %B %Y'));
            $prevDayLink = [
                'title' => sprintf('‹ %1$s', $formattedDateFortitle),
                'link' => route("startDatum", ['date' => $formattedDate])
            ];
        }

        $nextDayLink = null;
        if ($nextDaysNavInfo->count()) {
            $firstDay = $nextDaysNavInfo->first();
            $firstDayDate = Carbon::parse($firstDay['dateYMD']);
            $formattedDate = trim(str::lower($firstDayDate->formatLocalized('%e-%B-%Y')));
            $formattedDateFortitle = trim($firstDayDate->formatLocalized('%A %e %B %Y'));
            $nextDayLink = [
                'title' => sprintf('%1$s ›', $formattedDateFortitle),
                'link' => route("startDatum", ['date' => $formattedDate])
            ];
        }

        $numEventsToday = \DB::table('crime_events')
                    ->whereDate('created_at', $date['date']->format('Y-m-d'))
                    ->count();

        $mostCommonCrimeTypes = CrimeEvent::selectRaw('parsed_title, count(id) as antal')
            ->whereDate('created_at', $date['date']->format('Y-m-d'))
            ->groupBy('parsed_title')
            ->orderByRaw('antal DESC')
            ->limit(5)
            ->get();

        $isToday = $date['date']->isToday();
        $isYesterday = $date['date']->isYesterday();
        $isCurrentYear = $date['date']->year == date('Y');

        // Add breadcrumbs for dates before today
        if (!$isToday) {
            // $breadcrumbs = new \Creitive\Breadcrumbs\Breadcrumbs;
            // $breadcrumbs->addCrumb('Hem', '/');
            // $breadcrumbs->addCrumb('Datum', route("start"));
            // $breadcrumbs->addCrumb('Län', route("lanOverview"));
            // $breadcrumbs->addCrumb('Alla län', route("lanOverview"));
        }

        $introtext = null;
        $introtext_key = "introtext-start";
        if ($isToday) {
            $introtext = \Markdown::parse(\Setting::get($introtext_key));
        }

        if ($isCurrentYear) {
            // Skriv inte ut datum om det är nuvarande år
            $dateLocalized = trim($date['date']->formatLocalized('%A %e %B'));
        } else {
            $dateLocalized = trim($date['date']->formatLocalized('%A %e %B %Y'));
        }

        $title = '';
        if ($isToday) {
            $title = sprintf(
                '
                    Händelser från Polisen
                    <br><strong>Idag %1$s</strong>
                ',
                $dateLocalized
            );
        } elseif ($isYesterday) {
            $title = sprintf(
                '
                    Händelser från Polisen
                    <br><strong>Igår %1$s</strong>
                ',
                $dateLocalized
            );
        } else {
            $title = sprintf(
                '
                    Händelser från Polisen
                    <br><strong>%1$s</strong>
                ',
                $dateLocalized
            );
        }

        if ($isToday) {
            $canonicalLink = route('start');
        } else {
            $canonicalLink = route(
                'startDatum',
                [
                    'date' => trim(str::lower($date['date']->formatLocalized('%e-%B-%Y')))
                ]
            );
        }

        $pageTitle = '';
        $pageMetaDescription = '';

        if ($isToday) {
            $pageTitle = 'Händelser och brott från Polisen – senaste nytt från hela Sverige';
            $pageMetaDescription = 'Läs de senaste händelserna & brotten som Polisen rapporterat. Se polishändelser ✔ nära dig ✔ i din ort ✔ i ditt län. Händelserna hämtas direkt från Polisens webbplats.';
        } else {
            $pageTitle = sprintf(
                'Händelser från Polisen %2$s - %1$d händelser',
                $numEventsToday,
                trim($date['date']->formatLocalized('%A %e %B %Y'))
            );
        }

        $data = [
            'events' => $events,
            'eventsCount' => CrimeEvent::count(),
            'showLanSwitcher' => true,
            'breadcrumbs' => isset($breadcrumbs) ? $breadcrumbs : null,
            'chartImgUrl' => \App\Helper::getStatsImageChartUrl("home"),
            'title' => $title,
            'nextDayLink' => $nextDayLink,
            'prevDayLink' => $prevDayLink,
            'linkRelPrev' => !empty($prevDayLink) ? $prevDayLink['link'] : null,
            'linkRelNext' => !empty($nextDayLink) ? $nextDayLink['link'] : null,
            'numEventsToday' => $numEventsToday,
            'isToday' => $isToday,
            'introtext' => $introtext,
            'canonicalLink' => $canonicalLink,
            'pageTitle' => $pageTitle,
            'pageMetaDescription' => $pageMetaDescription,
            'mostCommonCrimeTypes' => $mostCommonCrimeTypes,
            'dateFormattedForMostCommonCrimeTypes' => trim($date['date']->formatLocalized('%e %B'))
        ];

        return view('start', $data);
    }
}