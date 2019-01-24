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
            $( "#progress" ).progressbar( "destroy" );
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

    var per = $('#progress').progressbar('value') /
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
          }//,

      });

       // 1秒おきにプログレスバーを更新
      var v = 0;
      var id = setInterval(function() {
          v = p.progressbar('value');
          p.progressbar('value', --v);

          if (v <= 0){

             clearInterval(id);

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

             }

             if(hp<1){

               modalopen();

             }else{

               popquestion();

             }

        }, 100);

     }

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

        $("h2").text(title);
        $("#choices1").val(choices[0]);
        $("#choices2").val(choices[1]);
        $("#choices3").val(choices[2]);
        $("#choices4").val(choices[3]);
      }

      function modalopen(){

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

       $( "#progress" ).progressbar( "destroy" );

      }

      function MonsItemJ(){

        switch(monsId){
          case 1:
           switch (itemId) {
             case 0:
             console.log('mons1＆item0');
             timeSet = timeSet + monsTime;
             break;

             case 1:
             console.log('mons1＆item1');
             timeSet = timeSet + monsTime + 15;
             break;

             case 2:
             console.log('mons1＆item2');
             getGold = getGold * 1.25;
             getExp = getExp * 1.25;
             timeSet = timeSet + monsTime;
             break;

             case 3:
             console.log('mons1＆item3');
             getGold = getGold * 1.5;
             timeSet = timeSet + monsTime - 15;
             break;
           }

         case 2:
          switch (itemId) {
            case 0:
            console.log('mons2＆item0');
            getGold = getGold * goldUp;
            getExp = getExp *expUp;
            break;

            case 1:
            console.log('mons2＆item1');
            getGold = getGold * goldUp;
            getExp = getExp *expUp;
            timeSet = timeSet + 15;
            break;

            case 2:
            console.log('mons2＆item2');
            getGold = getGold * (goldUp + 1.25 );
            getExp = getExp *(expUp + 1.25);
            break;

            case 3:
            console.log('mons2＆item3');
            getGold = getGold * (goldUp + 1.5);
            getExp = getExp *expUp;
            timeSet = timeSet - 15;
            break;
          }

          case 3:
           switch (itemId) {
             case 0:
             console.log('mons3＆item0');
             getGold = getGold * goldUp2;
             timeSet = timeSet - 30;
             break;

             case 1:
             console.log('mons3＆item1');
             getGold = getGold * goldUp2;
             timeSet = timeSet - 30 + 15;
             break;

             case 2:
             console.log('mons3＆item2');
             getGold = getGold * (goldUp2 + 1.25);
             getExp = getExp * 1.25;
             timeSet = timeSet - 30;
             break;

             case 3:
             console.log('getGold');
             getGold = getGold * (goldUp2 + 1.5);
             timeSet = timeSet -45;
             break;
           }

        }

      }
