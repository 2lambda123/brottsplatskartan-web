{{--

Template för ett län

--}}


@extends('layouts.web')

@section('title', "Brott och händelser i $lan")
@section('canonicalLink', "/lan/$lan")

@section('content')

    <h1>Brott i {{ $lan }}</h1>

    <p>
        Visar alla inrapporterade händelser och brott för {{ $lan }}, direkt från polisen.
    </p>

    @if ($events)

        <div class="Events Events--overview">

            @foreach ($events as $event)

                @include('parts.crimeevent', ["overview" => true])

            @endforeach

        </div>

        {{ $events->links() }}

    @endif

@endsection
