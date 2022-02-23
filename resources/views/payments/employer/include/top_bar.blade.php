 <div class="btn-group">
     <button class="btn sbold {{ ($type=='summary') ? 'green' : 'grey' }}" onclick="redirect_url($(this), '{{  route("admin.employer-payment-summary") }}' );"></i>
         Summary
    </button>
</div>
<div class="btn-group">
     <button class="btn sbold {{ ($type=='unpaid') ? 'green' : 'grey' }}" onclick="redirect_url($(this), '{{  route("admin.employer-payment-unpaid") }}');"></i>
        Unpaid 
    </button>
</div>
<div class="btn-group">
     <button class="btn sbold {{ ($type=='paid') ? 'green' : 'grey' }}" onclick="redirect_url($(this), '{{  route("admin.employer-payment-paid") }}');"></i>
       Paid 
    </button>
</div>
