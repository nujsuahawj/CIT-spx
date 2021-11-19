@extends('layouts.basedoc')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
       
        </div><!-- /.col -->
        <div class="col-sm-6">

        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <section class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{number_format($im_count)}} <sup style="font-size: 20px">{{__('lang.items')}}</sup></h3>

              <p>{{__('lang.import_doc')}} </p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="" class="small-box-footer"> {{__('lang.detail')}}<i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{number_format($ex_count)}} <sup style="font-size: 20px">{{__('lang.items')}}</sup></h3>

              <p>{{__('lang.export_doc')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="" class="small-box-footer"> {{__('lang.detail')}} <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{number_format($local_count)}} <sup style="font-size: 20px">{{__('lang.items')}}</h3>

              <p>{{__('lang.local_doc')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="" class="small-box-footer"> {{__('lang.detail')}} <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{number_format($not_comment_count)}} <sup style="font-size: 20px">{{__('lang.items')}}</h3>

              <p>{{__('doc.not_comment')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="" class="small-box-footer"> {{__('lang.detail')}} <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cloud-download-alt"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">{{__('lang.doc_type')}}</span>
              <span class="info-box-number">{{$doctype_count}}<small> {{__('lang.items')}}</small>
              </span>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tag"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">{{__('lang.depart')}}</span>
              <span class="info-box-number">{{$depart_count}}<small> {{__('lang.items')}}</small></span>
            </div>
          </div>
        </div>
      
        <div class="clearfix hidden-md-up"></div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-comment"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">{{__('lang.storage_file')}}</span>
              <span class="info-box-number">{{$storage_count}}<small> {{__('lang.items')}}</small></span>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">{{__('lang.user')}}</span>
              <span class="info-box-number">{{$user_count}}<small> {{__('lang.user')}}</small></span>
            </div>
          </div>
        </div>
      </div>

      <!-- /.Chart-md-6 -->
      <div class="row">
      <!--
      <div class="row">
        <?php print_r($datas_import) ?> 
        <?php print_r(json_encode($datas_import)) ?><br>
      </div>--> 
        
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="card-title">{{__('lang.import_doc')}}</h3>
                <!--<a href="javascript:void(0);">View Report</a>-->
              </div>
            </div>
            <div class="card-body">
              <div class="d-flex">
                <p class="d-flex flex-column">
                  <span class="text-bold text-lg">{{number_format($im_count)}}</span>
                  <span>{{__('lang.items')}}</span>
                </p>
                <!--
                <p class="ml-auto d-flex flex-column text-right">
                  <span class="text-success">
                    <i class="fas fa-arrow-up"></i> 12.5%
                  </span>
                  <span class="text-muted">Since last week</span>
                </p>
              -->
              </div>
              <!-- /.d-flex -->

              <div class="position-relative mb-4">
                <canvas id="visitors-chart" height="150"></canvas>
              </div>

            </div>
          </div>
        </div>

        <!-- /.Export Chart-md-6 -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="card-title">{{__('lang.export_doc')}}</h3>
                <!--<a href="">{{__('lang.view')}}</a>-->
              </div>
            </div>
            <div class="card-body">
              <div class="d-flex">
                <p class="d-flex flex-column">
                  <span class="text-bold text-danger fas fa-arrow-up"> {{number_format($ex_count)}}</span>
                  <span>{{__('lang.items')}}</span>
                </p>
              </div>

              <div class="position-relative mb-4">
                <canvas id="sales-chart" height="160"></canvas>
              </div>
            </div>
          </div>
        </div>
        
      </div>

    </div>
  </section>
@endsection

@section('scripts')
      <script>

        var datas_import =  <?php echo json_encode($datas_import) ?>

        $(function () {
          'use strict'

          var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
          }

          var mode = 'index'
          var intersect = true

          //Income charts
          var $visitorsChart = $('#visitors-chart')
          // eslint-disable-next-line no-unused-vars
          var visitorsChart = new Chart($visitorsChart, {
            data: {
              labels: ['ເດືອນ 01', 'ເດືອນ 02', 'ເດືອນ 03', 'ເດືອນ 04', 'ເດືອນ 05', 'ເດືອນ 06', 'ເດືອນ 07','ເດືອນ 08','ເດືອນ 09','ເດືອນ 10', 'ເດືອນ 11','ເດືອນ 12'],
              datasets: [{
                type: 'line',
                data: datas_import,
                backgroundColor: 'transparent',
                borderColor: '#13B7D2',
                pointBorderColor: '#13B7D2',
                pointBackgroundColor: '#13B7D2',
                fill: false
                // pointHoverBackgroundColor: '#007bff',
                // pointHoverBorderColor    : '#007bff'
              },]
            },
            options: {
              maintainAspectRatio: false,
              tooltips: {
                mode: mode,
                intersect: intersect
              },
              hover: {
                mode: mode,
                intersect: intersect
              },
              legend: {
                display: false
              },
              scales: {
                yAxes: [{
                  // display: false,
                  gridLines: {
                    display: true,
                    lineWidth: '4px',
                    color: 'rgba(0, 0, 0, .2)',
                    zeroLineColor: 'transparent'
                  },
                  ticks: $.extend({
                    beginAtZero: true,
                    //suggestedMax: 100
                  }, ticksStyle)
                }],
                xAxes: [{
                  display: true,
                  gridLines: {
                    display: true
                  },
                  ticks: ticksStyle
                }]
              }
            }
          })
        
        //Export Chart
        var $salesChart = $('#sales-chart')
          var datas_export = <?php echo json_encode($datas_export) ?>
          // eslint-disable-next-line no-unused-vars
          var salesChart = new Chart($salesChart, {
            type: 'bar',
            data: {
              labels: ['ເດືອນ 01', 'ເດືອນ 02', 'ເດືອນ 03', 'ເດືອນ 04', 'ເດືອນ 05', 'ເດືອນ 06', 'ເດືອນ 07','ເດືອນ 08','ເດືອນ 09','ເດືອນ 10', 'ເດືອນ 11','ເດືອນ 12'],
              datasets: [
                {
                  backgroundColor: '#09AD14',
                  borderColor: '#09AD14',
                  data: datas_export
                },
              ]
            },
            options: {
              maintainAspectRatio: false,
              tooltips: {
                mode: mode,
                intersect: intersect
              },
              hover: {
                mode: mode,
                intersect: intersect
              },
              legend: {
                display: false
              },
              scales: {
                yAxes: [{
                  // display: false,
                  gridLines: {
                    display: true,
                    lineWidth: '4px',
                    color: 'rgba(0, 0, 0, .2)',
                    zeroLineColor: 'transparent'
                  },
                  ticks: $.extend({
                    beginAtZero: true,

                    // Include a dollar sign in the ticks
                    callback: function (value) {
                      if (value >= 1000) {
                        value /= 1000
                        value += 'k'
                      }

                      return value
                    }
                  }, ticksStyle)
                }],
                xAxes: [{
                  display: true,
                  gridLines: {
                    display: false
                  },
                  ticks: ticksStyle
                }]
              }
            }
          })
          

        })

      </script>
@endsection