 <div class="btn-group">
     <button class="btn sbold {{ ($type=='summary') ? 'green' : 'grey' }}" onclick="redirect_url($(this), '{{  route("admin.referee-payment-summary") }}' );"></i>
         Summary
    </button>
</div>
<div class="btn-group">
     <button class="btn sbold {{ ($type=='unpaid') ? 'green' : 'grey' }}" onclick="redirect_url($(this), '{{  route("admin.referee-unpaid-payment") }}');"></i>
         Unpaid
    </button>
</div>
<div class="btn-group">
     <button class="btn sbold {{ ($type=='paid') ? 'green' : 'grey' }}" onclick="redirect_url($(this), '{{  route("admin.referee-paid-payment") }}');"></i>
         Paid 
    </button>
</div>
