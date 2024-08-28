	<style>
		.mt-5.bg-dark.text-light.p-3.text-center {
			z-index: 1;
			position: relative;
		}
	</style>
	
	
	
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>


	<div class="mt-5 bg-dark text-light p-3 text-center">
		<p class="m-0">Aplikasi Pengacak Nomor Undian</p>
	</div>


	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/popper.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.datatables.min.js"></script>
	<script src="../assets/js/datatables-bootstrap5.min.js"></script>
	<script src="../assets/js/chart.js"></script>
	
</body>

<script type="text/javascript">

	$(document).ready(function(){

		$('#table-datatable').DataTable({
			'paging'      : true,
			'lengthChange': false,
			'searching'   : false,
			'ordering'    : false,
			'info'        : true,
			'autoWidth'   : true,
			"pageLength": 10
		});	

		$('#table-hadiah').DataTable({
			'paging'      : true,
			'lengthChange': false,
			'searching'   : true,
			'ordering'    : false,
			'info'        : true,
			'autoWidth'   : true,
			"pageLength": 10
		});	
	});

</script>
</html>