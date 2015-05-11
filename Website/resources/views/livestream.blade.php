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
            
            <!--<video src="http://localhost:8554" autoplay>
                <p>
                    Your browser can’t play MPEG-DASH streams.
                    Please update your browser or try using another one, such as <a href="https://www.google.de/chrome/browser/">Google Chrome</a>.
                </p>
            </video>-->
        </div>
        <div class="col-md-6" >
            <h3>Cameras</h3>
            
            <div ng-controller="CameraListCtrl">
                <input class="form-control" type="text" maxlength="15" placeholder="Search by IP address or name" ng-model="query">

                <table class="table table-bordered table-hover table-condensed @{{ bodyClass }}" ng-cloack>
                    <tr style="font-weight: bold">
                        <th style="width:0%">
							<a href="#" ng-click="orderBy('ip_address')">
							    IP-Address
								<span ng-show="orderField == 'ip_address'">
									<i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>									
									<i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
								</span>
							</a>
						</th>
						<th style="width:0%">
							<a href="#" ng-click="orderBy('port')">
							    Port
								<span ng-show="orderField == 'port'">
									<i class="fa fa-sort-numeric-asc" ng-show="!orderReverse"></i>									
									<i class="fa fa-sort-numeric-desc" ng-show="orderReverse"></i>
								</span>
							</a>
						</th>
                        <th style="width:100%">
							<a href="#" ng-click="orderBy('name')">
							    Name
								<span ng-show="orderField == 'name'">
									<i class="fa fa-sort-alpha-asc" ng-show="!orderReverse"></i>									
									<i class="fa fa-sort-alpha-desc" ng-show="orderReverse"></i>
								</span>
							</a>
						</th>
                        <th style="width:0%">
							<!-- Action -->
						</th>
                    </tr>
                    
					<!-- TODO: Use orderBy:naturalSort:orderField:orderReverse or something -->
                    <tr ng-repeat="camera in cameras | filter:query | orderBy:orderField:orderReverse ">
                        <td>
                            <!-- IP address -->
                            <span editable-text="camera.ip_address" e-name="ip_address" e-form="cameraForm" e-required onbeforesave="validateIpAddress($data, camera.id)">
                                @{{ camera.ip_address }}
                            </span>
                        </td>
                        <td>
                            <!-- Port -->
                            <span editable-text="camera.port" e-name="port" e-form="cameraForm" e-required onbeforesave="validatePort($data, camera.id)">
                                @{{ camera.port }}
                            </span>
                        </td>
                        <td>
                            <!-- Name -->
                            <span editable-text="camera.name" e-name="name" e-form="cameraForm" onbeforesave="validateName($data, camera.id)">
                                @{{ camera.name }}
                            </span>
                        </td>
                        <td style="white-space: nowrap">
                            <!-- Action -->
							
							<!-- TODO: Get these to work -->
                            <div class="buttons" ng-show="!cameraForm.$visible">
                                <button class="btn btn-primary" ng-click="cameraForm.$show()">Edit</button>
                                <button class="btn btn-danger" click-disable="deleteCamera(camera)">Delete</button>
								
                                <button click-and-disable="functionThatReturnsPromise()">Click me</button>
								<div test></div>
                            </div>
							
							<form editable-form name="cameraForm" onbeforesave="saveCamera($data, camera.id)" ng-show="cameraForm.$visible" class="form-buttons form-inline" shown="true">
                                <button type="submit" ng-disabled="cameraForm.$waiting" class="btn btn-primary">
                                    Save
                                </button>
                                <button type="button" ng-disabled="cameraForm.$waiting" ng-click="cameraForm.$cancel()" class="btn btn-default">
                                    Cancel
                                </button>
                            </form>
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
	<script src="js/services.js"></script>
	<script src="js/filters.js"></script>
    <script src="js/controllers.js"></script>
    <script src="js/directives.js"></script>
@stop
