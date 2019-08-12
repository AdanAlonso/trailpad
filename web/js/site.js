$(function() {
  getGameCovers();
  registerServiceWorker();
});

function getGameCovers() {
  $('.game').each(getGameCover);
}

function getGameCover() {
  var _this = this;
  var id = $(_this).attr("data-id");
  $.ajax({
    url: "index.php?r=game%2Fcover&id=" + id,
    success: function(res) {
      $(_this).find('.cover').css('background-image', 'url(' + res + ')');
    }
  });
}

function registerServiceWorker() {
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('./sw.js').then(function(registration) {
        // Registration was successful
        // console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }, function(err) {
        // registration failed :(
        // console.log('ServiceWorker registration failed: ', err);
        });
    });
    }
}
