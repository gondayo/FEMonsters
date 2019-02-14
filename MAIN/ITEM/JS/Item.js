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
   var ItemFlag = $(this).attr("data-flag");
   var ItemId = $(this).attr("data-id");




   if(ItemFlag == 1){
     $("#modal-window").append('<h1>使用確認</h1>');
     $("#modal-window").append('<span id="useitem"></span><span class="check">を使用しますか？</span>');
     $("#modal-window").append('<span id="usenum" name="usenum"></span><span class="k">個</span><br>');
     $("#modal-window").append('<button type="submit" id="ok" name="ok">使う</button><br>');
     $("#modal-window").append('<p id="description">アイテム説明</p>')
   } else {
     $("#modal-window").append('<h1>使用確認</h1>');
     $("#modal-window").append('<span id="useitem"></span>');
     $("#modal-window").append('<span id="usenum" name="usenum"></span><span class="k">個</span><br>');
     $("#modal-window").append('<p id="description">アイテム説明</p>')
   }
   $("#useitem").text(ItemName);
   $("#usenum").text(ItemNum);
   $("#name").val(ItemName);
   $("#itemid").val(ItemId);
   //$("#UseNum").val(ItemNum);
      //body内の最後に<div id="modal-bg"></div>を挿入
     $("body").append('<div id="modal-background"></div>');

    //画面中央を計算する関数を実行
    modalResize();

    //モーダルウィンドウを表示
        $("#modal-background,#modal-window").fadeIn("slow");

    //画面外のどこかとボタンをクリックしたらモーダルを閉じる
      $("#modal-background,#ok").click(function(){
          $("#modal-window,#modal-background").fadeOut("slow",function(){
         //挿入した<div id="modal-bg"></div>を削除
              $("#modal-background").remove() ;
              $("#useitem").remove();
              $(".check").remove();
              $("#usenum").remove();
              $(".k").remove();
              $("#description").remove();
              $("#ok").remove();
              $("br").remove();
              $("h1").remove();
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
