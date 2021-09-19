<nav class="sidebar">
    <div class="logo d-flex justify-content-between">
        <a class="large_logo" href="index-2.html"><img src="<?=STATUS_ASSETS?>img/logo.png" alt=""></a>
        <a class="small_logo" href="index-2.html"><img src="<?=STATUS_ASSETS?>img/mini_logo.png" alt=""></a>
        <div class="sidebar_close_icon d-lg-none">
            <i class="ti-close"></i>
        </div>
    </div>
    <ul id="sidebar_menu">
        <li class="<?=($this->uri->segment(2) == '') ? 'active' : '' ?>">
            <a href="<?=BASE_URL_2XSTATUS?>" aria-expanded="false">
                <div class="nav_icon_small">
                    <img src="<?=STATUS_ASSETS?>img/menu-icon/dashboard.svg" alt="">
                </div>
                <div class="nav_title">
                    <span>Dashboard</span>
                </div>
            </a>
        </li>

        <li class="<?=($this->uri->segment(2) == 'video_list') ? 'active' : '' ?>">
            <a href="<?=BASE_URL_2XSTATUS?>video_list" aria-expanded="false">
                <div class="nav_icon_small">
                    <img src="<?=STATUS_ASSETS?>img/menu-icon/2.svg" alt="">
                </div>
                <div class="nav_title">
                    <span>Video List</span>
                </div>
            </a>
        </li>

        <li class="<?=($this->uri->segment(2) == 'video_upload') ? 'active' : '' ?>">
            <a href="<?=BASE_URL_2XSTATUS?>video_upload" aria-expanded="false">
                <div class="nav_icon_small">
                    <!-- <img src="<?=STATUS_ASSETS?>img/menu-icon/dashboard.svg" alt=""> -->
                    <i class="fa fa-upload"></i>
                </div>
                <div class="nav_title">
                    <span>Video Upload</span>
                </div>
            </a>
        </li>
      </ul>
</nav>