<div class="job-content-inner shadow">
  <div class="dashboard-main appliactions-list">
    <div class="btn-back">
      <a href="javascript:void(0);" onclick="redirect_url($(this),'{{route('specialist.applications', 'active')}}',true)"><img src="{{asset('assets/images/back-btn.png')}}" alt="back">Back</a>
    </div>
    <div class="project-job">
      <div class="top-block top-desktop">
         <div class="top-main">
          <em class="job-id">Job Id: {{  @$jobs->job_id }}</em>
          <span class="pending">Job Status: <span class="{{@$jobs->status}}">{{ ucfirst( @$jobs->status)}}</span></span>
        </div>
        <div class="project-details">
          <div class="left-detail">
            <h3>{{optional($jobs->position)->name}}</h3>

            @if($jobs->company->company_name)
                <h4 onclick="redirect_url($(this),'{{route('web.company.detail',[$jobs->company->slug])}}',null,true)">
                      {{$jobs->company->company_name}}
                </h4>
            @endif

            <span class="basket-text">
              <!-- cities -->
             @if($jobs->cities())
                {{implode(', ',$jobs->cities())}}
             @endif,

             <!-- states -->
             @if($jobs->state())
                <strong>{{implode(', ',$jobs->state())}}</strong>
             @endif,

             <!-- country -->
             <strong>
                {{($jobs->country)?$jobs->country->name:''}}
             </strong>
            </span>
            <span class="basket-text basket-vac">Vacancies: <strong>{{$jobs->vacancy}}</strong></span>
            <span class="basket-text basket-vac">Applications: <strong>{{ $jobs->applications() }}</strong></span>
            <span class="basket-text basket-work">Applications recommended: <strong>{{ $jobs->recommended() }}</strong></span>
            <span class="basket-text">Received: <strong>{{display_date_time($jobs->created_at)}}</strong></span>
          </div>
          <div class="right-detail">
             @php
               $logo_path = public_path('storage/employer_logos/'.$jobs->company->logo);

               if(file_exists($logo_path))
               {
                  $logo_path = asset('storage/employer_logos/'.$jobs->company->logo);
               }
               else
               {
                  $logo_path = asset('storage/employer/company_logo/default.png');
               }
            @endphp


            <a href="javascript:void(0);" class="project-logo" onclick="redirect_url($(this),'{{route('web.company.detail',[$jobs->company->slug])}}',null,true)"><img src="{{$logo_path}}" alt="project-apache"></a>
            <ul class="basket-bonus">
              <li>
                <span class="ref-bonus">
                  @if($jobs->specialist_bonus_amt)
                        @php 
                         $fromIsoCode = '';
                         $fromCurrencySign = '';
                         if($jobs->country->currency_sign)
                         {
                          $fromCurrencySign = $jobs->country->currency_sign->symbol;
                          $fromIsoCode = $jobs->country->currency_sign->iso_code;
                         }

                        $rateConversion = currencyRateConversion($fromIsoCode,$fromCurrencySign,$jobs->specialist_bonus_amt);
                        if($rateConversion)
                        {
                          echo $rateConversion;
                        }
                       @endphp
                     {{--{{get_amount($jobs->specialist_bonus_amt)}}--}}
                  @else
                  --   
                  @endif</span>
                <em class="ref-text">Specialist Bonus</em>
              </li>
              <li>
                <span class="ref-bonus">
                  @if($jobs->referral_bonus_amt)
                      @php 
                         $fromIsoCode = '';
                         $fromCurrencySign = '';
                         if($jobs->country->currency_sign)
                         {
                          $fromCurrencySign = $jobs->country->currency_sign->symbol;
                          $fromIsoCode = $jobs->country->currency_sign->iso_code;
                         }

                        $rateConversion = currencyRateConversion($fromIsoCode,$fromCurrencySign,$jobs->referral_bonus_amt);
                        if($rateConversion)
                        {
                          echo $rateConversion;
                        }
                       @endphp

                      {{--{{get_amount($jobs->referral_bonus_amt)}}--}}
                  @else
                     --   
                   @endif</span>
                <em class="ref-text">Referral Bonus</em>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="top-block top-mobile">
        <div class="project-details">
          <div class="left-detail">
            <em class="job-id">Job Id: {{ $jobs->job_id }}</em>
            <h3>{{optional($jobs->position)->name}}</h3>
            @if($jobs->company->company_name)
                <h4 onclick="redirect_url($(this),'{{route('web.company.detail',[$jobs->company->slug])}}',null,true)">
                      {{$jobs->company->company_name}}
                </h4>
            @endif
            <a href="javascript:void(0);" class="project-logo" onclick="redirect_url($(this),'{{route('web.company.detail',[$jobs->company->slug])}}',null,true)"><img src="{{$logo_path}}" alt="project-apache"></a>
            <span class="basket-text">
              <!-- cities -->
             @if($jobs->cities())
                {{implode(', ',$jobs->cities())}}
             @endif,

             <!-- states -->
             @if($jobs->state())
                <strong>{{implode(', ',$jobs->state())}}</strong>
             @endif,

             <!-- country -->
             <strong>
                {{($jobs->country)?$jobs->country->name:''}}
             </strong>
            </span>
            <span class="basket-text basket-vac">Vacancies: <strong>{{$jobs->vacancy}}</strong></span>
            <span class="basket-text basket-vac">Applications: <strong>{{ $jobs->applications() }}</strong></span>
            <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
            <span class="basket-text">Received: <strong>{{display_date_time($jobs->created_at)}}</strong></span>
          </div>
          <div class="right-detail">
            <ul class="basket-bonus">
              <li>
                <span class="ref-bonus">
                   @if($jobs->specialist_bonus_amt)
                     @php 
                         $fromIsoCode = '';
                         $fromCurrencySign = '';
                         if($jobs->country->currency_sign)
                         {
                          $fromCurrencySign = $jobs->country->currency_sign->symbol;
                          $fromIsoCode = $jobs->country->currency_sign->iso_code;
                         }

                        $rateConversion = currencyRateConversion($fromIsoCode,$fromCurrencySign,$jobs->specialist_bonus_amt);
                        if($rateConversion)
                        {
                          echo $rateConversion;
                        }
                       @endphp
                     {{--{{get_amount($jobs->specialist_bonus_amt)}}--}}
                  @else
                  --   
                  @endif 
                </span>
                <em class="ref-text">Specialist Bonus</em>
              </li>
              <li>
                <span class="ref-bonus">
                @if($jobs->referral_bonus_amt)
                       @php 
                         $fromIsoCode = '';
                         $fromCurrencySign = '';
                         if($jobs->country->currency_sign)
                         {
                          $fromCurrencySign = $jobs->country->currency_sign->symbol;
                          $fromIsoCode = $jobs->country->currency_sign->iso_code;
                         }

                        $rateConversion = currencyRateConversion($fromIsoCode,$fromCurrencySign,$jobs->referral_bonus_amt);
                        if($rateConversion)
                        {
                          echo $rateConversion;
                        }
                       @endphp
                      {{get_amount($jobs->referral_bonus_amt)}}
                @else
                     --   
                @endif
                </span>
                <em class="ref-text">Referal Amount</em>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="bottom-block unsave-block">
        <a href="{{ route('web.job_detail', [$jobs->slug]) }}" class="detail-view">View Detail</a>
        @if($jobs->status != 'cancelled')  
        <ul class="btn-list">
            @php
               $spcId =  my_id();
               $room_data = ['jobId'=>$jobs->id,'spcId'=>$spcId,'adminId'=>'1'];
               $roomId =  base64_encode(json_encode($room_data));
            @endphp

       
          <li>
            <a href="{{url('specialist/chat/'.$roomId)}}" class="msg-specialist">Message Admin</a>
          </li>
        
          @if($jobs->status != 'closed') 
          <li>
            @php
               $spcId =  my_id();
               $room_data = ['jobId'=>$jobs->id,'spcId'=>$spcId,'empId'=>$jobs->employer_id];
               $roomId =  base64_encode(json_encode($room_data));
            @endphp
            <a href="{{url('specialist/chat/'.$roomId)}}" class="msg-specialist">Message Employer</a>
          </li>
          @endif
        </ul>
        @endif
      </div>
    </div>
    <form class="app-form list-form" id="filters" method="GET">
      <label>Filter:</label>
      <div class="selected-list">
        @php 
             $application_status = ['applied' => 'Applied', 'in_progress' => 'In Progress with Specialist', 'in_progress_with_employer'=>'In Progress with Employer', 'unsuccess' => 'Unsuccess', 'success'=>'Success', 'candidate_declined'=> 'Candidate Declined', 'hired' => 'Hired','cancelled'=> 'Cancelled']; 
        @endphp 

        <div class="app-selectbox status-select">
          <select class="select-status" name="application_status">
            <option value="">Application Status</option>
            @foreach($application_status as $key=>$val)

            @php
               $selected = '';
               if(isset($filter_data['application_status']) && $filter_data['application_status'] == $key)
               {
                 $selected = 'selected="selected"';
               }
             @endphp

            <option {{$selected}} value="{{ $key }}">{{ $val }}</option>
            @endforeach
          </select>
        </div>
        <div class="app-selectbox candidate-select">
          <select class="can-select" name="candidate">
            <option value="">Candidate name</option>
            @if($candidates->count())
            @foreach($candidates as $key => $val)
              @php
               $selected = '';
               if(isset($filter_data['candidate']) && $filter_data['candidate'] == $key)
               {
                 $selected = 'selected="selected"';
               }
              @endphp
            <option {{$selected}} value="{{ $key }}">{{ $val }}</option>
            @endforeach
            @endif
          </select>
        </div>

        <div class="app-selectbox city-select-wrap job-select">
            <select name="location" class="loadAjaxSuggestion">
              <option value="{{ @$filters['location']}}">Enter</option>
            </select>
        </div>
      </div>
      <div class="wrapper-btn">
        <ul class="form-button">
          <li>
            <button type="button" class="button-link apply-btn" onclick="submit_form($(this),$('#filters'),true)">
              Apply
            </button>
          </li>
          @if($filter_data)
          <li>
            <button type="button" class="reset-button button" onclick="redirect_url($(this),'{{route('specialist.application.detail', [@$jobs->slug])}}',true)">
              Reset
            </button>
          </li>
          @endif
        </ul>
        <div class="sort-option clearfix">
          @php 
          $sortBy = ["recency"=> "Recency", "alphabetical"=>"Alphabetical", "referree"=>"Referree Rating", "specialist"=>"Specialist Ratings"];
          @endphp 
          <select class="sort-selectbox" name="sortBy">
            <option>Sort</option>
            @foreach($sortBy as $key=> $val)
            @php
               $selected = '';
               if(isset($filter_data['sortBy']) && $filter_data['sortBy'] == $key)
               {
                 $selected = 'selected="selected"';
               }
            @endphp    
            <option {{$selected}} value="{{ $key }}"> {{ $val }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </form>
    <div class="spc-job-ajax-render-section">
      @include('specialistApp.applications.include.card_application_detail')
    </div>
  </div>
</div>
