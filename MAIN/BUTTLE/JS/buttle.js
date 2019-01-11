

function update() {
gameTimer = setTimeout(update, 50);
var lifeBar = document.getElementById('lifeBar');


//最大値に達したらループ終了
if(lifeBar.value >= lifeBar.max){
clearTimeout(gameTimer);
}

}

update();
