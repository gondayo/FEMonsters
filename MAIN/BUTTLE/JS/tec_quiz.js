//modal
$(function(){

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
   });

function timeAct() {


       // プログレスバーを生成
         $('#progress').progressbar({
           value: 37,
           max: timeSet
         });

         var per =  $('#progress').progressbar('value') /
           $('#progress').progressbar('option', 'min')
         $('#loading').text(Math.ceil(per * 100) + '秒');

       // 何度も使うので、変数に退避
         var p = $('#progress');
         var l = $('#loading');

         p.progressbar({
           value: timeSet,
       // 値の変更をラベルにも反映
         change: function() {
           l.text(p.progressbar('value') + '秒');
         },

       });

       // 1秒おきにプログレスバーを更新
          var v = 0;
           var id = setInterval(function() {
           v = p.progressbar('value');
           p.progressbar('value', --v);

           if (v <= 0){

             clearInterval(id)

             $("#judge").text("不正解・・・");
             $("#answer").text("正解は"+ ans + "です。");
             x++;
             r++;

             $("#result").remove();
             $("#result").val(y);

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

                      $(function() {
                      // プログレスバーを生成
                        $('#progress').progressbar({
                          value: 37,
                          max: timeSet
                        });

                        var per =  $('#progress').progressbar('value') /
                          $('#progress').progressbar('option', 'min')
                        $('#loading').text(Math.ceil(per * 100) + '秒');

                        p.progressbar({
                          value: timeSet,
                      // 値の変更をラベルにも反映
                        change: function() {
                          l.text(p.progressbar('value') + '秒');
                        },
                      });
                    });
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

               $("h2").text(title);
               $("#choices1").val(choices[0]);
               $("#choices2").val(choices[1]);
               $("#choices3").val(choices[2]);
               $("#choices4").val(choices[3]);

             }


         }, 100);

     }


  /* $(function time (){


  });*/
