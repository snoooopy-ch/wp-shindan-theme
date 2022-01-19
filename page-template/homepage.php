<?php /* Template Name:トープページ */ ?>
<?php get_header(); ?>

<div class="body-content">
	<div class="container">
		<div>
			<a href="<?php echo get_home_url(); ?>" class="logo">アニギメ!</a>
		</div>
		<div>好きなアニメを選ぶだけで<br>あなたにおすすめのアニメを<br>AIが診断します！</div>
		<div>
			<form method="post" id="shinndan" action="<?php echo home_url(); ?>/shindan/">
				<input id="input-text" type="text" name="username" placeholder="ニックネームを入力してね">
			</form>
			<div>
				<button type="submit" id="button1" form="shinndan">診断してみる！</button>
			</div>
		</div>
		<div>
			<img src="<?php  echo get_template_directory_uri(); ?>/assets/images/top-page.png" class="top-girl">
		</div>
	</div>
</div>

<?php get_footer(); ?>

