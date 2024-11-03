@extends('layouts.master')

@section('content')   

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Statistic</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Components</a></div>
        <div class="breadcrumb-item">Statistic</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Statistics</h2>

      <div class="row">
        <div class="col-12 col-sm-12 col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Summary</h4>
              <div class="card-header-action">
                <a href="#summary-chart" data-tab="summary-tab" class="btn active">Chart</a>
                <a href="#summary-text" data-tab="summary-tab" class="btn">Text</a>
              </div>
            </div>
            <div class="card-body">
              <div class="summary">
                <div class="summary-info" data-tab-group="summary-tab" id="summary-text">
                  {{-- {{ $payslips->netsalary }} --}}
                  <div class="text-muted">Sold 4 items on 2 customers</div>
                  <div class="d-block mt-2">                              
                    <a href="#">View All</a>
                  </div>
                </div>
                <div class="summary-chart active" data-tab-group="summary-tab" id="summary-chart">
                  <canvas id="myChart" height="180"></canvas>
                </div>
                <div class="summary-item">
                  <h6 class="mt-3">Item List <span class="text-muted">(4 Items)</span></h6>
                  <ul class="list-unstyled list-unstyled-border">
                    <li class="media">
                      <a href="#">
                        <img alt="image" class="mr-3 rounded" width="50" src="assets/img/products/product-4-50.png">
                      </a>
                      <div class="media-body">
                        <div class="media-right">$805</div>
                        <div class="media-title"><a href="#">iBook Noob</a></div>
                        <div class="text-small text-muted">by <a href="#">Ahmad Sutisna</a> <div class="bullet"></div> Sunday</div>
                      </div>
                    </li>
                    <li class="media">
                      <a href="#">
                        <img alt="image" class="mr-3 rounded" width="50" src="assets/img/products/product-1-50.png">
                      </a>
                      <div class="media-body">
                        <div class="media-right">$405</div>
                        <div class="media-title"><a href="#">Headphone Blitz</a></div>
                        <div class="text-small text-muted">by <a href="#">Hasan Basri</a> <div class="bullet"></div> Sunday</div>
                      </div>
                    </li>
                    <li class="media">
                      <a href="#">
                        <img alt="image" class="mr-3 rounded" width="50" src="assets/img/products/product-2-50.png">
                      </a>
                      <div class="media-body">
                        <div class="media-right">$499</div>
                        <div class="media-title"><a href="#">RocketZ</a></div>
                        <div class="text-muted text-small">by <a href="#">Hasan Basri</a> <div class="bullet"></div> Sunday
                        </div>
                      </div>
                    </li>
                    <li class="media">
                      <a href="#">
                        <img alt="image" class="mr-3 rounded" width="50" src="assets/img/products/product-3-50.png">
                      </a>
                      <div class="media-body">
                        <div class="media-right">$149</div>
                        <div class="media-title"><a href="#">Xiaomay Readme 4.0</a></div>
                        <div class="text-small text-muted">by <a href="#">Kusnaedi</a> <div class="bullet"></div> Tuesday
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-12 col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Statistics</h4>
              <div class="card-header-action">
                <a href="#" class="btn active">Week</a>
                <a href="#" class="btn">Month</a>
                <a href="#" class="btn">Year</a>
              </div>
            </div>
            <div class="card-body">
              <canvas id="myChart2" height="180"></canvas>
              <div class="statistic-details mt-1">
                <div class="statistic-details-item">
                  <div class="text-small text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 7%</div>
                  <div class="detail-value">$243</div>
                  <div class="detail-name">Today</div>
                </div>
                <div class="statistic-details-item">
                  <div class="text-small text-muted"><span class="text-danger"><i class="fas fa-caret-down"></i></span> 23%</div>
                  <div class="detail-value">$2,902</div>
                  <div class="detail-name">This Week</div>
                </div>
                <div class="statistic-details-item">
                  <div class="text-small text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span>9%</div>
                  <div class="detail-value">$12,821</div>
                  <div class="detail-name">This Month</div>
                </div>
                <div class="statistic-details-item">
                  <div class="text-small text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 19%</div>
                  <div class="detail-value">$92,142</div>
                  <div class="detail-name">This Year</div>
                </div>
              </div>
            </div>
          </div>
  

        </div>
      </div>


    </div>
  </section>
</div>

</div>
</div>
@endsection



