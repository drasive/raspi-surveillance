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
             <!-- TODO: Rename controller -->
            <div ng-controller="CameraModeController" ng-cloak>
                <h3>Local Camera</h3>

                <table class="table table-condensed borderless">
                    <tr>
                        <td style="width: 100px;">IP Address:</td>
                        <td>{{{ $g_hostIpAddress }}} ({{{ $g_hostName }}})</td>
                    </tr>
                    <tr>
                        <td>Mode:</td>
                        <td>
                            <!-- TODO: Disable during activity -->
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default" ng-class="{active: mode === 0}" 
                                        ng-click="changeMode(0)" ng-disabled="isBusy">
                                    Off
                                </button>
                                <button type="button" class="btn btn-success" ng-class="{active: mode === 1}" 
                                        ng-click="changeMode(1)" ng-disabled="isBusy">
                                    Streaming
                                </button>
                                <button type="button" class="btn btn-primary" ng-class="{active: mode === 2}" 
                                        ng-click="changeMode(2)" ng-disabled="isBusy">
                                    Motion Detection
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Stream:</td>
                        <td>
                            <span ng-show="mode !== 1">Not in streaming mode.</span>
                            <button class="btn btn-success" ng-show="mode === 1" ng-click="loadStream(camera)">Watch</button>
                        </td>
                    </tr>
                </table>
            </div>

            <div ng-controller="LivestreamController" ng-cloak>
                <h3>Livestream</h3>

                <p ng-show="stream.sources.length === 0">
                    Select "Watch" on one of the listed cameras to see a livestream.
                </p>

                <p ng-show="stream.sources.length > 0">
                    <!-- TODO: Optional: Handle if video doesn't play -->
                    <videogular vg-player-ready="onPlayerReady($API)" vg-theme="stream.theme">
                        <vg-media vg-src="stream.sources"
                                  vg-tracks="stream.tracks"
                                  vg-native-controls="true"
                                  vg-auto-play="stream.autoPlay">
                        </vg-media>
                    </videogular>
                </p>
                <p>
                    <!-- TODO: Delete/keep functionality, use modal or textbox -->
                    <button type="button" class="btn btn-default">Open stream from URL</button>
                </p>
            </div>
        </div>

        <div class="col-lg-7" ng-controller="CameraManagementController" ng-cloak>
            <h3 class="inline-block">Network Cameras</h3>
            <span class="title-addition" ng-show="!query">(@{{ cameras.length }})</span>
            <span class="title-addition" ng-show="query">(@{{ camerasFiltered.length }}/ @{{ cameras.length }})</span>

            <p ng-show="cameras.length === 0">
                You currently do not have any network cameras.<br />
                Click on "Add network camera" to add your first one.
            </p>

            <div ng-show="cameras.length > 0">
                <p>
                    <input class="form-control" type="text" maxlength="100"
                           placeholder="Search by name, IP address, port or protocol" ng-model="query">
                </p>

                <div class="table-responsive">
                    <table class="table table-striped vert-aligh">
                        <tr>
                            <th style="width: 100%">
                                <a href="#" ng-click="orderBy('name')">
                                    Name
                                    <span ng-show="orderField == 'name'">
                                        <i class="fa fa-sort-alpha-asc" ng-show="!orderReverse"></i>
                                        <i class="fa fa-sort-alpha-desc" ng-show="orderReverse"></i>
                                    </span>
                                </a>
                            </th>
                            <th style="min-width: 130px">
                                <a href="#" ng-click="orderBy('ipAddress')">
                                    IP-Address
                                    <span ng-show="orderField == 'ipAddress'">
                                        <i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>
                                        <i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
                                    </span>
                                </a>
                            </th>
                            <th style="min-width: 75px">
                                <a href="#" ng-click="orderBy('port')">
                                    Port
                                    <span ng-show="orderField == 'port'">
                                        <i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>
                                        <i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
                                    </span>
                                </a>
                            </th>
                            <th style="min-width: 90px">
                                <a href="#" ng-click="orderBy('protocol')">
                                    Protocol
                                    <span ng-show="orderField == 'protocol'">
                                        <i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>
                                        <i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 0%">
                                <!-- Action -->
                            </th>
                        </tr>

                        <!-- TODO: Highlight playing video, Optional: Don't flicker at load, handler loading/error, add paging -->
                        <tr ng-repeat="camera in camerasFiltered = (cameras | filter:query | orderBy:orderField:orderReverse)" ng-class="{highlight: camera == activeCamera}">
                            <td>
                                <!-- Name -->
                                <span editable-text="camera.name"
                                      e-name="name" e-form="cameraForm" onbeforesave="validateName($data, camera.id)">
                                    @{{ camera.name }}
                                </span>
                            </td>
                            <td>
                                <!-- IP address -->
                                <span editable-text="camera.ipAddress"
                                      e-name="ipAddress" e-form="cameraForm" e-required onbeforesave="validateIpAddress($data, camera.id)">
                                    @{{ camera.ipAddress }}
                                </span>
                            </td>
                            <td>
                                <!-- Port -->
                                <span editable-text="camera.port"
                                      e-name="port" e-form="cameraForm" e-required onbeforesave="validatePort($data, camera.id)">
                                    @{{ camera.port }}
                                </span>
                            </td>
                            <td>
                                <!-- Protocol -->
                                <span editable-text="camera.protocol | uppercase"
                                      e-name="protocol" e-form="cameraForm" e-required onbeforesave="validateProtocol($data, camera.id)">
                                    @{{ camera.protocol | uppercase }}
                                </span>
                            </td>
                            <td style="white-space: nowrap">
                                <!-- Action -->
                                <div class="buttons" ng-show="!cameraForm.$visible">
                                    <button class="btn btn-success" ng-click="loadStream(camera)"
                                        ng-disabled="camera.isBusy">Watch</button>
                                    <button class="btn btn-primary" ng-click="cameraForm.$show()"
                                        ng-disabled="camera.isBusy">Edit</button>
                                    <button class="btn btn-danger" ng-click="deleteCamera(camera)"
                                        ng-disabled="camera.isBusy">Delete</button>
                                </div>

                                <!-- TODO: Get these to work, disable during activity -->
                                <form editable-form name="cameraForm" onbeforesave="saveCamera($data, camera.id)"
                                      ng-show="cameraForm.$visible" class="form-buttons form-inline" shown="inserted == camera">
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
@stop

@section('scripts')
<script src="bower_components/angular-sanitize/angular-sanitize.min.js"></script>
<script src="bower_components/videogular/videogular.js"></script>

<script src="js/app/app.js"></script>
<script src="js/app/directives.js"></script>
<script src="js/app/filters.js"></script>
<script src="js/app/services.js"></script>
<script src="js/app/controllers/controllers.js"></script>
<script src="js/app/controllers/cameraModeController.js"></script>
<script src="js/app/controllers/livestreamController.js"></script>
<script src="js/app/controllers/cameraManagementController.js"></script>
@stop
