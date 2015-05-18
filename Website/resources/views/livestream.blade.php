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

                <table class="table table-condensed borderless" ng-show="!isLoading">
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
                            <button class="btn btn-success" ng-show="settings.camera.mode === 1" ng-click="playStream()">Watch</button>
                        </td>
                    </tr>
                </table>
            </div>

            <div ng-controller="LivestreamController" ng-cloak>
                <!-- TODO: Show current stream URL somewhere -->
                <h3>Livestream</h3>

                <p ng-show="stream.sources.length === 0">
                    Select "Watch" on one of the listed cameras or enter a custom URL to see a livestream.
                </p>

                <p ng-show="stream.sources.length > 0">
                    <!-- TODO: Optional: Handle when video doesn't play -->
                    <videogular vg-player-ready="onPlayerReady($API)" vg-theme="stream.theme">
                        <vg-media vg-src="stream.sources"
                                  vg-tracks="stream.tracks"
                                  vg-native-controls="true"
                                  vg-auto-play="stream.autoPlay">
                        </vg-media>
                    </videogular>
                </p>

                <form name="custumUrlForm" novalidate>
                    <div ng-class="{ 'has-error': customUrlForm.customUrl.$invalid }">
                        <div class="input-group">
                            <!-- TODO: Add validation -->
                            <input class="form-control" name="customUrl" type="text" maxlength="2000" required placeholder="Custom URL to open the livestream from"
                                ng-model="customUrl" ng-required="true" ng-maxlength="2000" ng-class="{}" />
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" ng-click="playStreamFromUrl()">Open</button>
                            </span>
                        </div>
                        <span class="help-block" ng-show="customUrlForm.customUrl.$invalid ">Please enter a valid URL</span>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-7" ng-controller="CameraManagementController" ng-cloak>
            <h3 class="inline-block">Network Cameras</h3>
            <span ng-show="!isLoading">
                <span class="title-addition" ng-show="!searchQuery">(@{{ cameras.length }})</span>
                <span class="title-addition" ng-show="searchQuery">(@{{ camerasFiltered.length }}/ @{{ cameras.length }})</span>
            </span>

            <loader class="loader center-block" ng-show="isLoading"></loader>

            <div ng-show="!isLoading">
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
                                        IP-Address
                                        <span ng-show="orderField === 'ipAddress'">
                                            <i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>
                                            <i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
                                        </span>
                                    </a>
                                </th>
                                <th style="min-width: 75px">
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

                            <!-- TODO: Optional: Handler error, add paging -->
                            <tr ng-repeat="camera in camerasFiltered = (cameras | filter:searchQuery | orderBy:orderField:orderReverse)"
                                ng-class="{highlight: camera == activeCamera}" todo_onaftersave="saveCamera(camera)">
                                <td>
                                    <!-- Name -->
                                    <span editable-text="camera.name" e-form="cameraForm" e-name="name" e-placeholder="Front Door"
                                          onbeforesave="validateName($data)">
                                        @{{ camera.name }}
                                    </span>
                                </td>
                                <td>
                                    <!-- IP address -->
                                    <span editable-text="camera.ipAddress" e-name="ipAddress" e-form="cameraForm" e-placeholder="192.168.0.12"
                                          e-required onbeforesave="validateIpAddress($data)">
                                        @{{ camera.ipAddress }}
                                    </span>
                                </td>
                                <td>
                                    <!-- Port -->
                                    <span editable-text="camera.port" e-form="cameraForm" e-name="port" e-placeholder="8554"
                                          e-required onbeforesave="validatePort($data)">
                                        @{{ camera.port }}
                                    </span>
                                </td>
                                <td>
                                    <!-- Protocol -->
                                    <span editable-text="camera.protocol | uppercase" e-form="cameraForm" e-name="protocol" e-placeholder="HTTP"
                                          e-required onbeforesave="validateProtocol($data)">
                                        @{{ camera.protocol | uppercase }}
                                    </span>
                                </td>
                                <td style="white-space: nowrap">
                                    <!-- Actions -->
                                    <div class="buttons" ng-show="!cameraForm.$visible">
                                        <button class="btn btn-success" ng-click="playStream(camera)"
                                                ng-disabled="camera.isBusy">
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

                                    <!-- TODO: Get these to work, add validation and maxlength, disable during activity -->
                                    <form eclass="form-buttons form-inline" ditable-form name="cameraForm" todo_onaftersave="saveCamera($data, camera.id)"
                                          ng-show="cameraForm.$visible" shown="inserted == camera">
                                        <button type="submit" ng-disabled="cameraForm.$waiting" class="btn btn-primary">
                                            Save
                                        </button>
                                        <button type="button" class="btn btn-default"
                                                ng-disabled="cameraForm.$waiting" ng-click="cancelEditing(cameraForm, $index)">
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
