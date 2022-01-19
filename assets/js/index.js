let category_jp = ['ホラー/サスペンス/推理', 'ロボット/メカ', 'アクション/バトル', 'コメディ/ギャグ', '恋愛/ラブコメ', '日常/ほのぼの', 'スポーツ/競技', 'SF/ファンタジー', '歴史/戦記', '戦争/ミリタリー', 'ドラマ/青春', 'ショート', '2.5次元舞台', 'ライブ/ラジオ/etc.'];
let category_en = ['horror', 'robots', 'action', 'comedy', 'love', 'everyday', 'sports', 'fantasy', 'history', 'military', 'drama', 'short', '25d', 'live'];
let selected_wp = {'horror':0, 'robots':0, 'action':0, 'comedy':0, 'love':0, 'everyday':0, 'sports':0, 'fantasy':0, 'history':0, 'military':0, 'drama':0,'short':0, '25d':0, 'live':0};
let category_wp = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];

jQuery(document).ready(function($) {
	

	funcResize();
	$(window).resize(function() {
		funcResize();
	});

	function funcResize() {
		var wid = $(window).width();

		//画像の切替
		if (wid < 768) {
			$('.switch').each(function() {
				$(this).attr("src", $(this).attr("src").replace('_pc', '_sp'));
			});
		} else {
			$('.switch').each(function() {
				$(this).attr("src", $(this).attr("src").replace('_sp', '_pc'));
			});
		}
		//sp_menu(画像の置換)
		if (wid < 768) {
			$('header nav').each(function() {
				$(this).addClass('sp-nav').removeClass('pc-nav');
			});
		} else {
			$('header nav').each(function() {
				$(this).addClass('pc-nav').removeClass('sp-nav');
			});
		}
	};
});