 <style>
 /* wrapper preview */
.game-desc-preview {
    max-height: 320px;            /* desktop */
    overflow: hidden;
    position: relative;

    /* fade mượt, không che chữ */
    -webkit-mask-image: linear-gradient(to bottom, #000 72%, transparent);
    mask-image: linear-gradient(to bottom, #000 72%, transparent);

    transition: max-height 0.45s ease;
}

/* mobile */
@media (max-width: 768px) {
    .game-desc-preview {
        max-height: 220px;
    }
}

/* khi mở */
.game-desc-preview.expanded {
    max-height: 8000px;
    -webkit-mask-image: none;
    mask-image: none;
}

/* nút */
.game-desc-toggle {
    margin: 14px auto 0;
    display: block;

    padding: 8px 28px;
    border-radius: 999px;

    background: transparent;
    color: #fff;
    border: 1px solid rgba(255,255,255,.35);

    font-size: 14px;
    cursor: pointer;
    transition: all .25s ease;
}

.game-desc-toggle:hover {
    background: #ff8c00;
    border-color: #ff8c00;
    color: #000;
}
.ar
 {
    border: solid #64748b;
    border-width: 0 2px 2px 0;
    display: inline-block;
    padding: 2px;
    transform: rotate(-45deg);
    -webkit-transform: rotate(-45deg);
    margin-right: 4px;
}

 </style>
    <div class="info-the-game">

                            <div class="upt">
                                <a href="{{ $localePrefix ?: '/' }}"> {{ __('messages.home') }}</a>
                                <span class="ar"></span>
                                <a
                                    href="{{ $detail->getTheloai()->slug() }}">{{ $detail->getTheloai()->name() }}</a>
                                <span class="ar"></span>
                                <span class="we">{{ $detail->nameGame() }}</span>
                            </div>
        <div class="game-desc-preview" id="gameDesc">

                                    {!! $detail->description() !!}

        <br><br>
        <b>{{ __('messages.categories') }}</b>
        <p class="cat-list">
                                        <a href="{{ $detail->getTheloai()->slug() }}"
                                            class="cat-link">{{ $detail->getTheloai()->name() }}</a>
        </p>
        </div>

        <button class="game-desc-toggle" id="gameDescBtn">
            {{ __('messages.view_more') }}
        </button>

    </div>
<script>

</script>
