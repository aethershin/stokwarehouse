<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Rekap_Nota.xls");
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
    									<h2>Rekap Nota Dari <?php echo format_indo(date($dari)); ?> Sampai <?php echo format_indo(date($sampai)); ?></h2>
										<table id="mytable" class="display table" style="width: 100%; cellspacing: 0;">
                                        
                                            <thead>
                                                <tr>
                                                	<th>No</th>
                                                    <th>Nota</th>
                                                    <th>Jenis Transaksi</th>
                                                    <th>Konsumen</th>
                                                    <th>Riwayat Transaksi</th>
				                                    <th>Jumlah</th>
				                                    <th>Total</th>
													
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                
                                                foreach ($data->result() as $row):
                                                    $no++;
												
													$total_belanja += $row->total_belanja;
													$jumlah_pembelian += $row->jumlah_pembelian;
												
                                            ?>
                                                <tr>
                                                    <td><?php echo $no;?></td>
                                                    <td><?php echo $row->kode_transaksi;?></td>
                                                    <td><?php echo $row->jenis_transaksi;?></td>
                                                    <td><?php echo $row->nama;?></td>
                                                    <td><?php echo format_indo(date($row->tgl_transaksi));?></td>
													<td><?php echo $row->jumlah_pembelian;?></td>
													<td><?php echo'Rp.' . number_format($row->total_belanja, 0 , '' , '.' ) . ',-'?></td>
													
                                                </tr>
                                            <?php endforeach; ?>
											<tfoot>
												<tr>
													
													<th>TOTAL</th>
													<th>							</th>
													<th>							</th>
													<th>							</th>
													<th>							</th>
													<th><?php echo  $jumlah_pembelian; ?></th>
													<th><?php echo'Rp.' . number_format( $total_belanja, 0 , '' , '.' ) . ',-'?></th>
												</tr>
											</tfoot>
                                            </tbody>
                                            
                                        </table>
                               
    </body>
</html>