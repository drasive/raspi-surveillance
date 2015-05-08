@extends('site.default-layout')

@section('title', 'About')
@section('description', 'About Raspi Surveillance.')

@section('default-content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">About</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h3>uf/What</h3>
            <p>
                A simple website for viewing and managing the upcomming events of a cultural institution.
            </p>
        </div>
        <div class="col-md-6">
            <h3>uf/Technique</h3>
            <p>
                Frontend: A HTML5 & CSS3 website using Bootstrap and jQuery<br />
                Backend: PHP 5.4 using Laravel 4.2 running on IIS 8, MySQL 5.7
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h3>uf/Why</h3>
            <p>
                The creation of a website for a cultural institution was a school project for module #151 at the <a href="http://home.gibm.ch/">GIBM</a> (Switzerland).
            </p>
        </div>
        <div class="col-md-6">
            <h3>Who</h3>
            
            <h4>Developer</h4>
            <p>
                Dimitri Vranken<br />
                Mail: <a href="mailto:dimitri.vranken@hotmail.ch">dimitri.vranken@hotmail.ch</a><br />
            </p>
            <h4>Expert</h4>
            <p>
                B&eacute;atrice Duc<br />
                Mail: <a href="mailto:b.duc@gibmit.ch">b.duc@gibmit.ch</a><br />
            </p>
        </div>
    </div>
@stop
