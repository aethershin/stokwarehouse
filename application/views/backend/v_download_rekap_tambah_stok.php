<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Rekap_Tambah_Stok.xls");
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
    									<h2>Riwayat Tambah Stok Dari <?php echo format_indo(date($dari)); ?> Sampai <?php echo format_indo(date($sampai)); ?></h2>
										<table id="mytable" class="display table" style="width: 100%; cellspacing: 0;">
                                        
                                            <thead>
                                                <tr>
                                                	<th>No</th>
                                                	<th>Nota</th>
                                                   	<th>Nama Bahan</th>
                                                   	<th>Jumlah</th>
                                                   	<th>Biaya dikeluarkan</th>
                                                    <th>Riwayat Tanggal</th>
				                                    
				                                    
													
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                
                                                foreach ($data->result() as $row):
                                                    $no++;
												
													$biaya_dikeluarkan += $row->biaya_dikeluarkan;
													$jumlah_add_stock += $row->jumlah_add_stock;
												
                                            ?>
                                                <tr>
                                                    <td><?php echo $no;?></td>
                                                    <td><?php echo $row->kode_add_stock;?></td>
                                                	<td><?php echo $row->nama_stock;?></td>
                                                	<td><?php echo $row->jumlah_add_stock;?> <?php echo $row->nama_satuan;?></td>
                                                	<td><?php echo'Rp.' . number_format($row->biaya_dikeluarkan, 0 , '' , '.' ) . ',-'?></td>
                                                    <td><?php echo format_indo(date($row->tgl_buat));?></td>
													
													
													
                                                </tr>
                                            <?php endforeach; ?>
											<tfoot>
												<tr>
													
													<th>TOTAL</th>
													<th>							</th>
													<th>							</th>
													<th><?php echo  $jumlah_add_stock; ?></th>
													<th><?php echo'Rp.' . number_format( $biaya_dikeluarkan, 0 , '' , '.' ) . ',-'?></th>
													<th>							</th>
												</tr>
											</tfoot>
                                            </tbody>
                                            
                                        </table>
                               
    </body>
</html>