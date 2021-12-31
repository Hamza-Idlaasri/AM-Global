@extends('layouts.auth')


@section('auth')
    
    <form wire:submit.prevent="mount">

        <input type="text" wire:model="name">
        <button type="submit">submit</button>
    </form>
    

@endsection
