<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\Topic;
use app\models\User;
use app\models\Favorite;

$settings = Yii::$app->params['settings'];
$currentPage = $pages->page+1;

$this->title = Html::encode($tag['name']);
?>

<div class="row">

<!-- sf-left start -->
<div class="col-md-8 sf-left">

<div class="box">
	<div class="inner">
		<span class="fr gray small">主题总数 <?= $tag['topic_count'] ?></span>
		<?= Html::a('首页', ['topic/index']), '&nbsp;/&nbsp;', $this->title ?>
	</div>
	<?php
	foreach($topics as $topic){
		$topic = $topic['topic'];
		$url = ['topic/view', 'id'=>$topic['id']];
//		if ( $currentPage > 1) {
			$url['ip'] = $currentPage;
//		}
		echo '<div class="cell item clearfix">
				<div class="item-avatar">',
					Html::a(Html::img('@web/'.str_replace('{size}', 'normal', $topic['author']['avatar']), ["alt" => Html::encode($topic['author']['username'])]), ['user/view', 'username'=>Html::encode($topic['author']['username'])]),
				'</div>
			 	 <div class="item-content">
					<div class="item-title">',
					Html::a(Html::encode($topic['title']), $url),
					'</div>
					<div class="small gray">';
		if($topic['comment_count'] > 0){
		    $gotopage = ceil($topic['comment_count']/intval($settings['comment_pagesize']));
		    if($gotopage > 1){
				$url['p'] = $gotopage;
		    }
			echo '<div class="item-commentcount">', Html::a($topic['comment_count'], $url, ['class'=>'count_livid']),'</div>';
		}
					echo Html::a(Html::encode($topic['node']['name']), ['topic/node', 'name'=>$topic['node']['ename']], ['class'=>'node']),
					'  •  <strong>', Html::a(Html::encode($topic['author']['username']),['user/view', 'username'=>Html::encode($topic['author']['username'])]), '</strong>',
					' •  ', Yii::$app->formatter->asRelativeTime($topic['replied_at']);
		if ($topic['comment_count']>0) {
					echo '<span class="item-lastreply"> •  最后回复者 ', Html::a(Html::encode($topic['lastReply']['username']), ['user/view', 'username'=>Html::encode($topic['lastReply']['username'])]), '</span>';
		}
					echo '</div>
				</div>';


		echo '</div>';
	}
	?>
	<div class="item-pagination">
	<?php
	echo LinkPager::widget([
	    'pagination' => $pages,
		'maxButtonCount'=>5,
	]);
	?>
	</div>

</div>

</div>
<!-- sf-left end -->

<!-- sf-right start -->
<div class="col-md-4 sf-right">
<?= $this->render('@app/views/common/_right') ?>
</div>
<!-- sf-right end -->

</div>