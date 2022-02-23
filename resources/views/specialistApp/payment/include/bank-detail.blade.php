<div class="job-content-inner shadow">   
<h2>Payments</h2>
@include('specialistApp.payment.include.topbar')
<div class="refer-tabs-content">
  <div class="payment-content spe-bank payment-current" id="payment-bank">
          <p>
          Payments related to your rewards for referral or bonus (if any) will be made to below nominated account.
          </p>
          <form class="bank-info" method="POST" action="{{ route('specialist.update_bank_detail')}}">
            @csrf 
            <div class="bank-input-wrapper">
              <div class="bank-selectbox form-input profile-input">
                <label>Select Country</label>
                 <select id="bank-select" data-search="true" placeholder="India" class="careefer-select2" onchange="updateForm()" name="country_id">
                              @forelse ($countries as $country_id => $country_name) 
                                  <option value="{{$country_id}}" {{ ($countryId == $country_id) ? 'selected' : '' }}>{{$country_name}}</option>
                              @empty
                                  <option value="">No country found</option>
                              @endforelse 
                          </select>
              </div>
              @if(count($bank_format_fields) > 0)
              <div class="form-detail clearfix">
              @foreach($bank_format_fields as $b_field)
              @if($b_field->name != 'country')        
                <div class="form-input" style="margin-bottom:20px;">
                  <label>{{ $b_field->label }}</label>
                  <div>
                    <input type="text" name="{{ $b_field->name }}" placeholder="{{ $b_field->label }}" onfocus="this.placeholder=''" onblur="this.placeholder='{{ $b_field->label }}'" required="required" value="{{ @$b_field->specialist_value->value}}">
                  </div>
                </div>
              @endif
              @endforeach
              </div>
              @endif
              <!-- <div class="form-detail clearfix">
                <div class="form-input">
                  <label>Account Holder Name</label>
                  <div>
                    <input type="text" name="ac holder">
                  </div>
                </div>
                <div class="form-input">
                  <label>Account Number</label>
                  <div>
                    <input type="number" name="ac number">
                  </div>
                </div>
              </div> -->
            </div>
            <div class="bank-btn">
              <button type="submit" class="button button-link">
                Save
              </button>
            </div>
         </form>
  </div>
</div>   
</div> 
@push('script')
<script type="text/javascript">
  function updateForm(){
   var country_id = $("select[name='country_id']").val();
   var url = "{{ route('specialist.bank_detail') }}"; 
   self.location=url+'?country_id='+country_id;
  }
</script>
@endpush   