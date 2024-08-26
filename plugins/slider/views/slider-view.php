<link rel="stylesheet" href="<?=plugin_http_path('assets/css/my-slider.css')?>"/>
<script src="<?=plugin_http_path('assets/js/ism-2.2.min.js')?>"></script>

<div class="ism-slider" data-transition_type="fade" data-play_type="loop" id="my-slider">
  <ol>

    <?php if(!empty($rows)):?>
      <?php foreach($rows as $row):?>
        <li>
          <a href="<?=$row->link?>" target="_blank">
            <img src="<?=get_image($row->image)?>">
            <div class="ism-caption ism-caption-0"><?=esc($row->caption)?></div>
          </a>
        </li>
      <?php endforeach?>
    <?php else:?>
      <li>
        <div class="alert alert-success">No images found. Please add images in the admin section</div>
      </li>
    <?php endif?>

  </ol>
</div>