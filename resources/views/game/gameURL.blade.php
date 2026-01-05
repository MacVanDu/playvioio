<!DOCTYPE html>
<html>
  <head>
    <style>
      body {
        background-color: #000;
      }

      #myFrame {
        overflow-y: hidden;
        overflow-x: hidden;
      }
    </style>
  </head>
  <body>
    <iframe id="myFrame" src="" style="position:fixed;top:0;left:0;bottom:0;right:0;width:100%;height: calc(100% + 47px);border:none;margin:0;padding:0;overflow:hidden;z-index:999999;"></iframe>
    <script>
      function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
          vars[key] = value;
        });
        return vars;
      }
      var myParam = getUrlVars()["gameURL"];
      document.getElementById("myFrame").src = myParam;
    </script>
  </body>
</html>