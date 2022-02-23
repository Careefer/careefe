@extends('layouts.app')
@section('content')
<div class="page-content">
    <div class="portlet light bordered">
        <!-- <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Edit role</span>
                </li>
            </ul>
        </div> -->
        <div class="row">
            <div class="col-md-12">
                    <br>
                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase"><i class="fa fa-edit"></i>&nbspEdit role</h4>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        {{ Form::open(['url'=>route('role.edit.post',['role_id'=>$edit_data['id']]),'id'=>'edit_role_form']) }}
                            <div class="form-body">
                                <div class="form-group form-md-line-input has-info">
                                    <span class="err-msg">
                                        <p class="help-block">{{ $errors->first('title') }}</p>
                                    </span>
                                    {{Form::text('title',$edit_data['name'],['class'=>'form-control','placeholder'=>'Enter role name'])}}
                                    <label>
                                        <strong>Role Name</strong>
                                        <span class="required">*</span>
                                    </label>
                                </div>
                                <div class="form-group form-md-line-input has-info">
                                    <span class="err-msg">
                                        <p class="help-block">{{$errors->first('description')}}</p>
                                    </span>
                                    {{Form::textarea('description',$edit_data['description'],['class'=>'form-control','cols'=>'1','rows'=>'2'])}}
                                    <label>
                                        <strong>Role Description</strong>
                                        <span class="required">*</span>
                                    </label>
                                </div>
                                <div class="form-group form-md-line-input has-info">
                                    <span class="err-msg">
                                        <p class="help-block">{{$errors->first('status')}}</p>
                                    </span>
                                    {{Form::select('status',[''=>'Select status','active'=>'Active','inactive'=>'Inactive'],$edit_data['status'],['class'=>'form-control'])}}
                                    <label>
                                        <strong>Status</strong>
                                        <span class="required">*</span>
                                    </label>
                                </div>
                                <span class="err-msg">
                                    <p class="help-block">{{$errors->first('menu_ids')}}</p>
                                </span>
                                <div style="color:#327ad5">
                                    <label>
                                        <strong>Select Module Permissions</strong>
                                    </label>
                                    <input readonly name="menu_ids" type="hidden" id="event_result" value="">
                                    @if(count($menues) > 0)
                                        
                                        <div id="role_modules" class="tree-demo">
                                            <ul>
                                                @foreach($menues as $key => $m)
                                                    <li data-jstree='{ "module_id" : "", "opened" : false, "selected" : false }'> {{$m->name}}
                                                        <ul>
                                                            @if(count($m->sub_menue) > 0)
                                                                @foreach($m->sub_menue as $s_key => $s_value)
                                                                    <li data-jstree='{ "module_id" : "", "opened" : false, "selected" : {{ ($s_value->id == 1)?"true":"false" }} }'> {{$s_value->name}}
                                                                        <ul>

                                                                            @php
                                                                                $s_selected_view = $s_selected_add = $s_selected_edit = $s_selected_del = false;

                                                                                if(in_array($s_value->permission_name.'-view',$my_permissions))
                                                                                {
                                                                                    $s_selected_view = ',"selected":true';       
                                                                                }

                                                                                if(in_array($s_value->permission_name.'-add',$my_permissions))
                                                                                {
                                                                                    $s_selected_add = ',"selected":true';       
                                                                                }

                                                                                if(in_array($s_value->permission_name.'-edit',$my_permissions))
                                                                                {
                                                                                    $s_selected_edit = ',"selected":true';       
                                                                                }

                                                                                if(in_array($s_value->permission_name.'-del',$my_permissions))
                                                                                {
                                                                                    $s_selected_del = ',"selected":true';       
                                                                                }
                                                                            @endphp

                                                                            <li data-jstree='{ "module_id" : "{{$s_value->permission_name}}-view", "action" : "view" {{$s_selected_view}} }'>view</li>
                                                                            <li data-jstree='{ "module_id" : "{{$s_value->permission_name}}-add", "action" : "add" {{$s_selected_add}} }'>add</li>
                                                                            <li data-jstree='{ "module_id" : "{{$s_value->permission_name}}-edit", "action" : "edit" {{$s_selected_edit}} }'>edit</li>
                                                                            <li data-jstree='{ "module_id" : "{{$s_value->permission_name}}-del", "action" : "del" {{$s_selected_del}} }'>delete</li>
                                                                        </ul>
                                                                    </li>
                                                                @endforeach
                                                            @else   
                                                            @php
                                                                $selected_view = $selected_add = $selected_edit = $selected_del = false;

                                                                if(in_array($m->permission_name.'-view',$my_permissions))
                                                                {
                                                                    $selected_view = ',"selected":true';       
                                                                }

                                                                if(in_array($m->permission_name.'-add',$my_permissions))
                                                                {
                                                                    $selected_add = ',"selected":true';       
                                                                }

                                                                if(in_array($m->permission_name.'-edit',$my_permissions))
                                                                {
                                                                    $selected_edit = ',"selected":true';       
                                                                }

                                                                if(in_array($m->permission_name.'-del',$my_permissions))
                                                                {
                                                                    $selected_del = ',"selected":true';       
                                                                }

                                                            @endphp    
                                                            <li data-jstree='{ "module_id" : "{{$m->permission_name}}-view", "action" : "view" {{$selected_view}} }'>view</li>
                                                            <li data-jstree='{ "module_id" : "{{$m->permission_name}}-add", "action" : "add" {{$selected_add}} }'>add</li>
                                                            <li data-jstree='{ "module_id" : "{{$m->permission_name}}-edit", "action" : "edit" {{$selected_edit}} }'>edit</li>
                                                            <li data-jstree='{ "module_id" : "{{$m->permission_name}}-del", "action" : "del" {{$selected_del}} }'>delete</li>

                                                            @endif
                                                        </ul>
                                                    </li>
                                                @endforeach
                                            </ul>        
                                        </div>
                                    @else
                                        <p class="err_msg">No module found.</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-actions noborder">
                                {{Form::button('Save',['type'=>'button','class'=>'btn blue','onclick'=>"submit_form($(this),$('#edit_role_form'))"])}}

                                <button type="button" class="btn red" onclick="redirect_url($(this),'{{route('role.list')}}')">
                                        Cancel
                                </button>
                            </div>
                        {{Form::close()}}
                    </div>
            </div>
            
        </div>
    </div>
</div>

@push('scripts')
    <link href="{{asset('assets/js_tree/css/style.min.css')}}" rel="stylesheet" type="text/css" />

    <script src="{{asset('assets/js_tree/js/jstree.min.js')}}" type="text/javascript"></script>

    <script src="{{asset('assets/js_tree/js/ui-tree.min.js')}}" type="text/javascript"></script>
@endpush
    <script>
        $('#role_modules').jstree({
            "plugins" : [ "checkbox" ],
            "core": {
                "themes":{
                    "icons":false
                }
            }
        });

        $('#role_modules').on('changed.jstree', function (e, data) {

              var i, j, r = [];

              for(i = 0, j = data.selected.length; i < j; i++) {

                  r.push(data.instance.get_node(data.selected[i]).state.module_id);
              }

              $('#event_result').val(r.join(','));

        }).jstree();
    </script>
@endsection
