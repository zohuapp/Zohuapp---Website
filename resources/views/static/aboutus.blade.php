@include('layouts.app')

@include('layouts.header')

<div class="container">
	<div class="aboutus mt-5 mb-5" id="aboutus"></div>
</div>

@include('layouts.footer')
@include('layouts.nav')

<script type="text/javascript">

		jQuery("#overlay").show();

		var aboutusRef = database.collection('settings').doc('aboutUs');
		aboutusRef.get().then(async function (aboutusSnapshots) {
	        var aboutusData = aboutusSnapshots.data();
			$('#aboutus').html(aboutusData.about_us);
			jQuery("#overlay").hide();
		});	
			
</script>
