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

 </style>
 <div class="col-md-8 game-content">
    <div class="info-the-game">

        <div class="game-desc-preview" id="gameDesc">

                                    {!! $detail->description() !!}

        <br><br>
        <b>Categories</b>
        <p class="cat-list">
                                        <a href="{{ $detail->getTheloai()->slug() }}"
                                            class="cat-link">{{ $detail->getTheloai()->name() }}</a>
        </p>
        </div>

        <button class="game-desc-toggle" id="gameDescBtn">
            View more
        </button>

    </div>
</div>
<script>
const desc = document.getElementById('gameDesc');
const btn  = document.getElementById('gameDescBtn');

btn.addEventListener('click', () => {
    desc.classList.toggle('expanded');
    btn.textContent = desc.classList.contains('expanded')
        ? 'Show less'
        : 'View more';
});
</script>
