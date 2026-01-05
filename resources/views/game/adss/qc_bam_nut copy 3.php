<!-- OVERLAY FULLSCREEN -->
<div id="ad-overlay" style="
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.85);
    z-index: 99999;
    display: none;
    justify-content: center;
    align-items: center;
">
    <!-- Slot quảng cáo -->
    <div id="gpt-interstitial" style="width: 100%; height: 100%;"></div>

    <!-- NÚT CLOSE -->
    <button id="closeAd" style="
        position:absolute; top:25px; right:25px;
        padding:10px 20px;
        background:#fff;
        font-size:18px;
        border-radius:8px;
        border:none;
        display:none;
        cursor:pointer;
        z-index:100000;
    ">Close</button>

    <!-- VÒNG TRÒN COUNTDOWN -->
    <div id="countdown-circle" style="
        position:absolute;
        top:50%; left:50%;
        transform:translate(-50%, -50%);
        width:130px; height:130px;
        border-radius:50%;
        border:10px solid rgba(255,255,255,0.3);
        display:flex; justify-content:center; align-items:center;
        font-size:42px; color:#fff; font-weight:bold;
        z-index: 100000;
    ">
    </div>
</div>

<!-- GPT SCRIPT -->
<script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>

<script>
window.googletag = window.googletag || {cmd: []};

let interstitialSlot;
let adLoaded = false;
let noFill = false;

// INIT GPT
googletag.cmd.push(function () {

    interstitialSlot = googletag.defineOutOfPageSlot(
        "/23323875495/popup_interstitial",
        "gpt-interstitial"
    );

    if (!interstitialSlot) {
        console.log("GPT ERROR: Không tạo được Interstitial slot.");
    } else {
        interstitialSlot.addService(googletag.pubads());
        console.log("GPT: Interstitial slot created.");
    }

    googletag.pubads().enableSingleRequest();

    // Lắng nghe khi render quảng cáo
    googletag.pubads().addEventListener("slotRenderEnded", function (event) {
        if (event.slot === interstitialSlot) {
            if (event.isEmpty) {
                noFill = true;
                adLoaded = false;
                console.log("GPT: NO FILL – Google không trả quảng cáo.");
            } else {
                adLoaded = true;
                noFill = false;
                console.log("GPT: Quảng cáo load OK.");
            }
        }
    });

    googletag.enableServices();
});
</script>

<script>

// GỌI HIỂN THỊ QUẢNG CÁO
function requestRewardAd() {
    console.log("REQUEST: Hiển thị quảng cáo interstitial…");

    document.getElementById("ad-overlay").style.display = "flex";

    // Reset trạng thái
    adLoaded = false;
    noFill = false;

    // Gọi quảng cáo
    googletag.cmd.push(function () {
        googletag.display("gpt-interstitial");
    });

    // countdown 5 giây
    startCircleCountdown(5);
}


// COUNTDOWN
function startCircleCountdown(seconds) {
    const circle = document.getElementById("countdown-circle");
    const closeBtn = document.getElementById("closeAd");

    let time = seconds;
    circle.style.display = "flex";
    closeBtn.style.display = "none";
    circle.innerHTML = time;

    const timer = setInterval(() => {
        time--;
        circle.innerHTML = time;

        // hết giờ
        if (time <= 0) {
            clearInterval(timer);
            circle.style.display = "none";

            console.log("COUNTDOWN DONE.");

            // Nếu NO FILL thì tắt ngay
            if (noFill) {
                console.log("NO AD → Tắt overlay, vào game.");
                closeAd();
                return;
            }

            // Nếu quảng cáo load → hiện nút Close
            console.log("SHOW CLOSE BUTTON.");
            closeBtn.style.display = "block";
        }
    }, 1000);
}


// NÚT CLOSE
document.getElementById("closeAd").onclick = function () {
    closeAd();
};

function closeAd() {
    document.getElementById("ad-overlay").style.display = "none";
    console.log("CLOSE: Đã vào game.");
}
</script>
