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
 $(".buy").on('click',function(){
   var SItemName = $(this).attr("data-name");
   var SItemPrice = $(this).attr("data-price");

   $("#buyname").text(SItemName);
   $("#total").text(SItemPrice);
   $("#info1").val(SItemName);
 $("select").change(function() {
    var num = $(this).val();
    total = num * SItemPrice;
    $("#total").text(total);
    $("#info2").val(total);
    $("#info3").val(num)
  });

      //body内の最後に<div id="modal-bg"></div>を挿入
     $("body").append('<div id="modal-background"></div>');

    //画面中央を計算する関数を実行
    modalResize();

    //モーダルウィンドウを表示
        $("#modal-background,#modal-window").fadeIn("slow");

    //画面のどこかをクリックしたらモーダルを閉じる
      $("#modal-background,#itembuy").click(function(){
          $("#modal-window,#modal-background").fadeOut("slow",function(){
         //挿入した<div id="modal-bg"></div>を削除
              $("#modal-background").remove() ;
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
