//modal
$(function(){
  /*$(".use").change(function() {

    //disabled属性の状態を取得する
      var ItemNum = $("button").prop("class");
      var ItemNum2 = ItemNum - 1;
      if(ItemNum2 === 0) {
        //disabled属性を付与する
        $("button").prop("disabled, false");
      } else {
        //disabled属性を解除する
        $("button").prop("disabled", true);
      }*/
        /*function escapeSelectorString(val){
        return val.replace(/[ !"#$%&'()*+,.\/:;<=>?@\[\\\]^`{|}~]/g, "\\$&");
      }

      function escapeSelectorString(text){
      return text.replace(/[ !"#$%&'()*+,.\/:;<=>?@\[\\\]^`{|}~]/g, "\\$&");
    }
*/

  //テキストリンクをクリックしたら
 $(".use").on('click',function(){
   var ItemName = $(this).attr("data-name");
   var ItemNum = $(this).attr("data-num");

   $("#UseItem").text(ItemName);
   $("#UseNum").text(ItemNum);
   $("#Name").val(ItemName);
   //$("#UseNum").val(ItemNum);


   if(ItemNum == 0){
   $("#modal-window").append('<button type="submit" id="ok" name="ok">使う</button>');
   $("#ok").prop("disabled,true");
 } else {
   $("#modal-window").append('<button type="submit" id="ok" name="ok">使う</buuton>');
   $("#ok").prop("disabled,false");
 }

      //body内の最後に<div id="modal-bg"></div>を挿入
     $("body").append('<div id="modal-background"></div>');

    //画面中央を計算する関数を実行
    modalResize();

    //モーダルウィンドウを表示
        $("#modal-background,#modal-window").fadeIn("slow");

    //画面のどこかをクリックしたらモーダルを閉じる
      $("#modal-background,#modal-window").click(function(){
          $("#modal-window,#modal-background").fadeOut("slow",function(){
         //挿入した<div id="modal-bg"></div>を削除
              $("#modal-background").remove() ;
              $("#ok").remove();
         });

        });

    //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
     $(window).resize(modalResize);
      function modalResize(){

            var w = $(window).width();
          var h = $(window).height();

            var cw = $("#modal-window").outerWidth();
           var ch = $("#modal-window").outerHeight();

        //取得した値をcssに追加する
            $("#modal-window").css({
                "left": ((w - cw)/2) + "px",
                "top": ((h - ch)/2) + "px"
          });
     }

   });
});
