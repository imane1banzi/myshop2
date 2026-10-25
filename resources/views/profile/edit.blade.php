@extends('account.layout')

@section('title', 'Profil · Myshop')

@section('account')
    @include('profile.partials.update-profile-information-form')
    @include('profile.partials.update-password-form')
    @include('profile.partials.delete-user-form')
@endsection
