@extends('site.default-layout')

@section('title', 'Livestream')
@section('description', 'Watch livestreams of your Raspberry Pi surveillance cameras.')

@section('default-content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Livestream</h1>
        </div>
    </div>

	<div class="row" ng-app="raspiSurveillanceApp">
        <div class="col-md-6">
            <h3>Livestream</h3>
            
            <video src="http://localhost:8554" autoplay>
                <p>
                    Your browser can’t play MPEG-DASH streams.
                    Please update your browser or try using another one, such as <a href="https://www.google.de/chrome/browser/">Google Chrome</a>.
                </p>
            </video>
        </div>
        <div class="col-md-6" >
            <h3>Cameras</h3>
            
            <div ng-controller="CameraListCtrl">
                <input class="form-control" type="text" maxlength="15" placeholder="Search by IP address or name" ng-model="query">
                <select class="form-control" ng-model="order">
                    <option value="ip_address" selected>IP Address</option>
                    <option value="name">Name</option>
                </select>

                <table class="table table-bordered table-hover table-condensed">
                    <tr style="font-weight: bold">
                        <td style="width:25%">IP-Address</td>
                        <td style="width:50%">Name</td>
                        <td style="width:25%">Edit</td>
                    </tr>
                    
                    <tr ng-repeat="camera in cameras | filter:query | orderBy:order">
                        <td>
                            <!-- IP address -->
                            <span editable-text="camera.ip_address" e-name="ip_address" e-form="rowform" onbeforesave="validateIpAddress($data, camera.id)" e-required>
                                @{{ camera.ip_address }}
                            </span>
                        </td>
                        <td>
                            <!-- Name -->
                            <span editable-select="camera.name" e-name="name" e-form="rowform" onbeforesave="validateName($data, camera.id)">
                                @{{ camera.name }}
                            </span>
                        </td>
                        <td style="white-space: nowrap">
                            <!-- Edit -->
                            <form editable-form name="rowform" onbeforesave="saveCamera($data, camera.id)" ng-show="rowform.$visible" class="form-buttons form-inline" shown="inserted == camera">
                                <button type="submit" ng-disabled="rowform.$waiting" class="btn btn-primary">
                                    Save
                                </button>
                                <button type="button" ng-disabled="rowform.$waiting" ng-click="rowform.$cancel()" class="btn btn-default">
                                    Cancel
                                </button>
                            </form>
                            <div class="buttons" ng-show="!rowform.$visible">
                                <button class="btn btn-primary" ng-click="rowform.$show()">Edit</button>
                                <button class="btn btn-danger" ng-click="button=true && deleteCamera(camera)" ng-disabled="button">Delete</button>
                            </div>
                        </td>
                    </tr>
                </table>
                
                <button class="btn btn-default" ng-click="addCamera()">Add row</button>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="js/app.js"></script>
    <script src="js/controllers.js"></script>
    <script src="js/services.js"></script>
@stop
