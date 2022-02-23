@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($education->name) ? $education->name : 'Education' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('education.education.destroy', $education->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('education.education.index') }}" class="btn btn-primary" title="Show All Education">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('education.education.create') }}" class="btn btn-success" title="Create New Education">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('education.education.edit', $education->id ) }}" class="btn btn-primary" title="Edit Education">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Education" onclick="return confirm(&quot;Click Ok to delete Education.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $education->name }}</dd>
            <dt>Status</dt>
            <dd>{{ $education->status }}</dd>

        </dl>

    </div>
</div>

@endsection