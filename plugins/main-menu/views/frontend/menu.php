<link href="<?=plugin_http_path('assets/css/all.min.css')?>" rel="stylesheet">
<style type="text/css">
		 
	nav{
	  z-index: 99;
	  width: 100%;
	  background: #242526;

	}
	nav .wrapper{
	  position: relative;
	  max-width: 1300px;
	  padding: 0px 30px;
	  height: 50px;
	  line-height: 70px;
	  margin: auto;
	  display: flex;
	  align-items: center;
	  justify-content: space-between;
	}
	.wrapper .logo a{
	  color: #f2f2f2;
	  font-size: 30px;
	  font-weight: 600;
	  text-decoration: none;
	}
	.wrapper .menu-nav-links{
	  display: inline-flex;
	}
	.menu-nav-links li{
	  list-style: none;
	}
	.menu-nav-links li a{
	  color: #f2f2f2;
	  text-decoration: none;
	  font-size: 16px;
	  font-weight: 500;
	  padding: 9px 15px;
	  border-radius: 5px;
	  transition: all 0.3s ease;
	}
	.menu-nav-links li a:hover{
	  background: #3A3B3C;
	}
	.menu-nav-links .mobile-item{
	  display: none;
	}
	.menu-nav-links .drop-menu{
	  position: absolute;
	  background: #242526;
	  width: 180px;
	  line-height: 45px;
	  top: 85px;
	  opacity: 0;
	  visibility: hidden;
	  box-shadow: 0 6px 10px rgba(0,0,0,0.15);
	  z-index: 98;
	}
	.menu-nav-links li:hover .drop-menu,
	.menu-nav-links li:hover .mega-box{
	  transition: all 0.3s ease;
	  top: 50px;
	  opacity: 1;
	  visibility: visible;
	}
	.drop-menu li a{
	  width: 100%;
	  display: block;
	  padding: 0 0 0 15px;
	  font-weight: 400;
	  border-radius: 0px;
	}
	.mega-box{
	  position: absolute;
	  left: 0;
	  width: 100%;
	  padding: 0 30px;
	  top: 85px;
	  opacity: 0;
	  visibility: hidden;
	  z-index: 98;
	}
	.mega-box .content{
	  background: #242526;
	  padding: 25px 20px;
	  display: flex;
	  width: 100%;
	  justify-content: space-between;
	  box-shadow: 0 6px 10px rgba(0,0,0,0.15);
	}
	.mega-box .content .row{
	  width: calc(25% - 30px);
	  line-height: 45px;
	}
	.content .row img{
	  width: 100%;
	  height: 100%;
	  object-fit: cover;
	}
	.content .row header{
	  color: #f2f2f2;
	  font-size: 20px;
	  font-weight: 500;
	}
	.content .row .mega-links{
	  margin-left: -40px;
	  border-left: 1px solid rgba(255,255,255,0.09);
	}
	.row .mega-links li{
	  padding: 0 20px;
	}
	.row .mega-links li a{
	  padding: 0px;
	  padding: 0 20px;
	  color: #d9d9d9;
	  font-size: 17px;
	  display: block;
	}
	.row .mega-links li a:hover{
	  color: #f2f2f2;
	}
	.wrapper .btn{
	  color: #fff;
	  font-size: 20px;
	  cursor: pointer;
	  display: none;
	}
	.wrapper .btn.close-btn{
	  position: absolute;
	  right: 30px;
	  top: 10px;
	}

	@media screen and (max-width: 970px) {
	  .wrapper .btn{
	    display: block;
	  }
	  .wrapper .menu-nav-links{
	    position: fixed;
	    height: 100vh;
	    width: 100%;
	    max-width: 350px;
	    top: 0;
	    left: -100%;
	    background: #242526;
	    display: block;
	    padding: 50px 10px;
	    line-height: 50px;
	    overflow-y: auto;
	    box-shadow: 0px 15px 15px rgba(0,0,0,0.18);
	    transition: all 0.3s ease;
	  }
	  /* custom scroll bar */
	  ::-webkit-scrollbar {
	    width: 10px;
	  }
	  ::-webkit-scrollbar-track {
	    background: #242526;
	  }
	  ::-webkit-scrollbar-thumb {
	    background: #3A3B3C;
	  }
	  #menu-btn:checked ~ .menu-nav-links{
	    left: 0%;
	  }
	  #menu-btn:checked ~ .btn.menu-btn{
	    display: none;
	  }
	  #close-btn:checked ~ .btn.menu-btn{
	    display: block;
	  }
	  .menu-nav-links li{
	    margin: 15px 10px;
	  }
	  .menu-nav-links li a{
	    padding: 0 20px;
	    display: block;
	    font-size: 20px;
	  }
	  .menu-nav-links .drop-menu{
	    position: static;
	    opacity: 1;
	    top: 65px;
	    visibility: visible;
	    padding-left: 20px;
	    width: 100%;
	    max-height: 0px;
	    overflow: hidden;
	    box-shadow: none;
	    transition: all 0.3s ease;
	  }
	  .showDrop:checked ~ .drop-menu,
	  .showMega:checked ~ .mega-box{
	    max-height: 100%;
	  }
	  .menu-nav-links .desktop-item{
	    display: none;
	  }
	  .menu-nav-links .mobile-item{
	    display: block;
	    color: #f2f2f2;
	    font-size: 20px;
	    font-weight: 500;
	    padding-left: 20px;
	    cursor: pointer;
	    border-radius: 5px;
	    transition: all 0.3s ease;
	  }
	  .menu-nav-links .mobile-item:hover{
	    background: #3A3B3C;
	  }
	  .drop-menu li{
	    margin: 0;
	  }
	  .drop-menu li a{
	    border-radius: 5px;
	    font-size: 18px;
	  }
	  .mega-box{
	    position: static;
	    top: 65px;
	    opacity: 1;
	    visibility: visible;
	    padding: 0 20px;
	    max-height: 0px;
	    overflow: hidden;
	    transition: all 0.3s ease;
	  }
	  .mega-box .content{
	    box-shadow: none;
	    flex-direction: column;
	    padding: 20px 20px 0 20px;
	  }
	  .mega-box .content .row{

	    width: 100%;
	    margin-bottom: 15px;
	    border-top: 1px solid rgba(255,255,255,0.08);
	  }
	  .mega-box .content .row:nth-child(1),
	  .mega-box .content .row:nth-child(2){
	    border-top: 0px;
	  }
	  .content .row .mega-links{
	    border-left: 0px;
	    padding-left: 15px;
	  }
	  .row .mega-links li{
	    margin: 0;
	  }
	  .content .row header{
	    font-size: 19px;
	  }
	}
	nav input{
	  display: none;
	}

