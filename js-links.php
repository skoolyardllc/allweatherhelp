<!-- Scripts
================================================== -->
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/jquery-migrate-3.1.0.min.html"></script>
<script src="js/mmenu.min.js"></script>
<script src="js/tippy.all.min.js"></script>
<script src="js/simplebar.min.js"></script>
<script src="js/bootstrap-slider.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/snackbar.js"></script>
<script src="js/clipboard.min.js"></script>
<script src="js/counterup.min.js"></script>
<script src="js/magnific-popup.min.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/custom.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script> -->
<!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
<script>
// Snackbar for user status switcher
// $('#snackbar-user-status label').click(function() { 
// 	Snackbar.show({
// 		text: 'Your status has been changed!',
// 		pos: 'bottom-center',
// 		showAction: false,
// 		actionText: "Dismiss",
// 		duration: 3000,
// 		textColor: '#fff',
// 		backgroundColor: '#383838'
// 	}); 
// }); 
</script>


<!-- Google Autocomplete -->
<script>
	function initAutocomplete() {
		 var options = {
		  types: ['(cities)'],
		  // componentRestrictions: {country: "us"}
		 };

		 var input = document.getElementById('autocomplete-input');
		 var autocomplete = new google.maps.places.Autocomplete(input, options);
	}

	// Autocomplete adjustment for homepage
	if ($('.intro-banner-search-form')[0]) {
	    setTimeout(function(){ 
	        $(".pac-container").prependTo(".intro-search-field.with-autocomplete");
	    }, 300);
	}

	function status_online(status) {
        $.ajax({
            url:"editProfile_ajax.php",
            type:"post",
            data:{
                userId: '<?=$USER_ID?>',
                status_online:true,
                status:status,
            },
            success: function(data){
                console.log(data);
				var obj=JSON.parse(data);
				if(obj.msg.trim()=='success'){
					Snackbar.show({
					text: 'Your status has been changed to ONLINE !!',
					pos: 'bottom-center',
					showAction: false,
					actionText: "Dismiss",
					duration: 3000,
					textColor: '#fff',
					backgroundColor: '#383838'
				}); 
				}
            },
            error: function(data) {
                console.log("galti");
            }
        })
    }

	function status_invisible(status) {
        $.ajax({
            url:"editProfile_ajax.php",
            type:"post",
            data:{
                userId: '<?=$USER_ID?>',
                status_invisible:true,
                status:status,
            },
            success: function(data){
                console.log(data);
				var obj = JSON.parse(data);
				if(obj.msg.trim()=='success'){
					Snackbar.show({
					text: 'Your status has been changed to INVISIBLE !!',
					pos: 'bottom-center',
					showAction: false,
					actionText: "Dismiss",
					duration: 3000,
					textColor: '#fff',
					backgroundColor: '#383838'
				}); 
				}
            },
            error: function(data) {
                console.log("galti");
            }
        })
    }

</script>

<!-- Google API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaoOT9ioUE4SA8h-anaFyU4K63a7H-7bc&amp;libraries=places&amp;callback=initAutocomplete"></script>
