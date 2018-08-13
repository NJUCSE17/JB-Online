@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('labels.frontend.contact.box_title'))

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            {!!  __('strings.frontend.about') !!}
        </div>
    </div><!--row-->
@endsection
