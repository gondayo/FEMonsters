//modal
/*$(function(){
  $(".use").change(function() {

    //disabled属性の状態を取得する
      var ItemNum = $("button").prop("class");
      var ItemNum2 = ItemNum - 1;
      if(ItemNum2 === 0) {
        //disabled属性を付与する
        $("button").prop("disabled, false");
      } else {
        //disabled属性を解除する
        $("button").prop("disabled", true);
      }
  });*/
  //テキストリンクをクリックしたら
 $(".use").click(function(){
      var ItemName = $(".use").val();
      var ItemNum = $(".ItemNum").val();
      if(ItemNum === 0){
      $("div").prepend('<p>',$(ItemName),'を使用しますか？</p><button disabled id="ok">使う</button>');
    } else {
      $("div").prepend('<p>',$(ItemName),'を使用しますか？</p><button id="ok">使う</button>');
    }
      //body内の最後に<div id="modal-bg"></div>を挿入
     $("body").append('<div id="modal-bg"></div>');

    //画面中央を計算する関数を実行
    modalResize();

    //モーダルウィンドウを表示
        $("#modal-bg,#modal-main").fadeIn("slow");

    //画面のどこかをクリックしたらモーダルを閉じる
      $("#modal-bg,#modal-main").click(function(){
          $("#modal-main,#modal-bg").fadeOut("slow",function(){
         //挿入した<div id="modal-bg"></div>を削除
              $("#modal-bg").remove() ;
              $("p").remove('')
         });

        });

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
   });
});
