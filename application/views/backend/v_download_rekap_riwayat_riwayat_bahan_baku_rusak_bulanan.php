<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Rekap_Data_Bahan_Baku_Rusak_Bulanan.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html>
    <head>
	
        <!-- Title -->
        <title></title>
     
        
    </head>
    <body>
    									<h2>Rekap Data Bahan Baku Rusak Bulan <?php echo date("M"); ?></h2>
										<table id="mytable" class="display table" style="width: 100%; cellspacing: 0;">
                                        
                                            <thead>
                                                <tr>
                                                	<th>No</th>
                                                	<th>Kode Produksi</th>
                                                    <th>Nama Produk</th>
                                                    <th>Tanggal</th>
				                                    <th>Jumlah</th>
				                                    <th>Penanggung Jawab</th>
													
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                
                                                foreach ($data->result() as $row):
                                                    $no++;
												
													$totaljumlah += $row->jumlah_rusak;
												
                                            ?>
                                                <tr>
                                                    <td><?php echo $no;?></td>
                                                    <td><?php echo $row->kode_produksi_rusak;?></td>
                                                    <td><?php echo $row->nama_stock;?></td>
                                                    <td><?php echo format_indo(date($row->tgl_buat_rusak));?></td>
													<td><?php echo $row->jumlah_rusak;?> Qty</td>
													<td><?php echo $row->user_name;?></td>
													
                                                </tr>
                                            <?php endforeach; ?>
											<tfoot>
												<tr>
													
													<th>TOTAL</th>
													<th>							</th>
													<th>							</th>
													<th>							</th>
													<th><?php echo  $totaljumlah; ?> Qty</th>
													<th>							</th>
													
												</tr>
											</tfoot>
                                            </tbody>
                                            
                                        </table>
                               
    </body>
</html>