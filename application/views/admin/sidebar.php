<!-- Main sidebar -->
<div class="sidebar sidebar-main">
	<div class="sidebar-content">

		<!-- User menu -->
		<div class="sidebar-user">
			<div class="category-content">
				<div class="media">
					<a href="#" class="media-left"><img src="<?=base_url()?>assets/admin/images/placeholder.jpg" class="img-circle img-sm" alt=""></a>
					<div class="media-body">
						<span class="media-heading text-semibold">Admin</span>
						
					</div>
				</div>
			</div>
		</div>
		<!-- /user menu -->


		<!-- Main navigation -->
		<div class="sidebar-category sidebar-category-visible">
			<div class="category-content no-padding">
				<ul class="navigation navigation-main navigation-accordion">
					<li class="
					<?=( ($this->uri->segment(2) == 'dashboard') || ($this->uri->segment(1) == 'backoffice' && $this->uri->segment(2) == '') ) ? 'active' : '' ?>
					">
						<a href="<?=BASE_URL_ADMIN?>"><i class="icon-home4"></i> <span>Dashboard</span></a>
					</li>


					<?php if($this->crud->is_admin_login()) { ?>
						<li class="<?=($this->uri->segment(2) == 'sub_admin') ? 'active' : '' ?>">
							<a href="<?=BASE_URL_ADMIN?>sub_admin"><i class="icon-users2"></i> <span>Sub Admin</span></a>
						</li>
					<?php } ?>

					

					<?php if( $this->crud->is_user_authorized('Category') ) { ?>
					<li class="<?=($this->uri->segment(2) == 'category') ? 'active' : '' ?>">
						<a href="<?=BASE_URL_ADMIN?>category"><i class="icon-info22"></i>Category</a>
					</li>
					<?php } ?>


					<li class="<?=($this->uri->segment(2) == 'video') ? 'active' : '' ?>">
						<a href="javascript:void(0)"><i class="icon-video-camera"></i> Video</a>
						<ul>

							<?php if( $this->crud->is_user_authorized('Videolink') ) { ?>
							<li class="<?=($this->uri->segment(3) == 'videolink') ? 'active' : '' ?>">
								<a href="<?=BASE_URL_ADMIN?>video/videolink"><i class="icon-link"></i> Video Link</a>
							</li>
							<?php } ?>

							<?php if( $this->crud->is_user_authorized('Videoupload') ) { ?>
							<li class="<?=($this->uri->segment(3) == 'videoupload') ? 'active' : '' ?>">
								<a href="<?=BASE_URL_ADMIN?>video/videoupload"><i class="icon-cloud-upload"></i> Video Upload</a>
							</li>
							<?php } ?>

							<?php if( $this->crud->is_user_authorized('Videofirebase') ) { ?>
							<li class="<?=($this->uri->segment(3) == 'videofirebase') ? 'active' : '' ?>">
								<a href="<?=BASE_URL_ADMIN?>video/videofirebase"><i class="icon-fire"></i> Video Firebase</a>
							</li>
							<?php } ?>

							<?php if( $this->crud->is_user_authorized('Mobileupload') ) { ?>
							<li class="<?=($this->uri->segment(3) == 'mobileupload') ? 'active' : '' ?>">
								<a href="<?=BASE_URL_ADMIN?>video/mobileupload"><i class="icon-mobile"></i> Mobile Upload</a>
							</li>
							<?php } ?>

						</ul>
					</li>

					<li class="<?=($this->uri->segment(2) == 'comedyvideo') ? 'active' : '' ?>">
						<a href="javascript:void(0)"><i class="icon-video-camera"></i> Comedy Video</a>
						<ul>

							<?php if( $this->crud->is_user_authorized('Comedy_video_Mobileupload') ) { ?>
							<li class="<?=($this->uri->segment(3) == 'upload') ? 'active' : '' ?>">
								<a href="<?=BASE_URL_ADMIN?>comedyvideo/upload"><i class="icon-cloud-upload"></i> Video Upload</a>
							</li>
							<?php } ?>

						</ul>
					</li>


					<?php if( $this->crud->is_user_authorized('Custome_banner') ) { ?>
					<li class="<?=($this->uri->segment(2) == 'Custome_banner') ? 'active' : '' ?>">
						<a href="<?=BASE_URL_ADMIN?>Custome_banner"><i class="icon-image3"></i>Custome Banner</a>
					</li>
					<?php } ?>

					<?php if( $this->crud->is_user_authorized('Dialog_banner') ) { ?>
					<li class="<?=($this->uri->segment(2) == 'dialog_banner') ? 'active' : '' ?>">
						<a href="<?=BASE_URL_ADMIN?>dialog_banner"><i class="icon-images3"></i>Dialog Banner</a>
					</li>
					<?php } ?>

					<?php if( $this->crud->is_user_authorized('App_update') ) { ?>
					<li class="<?=($this->uri->segment(2) == 'app_update') ? 'active' : '' ?>">
						<a href="<?=BASE_URL_ADMIN?>app_update"><i class="icon-download"></i>App Update</a>
					</li>
					<?php } ?>

					


				</ul>
			</div>
		</div>
		<!-- /main navigation -->

	</div>
</div>
<!-- /main sidebar -->
