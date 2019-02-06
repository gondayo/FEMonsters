<!doctype html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <!--<script src="../JS/prog.js"></script>-->
        <title>Example for Bootstrap</title>

        <!-- Bootstrap core CSS-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<script type="text/javascript">


$(function() {
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
 });
 jQuery(function($) {
 $('#hoge').timer(10);
 });
</script>
</head>
<body>



</body>
</html>
