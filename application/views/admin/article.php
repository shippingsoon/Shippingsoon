<div class="admin-banner">
	<div class="container">
		<div class="row">
			<h2 class="opensans">
				<?php if ($project_id): ?>
				Edit <?= $project['title'] ?>
				<?php else: ?>
				Add Article
				<?php endif ?>
			</h2>
		</div> <!-- .row -->
	</div>
</div>

<div class="container">
	<form class="form-horizontal" style="" id="project-form" method="post" action="<?= base_url("admin/article/$project_id") ?>" enctype="multipart/form-data">
		<input type="hidden" id="auto_complete" value="<?= $auto_complete ?>"/>
		<div class="col-md-12">
			<ol class="breadcrumb pull-left">
				<li><a href="<?= base_url('admin') ?>">Admin</a></li>
			<?php if ($project_id): ?>
				<li><a href="<?= base_url('admin/article') ?>">Article</a></li>
				<li class="active">Edit <?= $project['title'] ?></li>
			<?php else: ?>
				<li class="active">Article</li>
			<?php endif ?>
				
			</ol>
			<div class="pull-right" style="text-align:right;">
				<span class="required">*</span> required
			</div>
		</div> <!-- /.col-md-12 -->
		<div class="col-md-12">
		<?php if (validation_errors()):?>
			<div class="alert alert-danger"><?= validation_errors() ?></div>
		<?php endif ?>
		</div> <!-- /.col-md-12 -->
		<div class="col-md-6" style="clear:both;">
			<div class="form-group">
				<label class="col-md-3 control-label" for="title"><span class="required">*</span> Title:</label>
				<div class="col-md-8">
					<input id="title" class="form-control" name="title" type="text" value="<?= set_value('title', $project['title']) ?>" placeholder="title" maxlength="200" autocomplete="off" title="Project title" required/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="description">Description:</label>
				<div class="col-md-8">
					<textarea id="description" class="form-control" name="description" placeholder="description" maxlength="" autocomplete="off" title="A description of this project" row="3"><?= set_value('description', $project['description']) ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="tags"><span class="required">*</span> Tags:</label>
				<div class="col-md-8">
					<ul id="tags">
					<?php if (isset($project['tags'])): ?>
						<?php foreach ($project['tags'] AS $tag): ?>
						<li><?= $tag ?></li>
						<?php endforeach ?>
					<?php else: ?>
						<li>application</li>
						<li>development</li>
						<li>code</li>
					<?php endif ?>
					</ul>
					<p class="help-block">Search tags for the project (e.g., c++, php, seo).</p>
				</div>
			</div>
			<div class ="form-group">
				<label class="col-md-3 control-label" for="user_css">CSS File:</label>
				<div class="col-md-8">
					<input id="user_css" class="form-control" name="user_css" type="file" accept=""  title=""/>
					<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
					<span class="help-block"></span>
				</div>
			</div>
			<div class ="form-group">
				<label class="col-md-3 control-label" for="user_js">Javascript File:</label>
				<div class="col-md-8">
					<input id="user_js" class="form-control" name="user_js" type="file" accept=""  title=""/>
					<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
					<span class="help-block"></span>
				</div>
			</div>
			<div class ="form-group">
				<label class="col-md-3 control-label" for="user_image">Image:</label>
				<div class="col-md-8">
					<input id="user_image" class="form-control" name="user_image" type="file" accept="image/x-png, image/gif, image/jpeg"  title=""/>
					<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
					<span class="help-block"></span>
				</div>
			</div>
		</div> <!-- /.col-md-6 -->
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-3 control-label" for="category_id"><span class="required">*</span> Category:</label>
				<div class="col-md-8">
					<select id="category_id" class="form-control" name="category_id" title="Which category does this article belong to?">
						<?php foreach ($categories AS $category): ?>
						<option value="<?= $category['category_id'] ?>" <?= set_select('category_id', $category['category_id'], $project['category_id'] == $category['category_id']) ?>><?= $category['title'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="visible"><span class="required">*</span> Visible:</label>
				<div class="col-md-8">
					<select id="visible" class="form-control" name="visible" title="Make this project publicly visible?">
						<option value="0" <?= set_select('visible', 0, $project['visible'] == 0) ?>>No - Do not make this project publicly visible</option>
						<option value="1" <?= set_select('visible', 1, $project['visible'] == 1) ?>>Yes - Make this project publicly visible</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="listed"><span class="required">*</span> Listed:</label>
				<div class="col-md-8">
					<select id="listed" class="form-control" name="listed" title="List this project?">
						<option value="0" <?= set_select('listed', 0, $project['listed'] == 0) ?>>No - List this project</option>
						<option value="1" <?= set_select('listed', 1, $project['listed'] == 1) ?>>Yes - List this project</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="status">Status:</label>
				<div class="col-md-8">
					<select id="status" class="form-control" name="status" title="Is this project complete?">
						<option value="Incomplete" <?= set_select('status', 'Incomplete', $project['status'] == 'Incomplete') ?>>Incomplete</option>
						<option value="Complete" <?= set_select('status', 'Complete', $project['status'] == 'Complete') ?>>Complete</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="license">License:</label>
				<div class="col-md-8">
					<input id="license" class="form-control" name="license" type="text" value="<?= set_value('license', $project['license']) ?>" placeholder="license" maxlength="500" autocomplete="off" title="The license for this project"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="date_created">Date Created:</label>
				<div class="col-md-8">
					<input id="date_created" class="form-control" name="date_created" type="text" value="<?= set_value('date_created', $project['date_created']) ?>" placeholder="date created" maxlength="10" autocomplete="off" title="The date this project was created"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="date_modified">Date Modified:</label>
				<div class="col-md-8">
					<input id="date_modified" class="form-control" name="date_modified" type="text" value="<?= set_value('date_modified', $project['date_modified']) ?>" placeholder="date modified" maxlength="10" autocomplete="off" title="The date this project was modified"/>
				</div>
			</div>
		</div> <!-- /.col-md-6 -->
		
		<div class="col-md-12">
			
			<ul class="nav nav-tabs">
			<?php if (isset($pages)): ?>
				<?php foreach ($pages AS $key => $page): ?>
				<li class="<?php if ($key == 0): ?>active<?php endif ?>">
					<a href="#page-<?= $key + 1 ?>" data-toggle="tab">Page #<?= $key + 1 ?></a>
				</li>
				<?php endforeach ?>
			<?php endif ?>
				<li class="<?php if (!isset($pages) AND empty($pages)): ?>active<?php endif ?>">
					<a href="#new-page" data-toggle="tab">New Page</a>
				</li>
			</ul> <!-- /.nav .nav-tabs -->

			
			<div class="tab-content">
			<?php if (isset($pages)): ?>
				<?php foreach ($pages AS $key => $page): ?>
				<div class="tab-pane <?php if ($key == 0): ?>active<?php endif ?>" id="page-<?= $key + 1 ?>">
					<textarea class="form-control" name="pages[]" placeholder="content" maxlength="" autocomplete="off" title="The page's content" row="10"><?= set_value('pages[]', $page['content']) ?></textarea>
				</div>
				<?php endforeach ?>
			<?php endif ?>
				<div class="tab-pane <?php if (!isset($pages) AND empty($pages)): ?>active<?php endif ?>" id="new-page">
					<textarea class="form-control" name="pages[]" placeholder="content" maxlength="" autocomplete="off" title="The page's content" row="10"><?= set_value('pages[]', '') ?></textarea>
				</div>
			
			</div> <!-- /.tab-content -->
			
		</div>
		<div class="col-md-12 center">
			<?php if ($project_id): ?>
			<a href="<?= base_url("blog/{$project['category_title']}/{$project['slug']}/$project_id") ?>" style="" class="btn btn-warning btn-lg" title="View <?= $project['title'] ?>">View</a>
			<?php endif ?>
			<input type="submit" value="Save" class="btn btn-primary btn-lg"/>
			<br/><br/>
		</div>
	</form>
</div> <!-- /.container -->

