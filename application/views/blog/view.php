<div class="blog-entry-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<ol class="breadcrumb pull-left">
					<li><a href="<?= base_url('blog') ?>">Blog</a></li>
					<li><a href="<?= base_url("blog/$method") ?>"><?= ucfirst($method) ?></a></li>
					<li class="active"><?= $article['title'] ?></li>
				<?php if ($layout['logged_in']): ?>
					<li>
						<a href="<?= base_url("admin/article/{$article['article_id']}") ?>" class="btn btn-danger btn-xs">
							<span class="glyphicon glyphicon-wrench"></span>
						</a>
					</li>
				<?php endif ?>
				</ol>
				<time datetime="<?= $article['date_created'] ?>" class="breadcrumb pull-right">
					<i class="fa fa-clock-o"></i> Published: <?= $article['date_created'] ?>
				</time>
			</div> <!-- /.col-md-8 -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->
</div> <!-- /.wrapper blog-entry-wrapper -->
<div class=" blog-entry-wrapper">
	<div class="container">
	<?php if (isset($article['content'])): ?>
		<?= $article['content'] ?>
		<br/>
	<?php endif ?>
	</div> <!-- /.container -->
</div> <!-- ./wrapper .blog-entry-wrapper -->
