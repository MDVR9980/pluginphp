<?php if(user_can('add_page')):?>
	
	<form onsubmit="page.submit(event)" method="post" enctype="multipart/form-data">
		
		<div class="row g-3 mb-5 pb-5">
		
		<?=csrf()?>

		<h4 class="text-center">New Website Page</h4>
		
		<div class="row">
			<label class="col-md-3 text-center">
				<img src="<?=get_image('')?>" class="img-thumbnail" style="cursor:pointer;width:100%;max-width:200px;max-height: 200px;object-fit: cover;">
				<input onchange="display_image(event)" type="file" name="image" class="d-none">

				<?php if(!empty($errors['image'])):?>
				  <small class="text-danger"><?=$errors['image']?></small>
				<?php endif?>
			</label>

			<div class="col-md-9">
				<div class="mb-3 col-md-12">
				  <label for="title" class="form-label">Title</label>
				  <input name="title" value="<?=old_value('title')?>" type="text" class="form-control" id="title" placeholder="Title">
					
					<?php if(!empty($errors['title'])):?>
					  <small class="text-danger"><?=$errors['title']?></small>
					<?php endif?>
				</div>

				<div class="mb-3 col-md-12">
				  <label for="slug" class="form-label">Slug</label>
				  <input name="slug" value="<?=old_value('slug')?>" type="text" class="form-control" id="slug" placeholder="Slug">
					
					<?php if(!empty($errors['slug'])):?>
					  <small class="text-danger"><?=$errors['slug']?></small>
					<?php endif?>
				</div>


				<div class="mb-3 col-md-12">
				  <label for="description" class="form-label">Description (Optional, for SEO)</label>
				  <input name="description" value="<?=old_value('description')?>" type="text" class="form-control" id="description" placeholder="Description">
					
					<?php if(!empty($errors['description'])):?>
					  <small class="text-danger"><?=$errors['description']?></small>
					<?php endif?>
				</div>

				<div class="mb-3 col-md-12">
				  <label for="keywords" class="form-label">Keywords(Optional, SEO)</label>
				  <input name="keywords" value="<?=old_value('keywords')?>" type="text" class="form-control" id="keywords" placeholder="Keywords">
					
					<?php if(!empty($errors['keywords'])):?>
					  <small class="text-danger"><?=$errors['keywords']?></small>
					<?php endif?>
				</div>

				<div class="mb-3 col-md-12">
					<label for="content" class="form-label">Display Featured Image</label>
					<select name="display_featured_image" class="form-select">
						<option <?=old_select('display_featured_image','1')?> value="1">Yes</option>
						<option <?=old_select('display_featured_image','0')?> value="0">No</option>
					</select>
				</div>

			</div>
		</div>
		
 		<div class="mb-3 col-md-12">
		  <label for="content" class="form-label">Page content</label>
			<textarea rows="10" id="content" name="content" class="summernote form-control" placeholder="Your page content in HTML"><?=old_value('content')?></textarea>
			<?php if(!empty($errors['content'])):?>
			  <small class="text-danger"><?=$errors['content']?></small>
			<?php endif?>
		</div>

		<div class="mb-3 col-md-12 border p-2">
			<label>Categories:</label>
			<div class="row g-2">
				<?php 
					$query = "select * from categories where disabled = 0";
					$categories = $page->query($query); 
				?>

				<?php if(!empty($categories)):$num = 0?>
					<?php foreach($categories as $category):$num++?>
						<div class="form-check col-md-6">
						  <input name="category[]" class="form-check-input" type="checkbox" value="<?=$category->id?>" id="check<?=$num?>">
						  <label class="form-check-label" for="check<?=$num?>" style="cursor:pointer;">
						    <?=esc(str_replace("_", " ", $category->category))?>
						  </label>
						</div>
					<?php endforeach?>
				<?php endif?>
			</div>

		</div>
 
 		<div class="progress my-1 d-none">
 			<div class="progress-bar" style="width:0%">0%</div>
 		</div>

		<div class="d-flex justify-content-between">
			<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>">
				<button type="button" class="btn btn-primary">
					<i class="fa-solid fa-chevron-left"></i> Back
				</button>
			</a>
			<button class="btn btn-danger">
				<i class="fa-solid fa-save"></i> Save
			</button>
		</div>
	</div>
	</form>

	<script type="text/javascript">

		var valid_image = true;
		var image_added = false;
		function display_image(e)
		{
			let allowed = ['image/jpeg','image/png','image/webp'];
			let file = e.currentTarget.files[0];

			if(!allowed.includes(file.type)){
				alert("Only files of this type allowed: " + allowed.toString().replaceAll('image/',''));
				valid_image = false;
				image_added = false;
				return;
			}
			valid_image = true;
			image_added = true;
			e.currentTarget.parentNode.querySelector('img').src = URL.createObjectURL(file);
		}

		function submit_form(e)
		{
			if(!valid_image)
			{
				e.preventDefault()
				alert("Please add a valid image");
				return;
			}
		}


		const page = {

			uploading: false,

			submit: function(e)
			{
				e.preventDefault();

				if(page.uploading){
					alert("Please wait while we upload");
					return;
				}

				let inputs = e.currentTarget.querySelectorAll("input,select,textarea");

 				document.querySelector('.progress').style.width = '0%';
 				document.querySelector('.progress').innerHTML = 'Saving...' + '0%';
 				document.querySelector('.progress').classList.remove('d-none');

				let myform = new FormData();
				for (var i = 0; i < inputs.length; i++) {

					if(inputs[i].type == 'file'){
						if(image_added)
							myform.append(inputs[i].name,inputs[i].files[0]);
					}else if(inputs[i].type == 'checkbox' || inputs[i].type == 'radio'){
						if(inputs[i].checked)
							myform.append(inputs[i].name,inputs[i].value);
					}else{

						if(inputs[i].name == 'title' && inputs[i].value.trim() == ''){

							alert("A title is required!");
							return;
						}
						myform.append(inputs[i].name,inputs[i].value);
					}
				}

				page.uploading = true;
				let xhr = new XMLHttpRequest();

				xhr.addEventListener('readystatechange',function(e){

					if(xhr.readyState == 4)
					{
						page.uploading = false;

						if(xhr.status == 200)
						{
							page.handleResult(xhr.responseText);
						}
					}
				});

				xhr.upload.addEventListener('progress',function(e){

					let percent = Math.round((e.loaded / e.total) * 100);
					let prog = document.querySelector('.progress-bar');
					prog.style.width = percent + '%';
					prog.innerHTML = 'Saving...' + percent + '%';
				});
 
				xhr.open('post','',true);
				xhr.send(myform);
			},

			handleResult: function(result)
			{
				let obj = JSON.parse(result);
				if(typeof obj == 'object')
				{
					alert(obj.message);
					if(obj.success)
					{
						window.location.href = '<?=ROOT?>/<?=$vars['admin_route']?>/<?=$vars['plugin_route']?>';
					}else{
						for(key in obj.errors)
						{
							alert(obj.errors[key]);
						}
					}
				}else{
					console.log(result);
				}
			},
 
		}

	</script>

	<!-- include libraries(jQuery, bootstrap) -->
	<script src="<?=plugin_http_path('assets/js/jquery-3.7.1.min.js')?>"></script>

	<!-- include summernote css/js -->
	<link href="<?=plugin_http_path('summernote-0.8.18-dist/summernote-lite.min.css')?>" rel="stylesheet">
	<script src="<?=plugin_http_path('summernote-0.8.18-dist/summernote-lite.min.js')?>"></script>

	<script type="text/javascript">
		
		window.addEventListener('load',function(){

			$(document).ready(function() {
			  $('.summernote').summernote({
			  	placeholder: 'Your page content',
		        tabsize: 2,
		        height: 400
			  });
			});
		});

	</script>
<?php else:?>
	<div class="alert alert-danger text-center">
		Access denied. You dont have permission for this action
	</div>
<?php endif?>