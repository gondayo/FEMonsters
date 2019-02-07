
$(function() {
        $("#modal-main2").hide();
});

//menu
$(function(){

  //ボタンをクリックしたら
 $("#modal-open").click(function(){
      //body内の最後に<div id="modal-bg"></div>を挿入
      $("body").append('<div id="modal-main2"><input id="retirecheck" type="image"src="../../../PICTURE/retire.png" value="c"><br><input id="gameBack" type="image"src="../../../PICTURE/gameBack.png" value="e"></div>');
      //$("body").append('<div id="modal-main2"><h1>Menu</h1><button id="retirecheck" type = "submit" name = "retireCheck" value = "c" ><img src="../../../PICTURE/retire.png"></button><button id="gameBack" type = "submit" name = "gameBack" value = "e" ><img src="../../../PICTURE/gameBack.png"></button></div>');
      $("body").append('<div id="modal-bg"></div>');
      $("body").append('<form method="POST"><div id="modal-main3"><p id="checkwrite">経験値とおかねは獲得できません。</p><p id="checkwrite2">MAPへ戻りますか？</p><input id="yesClick" name="yesClick"type="submit" value="d"><br><input id="noClick" type="image"src="../../../PICTURE/nobutton.png" value="f"></div></form>');


    //画面中央を計算す関数を実行
    modalResize();
    //モーダルウィンドウを表示
        $("#modal-bg,#modal-main2").fadeIn("slow");
        $("#retirecheck").on('click',function(){

        //画面中央を計算する関数を実行
        modalResize();

        //モーダルウィンドウを表示
            $("#modal-main3").fadeIn("slow");

            $("#modal-main2").remove();


        //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
         $(window).resize(modalResize);
          function modalResize(){

                var w = $(window).width();
              var h = $(window).height();

                var cw = $("#modal-main3").outerWidth();
               var ch = $("#modal-main3").outerHeight();

            //取得した値をcssに追加する
                $("#modal-main3").css({
                    "left": ((w - cw)/2) + "px",
                    "top": ((h - ch)/2) + "px"
              });

         }

        });

        $("#gameBack").on('click',function(){
          $("#modal-bg,#modal-main2").remove();
        });
        $("#noClick").on("click", function() {

          $("#modal-bg,#modal-main3").remove();
        });
    //画面の左上からmenu-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
     $(window).resize(modalResize);
      function modalResize(){

            var w = $(window).width();
          var h = $(window).height();

            var cw = $("#modal-main2").outerWidth();
           var ch = $("#modal-main2").outerHeight();

        //取得した値をcssに追加する
            $("#modal-main2").css({
                "left": ((w - cw)/2) + "px",
                "top": ((h - ch)/2) + "px"
          });
     }
   });
});
