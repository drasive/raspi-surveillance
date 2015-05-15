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
    <div class="col-lg-5" ng-controller="VideoCtrl" ng-cloak>
        <h3>Current Video</h3>

        <p ng-show="stream.sources.length === 0">
            Select "Watch" on one of the listed videos to see the recording.
        </p>

        <videogular vg-theme="stream.theme" ng-show="stream.sources.length > 0">
            <vg-media vg-src="stream.sources"
                      vg-tracks="stream.tracks"
                      vg-native-controls="true"
                      vg-auto-play="stream.autoPlay">
            </vg-media>
        </videogular>
    </div>

    <div class="col-lg-7" ng-controller="VideoManagementCtrl" ng-cloak>
        <h3>Recorded Videos</h3>
        <!-- TODO: _ -->
        <span class="title-addition">(@{{ videos.length }})</span>

        <p ng-show="videos.length === 0">
            There currently are no recorded surveillance videos.<br />
            Put the camera into motion detection mode to automatically record surveillance videos when motion is detected.
        </p>

        <div ng-show="videos.length > 0">
            <p>
                <input class="form-control" type="text" maxlength="100"
                       placeholder="Search by recording date, duration or size" ng-model="query">
            </p>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th style="width: 0%">
                            <a href="#" ng-click="orderBy('created_at')">
                                Recording date
                                <span ng-show="orderField == 'created_at'">
                                    <i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>
                                    <i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
                                </span>
                            </a>
                        </th>
                        <th style="width: 0%">
                            <a href="#" ng-click="orderBy('duration')">
                                Duration
                                <span ng-show="orderField == 'duration'">
                                    <i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>
                                    <i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
                                </span>
                            </a>
                        </th>
                        <th style="min-width: 85px">
                            <a href="#" ng-click="orderBy('size')">
                                Size
                                <span ng-show="orderField == 'size'">
                                    <i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>
                                    <i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
                                </span>
                            </a>
                        </th>
                        <th style="width: 0%">
                            <!-- Actions -->
                        </th>
                    </tr>

                    <!-- TODO: Handler error -->
                    <tr ng-repeat="video in videos
                        | orFilter:['created_at_formatted', 'duration_formatted', 'size_formatted']:query
                        | orderBy:orderField:orderReverse">
                        <td>
                            <!-- Recording date -->
                            <span>
                                @{{ video.created_at_formatted = (video.created_at | date:'dd.MM.yyyy HH:mm:ss') }}
                            </span>
                        </td>
                        <td>
                            <!-- Duration -->
                            <span>
                                @{{ video.duration_formatted = (video.duration | secondsToDateTime | date:'HH:mm:ss') }}
                            </span>
                        </td>
                        <td>
                            <!-- Size -->
                            <span>
                                @{{ video.size_formatted = (video.size | filesize:2) }}
                            </span>
                        </td>
                        <td style="white-space: nowrap">
                            <!-- Actions -->
                            <div class="buttons pull-right">
                                <button class="btn btn-success" ng-click="loadVideo(video)">Watch</button>
                                <a class="btn btn-primary" href="/videos/@{{ video.filename }}" download="@{{ video.filename }}">Download</a>
                                <button class="btn btn-danger" click-await="deleteVideo(video)">Delete</button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
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
