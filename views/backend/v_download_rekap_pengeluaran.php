<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Rekap_Pengeluaran.xls");
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
    									<h2>Rekap Pengeluaran Dari <?php echo format_indo(date($dari)); ?> Sampai <?php echo format_indo(date($sampai)); ?></h2>
										<table id="mytable" class="display table" style="width: 100%; cellspacing: 0;">
                                        
                                            <thead>
                                                <tr>
                                                    <th>Nama Karyawan</th>
                                                    <th>Keterangan</th>
                                                    <th>Riwayat Pengeluaran</th>
				                                    <th>Pengeluaran</th>
													
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                
                                                foreach ($data->result() as $row):
													$totalbiaya_pengeluaran += $row->biaya_pengeluaran;
												
                                            ?>
                                                <tr>
                                                    <td><?php echo $row->user_name;?></td>
                                                    <td><?php echo $row->ket_pengeluaran;?></td>
                                                    <td><?php echo format_indo(date($row->tgl_pengeluaran));?></td>
													<td><?php echo'Rp.' . number_format($row->biaya_pengeluaran, 0 , '' , '.' ) . ',-'?></td>
													
                                                </tr>
                                            <?php endforeach; ?>
											<tfoot>
												<tr>
													
													<th>TOTAL</th>
													<th>							</th>
                                                    <th>                            </th>
													<th><?php echo'Rp.' . number_format( $totalbiaya_pengeluaran, 0 , '' , '.' ) . ',-'?></th>
												</tr>
											</tfoot>
                                            </tbody>
                                            
                                        </table>
                               
    </body>
</html>