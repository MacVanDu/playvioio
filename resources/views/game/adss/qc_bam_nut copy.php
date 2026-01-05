<style>
  .video-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.8);
    z-index: 9999;
  }
</style>

<script src="https://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>

<div class="video-wrapper" id="videoContainer" style="display:none;">
  <video id="videoPlayer" width="640" height="480" controls></video>
</div>


<script>
const videoElement = document.getElementById('videoPlayer');
const videoContainer = document.getElementById('videoContainer');

const adTagUrl =
 "https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/23323875495/popup_interstitial&env=vp&impl=s&gdfp_req=1&output=vast&unviewed_position_start=1&url=[referrer_url]&description_url=[description_url]&correlator=[timestamp]";

let adDisplayContainer, adsLoader, adsManager;

function requestRewardAd() {

    adDisplayContainer = new google.ima.AdDisplayContainer(videoContainer, videoElement);
    adsLoader = new google.ima.AdsLoader(adDisplayContainer);

    // 1. Nếu load thành công → phát quảng cáo
    adsLoader.addEventListener(
        google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED,
        onAdsManagerLoaded,
        false
    );

    // 2. Nếu lỗi hoặc không có quảng cáo → không hiện popup
    adsLoader.addEventListener(
        google.ima.AdErrorEvent.Type.AD_ERROR,
        function() {
            console.log("Không có quảng cáo để hiển thị.");
            // KHÔNG hiện popup
            videoContainer.style.display = "none";
        }
    );

    const adsRequest = new google.ima.AdsRequest();
    adsRequest.adTagUrl = adTagUrl;

    adsLoader.requestAds(adsRequest);
}

function onAdsManagerLoaded(event) {
    // Có ads → mới hiện popup
    videoContainer.style.display = "flex";

    adsManager = event.getAdsManager(videoElement);

    adsManager.addEventListener(
        google.ima.AdEvent.Type.COMPLETE,
        function() {
             console.log("Bạn đã xem xong quảng cáo và nhận thưởng!");
            videoContainer.style.display = "none";
        }
    );

    // Bắt buộc
    adDisplayContainer.initialize();
    adsManager.init(640, 480, google.ima.ViewMode.NORMAL);
    adsManager.start();
}
</script>
