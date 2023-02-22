<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Rekap_Data_Stok_Warehouse.xls");
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
    									<h2>Rekap Data Stok Warehouse <?php echo format_indo(date("Y-m-d")); ?></h2>
										<table id="mytable" class="display table" style="width: 100%; cellspacing: 0;">
                                        
                                            <thead>
                                                <tr>
                                                	<th>No</th>
                                                	<th>Kode Barang</th>
                                                    <th>Nama</th>
				                                    <th>Stok</th>
				                                    <th>Nilai Modal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                
                                                foreach ($data->result() as $row):
                                                    $no++;
												
													$totalsaham += $row->nilai_saham;
													$totaljumlah += $row->stock;
													
                                            ?>
                                                <tr>
                                                    <td><?php echo $no;?></td>
                                                    <td><?php echo $row->kode_stock;?></td>
                                                    <td><?php echo $row->nama_stock;?></td>
													<td><?php echo $row->stock;?> <?php echo $row->nama_satuan;?></td>
													<td><?php echo'Rp.' . number_format($row->nilai_saham, 0 , '' , '.' ) . ',-'?></td>
													
                                                </tr>
                                            <?php endforeach; ?>
											<tfoot>
												<tr>
													
													<th>TOTAL</th>
													<th>							</th>
													<th>							</th>
													<th><?php echo  $totaljumlah; ?> Qty</th>
													<th><?php echo'Rp.' . number_format( $totalsaham, 0 , '' , '.' ) . ',-'?></th>
												</tr>
											</tfoot>
                                            </tbody>
                                            
                                        </table>
                               
    </body>
</html>