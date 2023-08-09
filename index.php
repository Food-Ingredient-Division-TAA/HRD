<?php
	$page = "KARYAWAN";
	$dashboard = "";
	include('header.php');
	if(isset($_GET['print'])){
		$tabel = "example1";
	}else{ $tabel = "";}	
	if(isset($_GET['day'])){$headtgl = $_GET['day'];}else{$headtgl=date('Y-m-d'); }
	if(isset($_GET['day2'])){$headtgl2 = $_GET['day2'];}else{$headtgl2=date('Y-m-d'); }
	$getweek = isset($_GET['getweek'])?$_GET['getweek']:NULL;
	if($getweek){ $minggu = $getweek;
		echo "<input type='hidden' value='".$getweek."' id='mggu' name='mggu'/>";
	}else{ echo "<input type='hidden' value='".$week."' id='mggu' name='mggu'/>"; $minggu = $week;}
?>
<input type="hidden" id="tgljam" value="<?php echo $headtgl2." ".date('H:i:s'); ?>"/>

<div class="row">	
	<div class="col-md-4">
	<!-- AREA CHART -->
		<div class="card card-primary">
			<div class="card-header">
			<h3 class="card-title">PRODUKSI BUMBU</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
				<i class="fas fa-minus"></i>
				</button>
				<!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
				<i class="fas fa-times"></i>
				</button> -->
			</div>
			</div>
			<div class="card-body">
			<div class="chart">
				<canvas id="bumbuChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
			</div>
			</div>
			<!-- /.card-body -->
		</div>
	</div>	
	<div class="col-md-4">
	<!-- AREA CHART -->
		<div class="card card-warning">
			<div class="card-header">
			<h3 class="card-title">PRODUKSI MINYAK</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
				<i class="fas fa-minus"></i>
				</button>
				<!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
				<i class="fas fa-times"></i>
				</button> -->
			</div>
			</div>
			<div class="card-body">
			<div class="chart">
				<canvas id="minyakChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
			</div>
			</div>
			<!-- /.card-body -->
		</div>
	</div>	
	<div class="col-md-4">
	<!-- AREA CHART -->
		<div class="card card-danger">
			<div class="card-header">
			<h3 class="card-title">QUALITY CONTROL</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
				<i class="fas fa-minus"></i>
				</button>
				<!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
				<i class="fas fa-times"></i>
				</button> -->
			</div>
			</div>
			<div class="card-body">
			<div class="chart">
				<canvas id="donutChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
			</div>
			</div>
			<!-- /.card-body -->
		</div>
	</div>
	<div class="col-md-4">
	<!-- AREA CHART -->
		<div class="card card-warning">
			<div class="card-header" style="background:#DDDDDD;">
			<h3 class="card-title">WAREHOUSE</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
				<i class="fas fa-minus"></i>
				</button>
				<!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
				<i class="fas fa-times"></i>
				</button> -->
			</div>
			</div>
			<div class="card-body">
			<div class="chart">
				<canvas id="donutChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
			</div>
			</div>
			<!-- /.card-body -->
		</div>
	</div>
	<div class="col-md-4">
	<!-- AREA CHART -->
		<div class="card card-primary">
			<div class="card-header" style="background:darkblue;">
			<h3 class="card-title">TECHNICAL</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
				<i class="fas fa-minus"></i>
				</button>
				<!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
				<i class="fas fa-times"></i>
				</button> -->
			</div>
			</div>
			<div class="card-body">
			<div class="chart">
				<canvas id="teknikChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
			</div>
			</div>
			<!-- /.card-body -->
		</div>
	</div>
	<div class="col-md-4">
	<!-- AREA CHART -->
		<div class="card card-warning">
			<div class="card-header" style="background:#E67E22;">
			<h3 class="card-title">PPIC</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
				<i class="fas fa-minus"></i>
				</button>
				<!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
				<i class="fas fa-times"></i>
				</button> -->
			</div>
			</div>
			<div class="card-body">
			<div class="chart">
				<canvas id="donutChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
			</div>
			</div>
			<!-- /.card-body -->
		</div>
	</div>
	<div class="col-md-4">
	<!-- AREA CHART -->
		<div class="card card-danger">
			<div class="card-header" style="background:purple;">
			<h3 class="card-title">PURCHASING</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
				<i class="fas fa-minus"></i>
				</button>
				<!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
				<i class="fas fa-times"></i>
				</button> -->
			</div>
			</div>
			<div class="card-body">
			<div class="chart">
				<canvas id="donutChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
			</div>
			</div>
			<!-- /.card-body -->
		</div>
	</div>
	<div class="col-md-4">
	<!-- AREA CHART -->
		<div class="card card-warning">
			<div class="card-header" style="background:cyan;">
			<h3 class="card-title">ACCOUNTING</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
				<i class="fas fa-minus"></i>
				</button>
				<!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
				<i class="fas fa-times"></i>
				</button> -->
			</div>
			</div>
			<div class="card-body">
			<div class="chart">
				<canvas id="donutChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
			</div>
			</div>
			<!-- /.card-body -->
		</div>
	</div>
	<div class="col-md-4">
	<!-- AREA CHART -->
		<div class="card card-danger">
			<div class="card-header" style="background:deeppink;">
			<h3 class="card-title">MANUFACTURING & HYGIENE</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
				<i class="fas fa-minus"></i>
				</button>
				<!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
				<i class="fas fa-times"></i>
				</button> -->
			</div>
			</div>
			<div class="card-body">
			<div class="chart">
				<canvas id="donutChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
			</div>
			</div>
			<!-- /.card-body -->
		</div>
	</div>
	<div class="col-md-4" style="margin:auto;">
	<!-- AREA CHART -->
		<div class="card card-warning">
			<div class="card-header" style="background:lime;">
			<h3 class="card-title">HRD</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
				<i class="fas fa-minus"></i>
				</button>
				<!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
				<i class="fas fa-times"></i>
				</button> -->
			</div>
			</div>
			<div class="card-body">
			<div class="chart">
				<canvas id="donutChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
			</div>
			</div>
			<!-- /.card-body -->
		</div>
	</div>
