<?php $this->load->view(ADMIN_VIEW.'header'); ?>
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4>
								<span class="text-semibold">Admin</span> - <?= !empty($this->uri->segment(2)) ? $this->uri->segment(2) : 'Dashboard' ?>
							</h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="<?=BASE_URL_ADMIN?>"><i class="icon-home2 position-left"></i> Admin</a></li>
							<li class="active"><?= !empty($this->uri->segment(2)) ? ucwords(str_replace('_',' ',$this->uri->segment(2))) : 'Dashboard' ?></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


<!-- Content area -->
<div class="content">

<div class="card">
<div class="card-header header-elements-inline">
    <h5 class="card-title"><span class="label bg-success heading-text">New user</span> <span class="label bg-primary heading-text">Total :  <?=$new_user?></span></h5>
    <div class="header-elements">
        <div class="list-icons">
            <a class="list-icons-item" data-action="collapse"></a>
            <a class="list-icons-item" data-action="reload"></a>
            <a class="list-icons-item" data-action="remove"></a>
        </div>
    </div>
</div>

<div class="card-body">
    <div class="chart-container">
        <div class="chart has-fixed-height" id="new_user_visitor"></div>

        <?php for ($i=10; $i >= 0; $i--){ ?>
            <span class="hidden visitor_new_user"><?=${'previous'.$i.'_new_user'}?></span>
            <span class="hidden date_data"><?=date('d', strtotime('-'.$i.' day', strtotime(date("d-m-Y"))))?></span>

        <?php } ?>
    </div>
</div>
</div>

<div class="card">
<div class="card-header header-elements-inline">
	<h5 class="card-title"><span class="label bg-success heading-text">Version 11</span> <span class="label bg-primary heading-text">Total :  <?=$total_visitor?></span></h5>
	<div class="header-elements">
		<div class="list-icons">
    		<a class="list-icons-item" data-action="collapse"></a>
    		<a class="list-icons-item" data-action="reload"></a>
    		<a class="list-icons-item" data-action="remove"></a>
    	</div>
	</div>
</div>

<div class="card-body">
	<div class="chart-container live_visitor">
        <div class="chart has-fixed-height" id="user_visitor"></div>
		<?php for ($i=10; $i >= 0; $i--){ ?>
            <span class="hidden visitor"><?=${'previous'.$i.'_visitor'}?></span>
        <?php } ?>
	</div>
</div>
</div>




	<!-- Main charts -->
	<div class="row">
		<div class="col-lg-12">


	

<?php $this->load->view(ADMIN_VIEW.'footer'); ?>

<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/pages/datatables_basic.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/styling/switchery.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/visualization/echarts/echarts.min.js"></script>

<script type="text/javascript">
	enable_switchery();

$(document).ready(function(){ 

    var date_data = [];
        var date_data = $('.date_data').map(function(){
          return Number($(this).text())
        }).get();


	var bardata = [];
		var bardata = $('.visitor').map(function(){
          return Number($(this).text())
        }).get();


        var visitor_new_user = [];
        var visitor_new_user = $('.visitor_new_user').map(function(){
          return Number($(this).text())
        }).get();



     EchartsColumnsBasicLight('new_user_visitor',visitor_new_user,date_data,'New user');
     EchartsColumnsBasicLight('user_visitor',bardata,date_data,'Visitor 11');

});


function EchartsColumnsBasicLight(id,bardata,date_data,name) {

	

    //
    // Setup module components
    //

    // Basic column chart
    var _columnsBasicLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var columns_basic_element = document.getElementById(id);


        //
        // Charts configuration
        //

        if (columns_basic_element) {

            // Initialize chart
            var columns_basic = echarts.init(columns_basic_element);


            //
            // Chart config
            //

            // Options
            columns_basic.setOption({

                // Define colors
                color: ['#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80'],

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Chart animation duration
                animationDuration: 750,

                // Setup grid
                grid: {
                    left: 0,
                    right: 40,
                    top: 35,
                    bottom: 0,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: [name, 'Precipitation'],
                    itemHeight: 8,
                    itemGap: 20,
                    textStyle: {
                        padding: [0, 5]
                    }
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    }
                },

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    data: date_data,
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: '#eee',
                            type: 'dashed'
                        }
                    }
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: ['#eee']
                        }
                    },
                    splitArea: {
                        show: true,
                        areaStyle: {
                            color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                        }
                    }
                }],

                // Add series
                series: [
                    {
                        name: name,
                        type: 'bar',
                        data: bardata,
                        itemStyle: {
                            normal: {
                                label: {
                                    show: true,
                                    position: 'top',
                                    textStyle: {
                                        fontWeight: 500
                                    }
                                }
                            }
                        },
                        markLine: {
                            data: [{type: 'average', name: 'Average'}]
                        }
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            columns_basic_element && columns_basic.resize();
        };

        // On sidebar width change
        var sidebarToggle = document.querySelector('.sidebar-control');
        sidebarToggle && sidebarToggle.addEventListener('click', triggerChartResize);

        // On window resize
        var resizeCharts;
        window.addEventListener('resize', function() {
            clearTimeout(resizeCharts);
            resizeCharts = setTimeout(function () {
                triggerChartResize();
            }, 200);
        });
    };


    //
    // Return objects assigned to module
    //

    // return {
    //     init: function() {
            _columnsBasicLightExample();
    //     }
    // }
}
	
</script>