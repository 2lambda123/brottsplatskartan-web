<?php

namespace App\Http\Controllers;

use App\CrimeEvent;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

/**
 * Controller för län, översikt och detalj
 */
class LanController extends Controller
{
    /**
     * Ett län, t.ex. Stockholms län
     *
     * URL är t.ex.
     * https://brottsplatskartan.localhost/lan/Stockholms%20l%C3%A4n
     *
     * Med paginering är URL t.ex.
     * https://brottsplatskartan.localhost/lan/Stockholms%20l%C3%A4n?page=2
     *
     * @param string $lan Namn på län, t.ex. "Stockholms län". Kan även vara "stockholms-län" (med minusstreck)
     * @param Request $request Illuminate request
     */
    public function lan($lan, Request $request)
    {

        // Om län innehåller minustecken ersätter vi det med mellanslag, pga lagrar länen icke-slug'ade
        $lan = str_replace('-', ' ', $lan);

        $page = (int) $request->input("page", 1);

        if (!$page) {
            $page = 1;
        }

        $events = CrimeEvent::orderBy("created_at", "desc")
                                    ->where("administrative_area_level_1", $lan)
                                    ->with('locations')
                                    ->paginate(10);

        // Hämta mest vanligt förekommande brotten
        $mostCommonCrimeTypes = CrimeEvent::selectRaw('parsed_title, count(id) as antal')
            ->where("administrative_area_level_1", $lan)
            ->groupBy('parsed_title')
            ->orderByRaw('antal DESC')
            ->limit(5)
            ->get();

        $linkRelPrev = null;
        $linkRelNext = null;

        if ($page > 1) {
            $linkRelPrev = route('lanSingle', [
                'lan' => $lan,
                'page' => $page - 1
            ]);
        }

        if ($page < $events->lastpage()) {
            $linkRelNext = route('lanSingle', [
                'lan' => $lan,
                'page' => $page + 1
            ]);
        }

        if ($page == 1) {
            $canonicalLink = route('lanSingle', ['lan' => $lan]);
        } else {
            $canonicalLink = route('lanSingle', ['lan' => $lan, 'page' => $page]);
        }

        $data = [
            'events' => $events,
            'lan' => $lan,
            'page' => $page,
            'linkRelPrev' => $linkRelPrev,
            'linkRelNext' => $linkRelNext,
            'canonicalLink' => $canonicalLink,
            'mostCommonCrimeTypes' => $mostCommonCrimeTypes
        ];

        if (!$data["events"]->count()) {
            abort(404);
        }

        $breadcrumbs = new \Creitive\Breadcrumbs\Breadcrumbs;
        $breadcrumbs->addCrumb('Hem', '/');
        $breadcrumbs->addCrumb('Län', route("lanOverview"));
        $breadcrumbs->addCrumb(e($lan), e($lan));

        $data["breadcrumbs"] = $breadcrumbs;
        $data["showLanSwitcher"] = true;

        // Kolla om förklarande text för län finns
        // key = like "introtext-lan-Stockholms län"
        $introtext_key = "introtext-lan-$lan";
        $data["introtext"] = \Markdown::parse(\Setting::get($introtext_key));

        // Hämta statistik för ett län
        $data["lanChartImgUrl"] = \App\Helper::getStatsImageChartUrl($lan);

        $data["lanInfo"] = \App\Helper::getSingleLanWithStats($lan);


        $mostCommonCrimeTypesMetaDescString = '';
        foreach ($mostCommonCrimeTypes as $oneCrimeType) {
            $mostCommonCrimeTypesMetaDescString .= $oneCrimeType->parsed_title . ', ';
        }
        $mostCommonCrimeTypesMetaDescString = trim($mostCommonCrimeTypesMetaDescString, ', ');

        $metaDescription = "Se var brott sker i närheten av {$lan}. Vanliga händelser i {$lan} är: {$mostCommonCrimeTypesMetaDescString}. Informationen kommer direkt från Polisen till vår karta.";

        $data['metaDescription'] = $metaDescription;

        return view('single-lan', $data);
    }

    /**
     * Lista alla län
     *
     * URL är
     * https://brottsplatskartan.se/lan/
     */
    public function listLan(Request $request)
    {
        $data = [];

        // some old pages are indexed by google like this
        // "brottsplatskartan.se/lan?lan=/lan/orebro-lan
        $old_lan_query = $request->input("lan");

        if ($old_lan_query) {
            // /lan/orebro-lan
            $old_lan_query = str_replace('/lan/', '', $old_lan_query);
            $redirect_to = "lan/{$old_lan_query}";
            return redirect($redirect_to, 301);
        }

        $lan = \App\Helper::getAllLanWithStats();
        $data["lan"] = $lan;

        $breadcrumbs = new \Creitive\Breadcrumbs\Breadcrumbs;
        $breadcrumbs->addCrumb('Hem', '/');
        $breadcrumbs->addCrumb('Län', route("lanOverview"));

        $data["breadcrumbs"] = $breadcrumbs;

        return view('overview-lan', $data);
    }

