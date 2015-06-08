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
        <h3>What</h3>
        <p>
            A website running on a Raspberry Pi for viewing and managing livestreams from Raspberry Pi cameras in the local network.<br />
            The Raspberri Pi that the website is running on can be set into three modes: Off, videostreaming and motion detection.
            In motion detection mode, a short video will be recorded every time the camera captures a moving object in its field of view.
            The recorded videos can be viewed and managed directly through the website.<br />
            <br />
            <i>This is a practice project and is in no way intended or suitable to be used for serious surceillance use cases.</i>
        </p>
    </div>
    <div class="col-md-6">
        <h3>Why</h3>
        <p>
            The creation of this website was a school project for software engineering module #152 at the <a href="http://home.gibm.ch/">GIBM</a> (Switzerland).
        </p>
    </div>
    
</div>
<div class="row">
    <div class="col-md-6">
        <h3>Technique</h3>

        <h4>Frontend</h4>
        <p>
            A HTML5 & CSS3 website using AngularJS and Bootstrap
        </p>
        <h4>Backend</h4>
        <p>
            PHP 5.6 using Laravel 5.0 running on Apache 2.4, MySQL Server 5.6
        </p>
    </div>
    <div class="col-md-6">
        <h3>Who</h3>

        <h4>Developer</h4>
        <p>
            Dimitri Vranken<br />
            Mail: <a href="mailto:dimitri.vranken@hotmail.ch?subject=Raspi%20Surveillance">dimitri.vranken@hotmail.ch</a><br />
        </p>
        <h4>Expert</h4>
        <p>
            B&eacute;atrice Duc<br />
            Mail: <a href="mailto:b.duc@gibmit.ch?subject=Raspi%20Surveillance">b.duc@gibmit.ch</a><br />
        </p>
    </div>
</div>
@stop
