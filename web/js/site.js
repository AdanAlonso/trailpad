$(function() {
  getGameCovers();
});

function getGameCovers() {
  $('.game').each(getGameCover);
}

function getGameCover() {
  var _this = this;
  var title = $(this).attr('title');
  $.ajax({
    url: "https://www.giantbomb.com/api/games/",
    dataType: "jsonp",
    jsonp: 'json_callback',
    data: {
        api_key: '[API KEY]',
        filter: 'name:' + title,
        format: 'jsonp',
        field_list: 'image'
    },
    success: function(res) {
      if(res.results.length > 0){
        $(_this).find('.cover').css('background-image', 'url(' + res.results[0].image.medium_url) + ')';
      }
    }
  });
}
