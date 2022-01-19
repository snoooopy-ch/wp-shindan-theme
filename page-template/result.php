<?php /* Template Name:結果ページ */ ?>

<?php
global $_GET;
$username = '';

if ((isset($_GET['cat1'])) && (isset($_GET['cat2'])) && (isset($_GET['cat3']))) {
	$cat1 = $_GET['cat1'];
	$cat2 = $_GET['cat2'];
	$cat3 = $_GET['cat3'];
} else {
	wp_redirect(get_home_url(), 301);
	exit;
}

if (isset($_GET['username'])) {
	$username = $_GET['username'];
}

get_header();

$args = array(
	'post_type' => 'animate',
	'post_status' => 'publish',
	'orderby' => 'title',
	'order' => 'ASC',
	'posts_per_page' => '-1'
);

$loop = new WP_Query($args);
$items = array();

while($loop->have_posts()) : $loop->the_post();
	$item['title'] = get_the_title();
	$item['index'] = get_field('index');;
	$item['img_url'] = get_field('img_url');
	$item['url'] = get_field('url');
	$item['category'] = get_field('category');

	$items[] = $item;
	unset($item);
endwhile;

$category_en = ['horror', 'robots', 'action', 'comedy', 'love', 'everyday', 'sports', 'fantasy', 'history', 'military', 'drama', 'short', '25d', 'live'];
$selected_wp = ['horror' => 0, 'robots' => 0, 'action' => 0, 'comedy' => 0, 'love' => 0, 'everyday' => 0, 'sports' => 0, 'fantasy' => 0, 'history' => 0, 'military' => 0, 'drama' => 0,'short' => 0, '25d' => 0, 'live' => 0];

$selected_wp[$category_en[$cat1 - 2]] = 5;
$selected_wp[$category_en[$cat2 - 2]] = 4;
$selected_wp[$category_en[$cat3 - 2]] = 3;

foreach ($items as $key => $item) {
	$ani_item_category = $item['category'];
	$sum = 0;

	foreach ( $category_en as $cat) {
		$sum += $ani_item_category[$cat] * $selected_wp[$cat];
	} 
	$items[$key]['sum'] = $sum;
}

usort($items, function($a, $b) { return $a['sum'] < $b['sum'] ? 1 : -1; });

$uploads_base_url = wp_get_upload_dir()['baseurl'];

$twitter_link = urlencode(home_url() . '/results?cat1=' . $cat1 . '&cat2=' . $cat2 . '&cat3=' . $cat3); 
?>

<div class="result-container">
	<div class="navbar">
		<a href="<?php echo get_home_url(); ?>" class="navbar-brand">アニギメ!</a>-あなたに合ったアニメをAIがサーチ-
	</div>
	<input id="cat1" value="<?php echo $cat1; ?>" hidden/>
	<input id="cat2" value="<?php echo $cat2; ?>" hidden/>
	<input id="cat3" value="<?php echo $cat3; ?>" hidden/>


	<div id="result" style="">
		<div id="meet-new-anime">-MEET NEW ANIME-</div>
		<div class="for-pc">
			<div id="osusume">
				<div id="osusume-text"><?php echo $username; ?>さんに<br>おすすめの<br>アニメはこちら！</div>
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/osusume-girl.png" width="115" height="140">
			</div>
		</div>

		<?php
		$twitter_titles = 'あなたのおすすめアニメは%0A';
		$titles = array();
		$i = 0;
		$show = 0;
		while($show < 10) {
			$cur_titles = preg_split('/ |　/', $items[$i]['title']);
			$cur_title1 = $cur_titles[0];
			$cur_title2 = '';
			if (count($cur_titles) >= 2) $cur_title2 = $cur_titles[1];

			$j = 0;
			for ($j = 0; $j < count($titles); $j++) {
				similar_text($cur_title1, $titles[$j], $percent);
				if ($percent >= 75) break;

				similar_text($cur_title2, $titles[$j], $percent);
				if ($percent >= 75) break;
			}
			
			if ($j == count($titles)) {
				$titles[] = $cur_title1;
				$show ++;
			} else {
				$i ++;
				continue;
			}
		?>
			<div class="for-pc">
				<div class="icon" style="text-align:left; display:table;">
					<?php if ($i < 5) { ?>
						<div class="icon" style="display:table-cell; vertical-align:middle; padding-right:5px; padding-left:40px;">
							マッチ率
						</div>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon<?php echo $i + 1; ?>.png" width="50" height="50">
					<?php } ?>
				</div>
				<div style="padding-bottom:5px;" class="anime-name"><?php echo $items[$i]['title']; ?></div>
				<div style="padding-bottom:20px;">
				<img src="<?php echo $uploads_base_url; ?>/anim-thumb/<?php echo $items[$i]['img_url'];?>" class="anime-image">
				</div>
				<div class="amazon" style="display:inline-block; padding-bottom:20px;">
					<div class="0" style="display:none;">
						<iframe src="https://rcm-fe.amazon-adsystem.com/e/cm?o=9&amp;p=294&amp;l=ur1&amp;category=primevideochannel&amp;banner=0NSPGYVA9YXSZRGEDP02&amp;f=ifr&amp;linkID=caaf95cb7302ae06107f85fc2fd05bad&amp;t=anigime-22&amp;tracking_id=anigime-22" width="320" height="100" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
					</div>
				</div>
				<div class="danime" style="display:inline-block; padding-bottom:20px;">
					<div class="0" style="/* display:none; */">
						<a href="<?php echo $items[$i]['url']; ?>" rel="nofollow">
						<img border="0" width="234" height="60" alt="" src="https://www25.a8.net/svt/bgt?aid=181223631074&amp;wid=001&amp;eno=01&amp;mid=s00000017962001006000&amp;mc=1"></a>
						<img border="0" width="1" height="1" src="https://www12.a8.net/0.gif?a8mat=2ZW91R+1823JM+3ULG+5ZMCH" alt="">
						<div style="text-decoration: none; color: indianred;">31日間無料/2300作品のアニメが見放題</div>
					</div>
				</div>
			</div>
		<?php 

		if ($i < 5) {
			$twitter_titles = $twitter_titles . '「' . $items[$i]['title'] . '」%0A';
		}
		$i ++;
		}
		$twitter_titles = $twitter_titles . 'です！残りの作品はこちら↓%0A';
		?>

		<div class="for-pc">
			<div style="padding-bottom:20px;">
				<div id="tsubuyaki">
					<div id="tsubuyaki-text">診断結果をつぶやこう！</div>
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/tsubuyaki-girl1.png" width="115" height="140">
				</div>
				<div style="padding-top:20px; padding-bottom:20px;">
				<button type="button" class="twitter"><a style="text-decoration: none;color: white;" href="https://twitter.com/intent/tweet?url=<?php echo $twitter_link; ?>&hashtags=アニピック,アニメガホン&text=<?php echo $twitter_titles; ?>" target="_blank" rel="nofollow">Twitterで診断結果をシェア</a></button>
				</div>
			</div>
		</div>
	</div>
	<a href="<?php echo get_home_url(); ?>" id="button4">もう一度診断する！</a>
</div>

<?php get_footer(); ?>

