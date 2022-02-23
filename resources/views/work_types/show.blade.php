@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($workType->name) ? $workType->name : 'Work Type' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('work_types.work_type.destroy', $workType->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('work_types.work_type.index') }}" class="btn btn-primary" title="Show All Work Type">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('work_types.work_type.create') }}" class="btn btn-success" title="Create New Work Type">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('work_types.work_type.edit', $workType->id ) }}" class="btn btn-primary" title="Edit Work Type">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Work Type" onclick="return confirm(&quot;Click Ok to delete Work Type.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $workType->name }}</dd>
            <dt>Status</dt>
            <dd>{{ $workType->status }}</dd>

        </dl>

    </div>
</div>

@endsection