<div class="m1" id="mySticky">
    <div class="head">
        <div class="header-main">
            <div class="left-section">
                <div class="me1">
                    <div id="openBtn" style="padding-top:7px;">
                    <img src="http://img.apkgosu.fun/img/menu.png" alt="Games" width="40" height="30"></div>
                </div>
                <div class="lo1">
                <a href="{{ $datamd['href']==''?'/':$datamd['href']}}" title="Free Games Online" "="">
                <img width=" 108" height="28" alt="Games" src="/gb/img/apkgosu_logo05.svg"></a></div>
            </div>
            <div class="right-section">
                <div class="fa1">
                    <div id="open-favlist" class="my-games">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                        </div>
                </div>

                <div class="search1" id="hd">
                <svg fill="#fff" width="26px" height="26px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M16.3198574,14.9056439 L21.7071068,20.2928932 L20.2928932,21.7071068 L14.9056439,16.3198574 C13.5509601,17.3729184 11.8487115,18 10,18 C5.581722,18 2,14.418278 2,10 C2,5.581722 5.581722,2 10,2 C14.418278,2 18,5.581722 18,10 C18,11.8487115 17.3729184,13.5509601 16.3198574,14.9056439 Z M10,16 C13.3137085,16 16,13.3137085 16,10 C16,6.6862915 13.3137085,4 10,4 C6.6862915,4 4,6.6862915 4,10 C4,13.3137085 6.6862915,16 10,16 Z"></path>
                    </svg>
                    </div>
                <div id="se" class="search2">
                    <form method="get" action="/search">
                        <div class="search-bk"> <input class="search-input" type="text" name="name" id="name" autocomplete="off" value="" placeholder="What are you playing today?">
                            <div id="display" style="position: relative;top:-44px;"></div>
                        </div>
                    </form>
                    <div id="closeButton" class="closeButton search-close-buttton">X</div>
                </div>
            </div>
        </div>
    </div>
</div>