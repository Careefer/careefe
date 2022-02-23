@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($industry->name) ? $industry->name : 'Industry' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('industries.industry.destroy', $industry->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('industries.industry.index') }}" class="btn btn-primary" title="Show All Industry">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('industries.industry.create') }}" class="btn btn-success" title="Create New Industry">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('industries.industry.edit', $industry->id ) }}" class="btn btn-primary" title="Edit Industry">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Industry" onclick="return confirm(&quot;Click Ok to delete Industry.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $industry->name }}</dd>
            <dt>Status</dt>
            <dd>{{ $industry->status }}</dd>

        </dl>

    </div>
</div>

@endsection