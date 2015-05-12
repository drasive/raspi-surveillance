@extends('site.default-layout')

@section('title', 'Video Archive')
@section('description', 'The archive of recorded surveillance videos.')

@section('default-content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Video Archive</h1>
    </div>
</div>

<div class="row" ng-app="raspiSurveillanceApp">
    <div class="col-lg-6" ng-controller="VideoCtrl">
        <h3>Current Video</h3>

        <videogular vg-theme="stream.theme">
            <vg-media vg-src="stream.sources"
                      vg-tracks="stream.tracks"                      
                      vg-native-controls="true"
                      vg-auto-play="stream.autoPlay">
            </vg-media>
        </videogular>
    </div>

    <div class="col-lg-6" ng-controller="VideoManagementCtrl">
        <h3>Recorded Videos</h3>

        <p>
            <!-- TODO: Fix filter -->
            <input class="form-control" type="text" maxlength="100" placeholder="Search by recording date or duration" ng-model="query">
        </p>

        <table class="table table-striped" ng-cloack>
            <tr>
                <th style="width:0%">
                    <a href="#" ng-click="orderBy('created_at')">
                        Recording date
                        <span ng-show="orderField == 'created_at'">
                            <i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>
                            <i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
                        </span>
                    </a>
                </th>
                <th style="width:0%">
                    <a href="#" ng-click="orderBy('duration')">
                        Duration
                        <span ng-show="orderField == 'duration'">
                            <i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>
                            <i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
                        </span>
                    </a>
                </th>
                <th style="width:0%">
                    <!-- Actions -->
                </th>
            </tr>

            <!-- TODO: Use natural sort, center row content vertically -->
            <tr ng-repeat="video in videos | filter:query | orderBy:orderField:orderReverse">
                <td>
                    <!-- Recording date -->
                    <span>
                        @{{ video.created_at | date:'dd.MM.yyyy HH:mm:ss' }}
                    </span>
                </td>
                <td>
                    <!-- Duration -->
                    <span>
                        @{{ video.duration | secondsToDateTime | date:'HH:mm:ss' }}
                    </span>
                </td>
                <td style="white-space: nowrap">
                    <!-- Actions -->
                    <div class="buttons pull-right">
                        <button class="btn btn-success" ng-click="loadVideo(video)">Watch</button>
                        <!-- TODO: -->
                        <a class="btn btn-primary" href="/videos/@{{ video.filename }}" download="@{{ video.filename }}">Download</a>
                        <button class="btn btn-danger" click-await="deleteVideo(video)">Delete</button>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
@stop

@section('scripts')
<script src="bower_components/angular-sanitize/angular-sanitize.min.js"></script>
<script src="bower_components/videogular/videogular.js"></script>

<script src="js/app.js"></script>
<script src="js/services.js"></script>
<script src="js/filters.js"></script>
<script src="js/controllers.js"></script>
<script src="js/directives.js"></script>
@stop
