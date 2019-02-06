
(function($) {
 $.fn.timer = function(totalTime) {
   // 既に起動済のものがある場合は削除しておく
   clearTimeout(this.data('id_of_settimeout'));
   this.empty();

   // ターゲット内に要素を作成
   this.append('<h4><span></span> seconds left.</h4>');
   this.append('<div class="progress"></div>');
   this.children('.progress').append('<div class="progress-bar progress-bar-info"></div>');
   this.find('.progress-bar').css({
       cssText: '-webkit-transition: none !important; transition: none !important;',
       width: '100%'
   });

   var countdown = (function(timeLeft) {
     var $progressBar = this.find('div.progress-bar');
     var $header = this.children('h4');

     if (timeLeft <= 0) {
       $header.empty().text('Over the time limit!').addClass('text-danger');
       return;
     }

     $header.children('span').text(timeLeft);

     var width = (timeLeft - 1) * (100/totalTime); // unit in '%'
     if (width < 20) { // less than 20 %
       $progressBar.removeClass();
       $progressBar.addClass('progress-bar progress-bar-danger');
     } else if (width < 50) { // less than 50 % (and more than 20 %)
       $progressBar.removeClass();
       $progressBar.addClass('progress-bar progress-bar-warning');
     }

     $progressBar.animate({
       width:  width + '%'
     }, 1000, 'linear');

     var id = setTimeout((function() {
       countdown(timeLeft - 1);
     }), 1000);
     this.data("id_of_settimeout", id);
   }).bind(this);

   countdown(totalTime);
 };
 })(jQuery);
