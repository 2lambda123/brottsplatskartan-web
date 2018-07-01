@if ($policeStations)
    <section class="LanPolicestations">
        <h2 class="LanPolicestations-title">Polisstationer</h2>
        <p class="LanPolicestations-intro">Det finns {{$policeStations['policeStations']->count()}} polisstationer i {{$policeStations['lanName']}}:</p>

        <ul class="LanPolicestations-items">
            @foreach ($policeStations['policeStations'] as $policeStation)
                <li class="LanPolicestations-item u-inline-block">
                    <a href="{{route('polisstationer')}}#{{str_slug($policeStations['lanName'] . '-' . $policeStation->name)}}">
                        {{$policeStation->name}}@if (!$loop->last), @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </section>
@endif
