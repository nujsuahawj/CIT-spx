<div>
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">{{__('lang.dashboard')}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.dashboard')}}</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>0</h3>
  
                  <p>ລາຍການສິນຄ້າທີ່ຮັບຝາກ</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">ລາຍລະອຽດ <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>0</h3>
  
                  <p>ລາຍການສິນຄ້າຈັດສົ່ງດ່ວນ</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">ລາຍລະອຽດ <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>0</h3>
  
                  <p>ຄິວຂົນສົ່ງສິນຄ້າປະຈຳວັນ</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">ລາຍລະອຽດ <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>0</h3>
  
                  <p>ລາຍການຮັບເຄື່ອງແບບ COD</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">ລາຍລະອຽດ <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>

          <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-money-bill-alt"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">ລາຍຮັບ</span>
                  <span class="info-box-number">
                    0
                    <small>ກີບ</small>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money-bill-alt"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">ລາຍຈ່າຍ</span>
                  <span class="info-box-number">
                    0
                    <small>ກີບ</small>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
  
            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>
  
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">ລາຍການສັ່ງຊື້ອອນລາຍ</span>
                  <span class="info-box-number">0</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">ລູກຄ້າທັງໝົດ</span>
                  <span class="info-box-number">0</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h5><b>{{__('lang.online_order')}}</b></h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>{{__('lang.no')}}</th>
                          <th>{{__('lang.code')}}</th>
                          <th>{{__('lang.productname')}}</th>
                          <th>{{__('lang.qty')}}</th>
                          <th>{{__('lang.money')}}</th>
                          <th>{{__('lang.status')}}</th>
                          <th>{{__('lang.date')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                          $stt = 1;    
                        @endphp
                        
                        </tbody>
                    </table>
  
                    <div>
              
                    </div>
  
                  </div>
                </div>
              </div>
      
            </div>
          </div>

        </div>
      </section>

</div>
