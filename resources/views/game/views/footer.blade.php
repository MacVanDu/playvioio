@php
    $currentPath = '/' . ltrim(request()->path(), '/');
    $localeCodes = array_filter(config('locales.supported'), function ($code) {
        return $code !== config('locales.default');
    });
    $segments = explode('/', trim($currentPath, '/'));

    if (isset($segments[0]) && in_array($segments[0], $localeCodes, true)) {
        array_shift($segments);
        $currentPath = '/' . implode('/', $segments);
    }

    $currentPath = $currentPath === '/' ? '' : $currentPath;
    $currentLocaleCode = $currentLocale ?? config('locales.default', 'en');
@endphp

<style>
    .footer-language {
        position: relative;
        display: inline-flex;
        vertical-align: middle;
    }

    .footer-language-toggle {
        width: 42px;
        height: 42px;
        border: 1px solid rgba(255, 255, 255, .28);
        border-radius: 10px;
        background: #1f1f1f;
        color: #fff;
        font-size: 15px;
        font-weight: 800;
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 22px rgba(0, 0, 0, .25);
    }

    .footer-language-menu {
        position: absolute;
        right: 0;
        bottom: 50px;
        min-width: 180px;
        padding: 8px;
        border-radius: 12px;
        background: #1f1f1f;
        border: 1px solid rgba(255, 255, 255, .15);
        box-shadow: 0 14px 34px rgba(0, 0, 0, .38);
        display: none;
        z-index: 20;
    }

    .footer-language.open .footer-language-menu {
        display: block;
    }

    .footer-language-option {
        display: block;
        padding: 9px 11px;
        border-radius: 8px;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        text-align: left;
        text-decoration: none;
        white-space: nowrap;
    }

    .footer-language-option:hover,
    .footer-language-option.active {
        color: #fff;
        background: #ff7438;
    }
</style>

<footer class="bg-black mt-4" style="background-color: #5121f0 !important;">
    <div class="container">
        <div class="row align-items-center py-4">
            <div class="col-12 col-md-4 text-center text-md-start mb-3 mb-md-0">
                <a class="navbar-brand" href="{{ $localePrefix ?: '/' }}">
                    <img src="/images/site-logo.webp" width="190" height="55" alt="Marios.games Logo">
                </a>
            </div>

            <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                <a href="{{ $localePrefix }}/page/about" class="footer-link">{{ __('messages.about') }}</a>
                <span>.</span>
                <a href="{{ $localePrefix }}/page/terms-of-Service" class="footer-link">{{ __('messages.terms') }}</a>
                <span>.</span>
                <a href="{{ $localePrefix }}/page/privacy" class="footer-link">{{ __('messages.privacy') }}</a>
                <span>.</span>
                <a href="{{ $localePrefix }}/page/contact" class="footer-link">{{ __('messages.contact_us') }}</a>
            </div>

            <div class="col-12 col-md-4 text-center text-md-end">
                <div class="footer-language me-2">
                    <button class="footer-language-toggle" type="button" aria-label="Change language" aria-expanded="false">
                        {{ strtoupper($currentLocaleCode) }}
                    </button>
                    <div class="footer-language-menu">
                        @foreach(config('locales.supported_text') as $code => $label)
                            @php
                                $href = $code === '' ? url($currentPath ?: '/') : url('/' . $code . $currentPath);
                                $optionLocale = $code === '' ? config('locales.default', 'en') : $code;
                            @endphp
                            <a class="footer-language-option {{ $optionLocale === $currentLocaleCode ? 'active' : '' }}" href="{{ $href }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ $datamd['fb_link'] }}" class="me-2">
                    <img src="/images/fb-footer.png" width="32">
                </a>
                <a href="{{ $datamd['x_link'] }}" class="me-2">
                    <img src="/images/x-footer.png" width="32">
                </a>
                <a href="{{ $datamd['r_link'] }}">
                    <img src="/images/redit-footer.png" width="32">
                </a>
            </div>
        </div>

        <div class="text-center text-secondary small pb-3">
            © 2026 Marios.games. {{ __('messages.rights') }}
        </div>
    </div>
</footer>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const picker = document.querySelector('.footer-language');
    if (!picker) {
        return;
    }

    const button = picker.querySelector('.footer-language-toggle');

    button.addEventListener('click', function (event) {
        event.stopPropagation();
        const isOpen = picker.classList.toggle('open');
        button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    document.addEventListener('click', function () {
        picker.classList.remove('open');
        button.setAttribute('aria-expanded', 'false');
    });
});
</script>
