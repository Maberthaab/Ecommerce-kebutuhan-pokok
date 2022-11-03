<?php
//session_start();
//ob_start();
include_once("../../koneksi.php"); 
?>
<html>
<head>
  <title>LAPORAN PENJUALAN BARANG</title>
</head>
<body>
 
  <center>
 
    <h2>LAPORAN PENJUALAN BARANG</h2>
    
  </center>
 <?php
            $nama_bulan = array('', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
            echo '<b>Data Transaksi Bulan '.$nama_bulan[$_POST['bulan']].' </b><br /><br />';

            ?>
 
 
  <table border="1" style="width: 100%">
    <tr>
      <th width="1%">No</th>
      
	    <th>Tanggal</th>
	    <th>Nama Barang</th>
	    <th>Jumlah</th>
	  
    </tr>
    <?php 
    $no = 1;
    
    	$sql = mysqli_query($koneksi,"SELECT * FROM orders p left join products d On p.id=d.id WHERE MONTH(booking_date)='$_POST[bulan]' ");

		while($data = mysqli_fetch_array($sql)){
    
    
			
		
	?>
	<tr>
	    <td><?php echo $no++;?></td>
	    <td><?php echo $data['booking_date']?></td>
	    <td><?php echo $data['products']?></td>
	    <td><?php echo $data['quantities']?></td>
	    
	</tr>
  </table>

 <p><br>
  <div align="right" >Admin </div><p></br>
  <div align="right">Daily-Hacth Shop</div>
  <script>
    window.print();
  </script>
 
</body>
</html>