</div>
<?php
	include('footer.php');
?>
<script>
    var bumbuChartCanvas = $('#bumbuChart').get(0).getContext('2d')
    var bumbuData        = {
      labels: ['SPV', 'LEADER', 'ADMIN', 'OPERATOR', 'HELPER',],
      datasets: [
        {
          data: [1,4,2,56,56],
		  backgroundColor : ['#f00c12', '#00a65a', '#f66900', '#00c0ef', '#328dbc', '#dfd6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : true,
      responsive : true,
	  legend: {
		display: true,
		position:'left'
		},
    }
    new Chart(bumbuChartCanvas, {
      type: 'pie',
      data: bumbuData,
      options: donutOptions
    });

    var minyakChartCanvas = $('#minyakChart').get(0).getContext('2d')
    var minyakData        = {
      labels: ['SPV', 'LEADER', 'ADMIN', 'OPERATOR', 'HELPER',],
      datasets: [
        {
          data: [0,4,1,41,48],
		  backgroundColor : ['#f00c12', '#00a65a', '#f66900', '#00c0ef', '#328dbc', '#dfd6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : true,
      responsive : true,
	  legend: {
		display: true,
		position:'left'
		},
    }
    new Chart(minyakChartCanvas, {
      type: 'pie',
      data: minyakData,
      options: donutOptions
    });

    var teknikChartCanvas = $('#teknikChart').get(0).getContext('2d')
	var teknikData        = {
      labels: ['SPV', 'LEADER', 'ADMIN', 'WORKSHOP', 'TEKNIKFIELD','MAINTENANCE','UTILITY',],
      datasets: [
        {
          data: [2,3,1,2,4,4,10],
		  backgroundColor : ['#f00c12', '#00a65a', '#f66900', '#00c0ef', '#328dbc', '#dfd6cc','#066900'],
        }
      ]
    }
    new Chart(teknikChartCanvas, {
      type: 'pie',
      data: teknikData,
      options: donutOptions
    });
</script>