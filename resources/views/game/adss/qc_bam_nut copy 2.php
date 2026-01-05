
<style>
    #loading-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0,0,0,0.85);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  color: white;
  font-size: 20px;
  z-index: 99999;
  display: none; /* Ẩn mặc định */
}

/* Vòng tròn loading */
.loader {
  width: 60px;
  height: 60px;
  border: 6px solid #ffffff50;
  border-top: 6px solid #00eaff;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 15px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
<div id="loading-screen">
  <div class="loader"></div>
  <p>Loading...</p>
</div>
<script>
    function showLoading() {
  document.getElementById("loading-screen").style.display = "flex";
}

function hideLoading() {
  document.getElementById("loading-screen").style.display = "none";
}

function requestRewardAd() {
  showLoading();
  try {
    (adsbygoogle = window.adsbygoogle || []).push({
      google_ad_format: "interstitial"
    });
  setTimeout(() => {
    hideLoading();
  }, 3000);
  } catch (e) {
    hideLoading();
    console.log("Interstitial not shown", e);
  }
}
</script>
