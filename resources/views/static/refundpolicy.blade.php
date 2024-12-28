@include('layouts.app')

@include('layouts.header')

<div class="container">
	<div class="refund_policy mt-5 mb-5" id="refund_policy"></div>
</div>

@include('layouts.footer')
@include('layouts.nav')

<script type="text/javascript">

		jQuery("#overlay").show();

		var refundPolicyRef = database.collection('settings').doc('refundPolicy');
		refundPolicyRef.get().then(async function (refundPolicySnapshots) {
	        var refundPolicyData = refundPolicySnapshots.data();
			$('#refund_policy').html(refundPolicyData.refund_policy);
			jQuery("#overlay").hide();
		});	
			
</script>
