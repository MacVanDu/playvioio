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
