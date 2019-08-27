<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-4" style="margin-top: 30px">
            <div class="sidebar-left">
                <!-- widget -->
                <nav class="nav-menu">
                    <div ng-click="menuStatus = !menuStatus" ng-class="{'active': menuStatus}" class="nav-menu__toggle">
                        <span class="toggle__text" data-text="Hide">Show </span>menu
                    </div>
                    <ul class="nav-menu__list" ng-style="{ 'display' : menuStatus ? 'block' : '' }">
                        <li value="menu" class="current">
                            <a href="my-info">My Info </a>
                        </li>
                        <li>
                            <a href="order-history">Order History </a>
                        </li>
                    </ul>
                </nav><!-- End /idget -->

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 form-wrap text-center">
                @if(empty($user->avatar))
                    <img src="/common-assets/img/profile.jpg" alt="" class="img-fluid"
                         style="border-radius: 10px;margin: 25px; width: 200px; height: 200px">
                @else
                    <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" alt="" class="img-fluid"
                         style="border-radius: 10px;margin: 25px; width: 200px; height: 200px">
                @endif
                <div class="text-center">
                    <p style="font-size: 1.4em;color: black;">
                        <% user.full_name %>
                    </p>
                </div>
            </div>
            <div class="col-lg-8 col-md-7 form-wrap ml-form">
                <div class="form-padding">
                    <div class="form-title">Contact Information</div>
                    <form id="userForm" action="my-info/update" method="POST">
                        {{--Main Info--}}
                        <div style="padding-top:10px;">
                            <div class="row" style="font-size:1.2em;font-weight: bold;color:black">
                                <div class="col-lg-6">MAIN INFO</div>
                            </div>
                            <div style="margin-top: 30px;">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 pb-2em">
                                        <span style="color:black">Email:</span>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                <input id="email" type="text" ng-model="field.value['email']"
                                                       disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 pb-2em">
                                        <span style="color:black">Full Name:</span>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                <input id="full_name" type="text"
                                                       ng-model="field.value['full_name']"
                                                       ng-disabled="!field.disabled['full_name']"
                                                       onkeypress="return blockSpecialChar(event)">
                                                <span class="error-text"
                                                      ng-if="field.value['full_name'] != null && !field.value['full_name']">Name invalid</span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12" style="margin-top:10px">
                                                <a ng-if="!field.disabled['full_name']" href=""
                                                   ng-click="editOrSave('full_name')" class="edit-href">Edit</a>
                                                <div ng-if="field.disabled['full_name']" class="row">
                                                    <div class="col-lg-6">
                                                        <a href="" ng-click="saveButton('full_name')"
                                                           ng-class="{'disable-click': !field.value['full_name']}"
                                                           class="edit-href">Save</a>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <a href="" ng-click="cancelEdit('full_name')"
                                                           class="edit-href">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 pb-2em">
                                        <span style="color:black">Birthday:</span>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                <input id="birth_day" type="text" ng-model="field.value['birth_day']"
                                                       ng-disabled="!field.disabled['birth_day']">
                                                <span class="error-text"
                                                      ng-if="field.value['birth_day'] != null && !field.value['birth_day']">Birthday invalid</span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12" style="margin-top:10px">
                                                <a ng-if="!field.disabled['birth_day']" href=""
                                                   ng-click="editOrSave('birth_day')" class="edit-href">Edit</a>
                                                <div ng-if="field.disabled['birth_day']" class="row">
                                                    <div class="col-lg-6">
                                                        <a href="" ng-click="saveButton('birth_day')"
                                                           ng-class="{'disable-click': !field.value['birth_day']}"
                                                           class="edit-href">Save</a>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <a href="" ng-click="cancelEdit('birth_day')"
                                                           class="edit-href">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 pb-2em">
                                        <span style="color:black">Phone Number:</span>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                <input id="phone" type="text"
                                                       onkeypress="return isNumber(event)"
                                                       ng-disabled="!field.disabled['phone']"
                                                       ng-model="field.value['phone']" maxlength="10">
                                                <span class="error-text"
                                                      ng-if="field.value['phone'] != null && !validPhone()">Phone number invalid</span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12" style="margin-top:10px">
                                                <a ng-if="!field.disabled['phone']"
                                                   ng-click="editOrSave('phone')"
                                                   href="" class="edit-href">Edit</a>
                                                <div ng-if="field.disabled['phone']" class="row">
                                                    <div class="col-lg-6">
                                                        <a href="" ng-click="saveButton('phone')"
                                                           ng-class="{'disable-click': !validPhone()}"
                                                           class="edit-href">Save</a>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <a href="" ng-click="cancelEdit('phone')" class="edit-href">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 pb-2em">
                                        <span style="color:black">Address:</span>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                <input id="address" type="text"
                                                       ng-disabled="!field.disabled['address']"
                                                       ng-model="field.value['address']">
                                                <span class="error-text"
                                                      ng-if="field.value['address'] != null && !field.value['address']">Address invalid</span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12" style="margin-top:10px">
                                                <a href="" class="edit-href"
                                                   ng-if="!field.disabled['address']"
                                                   ng-click="editOrSave('address')">Edit</a>
                                                <div ng-if="field.disabled['address']" class="row">
                                                    <div class="col-lg-6">
                                                        <a href="" ng-click="saveButton('address')"
                                                           ng-class="{'disable-click': !field.value['address']}"
                                                           class="edit-href">Save</a>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <a href="" ng-click="cancelEdit('address')" class="edit-href">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    {{--Alternate info--}}
                    <div style="padding-top:10px;" ng-repeat="(key,alterProfile) in alterProfiles">
                        <div class="row" style="font-size:1.2em;font-weight: bold;color:black">
                            <div class="col-lg-6">ALTERNATIVE INFO #<% key + 1 %></div>
                            <a type="button" ng-click="openConfirm(key)" class="col-lg-6 text-right"><i
                                        class="fa fa-close"></i></a>
                        </div>
                        <div style="margin-top: 30px;">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 pb-2em">
                                    <span style="color:black">Email:</span>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <input id="email" type="text"
                                                   ng-model="alterProfiles[key]['email']"
                                                   ng-disabled="!field.alterProfileDisabled[key]['email']">
                                            <span class="error-text"
                                                  ng-if="field.newAlterProfileValue[key]['email'] != null && !validEmail(key,'email')">Email invalid</span>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12" style="margin-top:10px">
                                            <a ng-if="!field.alterProfileDisabled[key]['email']"
                                               ng-click="editOrSaveAlterProfile(key,'email')"
                                               href="" class="edit-href">Edit</a>
                                            <div ng-if="field.alterProfileDisabled[key]['email']" class="row">
                                                <div class="col-lg-6">
                                                    <a href="" ng-click="saveAlterProfileButton(key,'email')"
                                                       ng-class="{'disable-click': !validEmail(key,'email')"
                                                       class="edit-href">Save</a>
                                                </div>
                                                <div class="col-lg-6">
                                                    <a href="" ng-click="cancelEditAlterProfile(key,'email')"
                                                       class="edit-href">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 pb-2em">
                                    <span style="color:black">Phone Number:</span>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <input id="phone" type="text"
                                                   onkeypress="return isNumber(event)"
                                                   ng-disabled="!field.alterProfileDisabled[key]['phone']"
                                                   ng-model="alterProfiles[key]['phone']" maxlength="10">
                                            <span class="error-text"
                                                  ng-if="field.newAlterProfileValue[key]['phone'] != null && !validAlterPhone(key,'phone')">Phone number invalid</span>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12" style="margin-top:10px">
                                            <a ng-if="!field.alterProfileDisabled[key]['phone']"
                                               ng-click="editOrSaveAlterProfile(key,'phone')"
                                               href="" class="edit-href">Edit</a>
                                            <div ng-if="field.alterProfileDisabled[key]['phone']" class="row">
                                                <div class="col-lg-6">
                                                    <a href="" ng-click="saveAlterProfileButton(key,'phone')"
                                                       ng-class="{'disable-click': !validAlterPhone(key,'phone')}"
                                                       class="edit-href">Save</a>
                                                </div>
                                                <div class="col-lg-6">
                                                    <a href="" ng-click="cancelEditAlterProfile(key,'phone')"
                                                       class="edit-href">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 pb-2em">
                                    <span style="color:black">Address:</span>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <input id="address" type="text"
                                                   ng-disabled="!field.alterProfileDisabled[key]['address']"
                                                   ng-model="alterProfiles[key]['address']">
                                            <span class="error-text"
                                                  ng-if="field.newAlterProfileValue[key]['address'] != null && !field.newAlterProfileValue[key]['address']">Address invalid</span>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12" style="margin-top:10px">
                                            <a href="" class="edit-href"
                                               ng-if="!field.alterProfileDisabled[key]['address']"
                                               ng-click="editOrSaveAlterProfile(key,'address')">Edit</a>
                                            <div ng-if="field.alterProfileDisabled[key]['address']" class="row">
                                                <div class="col-lg-6">
                                                    <a href="" ng-click="saveAlterProfileButton(key,'address')"
                                                       ng-class="{'disable-click': !alterProfiles[key]['address']}"
                                                       class="edit-href">Save</a>
                                                </div>
                                                <div class="col-lg-6">
                                                    <a href="" ng-click="cancelEditAlterProfile(key,'address')"
                                                       class="edit-href">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <a href="#" data-toggle="modal" data-target="#modalAddProfile" class="btn btn-success"><i
                                    class="fa fa-plus"></i> Add Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
