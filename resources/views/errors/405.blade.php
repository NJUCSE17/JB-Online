@extends('layouts.errors')

@section('err-code', 405)
@section('err-status', 'Method Not Allowed')
@section('err-detail', '使用了不允许的HTTP动词。')