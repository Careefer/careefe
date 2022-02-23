<div class="form-group">
    <label class="control-label col-md-3">Currency Code
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <select class="careefer-select2" data-placeholder="" form-control" id="iso_code" name="iso_code" data-live-search="true" data-size="8">
                <option value="" style="display: none;" {{ old('id', optional($currency_conversion)->iso_code ?: '') == '' ? 'selected' : '' }} disabled selected>Select Currency Code</option>
                @foreach ($currency_codes as $key => $currency_code)
                    <option value="{{ $currency_code }}" {{ old('iso_code', optional($currency_conversion)->iso_code) == $currency_code ? 'selected' : '' }}>
                        {{ $currency_code }}
                    </option>
                @endforeach
            </select>
            @if( $errors->has('iso_code'))
                <span class="err-msg">
                   {!! $errors->first('iso_code', '<p class="help-block">:message</p>') !!}
                </span>
            @endif
        </div>
    </div>
</div>


<div class="form-group">
    <label class="control-label col-md-3">Conversion Value To USD
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input class="form-control" name="usd_value" type="text" id="usd_value" value="{{ old('usd_value', optional($currency_conversion)->usd_value) }}">
            @if( $errors->has('usd_value'))
                <span class="err-msg">
                    {!! $errors->first('usd_value', '<p class="help-block">:message</p>') !!}
                </span>
            @endif
        </div>
    </div>
</div>



