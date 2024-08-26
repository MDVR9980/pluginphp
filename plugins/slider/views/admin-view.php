
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link <?=$tab == 'slider1' ? 'active':''?>" href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>?tab=slider1">Slider 1</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?=$tab == 'slider2' ? 'active':''?>" href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>?tab=slider2">Slider 2</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?=$tab == 'slider3' ? 'active':''?>" href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>?tab=slider3">Slider 3</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?=$tab == 'slider4' ? 'active':''?>" href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>?tab=slider4">Slider 4</a>
  </li>

</ul>

<form onsubmit="slider.submit(event)" method="post" enctype="multipart/form-data">
	
	<?=csrf()?>
	
	<div class="progress my-3 d-none">
		<div class="progress-bar" style="width: 0%">Uploading... 0%</div>
	</div>

	<?php if($tab == 'slider1'):?>
		
		<div class="p-2">
				
				<label style="display: block;cursor: pointer;">
					<img src="<?=get_image($row->image ?? '')?>" class="img-thumbnail" style="width:100%;height:350px;object-fit: cover">
					<input onchange="slider.displayImage(event)" type="file" name="image" style="display:none">
				</label>

				<div class="my-3">
					<label>Caption:</label>
					<input type="text" class="form-control" name="caption" value="<?=$row->caption ?? ''?>" placeholder="Add your caption here">
				</div>
				<div class="my-3">
					<label>Link:</label>
					<input type="text" class="form-control" name="link" value="<?=$row->link ?? ''?>" placeholder="Link">
				</div>
				<input type="hidden" name="id" value="1">
		</div>
	<?php elseif($tab == 'slider2'):?>
				
		<div class="p-2">
				
				<label style="display: block;cursor: pointer;">
					<img src="<?=get_image($row->image ?? '')?>" class="img-thumbnail" style="width:100%;height:350px;object-fit: cover">
					<input onchange="slider.displayImage(event)" type="file" name="image" style="display:none">
				</label>

				<div class="my-3">
					<label>Caption:</label>
					<input type="text" class="form-control" name="caption" value="<?=$row->caption ?? ''?>" placeholder="Add your caption here">
				</div>
				<div class="my-3">
					<label>Link:</label>
					<input type="text" class="form-control" name="link" value="<?=$row->link ?? ''?>" placeholder="Link">
				</div>
				<input type="hidden" name="id" value="2">
		</div>
	<?php elseif($tab == 'slider3'):?>
				
		<div class="p-2">
				
				<label style="display: block;cursor: pointer;">
					<img src="<?=get_image($row->image ?? '')?>" class="img-thumbnail" style="width:100%;height:350px;object-fit: cover">
					<input onchange="slider.displayImage(event)" type="file" name="image" style="display:none">
				</label>

				<div class="my-3">
					<label>Caption:</label>
					<input type="text" class="form-control" name="caption" value="<?=$row->caption ?? ''?>" placeholder="Add your caption here">
				</div>
				<div class="my-3">
					<label>Link:</label>
					<input type="text" class="form-control" name="link" value="<?=$row->link ?? ''?>" placeholder="Link">
				</div>
				<input type="hidden" name="id" value="3">
		</div>
	<?php elseif($tab == 'slider4'):?>
				
		<div class="p-2">
				
				<label style="display: block;cursor: pointer;">
						<img src="<?=get_image($row->image ?? '')?>" class="img-thumbnail" style="width:100%;height:350px;object-fit: cover">
					<input onchange="slider.displayImage(event)" type="file" name="image" style="display:none">
				</label>

				<div class="my-3">
					<label>Caption:</label>
					<input type="text" class="form-control" name="caption" value="<?=$row->caption ?? ''?>" placeholder="Add your caption here">
				</div>
				<div class="my-3">
					<label>Link:</label>
					<input type="text" class="form-control" name="link" value="<?=$row->link ?? ''?>" placeholder="Link">
				</div>
				<input type="hidden" name="id" value="4">
		</div>
	<?php endif?>

	<button type="submit" class="btn btn-primary">Save</button>
</form>

<script>
	
	const slider = {

		imageAdded: false,
		allowed: ['image/jpeg','image/png','image/webp'],
		uploading: false,

		submit: function(e){

			e.preventDefault();

			if(slider.uploading)
				return;

			let myform = new FormData();

			let inputs = e.currentTarget.querySelectorAll('input');
			for (var i = 0; i < inputs.length; i++) {

				if(inputs[i].name == 'image') {

					if(slider.imageAdded)
						myform.append(inputs[i].name,inputs[i].files[0]);
				} else {
					myform.append(inputs[i].name,inputs[i].value.trim());
				}
			}

			let xhr = new XMLHttpRequest;
			xhr.addEventListener('readystatechange',function() {

				if(xhr.readyState == 4){

					slider.uploading = false;

					if(xhr.status == 200) {
						slider.handleResult(xhr.responseText);
					} else {
						alert("An error occured");
						console.log(xhr.error);
					}
				}
			});

			xhr.upload.addEventListener('progress',function(e) {

				let percent = Math.round((e.loaded / e.total) * 100);
				let bar = document.querySelector('.progress-bar');

				bar.style.width = percent + '%';
				bar.innerHTML = 'Uploading... ' + percent + '%';
			});

			slider.uploading = true;
			document.querySelector('.progress').classList.remove('d-none');

			xhr.open('post','',true);
			xhr.send(myform);

		},

		displayImage: function(e) {
			if(!slider.validate(e.currentTarget.files[0])) {
				alert("Only files of this type allowed: "+ slider.allowed.toString().replaceAll('image/',''));
				slider.imageAdded = false;
				return false;
			}
			e.currentTarget.parentNode.querySelector("img").src = URL.createObjectURL(e.currentTarget.files[0]);
			slider.imageAdded = true;
		},

		handleResult: function(result) {
			let obj = JSON.parse(result);
			if(obj.success) {
				alert(obj.message);
			} else {
				console.log(result);
			}
			window.location.reload();
		},

		validate: function(file) {

			if(slider.allowed.includes(file.type))
				return true;

			return false;
		}
	};
</script>