//modal
function popquestion(){
          //問題表示
          let title = question_jq[array_key_jq[x]].Tec_QuestionText;
          let choices = [question_jq[array_key_jq[x]].Tec_Choices1, question_jq[array_key_jq[x]].Tec_Choices2, question_jq[array_key_jq[x]].Tec_Choices3, question_jq[array_key_jq[x]].Tec_Choices4];
          ans = choices[0];
            //選択肢シャッフル
          for (let i = choices.length - 1; i >= 0; i--){

            // 0~iのランダムな数値を取得
            var rand = Math.floor( Math.random() * ( i + 1 ) );

            // 配列の数値を入れ替える
            [choices[i], choices[rand]] = [choices[rand], choices[i]]

          }
          $("#t").text(ans);
          $("h2").text(title);
          $("#choices1").val(choices[0]);
          $("#choices2").val(choices[1]);
          $("#choices3").val(choices[2]);
          $("#choices4").val(choices[3]);
        }

        function modalopen(){
  clearTimeout($("#hoge").data('id_of_settimeout'));
  $("#hoge").empty();
          //body内の最後に<div id="modal-bg"></div>を挿入
         $("body").append('<div id="modal-bg"></div>');

         //画面中央を計算する関数を実行
         modalResize();

         //モーダルウィンドウを表示
         $("#modal-bg,#modal-main").fadeIn("slow");

        //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
         $(window).resize(modalResize);
         function modalResize(){

            var w = $(window).width();
            var h = $(window).height();

            var cw = $("#modal-main").outerWidth();
            var ch = $("#modal-main").outerHeight();

            //取得した値をcssに追加する
                $("#modal-main").css({
                    "left": ((w - cw)/2) + "px",
                    "top": ((h - ch)/2) + "px"
                });
         }


        }

$(function(){


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

  if (timeLeft == 0) {
  $header.empty().text('Over the time limit!').addClass('text-danger');
  clearTimeout(this.data('id_of_settimeout'));
  this.empty();
  $("#judge").text("不正解・・・");
  $("#answer").text("正解は"+ ans + "です。");
  x++;
  r++;
  $("#result").val(y);
  //body内の最後に<div id="modal-bg"></div>を挿入
  $("body").append('<div id="quiz-modalbg"></div>');

  //画面中央を計算する関数を実行
  modalResize();

  //モーダルウィンドウを表示
  $("#quiz-modalbg,#quiz-modal").fadeIn("slow");
  //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます

  //ボタンをクリックしたらモーダルを閉じる
   $("#next,#result").click(function(){

         $("#quiz-modal,#quiz-modalbg").fadeOut("slow",function(){
      //挿入した<div id="modal-bg"></div>を削除
         $('#quiz-modalbg').remove();
  });
  });

  $(window).resize(modalResize);
  function modalResize(){

        var w = $(window).width();
      var h = $(window).height();

        var cw = $("#modal-main").outerWidth();
       var ch = $("#modal-main").outerHeight();

    //取得した値をcssに追加する
        $("#modal-main").css({
            "left": ((w - cw)/2) + "px",
            "top": ((h - ch)/2) + "px"
      });

  }
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
  //選択肢をクリックしたら
 $(".choice").click(function(){

    //body内の最後に<div id="modal-bg"></div>を挿入
    $("body").append('<div id="quiz-modalbg"></div>');

    //画面中央を計算する関数を実行
    modalResize();

    //モーダルウィンドウを表示
    $("#quiz-modalbg,#quiz-modal").fadeIn("slow");
    //ボタンをクリックしたらモーダルを閉じる
    $("#next,#result").click(function(){
        $("#quiz-modal,#quiz-modalbg").fadeOut("slow",function(){
        //挿入した<div id="modal-bg"></div>を削除
            $('#quiz-modalbg').remove();


        });

    });


    //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
     $(window).resize(modalResize);
      function modalResize(){

          var w = $(window).width();
          var h = $(window).height();

          var cw = $("#quiz-modal").outerWidth();
          var ch = $("#quiz-modal").outerHeight();

            //取得した値をcssに追加する
            $("#quiz-modal").css({
                "left": ((w - cw)/2) + "px",
                "top": ((h - ch)/2) + "px"
            });
     }

                  z =  r - y;
                  hp -= z;
                  $("#hit").text(hp);
                  if(hp<1){
                    modalopen();
                  }
                  return;
});

$('#result').click(function(){


     });






});
