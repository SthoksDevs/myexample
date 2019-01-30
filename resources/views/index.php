<!DOCTYPE html>
<html lang="en-US" ng-app="contactsList">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
        <title>My Contacts</title>

        <!-- Load Bootstrap CSS -->
        <link href="<?= asset('css/bootstrap.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/font-awesome.css') ?>" rel="stylesheet">
    </head>
    <style>
        * {
            box-sizing: border-box;
        }

    </style>
    <body>
        <!-- Floating top menu -->
        <div class="col-12" style="padding: 20px 10px; position: relative; z-index: 5;" ng-controller="myContacts">
            <!-- Add new contact button -->
            <button id="btn-add" class="btn btn-primary btn-md" ng-click="toggle('add', 0)" style="position: fixed;">+ Add New Contact</button>
        </div>
        <div class="container" ng-controller="myContacts">
            <div style="text-align: center;">
                <h2>Contacts List</h2>
            </div>

            <!-- Our contacts here -->
            <div class="row">
                <div ng-repeat="contact in contacts">
                    <!-- Contacts card -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="box-shadow: -1px 2px 24px 3px #808080; text-align: center; margin: 15px 8px; padding: 10px 12px;">
                        <div style="color:#000;">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div style="text-align: left;">
                            <p style="border-top: #696969 solid 1px;"><i class="fa fa-user"></i> <strong>First Name:</strong> <span style="text-decoration:underline; float: right;">{{contact.first_name}}</span></p>
                            <p style="border-top: #696969 solid 1px;"><i class="fa fa-user"></i> <strong>Last Name:</strong> <span style="text-decoration:underline; float: right;">{{contact.last_name}}</span></p>
                            <p style="border-top: #696969 solid 1px;"><i class="fa fa-envelope"></i> <strong>Email:</strong> <span style="text-decoration:underline; float: right;">{{contact.email}}</span></p>
                            <p style="border-top: #696969 solid 1px;"><i class="fa fa-phone"></i> <strong>Mobile number:</strong> <span style="text-decoration:underline; float: right;">{{contact.mobile_number}}</span></p>
                        </div>
                        <div class="btn-group d-inline-block">
                            <button class="btn btn-warning btn-md" ng-click="toggle('edit', contact.id)">Edit</button>
                            <button class="btn btn-danger btn-md btn-delete" ng-click="confirmDelete(contact.id)">Delete</button>
                        </div>
                    </div><!-- End contact card -->

                </div>
                
                <!-- Shows no contacts message when database empty -->
                    <div ng-if="contacts.length == 0">
                        <p class="alert alert-info"><b>You have no contacts.</b></p>
                    </div>

               <!-- Modal (Pop up when detail button clicked) -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">{{form_title}}</h4>
                            </div>
                            <div class="modal-body">
                                <form name="frmContacts" class="form-horizontal" novalidate="">

                                    <div class="form-group error">
                                        <label for="inputEmail3" class="col-sm-3 control-label">First Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control has-error" id="first_name" name="first_name" placeholder="First name" value="{{first_name}}"
                                            ng-model="contact.first_name" ng-required="true">
                                            <span class="help-inline"
                                            ng-show="frmContacts.first_name.$error.required && frmContacts.first_name.$touched || frmContacts.first_name.$error.required && frmContacts.$submitted">First Name field is required</span>
                                        </div>
                                    </div>

                                    <div class="form-group error">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Last Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control has-error" id="last_name" name="last_name" placeholder="Last name" value="{{last_name}}"
                                            ng-model="contact.last_name" ng-required="true">
                                            <span class="help-inline"
                                            ng-show="frmContacts.last_name.$error.required && frmContacts.last_name.$touched">Last Name field is required</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="{{email}}"
                                            ng-model="contact.email" ng-required="true">
                                            <div ng-show="frmContacts.$submitted || frmContacts.email.$touched">
                                                <span class="help-inline"
                                                ng-show="frmContacts.email.$error.required">Email is required</span>
                                                <span class="help-inline"
                                                ng-show="frmContacts.email.$error.email">This email is invalid</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Mobile Number</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="Mobile Number" value="{{mobile_number}}"
                                            ng-model="contact.mobile_number" ng-required="true">
                                        <span class="help-inline"
                                            ng-show="frmContacts.mobile_number.$invalid && frmContacts.mobile_number.$touched">Contact number field is required</span>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmContacts.$invalid">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Load Javascript Libraries (AngularJS, JQuery, Bootstrap) -->
        <script src="<?= asset('app/lib/angular/angular.min.js') ?>"></script>
        <script src="<?= asset('js/jquery.js') ?>"></script>
        <script src="<?= asset('js/bootstrap.min.js') ?>"></script>

        <!-- AngularJS Application Scripts -->
        <script src="<?= asset('app/app.js') ?>"></script>
        <script src="<?= asset('app/controllers/contacts.js') ?>"></script>
    </body>
</html>