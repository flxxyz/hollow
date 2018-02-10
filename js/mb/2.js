$(function(){
	var s = $('<style></style>');
	s.append('#mb{position:fixed;bottom:-150px;left:72%}#mb img{width:20px;height:20px;position:absolute;bottom:100px;left:50%;margin-left:-10px}');
	var d = $('<div></div>');
	d.attr('id','mb');
	$('body').append(s,d);//prepend()

	var s = 0;
	var n = 8; //需要存活的图片数量,最大10,最小6
	var timer = setInterval(function(){
		if(s >= n) {
			clearInterval(timer);
			setInterval(function(){
				$('#mb img.float-x')[0].remove();
				buildCore();
			},300);
		}else buildCore();
	},300);

function buildCore(){
	var x = -500;
	var y = 100;
	var num = Math.floor(Math.random() * 5 + 1);
	var index = $('#mb').children('img').length;
	var rand = parseInt(Math.random() * (x - y + 1) + y);
	$('#mb').append("<img class='float-x' src=''>");
	$('img.float-x:eq(' + index + ')').attr('src','img/2-'+num+'.png')
	$("img.float-x").animate({
		bottom:"800px",
		opacity:"0",
		left: rand
	},3000);s++;
}
});

	

