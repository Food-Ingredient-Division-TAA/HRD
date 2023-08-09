<?php
ob_start();
session_start();
if(!isset($_SESSION['login'])){
	header('location:login.php');
} include('koneksi.php'); 
include "conn_hygiene.php";
if(isset($_GET['print'])){
	$tabel = "example1";
}else{ $tabel = "example";}
?>		
<div class="card">
	<div class="card-header">
	</div>
	<div class="card-body table-responsive p-0" style="height:300px;">
		<table class="table table-bordered table-sm table-striped table-head-fixed text-nowrap display" id="" cellspacing="0" width="100%">
			<thead>
				<tr>
                    <th width="5"><center>NO</center></th>
                    <th><center>KODE</center></th>
                    <th><center>AREA</center></th>
                    <th><center>TYPE</center></th>
                    <th><center>UNIT</center></th>
                    <th><center>CAM</center></th>
				</tr>
			</thead>
			<tbody>
				<?php $sql = mysqli_query($hygiene_conn, "SELECT * FROM area ORDER BY kode_area ASC");
				$no=1; $sum=0;
				while($data=mysqli_fetch_array($sql)){
				?>
				<tr>
					<td width="5"><center><?php echo $no++; ?></center></td>
					<td align="center"><?php echo $data['kode_area'];?></td>
					<td><?php echo $data['nama_area']; ?></td>
					<td align="center"><?php echo $data['type_area']; ?></td>
					<td align="center"><?php echo $data['dept_area']; ?></td>
					<td><?php echo $data['cam_area']; ?></td>
				</tr>
				<?php } ?>
			<tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('.display').DataTable( {
        "aLengthMenu" : [[10, 15, 25, 50, 75, -1], [10, 15, 25, 50, 75, "All"]],
        "iDisplayLength" : -1 ,
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
			function formatRibu(num){
				return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
			}
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
        }
    } );
} );
</script>