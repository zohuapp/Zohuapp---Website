@include('layouts.app')

@include('layouts.header')

<div class="container">
	<div class="help mt-5 mb-5" id="help"></div>
</div>

@include('layouts.footer')
@include('layouts.nav')

<script type="text/javascript">

		jQuery("#overlay").show();

		var helpRef = database.collection('settings').doc('support');
		helpRef.get().then(async function (helpSnapshots) {
	        var helpData = helpSnapshots.data();
			$('#help').html(helpData.support);
			jQuery("#overlay").hide();
		});	
			
</script>
