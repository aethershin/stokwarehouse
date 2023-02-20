<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Rekap_Setoran.xls");
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
    									<h2>Rekap Setoran Dari <?php echo format_indo(date($dari)); ?> Sampai <?php echo format_indo(date($sampai)); ?></h2>
										<table id="mytable" class="display table" style="width: 100%; cellspacing: 0;">
                                        
                                            <thead>
                                                <tr>
                                                    <th>Nama Konsumen</th>
                                                    <th>Nota</th>
                                                    <th>Keterangan</th>
                                                    <th>Riwayat Transaksi</th>
				                                    <th>Total</th>
													
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                
                                                foreach ($data->result() as $row):
                                                    $totalcash += $row->total_cash;
												
                                            ?>
                                            	<tr>
                                                    <td><?php echo $row->nama;?></td>
                                                    <td><?php echo $row->nota_cash;?></td>
                                                    <td><?php echo $row->ket_cash;?></td>
                                                    <td><?php echo format_indo(date($row->tgl_cash));?></td>
													<td><?php echo'Rp.' . number_format($row->total_cash, 0 , '' , '.' ) . ',-'?></td>
													
                                                </tr>
                                              
                                            <?php endforeach; ?>
											<tfoot>
												<tr>
													
													<th>TOTAL</th>
													<th>							</th>
													<th>							</th>
													<th>							</th>
													<th><?php echo'Rp.' . number_format( $totalcash, 0 , '' , '.' ) . ',-'?></th>
												</tr>
											</tfoot>
                                            </tbody>
                                            
                                        </table>
                               
    </body>
</html>