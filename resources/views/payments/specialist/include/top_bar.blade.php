 <div class="btn-group">
     <button class="btn sbold {{ ($type=='summary') ? 'green' : 'grey' }}" onclick="redirect_url($(this), '{{  route("admin.specialist-payment-summary") }}' );"></i>
          Summary
    </button>
</div>
<div class="btn-group">
     <button class="btn sbold {{ ($type=='unpaid') ? 'green' : 'grey' }}" onclick="redirect_url($(this), '{{  route("admin.specialist-unpaid-payments") }}');"></i>
         Unpaid 
    </button>
</div>
<div class="btn-group">
     <button class="btn sbold {{ ($type=='paid') ? 'green' : 'grey' }}" onclick="redirect_url($(this), '{{  route("admin.specialist-paid-payments") }}');"></i>
         Paid 
    </button>
</div>
