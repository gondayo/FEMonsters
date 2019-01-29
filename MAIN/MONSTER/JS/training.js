$(function(){
  $("#monscheck").on('click',function(){

    let mons_list = "<?php echo $array_mons_list; ?>";

    console.log(mons_list);

    $("#modal-main").append('<h1>モンスター選択</h1>');
    $("#modal-main").append('<input type="image" id="mons1"class=" monslist" src="/MAIN/MONSTER/MONSTERPIC/a.png"name="mons1" alt="モンスター画像1">');
    $("#modal-main").append('<input type="image" id="mons2"class=" monslist" src="/MAIN/MONSTER/MONSTERPIC/a.png"name="mons2" alt="モンスター画像2">');
    $("#modal-main").append('<input type="image" id="mons3"class=" monslist" src="/MAIN/MONSTER/MONSTERPIC/a.png"name="mons3" alt="モンスター画像3">');

    modalcall();
  });

  $("#evocheck").on('click',function(){
    modalcall();
  });

});

function monsclick(){
  $(".monslist").on('click',function(){

  //  switch(<?php echo($mons_list["MonsterId"])?>){

  //  }
  });
}

function modalcall(){
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
    //画面外のどこかとボタンをクリックしたらモーダルを閉じる
        $("#modal-bg").click(function(){
            $("#modal-main,#modal-bg").fadeOut("slow",function(){
            //挿入した<div id="modal-bg"></div>を削除
                $("#modal-bg").remove() ;
                $("h1").remove();
                $(".monslist").remove();
        });

      });
 }
}
