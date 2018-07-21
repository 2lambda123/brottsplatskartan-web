{{--

Template for geo results

--}}


@extends('layouts.web')

@section('title', 'Se brott som hänt nära dig')
@section('metaDescription', e('Brottsplatskartan visar brott i hela Sverige och hämtar informationen direkt från Polisen.'))

@section('content')

    <div class="widget">

        <h1 class="widget__title">
            Senaste brotten nära dig

            @if (isset($showLanSwitcher))
                <a class="Breadcrumbs__switchLan" href="{{ route("lanOverview") }}">Välj län</a>
            @endif
        </h1>

        @if ($events)
            <!-- Antal brott hämtade: {{ $events->count() }} -->
            <p>
                Visar de senaste brotten som rapporterats inom ungefär {{ $nearbyInKm }} km från din plats.
                Nyaste brotten visas först.
            </p>

            <!-- Antal försök: {{ $numTries }} -->

            @includeWhen($eventsByDay->count(), 'parts.events-by-day', ["overview" => true])

        @endif

        @if (isset($error) && $error)
            <p>
                Kunde inte avgöra din position.
                <a href="/geo.php">Försök igen</a>
            </p>
            <p>
                <i>Nära mig</i> fungerar bäst i din mobiltelefon.
                Använder du en dator kan du <a href="/lan/">välja län manuellt</a> för att se senaste händelserna i ditt län eller <a href="/">se senaste händelserna i hela Sverige</a>.
            </p>
        @endif

    </div>

@endsection

@section('sidebar')
    @include('parts.lan-and-cities')
    @include('parts.follow-us')
@endsection
