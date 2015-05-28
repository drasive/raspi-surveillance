@extends('site.default-layout')

@section('title', 'Video Archive')
@section('description', 'The archive of recorded surveillance videos.')

@section('default-content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Video Archive</h1>
    </div>
</div>

<div class="row" ng-app="raspiSurveillance.app">
    <div class="col-lg-5" ng-controller="VideoPlayerController" ng-cloak>
        <h3>Current Video</h3>

        <p ng-show="stream.sources.length === 0">
            Select "Watch" on one of the listed surveillance videos to see the recording.
        </p>

        <videogular vg-player-ready="onPlayerReady($API)" vg-theme="stream.theme" ng-show="stream.sources.length > 0">
            <vg-media vg-src="stream.sources"
                      vg-tracks="stream.tracks"
                      vg-native-controls="true"
                      vg-auto-play="stream.autoPlay">
            </vg-media>
        </videogular>
    </div>

    <div class="col-lg-7" ng-controller="VideoManagementController" ng-cloak>
        <h3 class="inline-block">Recorded Videos</h3>
        <span ng-show="!isLoading && !hasError">
            <span class="title-addition" ng-show="!searchQuery">(@{{ videos.length }})</span>
            <span class="title-addition" ng-show="searchQuery">(@{{ videosFiltered.length }}/@{{ videos.length }})</span>
        </span>

        <loader class="loader center-block" ng-show="isLoading"></loader>
        
        <div class="alert alert-danger" ng-show="!isLoading && hasError">
            Sorry, an error occured while loading the surveillance videos.<br />
            <br />
            <button class="btn btn-default" ng-click="videos = getVideos(false)">Try again</button>
        </div>

        <div ng-show="!isLoading && !hasError">
            <p ng-show="videos.length === 0">
                There currently are no recorded surveillance videos.<br />
                Put the local camera into motion detection mode to automatically record surveillance videos when motion is detected.
            </p>

            <div ng-show="videos.length > 0">
                <p>
                    <input class="form-control" type="text" maxlength="100"
                           placeholder="Search by recording date, duration or size" ng-model="searchQuery">
                </p>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th style="width: 0%">
                                <a href="#" ng-click="orderBy('createdAt')">
                                    Recording date
                                    <span ng-show="orderField === 'createdAt'">
                                        <i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>
                                        <i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 0%">
                                <a href="#" ng-click="orderBy('duration')">
                                    Duration
                                    <span ng-show="orderField === 'duration'">
                                        <i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>
                                        <i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
                                    </span>
                                </a>
                            </th>
                            <th style="min-width: 85px">
                                <a href="#" ng-click="orderBy('size')">
                                    Size
                                    <span ng-show="orderField === 'size'">
                                        <i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>
                                        <i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 0%">
                                <!-- Actions -->
                            </th>
                        </tr>

                        <tr ng-repeat="video in videosFiltered = (videos
                        | orFilter:['createdAtFormatted', 'durationFormatted', 'sizeFormatted']:searchQuery
                        | orderBy:orderField:orderReverse)" ng-class="{highlight: video === activeVideo}">
                            <td>
                                <!-- Recording date -->
                                <span>
                                    @{{ video.createdAtFormatted = (video.createdAt | date:'dd.MM.yyyy HH:mm:ss') }}
                                </span>
                            </td>
                            <td>
                                <!-- Duration -->
                                <span>
                                    @{{ video.durationFormatted = (video.duration | secondsToDateTime | date:'HH:mm:ss') }}
                                </span>
                            </td>
                            <td>
                                <!-- Size -->
                                <span>
                                    @{{ video.sizeFormatted = (video.size | filesize:2) }}
                                </span>
                            </td>
                            <td style="white-space: nowrap">
                                <!-- Actions -->
                                <div class="buttons pull-right">
                                    <button class="btn btn-success" ng-click="playVideo(video)" ng-disabled="video.isBusy">Watch</button>
                                    <a class="btn btn-primary" href="/videos/@{{ video.filename }}" download="@{{ video.filename }}"
                                       ng-class="{ active: camera === activeVideo }" ng-disabled="video.isBusy">Download</a>
                                    <button class="btn btn-danger" ng-click="deleteVideo(video)" ng-disabled="video.isBusy">Delete</button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script src="bower_components/angular-sanitize/angular-sanitize.min.js"></script>
<script src="bower_components/videogular/videogular.js"></script>

<script src="js/app/app.js"></script>
<script src="js/app/directives.js"></script>
<script src="js/app/filters.js"></script>
<script src="js/app/services.js"></script>
<script src="js/app/controllers/controllers.js"></script>
<script src="js/app/controllers/videoPlayerController.js"></script>
<script src="js/app/controllers/videoManagementController.js"></script>
@stop
