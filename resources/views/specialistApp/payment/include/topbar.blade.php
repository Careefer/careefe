<ul class="job-tabs-list clearfix refer-tabs-list hrz-scroll">
    <li data-tab="payment-referral" class="payment-list {{($type == 'referral-payment')?'payment-current':''}}" onclick="redirect_url($(this),'{{route("specialist.referral-payment")}}',true)">
      Referral Payments
    </li>
    <li data-tab="payment-spe" class="payment-list {{($type == 'specialist-payment')?'payment-current':''}}" onclick="redirect_url($(this),'{{route("specialist.specialist-payment")}}',true)">
      Specialist Payments
    </li>
    <li data-tab="payment-score" class="payment-list {{($type == 'referral-score')?'payment-current':''}}" onclick="redirect_url($(this),'{{route("specialist.referral-score")}}',true)">
      Referral Score Card
    </li>
    <li data-tab="score-spe" class="payment-list {{($type == 'specialist-score')?'payment-current':''}}" onclick="redirect_url($(this),'{{route("specialist.specialist-score")}}',true)">
      Specialist Score Card
    </li>
    <li data-tab="payment-bank" class="payment-list  {{($type == 'bank-detail')?'payment-current':''}}" onclick="redirect_url($(this),'{{route("specialist.bank_detail")}}',true)">
      Bank Details
    </li>
</ul>
