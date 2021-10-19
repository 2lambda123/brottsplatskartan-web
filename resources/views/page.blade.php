{{-- Template for text pages --}}


@extends('layouts.web')

@if ($pagename == 'press')
    @section('title', 'Logotyp och beskrivning av Brottsplatskartan för press, journalister, bloggar')
@else
    {{-- default title --}}
    @section('title', $pageTitle)
@endif

@section('canonicalLink', $canonicalLink)

@section('content')

    <div class="widget">

        @if ($pagename == 'api')

            @section('canonicalLink', '/sida/api')

            <h1 class="widget__title">Brottsplats API</h1>

            <p>Brottsplatskartan har ett API med stöd för både JSON och JSONP.</p>

            <p>Använda gärna API:et för icke-kommersielltbruk och skicka med en unik <code>app</code>-parameter så vi
                kan se hur mycket olika tjänster använder API:et.</p>

            <p>För kommersiellt bruk (eller om du kommer använda API:et väldigt mycket) vänligen
                kontakta oss på <a href="mailto:kontakt@brottsplatskartan.se">kontakt@brottsplatskartan.se</a>.
                Och använd även här en app-parameter.
            </p>

            <p>Vi kan komma att blockera anrop utan app-parameterar eller appar/tjänster/sajter som använder
                API:et väldigt mycket.</p>

            <p>Ungefär cirka såhär ser URLarna för APIet ut:</p>

            <h2>Endpoints</h2>

            <h3>Hämta alla län:</h3>

            <p><code>/api/areas?app=unikAppParameter</code></p>

            <h3>Hämta händelser</h3>


            <p><code>/api/events/?app=unikAppParameter</code></p>

            <p>med stöd för parametrar:</p>


            <p><code>/api/events/?area=stockholms län</code></p>

            <p><code>/api/events/?area=uppsala län</code></p>

            <p><code>/api/events/?location=nacka</code></p>

            <p><code>/api/events/?location=visby</code></p>

            <p><code>/api/events/?type=inbrott</code></p>

            <h3>Hämta i närheten</h3>

            <p><code>/api/eventsNearby?lat=59.32&lng=18.06</code></p>

            <h3>Hämta single event</h3>

            <p><code>/api/event/4095</code></p>

        @endif


        @if ($pagename == 'om')

            @section('canonicalLink', '/sida/om')

            <h1 class="widget__title">Om brottsplatskartan.se</h1>

            <p>Brottsplatskartan är en <a href="https://brottsplatskartan.se">sajt</a> och <a href="/sida/appar">appar</a>
                som visar var brott i Sverige har skett. Typ som en poliskarta eller brottskarta.</p>

            <p>Polisen själva har en sajt där dom skriver om vilka händelser som skett, men Polisens webbplats saknas en del
                funktioner, som vi här på Brottsplatskartan försökt fixa till. T.ex.:</p>

            <ul>
                <li>Permalänkar till brott och händelser som inte försvinner (hos Polisen så slutar en länk till en
                    händelser att fungera efter en vecka ungefär)</li>

                <li>Platsen för en händelse visas på en karta (på Polisens webbsida så står det bara en adress eller område,
                    men ingen länk till karta eller liknande)</li>

                <li>Möjlighet att visa saker "nära mig" genom att använda GPS:en på en mobiltelefon (Polisen har ingen
                    liknande funktion alls)</li>
            </ul>

            <h2>Om händelserna och deras position på kartan</h2>

            <p>Informationen om de händelser som visas på webbplatserna hämtas från Polisens webbplats.</p>

            <p>Platsen för varje händelse är skapad automatiskt och det kan därför förekomma fel.</p>

            <h2>Kontakta brottsplatskartan</h2>

            <p>Har du frågor om webbplatsen eller av annan anledning
                vill komma i kontakt med oss så nås vi via Twitter på <a
                    href="https://twitter.com/brottsplatser">https://twitter.com/brottsplatser</a>,
                via Facebook på <a
                    href="https://www.facebook.com/Brottsplatskartan/">https://www.facebook.com/Brottsplatskartan/</a>
                eller via e-post på <a href="mailto:kontakt@brottsplatskartan.se">kontakt@brottsplatskartan.se</a>.
                Vänligen observera att vi inte kan svara på frågor om Polisens arbete
                eller om de händelser som presenteras här på sajten.
            </p>

            <h2>Om tjänstens skapare</h2>

            <p>
                Brottsplatskartans grundare är den kartintresserad webbutvecklaren <a
                    href="https://twitter.com/eskapism">Pär Thernström</a>.
            </p>
            <p>
                Utöver Brottsplatskartan så har han även grundat <a href="https://texttv.nu/">Text TV-sajten texttv.nu</a>
                (med tillhörande appar för
                <a href="https://itunes.apple.com/se/app/texttv-nu-svt-text-tv/id607998045?mt=8">Ios</a>
                och <a href="https://play.google.com/store/apps/details?id=com.mufflify.TextTVnu&hl=sv">Android</a>).
            </p>

            <p>
                Han är även skapare av pluginen <a href="http://simple-history.com/">Simple History</a> till WordPress,
                som på en snyggt sätt visar vilka ändringar som användarna på en WordPress-webbplats gör. Använder du
                WordPress
                borde du installera den bums!
            </p>

            <h2>Kartorna</h2>

            <p>
                Kartbilderna kommer från OpenMapTiles:
                ©&nbsp;<a href="https://openmaptiles.org/">OpenMapTiles</a>
                ©&nbsp;<a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors</a>.
            </p>

        @endif


        @if ($pagename == 'appar')

            @section('canonicalLink', '/sida/appar')

            <h1 class="widget__title">Polisens händelser direkt i din mobil</h1>

            <div class='PageApps__screenshots'>

                <a
                    href="https://lh3.googleusercontent.com/nIvqRhYj2-fzB0Pv8v2evtdDGcOJQRaSvIrz_L6wcb9oxeDrdaV2SC4l-f_iRE42ZPs=h900-rw">
                    <amp-img layout="responsive" width="506" height="900"
                        src="https://lh3.googleusercontent.com/nIvqRhYj2-fzB0Pv8v2evtdDGcOJQRaSvIrz_L6wcb9oxeDrdaV2SC4l-f_iRE42ZPs=h900-rw"
                        alt="Skärmdump som visar hur appen ser ut på en Android-telefon"></amp-img>

                    <a
                        href="http://a5.mzstatic.com/eu/r30/Purple71/v4/05/c9/3d/05c93d0e-d40c-d35a-4eb7-7ca001e36e93/screen696x696.jpeg">
                        <amp-img layout="responsive" width="392" height="596"
                            src="http://a5.mzstatic.com/eu/r30/Purple71/v4/05/c9/3d/05c93d0e-d40c-d35a-4eb7-7ca001e36e93/screen696x696.jpeg"
                            alt="Skärmdump som visar hur appen ser ut på en Iphone-telefon"></amp-img>
                    </a>

            </div>

            <p>
                Med våra brottsappar till Iphone och Android så kan du se de senaste händelserna från polisen
                direkt i din mobil.
            </p>

            <h2>Ladda hem apparna</h2>

            <p>Apparna med brottskartan hittar du här:</p>

            <ul>
                <li>
                    <a href="https://itunes.apple.com/se/app/brottsplatskartan-handelser/id1174082309?mt=8">Brottsplatskartan
                        som app till Iphone/Ipad</a>
                <li>
                    <a href="https://play.google.com/store/apps/details?id=com.mufflify.brottsplatskartan&hl=sv">Brottsplatskartan
                        som app till Android</a>
            </ul>

            <h2>Tips!</h2>

            <p>Om du gillar <a href="https://brottsplatskartan.se">hemsidan</a> mer än apparna så kan du välja att lägga ett
                bokmärke till <a href="https://brottsplatskartan.se">brottsplatskartan.se</a> på
                din hemskärm i din telefon.</p>

        @endif


        @if ($pagename == 'cookies')

            <h1 class="widget__title">Om cookies på Brottsplatskartan.se</h1>

            <h2>Vad är cookies</h2>

            <p>
                Cookies (även kallade för "kakor" på svenska) är små filer som skickas till din webbläsare och sparas av din
                webbläsare.
                De används för att lagra olika typer av information.</p>

            <h2>Cookies på Brottsplatskartan</h2>

            <p>Vi använder cookies för att mäta trafiken på vår webbplats, för statistik och för att anpassa annonser.</p>

            <h3>Nycklar och värden i cookies och local storage som sätts och används</h3>

            <h4>Local storage</h4>

            <table>
                <thead>
                    <tr>
                        <th>Namn</th>
                        <th>Domän</th>
                        <th>Syfte</th>
                        <th>Lagringstid</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>amp-store:https://brottsplatskartan.se</td>
                        <td>brottsplatskartan.se</td>
                        <td>Används för att komma ihåg dina cookies-inställningar för Brottsplatskartan</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <h2>Cookies / Kakor</h2>
            <table>
                <thead>
                    <tr>
                        <th>Namn</th>
                        <th>Domän</th>
                        <th>Syfte</th>
                        <th>Lagringstid</th>
                    </tr>
                </thead>
                <tbody>


                    <tr>
                        <td>__Secure-3PSIDCC</td>
                        <td>.google.com</td>
                    </tr>

                    <tr>
                        <td>SAPISID</td>
                        <td>.google.com</td>
                    </tr>

                    <tr>
                        <td>SSID</td>
                        <td>.google.com</td>
                    </tr>

                    <tr>
                        <td>HSID</td>
                        <td>.google.com</td>
                    </tr>

                    <tr>
                        <td>__Secure-3PSID</td>
                        <td>.google.com</td>
                    </tr>

                    <tr>
                        <td>SID</td>
                        <td>.google.com</td>
                    </tr>

                    <tr>
                        <td>__Secure-1PSID</td>
                        <td>.google.com</td>
                    </tr>

                    <tr>
                        <td>APISID</td>
                        <td>.google.com</td>
                    </tr>

                    <tr>
                        <td>SIDCC</td>
                        <td>.google.com</td>
                    </tr>

                    <tr>
                        <td>__Secure-3PAPISID</td>
                        <td>.google.com</td>
                    </tr>

                    <tr>
                        <td>__Secure-1PAPISID</td>
                        <td>.google.com</td>
                    </tr>

                    <tr>
                        <td>NID</td>
                        <td>.google.com</td>
                    </tr>

                    <tr>
                        <td>IDE</td>
                        <td>.doubleclick.net</td>
                    </tr>

                    <tr>
                        <td>DSID</td>
                        <td>.doubleclick.net</td>
                    </tr>

                    <tr>
                        <td>1P_JAR</td>
                        <td>.google.com</td>
                    </tr>

                    <tr>
                        <td>CONSENT</td>
                        <td>.google.com</td>
                    </tr>

                    <tr>
                        <td>remember_web_59ba36addc2b2f9401580f014c7f58ea4e30989d</td>
                        <td> brottsplatskartan.se</td>
                    </tr>

                    <tr>
                        <td>XSRF-TOKEN</td>
                        <td> brottsplatskartan.se</td>
                    </tr>

                    <tr>
                        <td>SEARCH_SAMESITE</td>
                        <td>.google.com</td>
                    </tr>

                    <tr>
                        <td>_ga</td>
                        <td>.brottsplatskartan.se</td>
                    </tr>

                    <tr>
                        <td>laravel_session</td>
                        <td> brottsplatskartan.se</td>
                    </tr>

                    <tr>
                        <td>S</td>
                        <td>.google.com</td>
                    </tr>

                </tbody>
            </table>


            <h2>Hur du tar bort eller inaktiverar cookies</h2>

            <p>
                Om du vill så kan du ta bort eller inaktivera cookies i din webbläsare.
                Exakt hur du gör beror på vilken webbläsare du har:
            </p>

            <ul>
                <li>
                    Chrome:
                    <br><a href="https://support.google.com/chrome/answer/95647">Rensa, aktivera och hantera cookies i
                        Chrome</a>
                </li>
                <li>
                    Safari:
                    <br><a href="https://support.apple.com/sv-se/guide/safari/sfri11471/">Hantera cookies och webbplatsdata
                        i Safari på datorn</a>
                    <br><a href="https://support.apple.com/sv-se/HT201265">Rensa historik och cookies från Safari på din
                        iPhone, iPad eller iPod touch</a>
                </li>
                <li>
                    Firefox:
                    <br><a href="https://support.mozilla.org/sv/kb/rensa-kakor-och-webbplatsdata-firefox">Rensa kakor och
                        webbplatsdata i Firefox</a>
                </li>
                <li>
                    Microsoft Edge:
                    <br>
                    <a
                        href="https://support.microsoft.com/sv-se/windows/ta-bort-och-hantera-cookies-168dab11-0753-043d-7c16-ede5947fc64d">Ta
                        bort och hantera cookies</a>
                </li>
            </ul>
        @endif


        @if ($pagename == 'press')

            <h1 class="widget__title">Press</h1>

            <h2>Vad är Brottsplatskartan?</h2>

            <p>Brottsplatskartan är en sajt och en app som visar var brott som rapporterats av polisen har skett på en
                karta. Brottsplatskartan har en unik algoritm som ritar ut en ungefärlig plats, utan att peka ut enskilda
                platser, hus eller individer.

            <h2>Snabba fakta</h2>

            <ul>

                <li>Första versionen av Brottsplatskartan kom 2010. Det var en vidareutveckling av sajten <em>Brottsplats
                        Stockholm</em>, som endast visade brott i Stockholm.</li>

                <li>2017 skedde en relansering av Brottsplatskartan. Sajten fick då sitt nuvarande
                    utseende och en mängd nya funktioner såsom bättre placering av brott på kartan, händelser från alla
                    sveriges län, och mycket mer.</li>

                <li>Feber skrev om när sajten lanserades http://feber.se/webb/art/165994/brottsplats_stockholm/</li>

                <li>Webbplatsen har 140 000 användare per månad (December 2018)</li>

                <li>75 % av användare besöker sajten via en mobiltelefon (December 2018)</li>

            </ul>

            <h2>Logotyp</h2>

            <p>
                Brottsplatskartans logotyp i PNG-format:
                <br>
                <a href="/img/brottsplatskartan-logotyp.png">
                    <amp-img src="/img/brottsplatskartan-logotyp.png" width=282 height=36 alt="Brottsplatskartan"></amp-img>
                </a>
                <br>
                <a href="/img/brottsplatskartan-logotyp.png">brottsplatskartan-logotyp.png</a> (6KB, 626✕80, PNG)
            </p>

            <!--
                <p>
                    <a href="/img/brottsplatskartan-logotyp-symbol-only.png">
                        <amp-img alt="Brottsplatskartan" src="/img/brottsplatskartan-logotyp-symbol-only.png" width=40 height=40></amp-img>
                    </a>
                </p>
                -->

            <h2>Kontakt</h2>

            <p>För frågor kontakta Brottsplatskartan via e-post <a
                    href="mailto:kontakt@brottsplatskartan.se">kontakt@brottsplatskartan.se</a>.</p>

        @endif

    </div>

@endsection

@section('sidebar')
    @include('parts.widget-blog-entries')
    @include('parts.lan-and-cities')
    @include('parts.follow-us')
@endsection
