var block_show = false;

var lastId = 0;

function scrollMore() {
  let $target = $('#autoscroll-trigger');

  if (block_show) {
    return false;
  }
 
  let wt = $(window).scrollTop();
  let wh = $(window).height();
  let et = $target.offset().top;
  let eh = $target.outerHeight();
  let dh = $(document).height();   
 
  if (wt + wh >= et || wh + wt == dh || eh + et < wh){
    block_show = true;
    $('#autoscroll-trigger').css('display', 'flex')

    let lastId = $('.screenshot-card').last().attr('data-id'); 
    lastId = (lastId === undefined) ? 0 : lastId

    $.ajax({ 
      url: '/screenshots?lastid=' + lastId,  
      dataType: 'html',
      success: function(data){
        if (data.length !== 0) {
          $('#autoscroll-trigger').css('display', 'none')
          $('#autoscroll-trigger').before(data);
        } else {
          $(window).off('scroll');
          $(document).off('ready');
          $target.remove();
        }
        block_show = false;
      }
    });
  }
}

$(window).scroll(function(){
  scrollMore();
});

$(document).ready(function(){ 
  scrollMore();
});