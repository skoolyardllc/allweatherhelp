<!-- JavaScript -->

	<!-- jQuery first, then Popper.js, then Bootstrap JS -->

	<script src="assets/js/jquery.min.js"></script>

	<script src="assets/js/popper.min.js"></script>

	<script src="assets/js/bootstrap.min.js"></script>

	<!--plugins-->

	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>

	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>

	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>

	<!-- Vector map JavaScript -->

	<script src="assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>

	<script src="assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>

	<script src="assets/plugins/vectormap/jquery-jvectormap-in-mill.js"></script>

	<script src="assets/plugins/vectormap/jquery-jvectormap-us-aea-en.js"></script>

	<script src="assets/plugins/vectormap/jquery-jvectormap-uk-mill-en.js"></script>

	<script src="assets/plugins/vectormap/jquery-jvectormap-au-mill.js"></script>
	<script src="assets/plugins/chartjs/js/Chart.min.js"></script>
	<script src="assets/plugins/chartjs/js/chartjs-custom.js"></script>


	 <!--<script src="assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script> -->

	<script src="assets/js/index.js"></script>

	<!-- App JS -->

	<script src="assets/js/app.js"></script>

	<script>

		new PerfectScrollbar('.dashboard-social-list');

		new PerfectScrollbar('.dashboard-top-countries');

		$(function () {

       

			$('#example1').DataTable()

			$('#example2').DataTable({

			'paging'      : true,

			'lengthChange': true,

			'searching'   : true,

			'ordering'    : true,

			'info'        : true,

			'autoWidth'   : true

			})

		})

	</script>