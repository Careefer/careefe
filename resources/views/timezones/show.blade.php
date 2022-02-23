@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($timezone->name) ? $timezone->name : 'Timezone' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('timezones.timezone.destroy', $timezone->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('timezones.timezone.index') }}" class="btn btn-primary" title="Show All Timezone">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('timezones.timezone.create') }}" class="btn btn-success" title="Create New Timezone">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('timezones.timezone.edit', $timezone->id ) }}" class="btn btn-primary" title="Edit Timezone">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Timezone" onclick="return confirm(&quot;Click Ok to delete Timezone.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $timezone->name }}</dd>
            <dt>Status</dt>
            <dd>{{ $timezone->status }}</dd>

        </dl>

    </div>
</div>

@endsection