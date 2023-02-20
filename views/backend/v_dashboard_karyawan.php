
 
<div class="page-content">
    <section class="row">
    <div class="row">
        <div class="card">
            <div class="card-body">
               <h2>Selamat Datang, <?php echo $this->session->userdata('name'); ?></h2>
          </div>
        </div>
            </div>
        
    </section>
</div>
        <!------- FOOTER --------->
            <?php $this->load->view("backend/_partials/footer.php") ?>
        <!------- FOOTER --------->
            
        </div>
    </div>
    

<script>
	var optionsProfileVisit = {
	annotations: {
		position: 'back'
	},
	dataLabels: {
		enabled:false
	},
	chart: {
		type: 'bar',
		height: 300
	},
	fill: {
		opacity:1
	},
	plotOptions: {
	},
	series: [{
		name: 'Pengunjung',
		data: <?php echo $valuevisit;?>
	}],
	colors: '#435ebe',
	xaxis: {
		categories: <?php echo $monthvisit;?>,
	},
}
var chartProfileVisit = new ApexCharts(document.querySelector("#chart-profile-visit"), optionsProfileVisit);
chartProfileVisit.render();
</script>



<script>
        $(document).ready(function(){
            show_product2();

// SIMPLE DATATABLES
let dataTable = new simpleDatatables.DataTable(
  document.getElementById("table1")
)


        

        });
    </script>
   	
</body>

</html>
