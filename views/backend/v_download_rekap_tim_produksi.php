<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Rekap_Data_Tim_Produksi.xls");
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
    									<h2>Rekap Data Tim Produksi Dari <?php echo format_indo(date($dari)); ?> Sampai <?php echo format_indo(date($sampai)); ?></h2>
										<table id="mytable" class="display table" style="width: 100%; cellspacing: 0;">
                                        
                                            <thead>
                                                <tr>
                                                	<th>No</th>
                                                	<th>Kode Produksi</th>
                                                	<th>Nama Produk</th>
                                                	<th>Jumlah Produksi</th>
                                                	<th>Jumlah Bahan Rusak</th>
                                                	<th>Biaya Produksi</th>
                                                	<th>Dikerjakan Oleh</th>
                                                    
                                                    <th>Riwayat Produksi</th>
				                                    
													
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                
                                                foreach ($data->result() as $row):
                                                    $no++;
												
													$produksi_selesai_biaya += $row->produksi_selesai_biaya;
													$produksi_selesai_jumlah += $row->produksi_selesai_jumlah;
												
                                            ?>
                                                <tr>
                                                    <td><?php echo $no;?></td>
                                                    <td><?php echo $row->kode_produksi_selesai;?></td>
                                                    <td><?php echo $row->nama_stock;?></td>
                                                    <td><?php echo $row->produksi_selesai_jumlah;?> <?php echo $row->nama_satuan;?></td>
                                                    <td><?php echo $row->jums_rusak;?> Pcs</td>
                                                    <td><?php echo'Rp.' . number_format($row->produksi_selesai_biaya, 0 , '' , '.' ) . ',-'?></td>
                                                    <td><?php echo $row->user_name;?></td>
                                                    <td><?php echo format_indo(date($row->produksi_selesai_tgl));?></td>
                                                    
													
													
													
                                                </tr>
                                            <?php endforeach; ?>
											<tfoot>
												<tr>
													
													<th>TOTAL</th>
													<th>							</th>
													<th>							</th>
													<th><?php echo  $produksi_selesai_jumlah; ?></th>
													<th>							</th>
													<th><?php echo'Rp.' . number_format( $produksi_selesai_biaya, 0 , '' , '.' ) . ',-'?></th>
													<th>							</th>
													<th>							</th>
												</tr>
											</tfoot>
                                            </tbody>
                                            
                                        </table>
                               
    </body>
</html>