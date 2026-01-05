
      <div class="css3 gameplay gamep" style="grid-area: game;">
        <div class="butlist">
          <div id="rating" data-game-id="{{ $detail->id }}">
            <div class="rating">
              <div class="bt5">
                <div class="icon-bt5 fa-thumbs-o-up thumbs-up likes tooltip" data-tooltip="Like" id="thumbs-up">
                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path
                      d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3">
                    </path>
                  </svg>
                  <span>{{$detail->likes()}}</span>
                </div>
                <div class="icon-bt5 fa-thumbs-o-down thumbs-down dislikes tooltip" data-tooltip="Dislike"
                  id="thumbs-down">
                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path
                      d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17">
                    </path>
                  </svg>
                  <span>{{$detail->dislikes()}}</span>
                </div>
              </div>
            </div>
            <div class="icon-bt5 tooltip" data-tooltip="Add to Favorite Games" id="add-to-favorites">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                  d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                </path>
              </svg>
            </div>
            <div class="icon-bt5 view-modal  tooltip" data-tooltip="Share">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="18" cy="5" r="3"></circle>
                <circle cx="6" cy="12" r="3"></circle>
                <circle cx="18" cy="19" r="3"></circle>
                <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
              </svg>
            </div>
            <div class="icon-bt5 add-button tooltip" data-tooltip="Add Avatar as an app" onclick="ga(" send", " event"
              , " PWA" , " PWA-Desktop-Install" , " PWA-Desktop-Install" );">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2"
                stroke-linecap="square" stroke-linejoin="arcs">
                <path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 9l-5 5-5-5M12 12.8V2.5"></path>
              </svg>
            </div>
            <div class="icon-bt5 report tooltip" data-tooltip="Report a bug" id="reportButton">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                  d="M4 15L17.865 15C18.7128 15 19.176 14.0111 18.6332 13.3598L15 9L18.6332 4.64018C19.176 3.98886 18.7128 3 17.865 3L4 3L4 21" />
              </svg>
            </div>
            <div class="icon-bt5 report tooltip" data-tooltip="Full Screen" id="fullscreen">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                 <path d="M3,15 L3.11662113,15.0067277 C3.57570299,15.0600494 3.93995063,15.424297 3.99327227,15.8833789 L4,16 L4,20 L8,20 L8.11662113,20.0067277 C8.61395981,20.0644928 9,20.4871642 9,21 C9,21.5128358 8.61395981,21.9355072 8.11662113,21.9932723 L8,22 L3,22 L2.88337887,21.9932723 C2.42429701,21.9399506 2.06004937,21.575703 2.00672773,21.1166211 L2,21 L2,16 L2.00672773,15.8833789 C2.06004937,15.424297 2.42429701,15.0600494 2.88337887,15.0067277 L3,15 Z M21,15 C21.5128358,15 21.9355072,15.3860402 21.9932723,15.8833789 L22,16 L22,21 C22,21.5128358 21.6139598,21.9355072 21.1166211,21.9932723 L21,22 L16,22 C15.4477153,22 15,21.5522847 15,21 C15,20.4871642 15.3860402,20.0644928 15.8833789,20.0067277 L16,20 L20,20 L20,16 C20,15.4871642 20.3860402,15.0644928 20.8833789,15.0067277 L21,15 Z M8,2 C8.55228475,2 9,2.44771525 9,3 C9,3.51283584 8.61395981,3.93550716 8.11662113,3.99327227 L8,4 L4,4 L4,8 C4,8.51283584 3.61395981,8.93550716 3.11662113,8.99327227 L3,9 C2.48716416,9 2.06449284,8.61395981 2.00672773,8.11662113 L2,8 L2,3 C2,2.48716416 2.38604019,2.06449284 2.88337887,2.00672773 L3,2 L8,2 Z M21,2 L21.1166211,2.00672773 C21.575703,2.06004937 21.9399506,2.42429701 21.9932723,2.88337887 L22,3 L22,8 L21.9932723,8.11662113 C21.9399506,8.57570299 21.575703,8.93995063 21.1166211,8.99327227 L21,9 L20.8833789,8.99327227 C20.424297,8.93995063 20.0600494,8.57570299 20.0067277,8.11662113 L20,8 L20,4 L16,4 L15.8833789,3.99327227 C15.3860402,3.93550716 15,3.51283584 15,3 C15,2.48716416 15.3860402,2.06449284 15.8833789,2.00672773 L16,2 L21,2 Z"/>
              </svg>
            </div>
          </div>
        </div>
        <div class="str-main">
          <div class="game-block">
            <div id="game" data-src="{{$detail->getLinkIframe()}}"></div>
            <div class="game-plug">
              <div class="game-plug-video">
                <figure class="video_play fit-cover gamenow"><img src="{{$detail->linkImgGame()}}" width="400"
                    height="225" alt="{{$detail->name}}" decoding="async"></figure>
                <div class="video-overlay"></div>
                <div class="game-plug-cont">
                  <img class="gamenow imgp" src="{{$detail->linkImgGame()}}"  width="200" height="120" alt="{{$detail->name}}"
                    decoding="async">
                  <div class="rate">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                      width="20" height="20" viewBox="0 0 256 256" xml:space="preserve">
                      <defs></defs>
                      <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                        transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                        <path
                          d="M 45 2.024 C 45 2.024 45 2.024 45 2.024 c -1.398 0 -2.649 0.778 -3.268 2.031 L 29.959 27.911 c -0.099 0.2 -0.29 0.338 -0.51 0.37 L 3.122 32.107 c -1.383 0.201 -2.509 1.151 -2.941 2.48 c -0.432 1.329 -0.079 2.76 0.922 3.736 l 19.049 18.569 c 0.16 0.156 0.233 0.38 0.195 0.599 L 15.85 83.71 c -0.236 1.377 0.319 2.743 1.449 3.564 c 1.129 0.821 2.6 0.927 3.839 0.279 l 23.547 -12.381 c 0.098 -0.051 0.206 -0.077 0.314 -0.077 C 51.721 53.905 50.301 28.878 45 2.024 z"
                          style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,200,80); fill-rule: nonzero; opacity: 1;"
                          transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <path
                          d="M 45 2.024 C 45 2.024 45 2.024 45 2.024 c 1.398 0 2.649 0.778 3.268 2.031 l 11.773 23.856 c 0.099 0.2 0.29 0.338 0.51 0.37 l 26.326 3.826 c 1.383 0.201 2.509 1.151 2.941 2.48 c 0.432 1.329 0.079 2.76 -0.922 3.736 L 69.847 56.892 c -0.16 0.156 -0.233 0.38 -0.195 0.599 L 74.15 83.71 c 0.236 1.377 -0.319 2.743 -1.449 3.564 c -1.129 0.821 -2.6 0.927 -3.839 0.279 L 45.315 75.172 c -0.098 -0.051 -0.206 -0.077 -0.314 -0.077 C 37.08 54.593 38.849 29.395 45 2.024 z"
                          style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,220,100); fill-rule: nonzero; opacity: 1;"
                          transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                      </g>
                    </svg>
                    4.9 / 5
                  </div>
                  <h1 itemprop="name">{{$detail->name}}</h1>
                  <button class="btn btn-lg btn-block s-blue gamenow">
                    Play Now
                    <svg class="play_svg" viewBox="0 0 142.45 142.45">
                      <g fill="#1D1D1B">
                        <path
                          d="m142.41 68.9c-1.195-37.42-31.443-67.667-68.862-68.862-20.361-0.646-39.41 7.104-53.488 21.639-13.534 13.973-20.645 32.394-20.023 51.872 1.194 37.419 31.442 67.667 68.861 68.861 0.779 0.025 1.551 0.037 2.325 0.037 19.454 0 37.624-7.698 51.163-21.676 13.534-13.972 20.646-32.394 20.024-51.871zm-30.798 41.436c-10.688 11.035-25.032 17.112-40.389 17.112-0.614 0-1.228-0.01-1.847-0.029-29.532-0.943-53.404-24.815-54.348-54.348-0.491-15.382 5.122-29.928 15.806-40.958 10.688-11.035 25.032-17.112 40.389-17.112 0.614 0 1.228 0.01 1.847 0.029 29.532 0.943 53.404 24.815 54.348 54.348 0.491 15.382-5.123 29.928-15.806 40.958z" />
                        <path
                          d="m94.585 67.086-31.584-22.646c-3.369-2.416-8.059-8e-3 -8.059 4.138v45.293c0 4.146 4.69 6.554 8.059 4.138l31.583-22.647c2.834-2.031 2.834-6.244 1e-3 -8.276z" />
                      </g>
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>