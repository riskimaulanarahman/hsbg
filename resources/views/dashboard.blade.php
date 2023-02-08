@extends('layouts.default', ['sidebarSearch' => true])

@section('title', 'Dashboard')

@push('css')
	<link href="/assets/plugins/jvectormap-next/jquery-jvectormap.css" rel="stylesheet" />
	<link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
	<link href="/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
@endpush

@section('content')
	<!-- begin page-header -->
	{{-- <h1 class="page-header">Selamat Datang, {{ Auth::user()->nama_lengkap }}</h1> --}}
	<!-- end page-header -->
	
	<!-- begin row -->
	<div class="row">
		<!-- begin col-3 -->
		<div class="col-xl-3 col-md-6">
			<div class="widget widget-stats bg-success">
				<div class="stats-icon"><i class="fa fa-desktop"></i></div>
				<div class="stats-info">
					<h4>TOTAL SP</h4>
					<p id="totalsp">0</p>	
				</div>
				<div class="stats-link">
					<a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
	</div>
	<!-- end row -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-8 -->
		<div class="col-xl-12">
			<!-- begin panel -->
			<div class="panel panel-success" data-sortable-id="index-1">
				<div class="panel-heading">
					<h4 class="panel-title">SP Analytic Progress</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>
				<div class="panel-body pr-1">
					<div id="chart" class="height-sm"></div>
				</div>
			</div>
			<!-- end panel -->
			
		</div>
		<!-- end col-8 -->

	</div>
	<!-- end row -->
@endsection

@push('scripts')

<script>

$.getJSON(apiurl+'/totalsp',function(item){
	$('#totalsp').text(item);
})

$.getJSON(apiurl+'/totalspchart',function(data){
	// $('#totalsp').text(item);

// const dataSource = [{
//   day: 'Monday',
//   oranges: 3,
// }, {
//   day: 'Tuesday',
//   oranges: 2,
// }, {
//   day: 'Wednesday',
//   oranges: 3,
// }, {
//   day: 'Thursday',
//   oranges: 4,
// }, {
//   day: 'Friday',
//   oranges: 6,
// }, {
//   day: 'Saturday',
//   oranges: 11,
// }, {
//   day: 'Sunday',
//   oranges: 4,
// }];

const dataSource = data;

	$('#chart').dxChart({
    dataSource,
    series: {
      argumentField: 'sp',
      valueField: 'jml',
      name: 'My oranges',
      type: 'bar',
      color: '#ffaa66',
    },
    tooltip: {
      enabled: true,
      customizeTooltip(arg) {
        return {
          text: `${arg.valueText} %`,
        };
      },
    },
  });

})
</script>

@endpush
