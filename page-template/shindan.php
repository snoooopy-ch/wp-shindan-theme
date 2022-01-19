<?php /* Template Name:診断ページ */ ?>
<?php get_header(); 
global $_POST;
$username = '';
if (isset($_POST['username'])) {
	$username = $_POST['username'];
}
?>

<div class="body-content">
	<div class="navbar">
		<a href="<?php echo get_home_url(); ?>" class="navbar-brand">アニギメ!</a>-あなたに合ったアニメをAIがサーチ-
	</div>
	<div class="container">
		<div class="fukidashi">
			<div id="outer">
				<div id="inner">
					<div style="padding-bottom:5px;" class="header-text">この中で好きなアニメを選んでね！</div>
					<div id="cat-container">
						
					</div>
				</div>
			</div>
		</div>
		<div id="girl">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/question1.png" width="224" height="301" style="padding-left:30px;">
		</div>
	</div>
</div>
<script>
	let category_in_page = 7;
	let selected_category = [];

	jQuery(document).ready(function($) {
		shuffleArray(category_wp);
		addCategory();
		
		$('#inner').on("click", ".cat-button", function(e) {
			if (selected_category.length >= 3) {
				return;
			}

			var element = e.target;
			selected_category.push(parseInt(element.value));
			if (selected_category.length == 3) {
				// shindanAnimate();
				redirectToResultPage();
			} else {
				category_wp = arr_diff(category_wp, selected_category);
				shuffleArray(category_wp);
				console.log(category_wp);
				addCategory();
			}
			
		});

		$('#inner').on("click", ".skip-button", function(e) {
			var element = e.target;
			console.log(element.value);
			shuffleArray(category_wp);
			addCategory();
		});

		function shuffleArray(array) {
			// 削除 2.5次元部隊とlive
			for (var i = array.length - 3; i > 0; i--) {
				var j = Math.floor(Math.random() * (i + 1));
				var temp = array[i];
				array[i] = array[j];
				array[j] = temp;
			}
		}

		function addCategory() {
			var div_outer = $('#cat-container');
			div_outer.empty();
			for (i = 0; i < category_in_page; i ++) {
				var div_child = '<div class="anime"><button class="cat-button" name="' +  category_wp[i] + '" value="' + category_wp[i] + '" type="button">' + category_jp[category_wp[i] - 2] + '</button></div>';
				div_outer.append(div_child);
			}
			div_outer.append('<div class="skip-button"><button class="button3" name="6" value="skip" type="button">この中にはない！</button></div>')
		}

		function arr_diff (a1, a2) {
			var diff = [];
			jQuery.grep(a1, function(el) {
				if (jQuery.inArray(el, a2) == -1) diff.push(el);
			});

			return diff;
		}

		function redirectToResultPage() {
			var url = '<?php echo home_url(); ?>/results?cat1=' + selected_category[0] + '&cat2=' + selected_category[1] + '&cat3=' + selected_category[2] + '&username=<?php echo $username; ?>'; 
			window.location.href = url;
			// var redirect = '<?php echo home_url(); ?>/results';
			// jQuery.redirectPost(redirect, {var1: selected_category[0], y: selected_category[1], z: selected_category[2]});
		}

		jQuery.extend(
		{
			redirectPost: function(location, args)
			{
				var form = '';
				$.each( args, function( key, value ) {
					form += '<input type="hidden" name="'+key+'" value="'+value+'">';
				});
				$('<form action="'+location+'" method="POST">'+form+'</form>').appendTo('body').submit();
			}
		});
	});

	

	
</script>
<?php get_footer(); ?>

