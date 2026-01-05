@extends('game.mobile.all')
@section('heads')
@include('game.head.index')
@endsection
@section('schema')
{!! $schema!!}
@endsection
@section('body')
<div class="c-home-game swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
  <div class="swiper-wrapper" style="transition-duration: 0ms; transition-delay: 0ms; transform: translate3d(-622.985px, 0px, 0px);" id="swiper-wrapper-93ecf5049e61bd88" aria-live="polite">
  @include('game.mobile.items.swiperslide', ['datagames' => $game_swiperslide])
  </div><span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
</div>
<div class="indicators"><span class="indicator active" data-index="0"></span><span class="indicator" data-index="1"></span><span class="indicator" data-index="2"></span><span class="indicator" data-index="3"></span><span class="indicator" data-index="4"></span></div>
<div class="container" style="margin-top:40px;">
  @include('game.mobile.items.listgame', ['datagames' => $game_infocenter])
</div>
@endsection
@section('feedback')
@endsection
@section('footer')
@endsection
@section('customModal')
    <div class="home_txt">
        <h1>Free Games Online</h1>
        <p>Our games are designed to bring fun and adventure to the whole family, catering to diverse tastes and
            interests. We offer a vast selection that includes:</p>

        <p>Games for both girls and boys, featuring a variety of activities from fashion to heroic adventures. Engaging
            two-player experiences, perfect for sharing the fun with friends or family. </p>
        <div id="openCustomModalBtn">Show More</div>
    </div>
    <div style="padding:6px;"></div>
    <div id="customModal" class="custom-modal">
        <div class="custom-modal-content">
            <div class="custom-close">×</div>
            <p></p>
            <div style="font-size:24px; margin-bottom:10px;">Free Games Online</div>
            <p>Our games are designed to bring fun and adventure to the whole family, catering to diverse tastes and
                interests. We offer a vast selection that includes:</p>

            <p>Games for both girls and boys, featuring a variety of activities from fashion to heroic adventures.
                Engaging two-player experiences, perfect for sharing the fun with friends or family. Driving
                simulations, where you can take control of <strong>cars</strong>, airplanes, or even spacecraft.
                Suspense-filled adventures, exploring fantastic worlds or traveling through time. Action-packed fighting
                and shooting games for those seeking excitement and adrenaline.</p>

            <p>Huggy Wuggy: A suspenseful and mysterious adventure where you must navigate through terrifying
                challenges, avoiding encounters with <strong>Huggy Wuggy,</strong> the iconic character from the
                survival and horror game.</p>

            <p>Creativity and exploration in the endless world of Minecraft, where you can build anything you imagine.
                Additionally, we introduce in our selection exciting universes from Roblox, terrifying adventures with
                Huggy Wuggy, captivating culinary experiences with Papa Louie, and limitless creativity in Minecraft.
            </p>

            <p><strong>Papa Louie</strong>: The Papa Louie game series invites you to take control of a restaurant, cook
                delicious dishes, and serve customers enthusiastically. Each new game adds interesting challenges and
                recipes. Minecraft: A universe of exploration and building, where players can create their own worlds,
                survive against monsters at night, or construct complex structures, all in a pixelated environment that
                stimulates creativity. Two-player games: Ideal for sharing fun with a friend or family member, these
                games offer a variety of challenges and adventures that can be played on the same device or online. From
                thrilling races to strategic battles, two-player games are a perfect way to strengthen bonds and test
                your skills together.</p>

            <p>Multiplayer games: Expanding on the dynamics of two-player games, multiplayer games throw you into
                virtual universes where you can collaborate or compete with players from around the world. Whether it's
                team adventures, epic battles, or sports competitions, multiplayer games add an extra level of
                interactivity and unpredictability.</p>

            <p>Additionally, you can enjoy fun with the most beloved princesses who beautify the Disney world: Snow
                White, Cinderella, Aurora, Ariel, Belle, Jasmine, Pocahontas, Mulan, Tiana, Rapunzel, Merida, Moana,
                Elsa, and Anna. Discover these worlds and many others in our selection of games, ideal for cozy winter
                days, adventurous summers, family holidays, or gatherings with friends. We eagerly await your joining
                our community of passionate players.</p>
            <p></p>
        </div>
    </div>
@endsection
@section('scripts')
@endsection