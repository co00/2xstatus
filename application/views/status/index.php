<?php $this->load->view(STATUS_VIEW.'header'); ?>

<div class="container-fluid no-gutters">
        <div class="row">
            <div class="col-lg-12 p-0 ">
                <div class="header_iner d-flex justify-content-between align-items-center">
                    <div class="sidebar_icon d-lg-none">
                        <i class="ti-menu"></i>
                    </div>
                    <label class="switch_toggle d-none d-lg-block" for="checkbox">
                        <input type="checkbox" id="checkbox">
                        <div class="slider round open_miniSide"></div>
                    </label>

                    <div class="header_right d-flex justify-content-between align-items-center">
                        <div class="header_notification_warp d-flex align-items-center">
                            <li>
                                <div class="serach_button">
                                    <i class="ti-search"></i>
                                    <div class="serach_field-area d-flex align-items-center">
                                        <div class="search_inner">
                                            <form action="#">
                                                <div class="search_field">
                                                    <input type="text" placeholder="Search here..." >
                                                </div>
                                                <button class="close_search"> <i class="ti-search"></i> </button>
                                            </form>
                                        </div>
                                        <span class="f_s_14 f_w_400 ml_25 white_text text_white" >Apps</span>
                                    </div>
                                </div>
                            </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="main_content_iner overly_inner ">
        <div class="container-fluid p-0 ">
            <!-- page title  -->
            <div class="row">
                <div class="col-12">
                    <div class="page_title_box d-flex flex-wrap align-items-center justify-content-between">
                        <div class="page_title_left">
                            <h3 class="f_s_25 f_w_700 dark_text" >Dashboard</h3>
                            <ol class="breadcrumb page_bradcam mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Analytic</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-xl-12 ">
                    <div class="white_card mb_30 card_height_100">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0" id="chart_title">2x STATUS User</h3>
                                </div>
                                <div class="row float-lg-right float-none common_tab_btn2 justify-content-end">

                                    <div class="col-md-4">
                                        <select class="form-control user_report_days">
                                            <option value="0">Today</option>
                                            <option value="2">Last 3 Days</option>
                                            <option value="6">Last 7 Days</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <select class="form-control app_type">
                                            <option value="2xstatus">2x status</option>
                                            <option value="3xstatus">3x status</option>
                                            <option value="4xstatus">4x status</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <select class="form-control version_code">

                                            <?php for ($i=1; $i <= 25; $i++) { 

                                                $selected = '';  

                                                if ($i == 22) {
                                                    $selected = 'selected';
                                                }

                                                ?>

                                            <option value="<?=$i?>" <?=$selected?>><?=$i?></option>

                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="white_card_body">
                            <div id="marketchart"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $this->load->view(STATUS_VIEW.'footer'); ?>

<script type="text/javascript">
	

$(document).ready(function(){


   get_user_chart();

    $(document).off('change','.user_report_days').on('change','.user_report_days',function(e){
        e.preventDefault();

        get_user_chart();

    });

    $(document).off('change','.app_type').on('change','.app_type',function(e){
        e.preventDefault();
        
        get_user_chart();

    });

    $(document).off('change','.version_code').on('change','.version_code',function(e){
        e.preventDefault();
        
        get_user_chart();

    });



});  


function get_user_chart()
{

    var days = $('.user_report_days').val();
    var app_type = $('.app_type').val();
    var version_code = $('.version_code').val();

    $('#marketchart').text("");

    $.ajax({
                url: '<?=BASE_URL_2XSTATUS?>index/show_report',
                type:'POST',
                dataType: 'JSON',
                data:{
                    days:days,
                    app_type:app_type,
                    version_code:version_code,
                },
                success: function(response) {
                    if(response.response ) {

                        $('#chart_title').text(app_type);

                        show_chart("#marketchart",'New user',response.new_user,'User visit',response.user_visitor,response.days);
                    }
                },
                error: function(repsonse){
                }
            });
}  


// currently sale
var options = {
    series: [{
        name: 'series1',
        data: [0, 20, 15, 40, 18, 20, 18, 23, 18, 35, 30, 55, 0]
    }],
    chart: {
        height: 150,
        type: 'area',
        toolbar: {
            show: false
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth'
    },
    xaxis: {
        type: 'category',
        low: 0,
        offsetX: 0,
        offsetY: 0,
        show: false,
        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Jan"],
        labels: {
            low: 0,
            offsetX: 0,
            show: false,
        },
        axisBorder: {
            low: 0,
            offsetX: 0,
            show: false,
        },
    },
    markers: {
        strokeWidth: 3,
        colors: "#ffffff",
        strokeColors: [ '#F65365', '#D6FFF9'],
        hover: {
            size: 6,
        }
    },
    yaxis: {
        low: 0,
        offsetX: 0,
        offsetY: 0,
        show: false,
        labels: {
            low: 0,
            offsetX: 0,
            show: false,
        },
        axisBorder: {
            low: 0,
            offsetX: 0,
            show: false,
        },
    },
    grid: {
        show: false,
        padding: {
            left: 0,
            right: 0,
            bottom: 0,
            top: 0
        }
    },
    colors: [ '#884FFB', '#884FFB'],
    fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.5,
            stops: [0, 80, 100]
        }
    },
    legend: {
        show: false,
    },
    tooltip: {
        x: {
            format: 'MM'
        },
    },
};

var chart = new ApexCharts(document.querySelector("#chart-currently"), options);
chart.render();

/* -------------------------------------------------------------------------- */
/*                                     lol                                    */
/* -------------------------------------------------------------------------- */



function show_chart(id,name1,data1,name2,data2,days)
{
    // market value chart
var options1 = {
    chart: {
        height: 380,
        type: 'bar',
        toolbar: {
            show: false
        },
    },
    series: [{
        name: name1,
        data: data1
    }, {
        name: name2,
        data: data2
    }],
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: ['80%'],
            endingShape: 'rounded'
        },
    },
    xaxis: {
        categories: days,
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: true
        },
        labels: {
            style: {
                fontSize: '12px'
            }
        }
    },
    colors: [ "#F65365" , "#2264E6"],
    
    markers: {
        size: 6,
        colors: ['#fff'],
        strokeColor: "#F65365",
        strokeWidth: 3,
    },
    legend: {
        show: true
    },
    dataLabels: {
        enabled: true
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    states: {
        normal: {
            filter: {
                type: 'none',
                value: 0
            }
        },
        hover: {
            filter: {
                type: 'none',
                value: 0
            }
        },
        active: {
            allowMultipleDataPointsSelection: false,
            filter: {
                type: 'none',
                value: 0
            }
        }
    },
    grid: {
        borderColor: "#FFCCD2",
        strokeDashArray: 4,
        yaxis: {
            lines: {
                show: true
            }
        }
    }
}

var chart1 = new ApexCharts(
    document.querySelector(id),
    options1
);

chart1.render();
}
</script>