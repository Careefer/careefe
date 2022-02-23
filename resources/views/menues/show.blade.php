@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($menues->name) ? $menues->name : 'Menues' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('menues.menues.destroy', $menues->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('menues.menues.index') }}" class="btn btn-primary" title="Show All Menues">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('menues.menues.create') }}" class="btn btn-success" title="Create New Menues">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('menues.menues.edit', $menues->id ) }}" class="btn btn-primary" title="Edit Menues">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Menues" onclick="return confirm(&quot;Click Ok to delete Menues.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $menues->name }}</dd>
            <dt>Url</dt>
            <dd>{{ $menues->url }}</dd>
            <dt>Status</dt>
            <dd>{{ $menues->status }}</dd>
            <dt>Sort</dt>
            <dd>{{ $menues->sort }}</dd>

        </dl>

    </div>
</div>

@endsection