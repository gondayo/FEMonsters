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





    //モーダルウィンドウを表示
    $(".buy0").click(function(){
        //テキストリンクをクリックしたら
          var SName = $(this).attr("data-name");
          var SPrice = $(this).attr("data-price");
        //body内の最後に<div id="modal-bg"></div>を挿入
          $("body").append('<div id="modal-background"></div>');
          $("#modal-background,.modal-window1").fadeIn("slow");
          $(".buyname").text(SName);
          $(".total").text(SPrice);
          $(".info1").val(SName);
      $("select").change(function() {
         var num = $(this).val();
         total = num * SPrice;
         $(".total").text(total);
         $(".info2").val(total);
         $(".info3").val(num)
       });
       //画面中央を計算する関数を実行
       modalResize();
       //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
        $(window).resize(modalResize);
         function modalResize(){

               var w = $(window).width();
             var h = $(window).height();

               var cw = $(".modal-window1").outerWidth();
              var ch = $(".modal-window1").outerHeight();

           //取得した値をcssに追加する
               $(".modal-window1").css({
                   "left": ((w - cw)/2) + "px",
                   "top": ((h - ch)/2) + "px"
             });
        }
        
        //画面外のどこかとボタンをクリックしたらモーダルを閉じる
          $("#modal-background,.shopbuy").click(function(){
              $(".modal-window1,#modal-background").fadeOut("slow",function(){
             //挿入した<div id="modal-bg"></div>を削除
                  $("#modal-background").remove() ;
                  // 未選択状態にする

                  selectedIndex = -1;
              });

          });
      });
    $(".buy1").click(function(){
      var SId = $(this).attr("data-id");
      //テキストリンクをクリックしたら
        var SName = $(this).attr("data-name");
        var SPrice = $(this).attr("data-price");
       //body内の最後に<div id="modal-bg"></div>を挿入
        $("body").append('<div id="modal-background"></div>');
        $("#modal-background,.modal-window2").fadeIn("slow");
        $(".buyname").text(SName);
        $(".total").text(SPrice);
        $(".info4").val(SName);
        $(".info7").val(SId);
      $("select").change(function() {
         var num = $(this).val();
         total = num * SPrice;
         $(".total").text(total);
         $(".info5").val(total);
         $(".info6").val(num)
       });
       //画面中央を計算する関数を実行
       modalResize();
       //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
        $(window).resize(modalResize);
         function modalResize(){

               var w = $(window).width();
             var h = $(window).height();

               var cw = $(".modal-window2").outerWidth();
              var ch = $(".modal-window2").outerHeight();

           //取得した値をcssに追加する
               $(".modal-window2").css({
                   "left": ((w - cw)/2) + "px",
                   "top": ((h - ch)/2) + "px"
             });
        }
        //画面のどこかをクリックしたらモーダルを閉じる
          $("#modal-background,.shopbuy").click(function(){
              $(".modal-window2,#modal-background").fadeOut("slow",function(){
             //挿入した<div id="modal-bg"></div>を削除
                  $("#modal-background").remove() ;

             });

            });
      });


   $(function() {
     $('.ChangeElem_Panel').hide();
     $('.ChangeElem_Panel').eq(0).show();
     // クリックしたときの関数
     $('.type').click(function() {
      var index = $('.type').index(this);
      $('.ChangeElem_Panel').hide();
      $('.ChangeElem_Panel').eq(index).show();
      // 〜〜タブについての処理〜〜
      // 一度タブについている'tab_current'を消し
      $('.tab li').removeClass('tab_current');
      //クリックされたタブのみに'tab_current'をつける。
      $(this).addClass('tab_current')
    });
  });

});
