<div id="loadspl">
    <div class="table-responsive p-0" style="height:570; font-size:12px; font-family:Calibri;">
      <table class="table table-bordered table-sm table-striped table-head-fixed text-nowrap display12" id="scroll" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th><center>NO</center></th>
            <th><center>NIK</center></th>
            <th><center>NAMA KARYAWAN</center></th>
            <th><center>DEPT. POSISI</center></th>
            <th><center>TGL LEMBUR</center></th>
            <th><center>JUMLAH</center></th>
          </tr>
        </thead>
        <tbody>
          <?php date_default_timezone_set('Asia/Jakarta');
          include_once('koneksihr.php'); 
          $year = date('Y');
          $sql = mysqli_query($konekhr, "SELECT * FROM lemburan WHERE stts_spl='1' GROUP BY nik_spl ORDER BY posisi_spl, nama_spl");
            $no=1; $nilai=0;
          while($data=mysqli_fetch_array($sql)){
            $sql2 = mysqli_query($konekhr, "SELECT * FROM lemburan WHERE stts_spl='1' AND nik_spl='$data[nik_spl]'");
            $jml = mysqli_num_rows($sql2);
						if($jml>5){$strip="blink"; }else{$strip=NULL; }
            echo'<tr class="table-row" id="new_row_ajax '.$strip.'">
            <td align="center">'.$no.'</td>
            <td align="center">'.$data['nik_spl'].'</td>
            <td>'.$data['nama_spl'].'</td>
            <td align="center">'.$data['posisi_spl'].'</td>
            <td align="center">'.$data['tgl_spl'].'</td>
            <td align="center">'.$jml.'</td>
            </tr>'; 
            $no++;
          }
          $numb = $nilai;
          ?>
        </tbody>
      </table>
    </div>
</div>
        <?php if($numb>0){?><div id="notifcs" class="text-white"><?php echo $numb; ?></div> <?php } ?>
