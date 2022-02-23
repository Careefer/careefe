@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($designation->name) ? $designation->name : 'Designation' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('designations.designation.destroy', $designation->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('designations.designation.index') }}" class="btn btn-primary" title="Show All Designation">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('designations.designation.create') }}" class="btn btn-success" title="Create New Designation">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('designations.designation.edit', $designation->id ) }}" class="btn btn-primary" title="Edit Designation">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Designation" onclick="return confirm(&quot;Click Ok to delete Designation.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Position</dt>
            <dd>{{ $designation->name }}</dd>
            <dt>Status</dt>
            <dd>{{ $designation->status }}</dd>

        </dl>

    </div>
</div>

@endsection