{{--

Template för en ort.

Exempel på URL:
https://brottsplatskartan.localhost/plats/nacka

--}}


@extends('layouts.web')

@if ($isToday)
    @section('title', "Senaste nytt från Polisen i $plats – händelser & brott")
    @section('metaDescription', $metaDescription)
@else
    @section('title', "$dateForTitle - Brott och polishändelser i $plats. Karta med platsinfo. Information direkt från Polisen.")
@endif
@section('canonicalLink', $canonicalLink)

@section('metaContent')
    @if ($linkRelPrev)
        <link rel="prev" href="{{ $linkRelPrev }}" />
    @endif
    @if ($linkRelNext)
        <link rel="next" href="{{ $linkRelNext }}" />
    @endif
@endsection

@section('content')

    <h1>
        @if ($isToday)
            <strong>{{$plats}}</strong>: brott &amp; händelser
        @else
            Brott &amp; händelser i {{$plats}} {{$dateForTitle}}
        @endif
    </h1>

    <div class="Introtext">

        @if (empty($introtext))
            <p>Inrapporterade händelser från Polisen.</p>
        @else
            {!! $introtext !!}
        @endif

        @if ($mostCommonCrimeTypes && $mostCommonCrimeTypes->count() >= 5)
            <p>
                De 5 mest förekommande typerna av händelser här är
                @foreach ($mostCommonCrimeTypes as $oneCrimeType)
                    @if ($loop->remaining == 0)
                        och <strong>{{ mb_strtolower($oneCrimeType->parsed_title) }}</strong>.
                    @elseif ($loop->remaining == 1)
                        <strong>{{ mb_strtolower($oneCrimeType->parsed_title) }}</strong>
                    @else
                        <strong>{{ mb_strtolower($oneCrimeType->parsed_title) }}</strong>,
                    @endif
                    <!-- {{ $oneCrimeType->antal }} -->
                @endforeach
            </p>
        @endif

    </div>

    @includeWhen(!$isToday, 'parts.daynav')

    @if ($events->count())
        @include('parts.events-by-day')
    @else
        <p>Inga händelser har rapporterats från Polisen denna dag.</p>
    @endif


    @include('parts.daynav')

@endsection

@section('sidebar')

    {{--
    <div class="Stats Stats--lan">
        <h2 class="Stats__title">Brottsstatistik</h2>
        <p>Antal Polisiära händelser per dag för {{$plats}}, 14 dagar tillbaka.</p>
        <p><amp-img layout="responsive" class="Stats__image" src='{{$chartImgUrl}}' alt='Linjediagram som visar antal Polisiära händelser per dag för {{$plats}}' width=400 height=150></amp-img></p>
    </div>
    --}}

    @if ($relatedLinks)
        <section class="widget RelatedLinks">

            <h2 class="RelatedLinks__title">Relaterade länkar</h2>
            <ul class="RelatedLinks__items">
                @foreach ($relatedLinks as $relatedLink)
                    <li class="RelatedLinks__item">
                        <h3 class="RelatedLinks__title">
                            <a class="RelatedLinks__link" href="{{$relatedLink->url}}">
                                {{$relatedLink->title}}
                            </a>
                        </h3>
                        <p class="RelatedLinks__description">{{$relatedLink->desc}}</p>
                    </li>
                @endforeach
            </ul>

            @if ($plats == 'Täby')
                <amp-facebook-page
                    width="340"
                    height="440"
                    layout="responsive"
                    data-hide-cover="true"
                    data-hide-cta="true"
                    data-small-header ="true"
                    data-href="https://www.facebook.com/PolisenTaby/"
                    data-tabs="timeline"
                    >
                </amp-facebook-page>

                <amp-facebook-page
                    width="340"
                    height="440"
                    layout="responsive"
                    data-hide-cover="true"
                    data-hide-cta="true"
                    data-small-header ="true"
                    data-href="https://www.facebook.com/tabynyheter/"
                    data-tabs="timeline"
                    >
                </amp-facebook-page>
            @endif

        </section>

    @endif



    {{-- Lista närmaste polisstationerna --}}
    @if ($policeStations)
        <section class="widget">
            <h2>Polisstationer nära {{$plats}}</h2>
            @foreach ($policeStations->slice(0, 3) as $policeStation)
                <h3>
                    <a href="{{route('polisstationer')}}#{{str_slug($place->lan . '-' . $policeStation->name)}}">
                        {{$policeStation->name}}
                    </a>
                </h3>
                <p>
                    {{$policeStation->location->name}}
                </p>
                <p class="u-hidden">{{$policeStation->distance}} meter från mitten av {{$plats}}</p>
            @endforeach
        </section>
    @endif

    @include('parts.follow-us')

    @include('parts.lan-and-cities')

@endsection
