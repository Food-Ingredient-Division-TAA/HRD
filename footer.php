			</div>
			</section>
			
		</div>
		
  <footer class="main-footer">
    <strong>Copyright &copy; <a href="#">FID TAA 2022 | CA-PO</a>.</strong>
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 0.0.1
    </div>
  </footer>

  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="judul" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="judul"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div id="tampil_modal">
            </div>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="modal-detail" tabindex="" role="dialog" aria-labelledby="judul" aria-hidden="true">
    <div class="modal-dialog" style="margin-left:auto;">
      <div class="modal-content" style="width:1600px; margin-left:-550px;">
        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title" id="heading"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
            <div id="data_modal">
            <!-- Data akan di tampilkan disini-->
            </div>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Data Sparepart akan dikembalikan pada Stock !</div>
      <div class="modal-footer">
        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fas fa-times"> Cancel</i></button>
        <a id="btn-reject" class="btn btn-success" href="#"><i class="fas fa-check"> Confim</i></a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body"> Konfirmasi Penggunaan Sparepart !</div>
      <div class="modal-footer">
        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fas fa-times"> </i> Cancel</button>
        <a id="btn-confirm" class="btn btn-success" href="#"><i class="fas fa-check"> </i> Setuju</a>
      </div>
    </div>
  </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="plugins/sparklines/sparkline.js"></script>
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="dist/js/demo.js"></script>
<script src="dist/js/pages/dashboard.js"></script>
<script src="assets/jquery/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin.min.js"></script>
<script src="plugins/select2/js/select2.full.js"></script>
<script src="plugins/select2/js/select2.full.min.js"></script>
<script src="plugins/select2/js/select2.js"></script>
<script src="plugins/select2/js/select2.min.js"></script>
<script src="js/demo/chart-area-demo.js"></script>
<script src="assets/datatables/jquery.dataTables.js"></script>
<script src="assets/datatables/dataTables.bootstrap4.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="js/demo/datatables-demo.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script>
	function deleteConfirm(url){
		$('#btn-delete').attr('href', url);
		$('#deleteModal').modal();
	}
	function confirmUsed(url){
		$('#btn-confirm').attr('href', url);
		$('#confirmModal').modal();
	}
	function rejectUsed(url){
		$('#btn-reject').attr('href', url);
		$('#rejectModal').modal();
	}
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
	function uploadspl(){
		var sppt = sppt;
		const link = 'spl_post.php';
			$.ajax({
				url: link,
				method: 'post',
				data: {sppt:sppt},
				success:function(data){
					$('#modal-default').modal("show");
					$('#tampil_modal').html(data);
					document.getElementById("judul").innerHTML='Upload Data SPL'; 
				}
            });
    }

function jam() {
var time = new Date(),
	hours = time.getHours(),
	minutes = time.getMinutes(),
	seconds = time.getSeconds();
document.querySelectorAll('.jam')[0].innerHTML = harold(hours) + " : " + harold(minutes) + " : " + harold(seconds);
	
function harold(standIn) {
	if (standIn < 10) {
		standIn = '0' + standIn
	}
	return standIn;
	}
}
setInterval(jam, 1000);
</script>
</body>
</html>