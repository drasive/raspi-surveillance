@extends('site.default-layout')

@section('title', 'Livestream')
@section('description', 'Watch livestreams of your Raspberry Pi surveillance cameras.')

@section('default-content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Livestream</h1>
    </div>
</div>

<div ng-app="raspiSurveillance.app">
    <div class="row">
        <div class="col-lg-5">
            <div ng-controller="SettingsController" ng-cloak>
                <h3>Local Camera</h3>

                <loader class="loader center-block" ng-show="isLoading"></loader>

                <div class="alert alert-danger" ng-show="!isLoading && hasError">
                    Sorry, an error occured while loading the local camera settings.<br />
                    <br />
                    <button class="btn btn-default" ng-click="settings = getSettings(false, false)">Try again</button>
                </div>

                <table class="table table-condensed borderless" ng-show="!isLoading && !hasError">
                    <tr>
                        <td style="width: 100px;">IP Address:</td>
                        <td>{{{ $g_hostIpAddress }}} ({{{ $g_hostName }}})</td>
                    </tr>
                    <tr>
                        <td>Mode:</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default" ng-class="{active: settings.camera.mode === 0}" 
                                        ng-click="changeMode(0)" ng-disabled="isBusy">
                                    Off
                                </button>
                                <button type="button" class="btn btn-success" ng-class="{active: settings.camera.mode === 1}" 
                                        ng-click="changeMode(1)" ng-disabled="isBusy">
                                    Streaming
                                </button>
                                <button type="button" class="btn btn-primary" ng-class="{active: settings.camera.mode === 2}"
                                        ng-click="changeMode(2)" ng-disabled="isBusy">
                                    Motion Detection
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Stream:</td>
                        <td>
                            <span ng-show="settings.camera.mode !== 1">Not available (not in streaming mode).</span>
                            <button class="btn btn-success" ng-click="playStream()"
                                ng-show="settings.camera.mode === 1" ng-class="{ active: isStreamPlaying }"
                                ng-disabled="isBusy">Watch</button>
                        </td>
                    </tr>
                </table>
            </div>

            <div ng-controller="LivestreamController" ng-cloak>
                <h3 class="inline-block">Livestream</h3>
                <span class="title-addition" ng-show="stream.sources.length > 0">(@{{ getStreamUrl() }})</span>

                <p ng-show="stream.sources.length === 0">
                    Select "Watch" on one of the listed cameras or enter a custom URL to see a livestream.
                </p>

                <p ng-show="stream.sources.length > 0">
                    <videogular vg-player-ready="onPlayerReady($API)" vg-theme="stream.theme">
                        <vg-media vg-src="stream.sources"
                                  vg-tracks="stream.tracks"
                                  vg-native-controls="true"
                                  vg-auto-play="stream.autoPlay">
                        </vg-media>
                    </videogular>
                </p>

                <div class="input-group">
                    <input class="form-control" name="customUrl" type="text" required maxlength="2000"
                        placeholder="Custom URL to open the livestream from" ng-model="customUrl" />
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" ng-click="playStreamFromUrl()" ng-disabled="!customUrl">Open</button>
                    </span>
                </div>
                <span class="help-block" ng-show="customUrlForm.customUrl.$invalid ">Please enter a valid URL</span>
            </div>
        </div>

        <div class="col-lg-7" ng-controller="CameraManagementController" ng-cloak>
            <h3 class="inline-block">Network Cameras</h3>
            <span ng-show="!isLoading && !hasError">
                <span class="title-addition" ng-show="!searchQuery">(@{{ cameras.length }})</span>
                <span class="title-addition" ng-show="searchQuery">(@{{ camerasFiltered.length }}/@{{ cameras.length }})</span>
            </span>

            <loader class="loader center-block" ng-show="isLoading"></loader>

            <div class="alert alert-danger" ng-show="!isLoading && hasError">
                Sorry, an error occured while loading the network cameras.<br />
                <br />
                <button class="btn btn-default" ng-click="cameras = getCameras(false)">Try again</button>
            </div>

            <div ng-show="!isLoading && !hasError">
                <p ng-show="cameras.length === 0">
                    You currently do not have any network cameras.<br />
                    Click on "Add network camera" to add your first one.
                </p>

                <div ng-show="cameras.length > 0">
                    <p>
                        <input class="form-control" type="text" maxlength="100"
                               placeholder="Search by name, IP address, port or protocol" ng-model="searchQuery">
                    </p>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th style="width: 100%">
                                    <a href="#" ng-click="orderBy('name')">
                                        Name
                                        <span ng-show="orderField === 'name'">
                                            <i class="fa fa-sort-alpha-asc" ng-show="!orderReverse"></i>
                                            <i class="fa fa-sort-alpha-desc" ng-show="orderReverse"></i>
                                        </span>
                                    </a>
                                </th>
                                <th style="min-width: 130px">
                                    <a href="#" ng-click="orderBy('ipAddress')">
                                        IP address
                                        <span ng-show="orderField === 'ipAddress'">
                                            <i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>
                                            <i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
                                        </span>
                                    </a>
                                </th>
                                <th style="min-width: 85px">
                                    <a href="#" ng-click="orderBy('port')">
                                        Port
                                        <span ng-show="orderField === 'port'">
                                            <i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>
                                            <i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
                                        </span>
                                    </a>
                                </th>
                                <th style="min-width: 90px">
                                    <a href="#" ng-click="orderBy('protocol')">
                                        Protocol
                                        <span ng-show="orderField === 'protocol'">
                                            <i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>
                                            <i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
                                        </span>
                                    </a>
                                </th>
                                <th style="width: 0%">
                                    <!-- Actions -->
                                </th>
                            </tr>

                            <tr ng-repeat="camera in camerasFiltered = (cameras | filter:searchQuery | orderBy:orderField:orderReverse)"
                                ng-class="{highlight: camera === activeCamera}">
                                <td>
                                    <!-- Name -->
                                    <span editable-text="camera.name" e-form="cameraForm" e-name="name" e-required e-type="text" e-maxlength="64"
                                          e-placeholder="Front Door" onbeforesave="validateName($data)">
                                        @{{ camera.name }}
                                    </span>
                                </td>
                                <td>
                                    <!-- IP address -->
                                    <span editable-text="camera.ipAddress" e-form="cameraForm" e-name="ipAddress" e-required e-type="text" e-maxlength="15"
                                          e-placeholder="192.168.0.12" onbeforesave="validateIpAddress($data)">
                                        @{{ camera.ipAddress }}
                                    </span>
                                </td>
                                <td>
                                    <!-- Port -->
                                    <span editable-text="camera.port" e-form="cameraForm" e-name="port" e-required e-type="number" e-min="0" e-max="65535"
                                          e-placeholder="8554" onbeforesave="validatePort($data)">
                                        @{{ camera.port }}
                                    </span>
                                </td>
                                <td>
                                    <!-- Protocol -->
                                    <span editable-text="camera.protocol" e-form="cameraForm" e-name="protocol" e-required e-type="text" e-maxlength="5"
                                          e-placeholder="HTTP" onbeforesave="validateProtocol($data)">
                                        @{{ camera.protocol | uppercase }}
                                    </span>
                                </td>
                                <td style="white-space: nowrap">
                                    <!-- Actions -->
                                    <div class="buttons" ng-show="!cameraForm.$visible">
                                        <button class="btn btn-success" ng-click="playStream(camera)"
                                            ng-class="{ active: camera === activeCamera }" ng-disabled="camera.isBusy">
                                            Watch
                                        </button>
                                        <button class="btn btn-primary" ng-click="cameraForm.$show()"
                                            ng-disabled="camera.isBusy">
                                            Edit
                                        </button>
                                        <button class="btn btn-danger" ng-click="deleteCamera(camera)"
                                            ng-disabled="camera.isBusy">
                                            Delete
                                        </button>
                                    </div>

                                    <form class="form-buttons form-inline" editable-form name="cameraForm"
                                          ng-show="cameraForm.$visible" shown="inserted === camera" onbeforesave="saveCamera(camera, $data)">
                                        <button class="btn btn-primary" type="submit" ng-disabled="camera.isBusy">
                                            Save
                                        </button>
                                        <button class="btn btn-default" type="button" ng-disabled="camera.isBusy"
                                                ng-click="cancelEditing(camera, cameraForm)">
                                            Cancel
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <p>
                    <button class="btn btn-default" ng-click="addCamera()">Add network camera</button>
                </p>
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
<script src="js/app/controllers/settingsController.js"></script>
<script src="js/app/controllers/livestreamController.js"></script>
<script src="js/app/controllers/cameraManagementController.js"></script>
@stop
