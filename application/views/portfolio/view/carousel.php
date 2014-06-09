<?php if (!empty($images)): ?>
			<div id="portfolio-carousel" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
<?php for($i = 0; $i < count($images); $i++): ?>
					<li data-target="#portfolio-carousel" data-slide-to="<?= $i ?>" class="<?php if ($i == 0): ?>active<?php endif ?>"></li>
<?php endfor ?>
				</ol> <!-- /.carousel-indicators -->
				<div class="carousel-inner">
<?php foreach ($images AS $key => $image): ?>
					<div class="item <?php if ($key == 3): ?>active<?php endif ?>">
						<a class="fancybox" href="<?= base_url("uploads/articles/img/$article_id/$image") ?>" title="<?= $title ?>">
							<img class="img-responsive" src="<?= base_url("uploads/articles/img/$article_id/$image") ?>" alt="">
						</a>
						<div class="carousel-caption"></div>
					</div> <!-- /.item -->
<?php endforeach ?>
				</div> <!-- /.carousel-inner -->
				<a class="left carousel-control" href="#portfolio-carousel" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
				</a>
				<a class="right carousel-control" href="#portfolio-carousel" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
				</a>
			</div> <!-- /#portfolio-carousel .carousel .slide -->
<?php endif ?>
