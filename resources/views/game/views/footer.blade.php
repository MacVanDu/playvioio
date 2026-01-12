<footer class="bg-black mt-4">
    <div class="container">
        <div class="row align-items-center py-4">

            <!-- Logo -->
            <div class="col-12 col-md-4 text-center text-md-start mb-3 mb-md-0">
                   <a class="navbar-brand" href="/">
                    <img src="/images/site-logo.webp" width="190" height="55" alt="Marios.games Logo">
                </a>
            </div>

            <!-- Footer links -->
            <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                <a href="/page/about" class="footer-link">About</a>
                <span>.</span>
                <a href="/page/terms-of-Service" class="footer-link">Terms of Service</a>
                <span>.</span>
                <a href="/page/privacy" class="footer-link">Privacy</a>
                <span>.</span>
                <a href="/page/contact" class="footer-link">Contact us</a>
            </div>

            <!-- Social -->
            <div class="col-12 col-md-4 text-center text-md-end">
                <a href="{{ $datamd['fb_link']   }}" class="me-2">
                    <img src="/images/fb-footer.png" width="32">
                </a>
                <a href="{{ $datamd['x_link']   }}" class="me-2">
                    <img src="/images/x-footer.png" width="32">
                </a>
                <a href="{{ $datamd['r_link']   }}">
                    <img src="/images/redit-footer.png" width="32">
                </a>
            </div>

        </div>

        <div class="text-center text-secondary small pb-3">
            © 2026 Marios.games. All rights reserved.
        </div>
    </div>
</footer>
