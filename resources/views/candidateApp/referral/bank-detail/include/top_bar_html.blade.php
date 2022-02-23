<ul class="refer-tabs-list job-tabs-list clearfix hrz-scroll">
	<li data-tab="sent-content" class="refer-list {{($page == 'sent')?'refer-current':''}}" onclick="redirect_url($(this),'{{route("candidate.referral",["sent"])}}',true)">
		Referrals Sent
	</li>
	<li data-tab="received-content" class="refer-list {{($page == 'receive')?'refer-current':''}}" onclick="redirect_url($(this),'{{route("candidate.referral",["received"])}}',true)">
		Referrals Received
	</li>
	<li data-tab="pay-content" class="refer-list  {{($page == 'payment-history')?'refer-current':''}}" onclick="redirect_url($(this),'{{route("candidate.payment-history")}}',true)">
		Payment History
	</li>
	<li data-tab="bank-content" class="refer-list bank-details {{($page == 'bank-detail')?'refer-current':''}} " onclick="redirect_url($(this),'{{route("candidate.bank_detail")}}',true)">
		Bank Details
	</li>
	<li data-tab="score-content" class="refer-list {{($page == 'score-card')?'refer-current':''}}" onclick="redirect_url($(this),'{{route("candidate.score-card")}}',true)">
		Score Card
	</li>
</ul>