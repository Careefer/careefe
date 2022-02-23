@extends('layouts.app')

@section('content')

    <div class="page-content">
        <div class="portlet light bordered">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('blog_categories.blog_category.index') }}">Blog Categories</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Update bank format</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-edit"></i>&nbspUpdate Bank format
                            </h4>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <form method="POST" action="{{ route('bank_format.update', $bank_format->id) }}" id="edit_blog_category_form" name="edit_blog_category_form" accept-charset="UTF-8" >

                            <div class="form-body">
                                {{ csrf_field() }}
                                <table>
                                    @if(isset($bank_format->bank_format_fields))
                                        <tr>
                                            <th>Fields --</th>
                                        </tr>
                                        @foreach($bank_format->bank_format_fields as $key => $val)
                                            <tr>
                                                <td>{{$val->label}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    <tr><td><hr></td></tr>
                                    <tr>
                                        <tr>
                                            <th>Bank format name</th>
                                            <td>
                                                <div class="form-group form-md-line-input has-info">
                                                    @if( $errors->has('name'))
                                                        <span class="err-msg">
                                                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                                                        </span>
                                                    @endif
                                                        <input class="form-control" name="name" type="text" id="name" value="{{$bank_format->name}}">
                                                </div>
                                            </td>
                                        <tr>
                                        <tr>
                                            <th>Countries</th>
                                            <td>
                                                @php
                                                    $country_arr = [];
                                                    if(isset($bank_format->bank_format_countries) && !empty($bank_format->bank_format_countries))
                                                    {
                                                        foreach($bank_format->bank_format_countries AS $index => $obj)
                                                        {
                                                            $country_arr[]=$obj->country_id;
                                                        }
                                                    }
                                                @endphp

                                                @if( $errors->has('countries'))
                                                    <span class="err-msg">
                                                        {!! $errors->first('countries', '<p class="help-block">:message</p>') !!}
                                                    </span>
                                                @endif
                                                <select name="countries[]" class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-select-all="true" data-width="100%" data-filter="true">
                                                    @forelse ($countries as $country_id => $country_name) 

                                                        @php
                                                            $selected = '';
                                                            if(in_array($country_id,$country_arr))
                                                            {
                                                               $selected = 'selected="selected"'; 
                                                            }
                                                        @endphp

                                                        <option value="{{$country_id}}" {{$selected}}>{{$country_name}}</option>
                                                    @empty
                                                        <option value="">No country found</option>
                                                    @endforelse 
                                                </select>
                                             </td>       
                                        </tr>
                                    </tr>
                                </table>
                            </div>

                            <div class="form-actions noborder">
                                
                                <button type="submit" class="btn blue" onclick='submit_form($(this),$("#edit_blog_category_form"))'>
                                    Update
                                </button>
                                <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('bank_format.index') }}')">Cancel
                                </button>
                            </div>    
                        </form>


                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    @push('scripts')

        <link href="{{asset('assets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css')}}" type="text/css" />

        <script src="{{asset('assets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js')}}"></script>

        <script src="{{asset('assets/pages/scripts/components-bootstrap-multiselect.min.js')}}" type="text/javascript"></script>
         
    @endpush
@endsection