</style>
<nav>
  <div class="wrapper">
    <div class="logo"><a href="#">Logo</a></div>
    <input type="radio" name="slider" id="menu-btn">
    <input type="radio" name="slider" id="close-btn">
    <ul class="menu-nav-links" style="margin-top: 1rem;">
      <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
      	
    <?php $links = $data['links']?>

		<?php if(!empty($links)):?>

			<?php
					//order the links
					usort($links, function($a, $b){

						$a = $a->list_order ?? 10;
						$b = $b->list_order ?? 10;

						if($a == $b) return 0;
						return $a > $b ? 1 : -1;
					});

			?>
			<?php foreach($links as $link):?>

				<?php if(user_can($link->permission)):?>
					<li>
						<a class="<?=!empty($link->children) ? 'desktop-item':''?>" href="<?=ROOT?>/<?=$link->slug?>">
							<?php if(!empty($link->show_image) || (!empty($link->image) && file_exists($link->image))):?>
								<img src="<?=get_image($link->image)?>" class="rounded-circle" style="width:40px;height:40px;object-fit: cover;">
							<?php endif?>
							<?=esc(ucfirst($link->title))?>
						</a>

							<?php if(!empty($link->children) && empty($link->is_mega)):?>

								<input type="checkbox" id="showDrop<?=$link->id?>" class="showDrop">
				        <label for="showDrop<?=$link->id?>" class="mobile-item showDrop">
				        	<?php if(!empty($link->show_image) || (!empty($link->image) && file_exists($link->image))):?>
										<img src="<?=get_image($link->image)?>" class="rounded-circle" style="width:40px;height:40px;object-fit: cover;">
									<?php endif?>
				        	<?=esc(ucfirst($link->title))?>
				        </label>
				        <ul class="drop-menu">

				        	<?php foreach($link->children as $child):?>
				          	<li>
				          		<a href="<?=ROOT?>/<?=$child->slug?>">
				          			<?php if(!empty($child->show_image) || (!empty($child->image) && file_exists($child->image))):?>
													<img src="<?=get_image($child->image)?>" class="rounded-circle" style="width:40px;height:40px;object-fit: cover;">
												<?php endif?>
				          			<?=esc(ucfirst($child->title))?>
			          			</a>
			          		</li>
				          <?php endforeach?>
				        </ul>

							<?php elseif(!empty($link->children) && !empty($link->is_mega)):?>

								<input type="checkbox" id="showMega<?=$link->id?>" class="showMega">
				        <label for="showMega<?=$link->id?>" class="mobile-item showMega"><?=esc(ucfirst($link->title))?></label>
				        <div class="mega-box">
				          <div class="content">
				            <div class="row">
				            	<?php if(!empty($link->mega_image) && file_exists($link->mega_image)):?>
				              	<img src="<?=get_image($image->get_thumbnail($link->mega_image,240,240))?>" alt="">
				              <?php endif?>
				            </div>
				            
				            <?php foreach($link->children as $child):?>
					            <div class="row" style="display: block;">
					              <header>
					              	<?php if(!empty($child->show_image) || (!empty($child->image) && file_exists($child->image))):?>
														<img src="<?=get_image($child->image)?>" class="rounded-circle" style="width:40px;height:40px;object-fit: cover;">
													<?php endif?>
					              	<?=esc(ucfirst($child->title))?>
					              </header>
					              
					              <?php if(!empty($child->grandchildren)):?>
						              <ul class="mega-links">
						              	<?php foreach($child->grandchildren as $grandchild):?>
						                	<li>
						                		<a href="<?=ROOT?>/<?=$grandchild->slug?>">
						                			<?php if(!empty($grandchild->show_image) || (!empty($grandchild->image) && file_exists($grandchild->image))):?>
																		<img src="<?=get_image($grandchild->image)?>" class="rounded-circle" style="width:40px;height:40px;object-fit: cover;">
																	<?php endif?>
						                			<?=esc(ucfirst($grandchild->title))?>
					                			</a>
					                		</li>
						                <?php endforeach?>
						              </ul>
					              <?php endif?>
					            </div>
				            <?php endforeach?>
				          </div>
				        </div>
							<?php endif?>
					</li>
				<?php endif?>
			<?php endforeach?>
		<?php endif?>
 
    </ul>
    <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>
  </div>
</nav>
