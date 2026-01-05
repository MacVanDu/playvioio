<script>
function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

   const fbk = '{"sefb":"Send Feedback","messwar":"A minimum of 25 characters is required.","fmess":"Message","fema":"E-mail (optional)", "siss":"Select the issue:","iss":"Issue","title":"<div class=sfbk>Thank you for your feedback!</div><div class=sfb>It helps us improve the experience on the pkgosu.fun</div>", "title2":"Please tell us what the issue is with the game <b>Fashion Sticker Studio</b> ?", "close":"&times;" , "q1":"The game doesn&#39;t load","q2":"I don&#39;t like the game" , "q3":"The game is not working" , "q4":"Other reasons"}'
 const obj = JSON.parse(fbk);
 let timer;

 function addRecentGame(a) {
     const b = getRecentGames(),
         c = b.findIndex(c => c.url === a.url); - 1 === c ? b.push(a) : (b.splice(c, 1), b.push(a)), saveRecentGames(b)
 }

 function saveRecentGames(a) {
     localStorage.setItem("AIrecentGames", JSON.stringify(a))
 }
 document.addEventListener("DOMContentLoaded", () => {
     const a = {
          name: "{{ $detail->nameGame() }}",
          image: "{{ $detail->linkImgGame() }}",
          url: "{{  $datamd['href'].$detail->slugGame() }}"
     };
     timer = setTimeout(() => {
         addRecentGame(a)
     }, 3e4)
 }), window.addEventListener("beforeunload", () => {
     clearTimeout(timer)
 });
 </script>

  <script>
 
document.addEventListener("DOMContentLoaded", () => {
    let e = document.getElementById("add-to-favorites");
    if (e) {
        let t = {
         name: "{{ $detail->nameGame() }}",
          image: "{{ $detail->linkImgGame() }}",
          url: "{{  $datamd['href'].$detail->slugGame() }}"
        };
        e && isInFavorites(t) && e.classList.add("favorite"),
        e.addEventListener("click", () => {
            isInFavorites(t) ? (removeFavorite(t),
            e.classList.remove("favorite")) : (addFavorite(t),
            e.classList.add("favorite"),
            openfavlistButton.classList.add("pulse"),
            setTimeout( () => {
                openfavlistButton.classList.remove("pulse")
            }
            , 600)),
            displayFavorites()
        }
        )
    }
    displayFavorites()
}
)
 </script>