    /**
     * Visa händelser för ett län ett specifikt datum.
     *
     * URL är t.ex.
     * https://brottsplatskartan.se/lan/Stockholms%20l%C3%A4n/handelser/3-februari-2018
     */
    public function day(Request $request, $lan, $date = null)
    {
        $date = \App\Helper::getdateFromDateSlug($date);

        if (!$date) {
            abort(500, 'Knas med datum hörru');
        }

        // Om län innehåller minustecken ersätter vi det med mellanslag, pga lagrar länen icke-slug'ade
        $lan = str_replace('-', ' ', $lan);

        // Hämta alla händelser för detta datum.
        $events = CrimeEvent::orderBy("created_at", "desc")
            ->whereDate('created_at', $date['date']->format('Y-m-d'))
            ->where("administrative_area_level_1", $lan)
            ->with('locations')
            ->get();

        // Hämta mest vanligt förekommande brotten
        $mostCommonCrimeTypes = CrimeEvent::selectRaw('parsed_title, count(id) as antal')
            ->whereDate('created_at', $date['date']->format('Y-m-d'))
            ->where("administrative_area_level_1", $lan)
            ->groupBy('parsed_title')
            ->orderByRaw('antal DESC')
            ->limit(5)
            ->get();
        $prevDaysNavInfo = \App\Helper::getLanPrevDaysNavInfo($date['date'], $lan);
        $nextDaysNavInfo = \App\Helper::getLanNextDaysNavInfo($date['date'], $lan);

        $prevDayLink = null;
        if ($prevDaysNavInfo->count()) {
            $firstDay = $prevDaysNavInfo->first();
            $firstDayDate = Carbon::parse($firstDay['dateYMD']);
            $formattedDate = trim(str::lower($firstDayDate->formatLocalized('%e-%B-%Y')));
            $formattedDateFortitle = trim($firstDayDate->formatLocalized('%A %e %B %Y'));
            $prevDayLink = [
                'title' => sprintf('‹ %1$s', $formattedDateFortitle),
                'link' => route("lanDate", ['lan' => $lan, 'date' => $formattedDate])
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
                'link' => route("lanDate", ['lan' => $lan, 'date' => $formattedDate])
            ];
        }

        $isToday = $date['date']->isToday();
        $isYesterday = $date['date']->isYesterday();
        $isCurrentYear = $date['date']->year == date('Y');

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
                    Händelser i %2$s
                    <strong>idag</strong>
                ',
                $dateLocalized,
                $lan
            );
        } elseif ($isYesterday) {
            $title = sprintf(
                '
                    Händelser i %2$s
                    <br><strong>igår %1$s</strong>
                ',
                $dateLocalized,
                $lan
            );
        } else {
            $title = sprintf(
                '
                    Polisen i %2$s
                    <br>
                    <strong>
                        Händelser
                        %1$s
                    </strong>
                ',
                $dateLocalized,
                $lan
            );
        }

        if ($isToday) {
            $canonicalLink = route('lanSingle', ['lan' => $lan]);
        } else {
            $canonicalLink = route(
                'lanDate',
                [
                    'lan' => $lan,
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
                $events->count(),
                trim($date['date']->formatLocalized('%A %e %B %Y'))
            );
        }

        $data = [
            'title' => $title,
            'events' => $events,
            'lan' => $lan,
            'linkRelPrev' => !empty($prevDayLink) ? $prevDayLink['link'] : null,
            'linkRelNext' => !empty($nextDayLink) ? $nextDayLink['link'] : null,
            'nextDayLink' => $nextDayLink,
            'prevDayLink' => $prevDayLink,
            'canonicalLink' => $canonicalLink,
            'mostCommonCrimeTypes' => $mostCommonCrimeTypes,
            'dateFormattedForMostCommonCrimeTypes' => trim($date['date']->formatLocalized('%e %B')),
            'isToday' => $isToday,
            'isYesterday' => $isYesterday,
            'isCurrentYear' => $isCurrentYear,
            'numEventsToday' => $events->count()
        ];

        if (!$data["events"]->count()) {
            abort(404);
        }

        $breadcrumbs = new \Creitive\Breadcrumbs\Breadcrumbs;
        $breadcrumbs->addCrumb('Hem', '/');
        $breadcrumbs->addCrumb('Län', route("lanOverview"));
        $breadcrumbs->addCrumb(e($lan), e($lan));

        $data["breadcrumbs"] = $breadcrumbs;
        $data["showLanSwitcher"] = true;

        // Kolla om förklarande text för län finns
        // key = like "introtext-lan-Stockholms län"
        $introtext_key = "introtext-lan-$lan";
        $data["introtext"] = \Markdown::parse(\Setting::get($introtext_key));

        // Hämta statistik för ett län
        $data["lanChartImgUrl"] = \App\Helper::getStatsImageChartUrl($lan);

        $data["lanInfo"] = \App\Helper::getSingleLanWithStats($lan);

        $mostCommonCrimeTypesMetaDescString = '';
        foreach ($mostCommonCrimeTypes as $oneCrimeType) {
            $mostCommonCrimeTypesMetaDescString .= $oneCrimeType->parsed_title . ', ';
        }
        $mostCommonCrimeTypesMetaDescString = trim($mostCommonCrimeTypesMetaDescString, ', ');

        $metaDescription = "Se var brott sker i närheten av {$lan}. Vanliga händelser i {$lan} är: {$mostCommonCrimeTypesMetaDescString}. Informationen kommer direkt från Polisen till vår karta.";

        $data['metaDescription'] = $metaDescription;
        $data['mostCommonCrimeTypes'] = $mostCommonCrimeTypes;

        return view('single-lan', $data);
    }
}
