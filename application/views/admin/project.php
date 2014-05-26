<div class="admin-banner">
	<div class="container">
		<div class="row">
			<h2 class="opensans">
				<?php if ($project_id): ?>
				Edit <?= "{$project['title']} {$project['version']}" ?>
				<?php else: ?>
				Add Project
				<?php endif ?>
			</h2>
		</div> <!-- .row -->
	</div>
</div>

<div class="container">
	<form class="form-horizontal" style="" id="project-form" method="post" action="<?= base_url("admin/project/$project_id") ?>" enctype="multipart/form-data">
		<input type="hidden" id="auto_complete" value="<?= $auto_complete ?>"/>
		<div class="col-md-12">
			<ol class="breadcrumb pull-left">
				<li><a href="<?= base_url('admin') ?>">Admin</a></li>
			<?php if ($project_id): ?>
				<li><a href="<?= base_url('admin/project') ?>">Project</a></li>
				<li class="active">Edit <?= "{$project['title']} {$project['version']}" ?></li>
			<?php else: ?>
				<li class="active">Project</li>
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
			<div class ="form-group">
				<label class="col-md-3 control-label" for="user_file">File:</label>
				<div class="col-md-8">
					<input id="user_file" class="form-control" name="user_file" type="file" accept=""  title=""/>
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
				<label class="col-md-3 control-label" for="status">Status:</label>
				<div class="col-md-8">
					<select id="status" class="form-control" name="status" title="Is this project complete?">
						<option value="Incomplete" <?= set_select('status', 'Incomplete', $project['status'] == 'Incomplete') ?>>Incomplete</option>
						<option value="Complete" <?= set_select('status', 'Complete', $project['status'] == 'Complete') ?>>Complete</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="version">Version:</label>
				<div class="col-md-8">
					<input id="version" class="form-control" name="version" type="text" value="<?= set_value('version', $project['version']) ?>" placeholder="version" maxlength="500" autocomplete="off" title="The version of this project"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="reference">Reference:</label>
				<div class="col-md-8">
					<input id="reference" class="form-control" name="reference" type="text" value="<?= set_value('reference', $project['reference']) ?>" placeholder="reference" maxlength="500" autocomplete="off" title="A reference/citation used for this project"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="link">Link:</label>
				<div class="col-md-8">
					<input id="link" class="form-control" name="link" type="text" value="<?= set_value('link', $project['link']) ?>" placeholder="link" maxlength="250" autocomplete="off" title="A link to the project"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="indention_style">Indention Style:</label>
				<div class="col-md-8">
					<input id="indention_style" class="form-control" name="indention_style" type="text" value="<?= set_value('indention_style', $project['indention_style']) ?>" placeholder="indention style" maxlength="100" autocomplete="off" title="Indention style"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="license">License:</label>
				<div class="col-md-8">
					<input id="license" class="form-control" name="license" type="text" value="<?= set_value('license', $project['license']) ?>" placeholder="license" maxlength="500" autocomplete="off" title="The license for this project"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="owner">Owner:</label>
				<div class="col-md-8">
					<input id="owner" class="form-control" name="owner" type="text" value="<?= set_value('owner', $project['owner']) ?>" placeholder="owner" maxlength="100" autocomplete="off" title="The owner of this project"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="line_count">Line Count:</label>
				<div class="col-md-8">
					<input id="line_count" class="form-control" name="line_count" type="text" value="<?= set_value('line_count', $project['line_count']) ?>" placeholder="line count" maxlength="10" autocomplete="off" title="The line count of this project"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="word_count">Word Count:</label>
				<div class="col-md-8">
					<input id="word_count" class="form-control" name="word_count" type="text" value="<?= set_value('word_count', $project['word_count']) ?>" placeholder="word count" maxlength="10" autocomplete="off" title="The word count of this project"/>
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
		<div class="col-md-12 center">
			<?php if ($project_id): ?>
			<a href="<?= base_url("portfolio/view/{$project['slug']}/{$project['project_id']}") ?>" style="" class="btn btn-warning btn-lg" title="View <?= $project['title'] ?>">View</a>
			<?php endif ?>
			<input type="submit" value="Save" class="btn btn-primary btn-lg"/>
			<br/><br/>
		</div>
	</form>
</div> <!-- /.container -->

