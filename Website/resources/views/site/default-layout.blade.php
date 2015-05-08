@extends('site.master-layout')

@section('master-content')
    <div id="wrapper">
        <!-- Navigation -->
        @include('site.navigation')
        
        <div id="page-wrapper">
            <!-- Notifications -->
            <div class="row">
                <div class="col-md-12">
                    @include('site.notifications')
                </div>
            </div>
            
            <!-- Content -->
            <div class="row">
                @yield('default-content')
            </div>
        </div>
    </div>
@stop
