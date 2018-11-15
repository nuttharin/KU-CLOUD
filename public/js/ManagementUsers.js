/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "http://localhost:8080/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/ManagementUsers.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ManagementUsers", function() { return ManagementUsers; });
/* harmony export (immutable) */ __webpack_exports__["FatoryCreateManagmentUser"] = FatoryCreateManagmentUser;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utility__ = __webpack_require__("./resources/js/utility.js");
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }



var modalCreate = null;
var modalDetail = null;
var modalEdit = null;
var modalBlock = null;
var modalUnblock = null;
var modalDelete = null;
var FormAddEmail = "\n                    <div class=\"input-group mb-2\">\n                        <input type=\"text\" class=\"add_email_val form-control mt-1\" value={email} disabled>\n                            <div class=\"input-group-append\">\n                                <button class=\"btn btn-danger mt-1 btn-delete-email\" type=\"button\"><i class=\"fas fa-times\"></i></button>  \n                            </div>\n                    </div>\n                    ";
var FormAddPhone = " \n                    <div class=\"input-group mb-2\">\n                        <input type=\"text\" class=\"add_phone_val form-control mt-1\" value={phone} disabled>\n                        <div class=\"input-group-append\">\n                            <button class=\"btn btn-danger mt-1 btn-delete-phone\" type=\"button\"><i class=\"fas fa-times\"></i></button>  \n                        </div>\n                    </div>";

toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

var END_POINT = 'http://localhost:8000/api/';

var ModalCreate = function ModalCreate(config) {
    _classCallCheck(this, ModalCreate);

    if (modalCreate) {
        return modalCreate;
    }

    this.resetModal = function () {
        $("#add_email_val").val('');
        $("#add_fname_val").val('');
        $("#add_phone_val").val('');
        $("#add_pwd_val").val('');
        $("#add_lname_val").val('');
    };
};

var ModalDetail = function ModalDetail() {
    _classCallCheck(this, ModalDetail);

    if (modalDetail) {
        return modalDetail;
    }

    this.create = function (key) {
        if ($("#detailUser").length === 0) {
            var modal = "\n                                <div class=\"modal fade\" id=\"detailUser\">\n                                    <div class=\"modal-dialog\">\n                                        <div class=\"modal-content\">\n                                            <div class=\"modal-header\">\n                                                <h5 class=\"modal-title\" id=\"title-user\"></h5>\n                                                <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\n                                            </div>\n        \n                                            <div class=\"modal-body\">\n                                                <h6>Name : <span  id=\"name-user\"><span></h6>\n                                                <h6>Phone : <span id=\"phone-user\"><span></h6>\n                                                <h6>Email : <span id=\"email-user\"><span></h6>\n                                            </div>\n        \n                                            <div class=\"modal-footer\">\n                                                \n                                            </div>\n                                        </div>\n                                    </div>\n                                </div>\n                                  ";
            $('body').append(modal);
        }

        $('#title-user').html(UsersList[key].email[0].email_user);
        $('#name-user').html(UsersList[key].fname + " " + UsersList[key].lname);

        var phone_list = UsersList[key].phone.map(function (data) {
            return data.phone_user;
        });
        $('#phone-user').html(phone_list.join(','));
        var email_list = UsersList[key].email.map(function (data) {
            return data.email_user;
        });
        $('#email-user').html(email_list.join(','));

        $("#detailUser").modal('show');
    };
};

var ModalEdit = function ModalEdit(config) {
    _classCallCheck(this, ModalEdit);

    if (modalEdit) {
        return modalEdit;
    }

    this.create = function (key) {
        if ($("#editUser").length === 0) {
            var modal = "\n                <div class=\"modal fade\" id=\"editUser\">\n                    <div class=\"modal-dialog modal-lg\">\n                        <div class=\"modal-content\">\n                            <div class=\"modal-header\">\n                                <h4 class=\"modal-title\">Edit User Company</h4>\n                                <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\n                            </div>\n\n                            <div class=\"modal-body\">\n                                <form id=\"form-edit-user\">\n                                    <div class=\"row\">\n                                        <div class=\"col-6\">\n                                            <label>Firstname</label>\n                                            <input type=\"text\" id=\"edit-fname\" class=\"form-control\"/>\n                                            <button class=\"btn btn-primary btn-sm btn-radius mt-2\" id=\"btn-add-email\"><i class=\"fas fa-plus\"></i> add email</button>\n                                            <div id=\"input-add-email\">\n                                            </div>\n                                        </div>\n                                        <div class=\"col-6\">\n                                            <label>Lastname</label>\n                                            <input type=\"text\" id=\"edit-lname\" class=\"form-control\"/>\n                                            <button class=\"btn btn-primary btn-sm btn-radius mt-2\" id=\"btn-add-phone\"><i class=\"fas fa-plus\"></i> add phone</button>\n                                            <div id=\"input-add-phone\">\n                                            </div>\n                                        </div>\n                                    </div>\n                                </form>\n                            </div>\n\n                            <div class=\"modal-footer\">\n                                <button type=\"button\" id=\"btn-edit-submit\" class=\"btn btn-success btn-block btn-submit-edit\" data-loading-text=\"<i class='fas fa-circle-notch fa-spin'></i> Saving . . .\">Save</button>\n                            </div>\n                        </div>\n                    </div>\n                </div>";
            $('body').append(modal);
        }

        $("#btn-edit-submit").unbind().click(function () {
            onSubmitEditClick(key);
        });

        $("#btn-add-phone").unbind().click(function () {
            event.preventDefault();
            var addPhone = FormAddPhone.replace('disabled', '');
            addPhone = addPhone.replace('{phone}', '');
            if ($(".btn-delete-phone").length <= 2) {
                $("#input-add-phone").append(addPhone);
            }
        });

        $("#btn-add-email").unbind().click(function () {
            event.preventDefault();
            var addEmail = FormAddEmail.replace('disabled', '');
            addEmail = addEmail.replace('{email}', '');
            if ($(".btn-delete-email").length <= 2) $("#input-add-email").append(addEmail);
        });

        var phoneList = UsersList[key].phone;
        var inputPhone = null;
        inputPhone = phoneList.map(function (phone) {
            return FormAddPhone.replace('{phone}', phone.phone_user);
        });

        var emailList = UsersList[key].email;
        var inputEmail = null;
        inputEmail = emailList.map(function (email) {
            return FormAddEmail.replace('{email}', email.email_user);
        });

        $('#edit-fname').val(UsersList[key].fname);
        $('#edit-lname').val(UsersList[key].lname);
        $('#input-add-phone').html(inputPhone.join(''));
        $('#input-add-email').html(inputEmail.join(''));
        $('#editUser').modal('show');
    };

    var onSubmitEditClick = function onSubmitEditClick(index) {
        __WEBPACK_IMPORTED_MODULE_0__utility__["b" /* LOADING */].set($("#btn-edit-submit"));
        var fname = $("#edit-fname").val();
        var lname = $("#edit-lname").val();
        var phone = $(".add_phone_val").map(function () {
            return $(this).val();
        }).get();
        var email = $(".add_email_val").map(function () {
            return $(this).val();
        }).get();
        $.ajax({
            url: END_POINT + config.edit,
            method: "PUT",
            data: {
                user_id: UsersList[index].user_id,
                fname: fname,
                lname: lname,
                phone_user: phone,
                email_user: email
            },
            success: function success(res) {
                toastr["success"]("Edit user success");
                __WEBPACK_IMPORTED_MODULE_0__utility__["b" /* LOADING */].reset($("#btn-edit-submit"));
                $("#editUser").modal('hide');
                ManagementUsers.refreshData();
            },
            error: function error(res) {
                __WEBPACK_IMPORTED_MODULE_0__utility__["b" /* LOADING */].reset($("#btn-edit-submit"));
                console.log(res);
            }
        });
    };
};

var ModalToggleActive = function ModalToggleActive(config) {
    _classCallCheck(this, ModalToggleActive);

    if (modalBlock) {
        return modalBlock;
    }

    this.create = function (key) {
        if ($("#BlockUser").length === 0) {
            var modal = "\n                <div class=\"modal fade\" id=\"BlockUser\">\n                    <div class=\"modal-dialog\">\n                        <div class=\"modal-content\">\n                            <div class=\"modal-header\">\n                                <h4 class=\"modal-title\">Block User Company</h4>\n                                <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\n                            </div>\n\n                            <div class=\"modal-body\">\n                                <form id=\"form-block-user\">\n                                    <h6 id=\"span-text-confirm-block\"></h6>\n                                </form>\n                            </div>\n\n                            <div class=\"modal-footer\" id=\"btn-toggle-active-footer\">\n                                \n                            </div>\n                        </div>\n                    </div>\n                </div>";

            $('body').append(modal);
        }
        var active = UsersList[key].block ? 'block' : 'unblock';
        if (UsersList[key].block) {
            $("#btn-toggle-active-footer").html("<button type=\"button\" id=\"btn-toggle-active-submit\" class=\"btn btn-info btn-block\" data-loading-text=\"<i class='fas fa-circle-notch fa-spin'></i> Saving . . .\">UnBlock</button>");
        } else {
            $("#btn-toggle-active-footer").html("<button type=\"button\" id=\"btn-toggle-active-submit\" class=\"btn btn-danger btn-block\" data-loading-text=\"<i class='fas fa-circle-notch fa-spin'></i> Saving . . .\">Block</button>");
        }

        $('#btn-toggle-active-submit').unbind().click(function () {
            onSubmitToggleActiveUser(key);
        });

        $("#span-text-confirm-block").html("Are you sure to " + active + " " + UsersList[key].fname + " " + UsersList[key].lname + " ?");
        $("#BlockUser").modal('show');
    };

    var onSubmitToggleActiveUser = function onSubmitToggleActiveUser(key) {
        __WEBPACK_IMPORTED_MODULE_0__utility__["b" /* LOADING */].set($("#btn-toggle-active-submit"));
        $.ajax({
            url: END_POINT + config.block,
            method: "put",
            data: {
                user_id: UsersList[key].user_id,
                block: UsersList[key].block ? 0 : 1
            },
            success: function success(res) {
                toastr["success"]("Blcok user success");
                $("#BlockUser").modal('hide');
                __WEBPACK_IMPORTED_MODULE_0__utility__["b" /* LOADING */].reset($("#btn-toggle-active-submit"));
                ManagementUsers.refreshData();
            },
            error: function error(res) {
                __WEBPACK_IMPORTED_MODULE_0__utility__["b" /* LOADING */].reset($("#btn-toggle-active-submit"));
                console.log(res);
            }
        });
    };
};

var ModalDelete = function ModalDelete(config) {
    _classCallCheck(this, ModalDelete);

    if (modalDelete) {
        return modalDelete;
    }

    this.create = function (key) {
        if ($("#DeleteUser").length === 0) {
            var modal = "<div class=\"modal fade\" id=\"DeleteUser\">\n                                <div class=\"modal-dialog\">\n                                    <div class=\"modal-content\">\n                                        <div class=\"modal-header\">\n                                            <h4 class=\"modal-title\">Delete User Company</h4>\n                                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\n                                        </div>\n    \n                                        <div class=\"modal-body\">\n                                            <form id=\"form-delete-user\">\n                                                <h6 id=\"span-text-confirm\"></h6>\n                                            </form>\n                                        </div>\n    \n                                        <div class=\"modal-footer\">\n                                            <button type=\"button\" id=\"btn-delete-submit\" class=\"btn btn-danger btn-block\" data-loading-text=\"<i class='fas fa-circle-notch fa-spin'></i> Saving . . .\">Delete</button>\n                                        </div>\n                                    </div>\n                                </div>\n                            </div>";
            $("body").append(modal);
        }
        $('#span-text-confirm').html("Are you sure to delete " + UsersList[key].email[0].email_user + " ? ");
        $('#DeleteUser').modal('show');
    };
};

var UsersList = [];

var ManagementUsers = function () {
    function ManagementUsers(config) {
        var _this = this;

        _classCallCheck(this, ManagementUsers);

        this.config = {
            getUsers: config.getUsers,
            getOnlineUsers: config.OnlineUsers,
            create: config.create,
            edit: config.edit,
            block: config.block,
            unblock: config.unblock,
            delete: config.delete,
            type: config.type
        };

        var UsersDATATABLE = null;

        var initialDatatable = function initialDatatable() {
            if (UsersDATATABLE !== null) {
                return false;
            }

            UsersDATATABLE = $('#example').dataTable({});
        };

        var showDatatableLoadingStatus = function showDatatableLoadingStatus(showOrHide) {
            if (showOrHide) {
                $(".dataTables_wrapper").hide();
                $('#example').hide();
                $('.lds-roller').show();
            } else {
                $(".dataTables_wrapper").show();
                $('.lds-roller').hide();
                $('.text-loading').hide();
                $('#example').show();
                $('.text-static').show();
            }
        };

        var createTableUsersCompany = function createTableUsersCompany() {
            var Datatable = [];
            UsersDATATABLE.fnClearTable();
            $.each(UsersList, function (index, item) {
                var ret = [];
                var btnBlock = "                            \n                <button type=\"button\" class=\"btn btn-secondary btn-sm btn-block-user\" index=" + index + " data-toggle=\"tooltip\" data-placement=\"top\" title=\"Block\">\n                    <i class=\"fas fa-times\"></i>\n                </button>";
                if (item.block) {
                    btnBlock = "                            \n                    <button type=\"button\" class=\"btn btn-secondary btn-sm btn-block-user\" index=" + index + " data-toggle=\"tooltip\" data-placement=\"top\" title=\"UnBlock\">\n                        <i class=\"fas fa-unlock\"></i>\n                    </button>";
                }
                ret[0] = item.fname + " " + item.lname;
                ret[1] = item.phone[0].phone_user;
                ret[2] = item.email[0].email_user;
                ret[3] = item.block ? '<b class="text-danger">Block</b>' : 'Unblock';
                ret[4] = item.sub_type_user;
                ret[5] = item.online ? '<b class="text-success">online <i class="fas fa-circle text-success fa-xs"></i></b>' : '<span class="text-secondary">offline <i class="fas fa-circle text-secondary fa-xs"></i></span>';
                ret[6] = "<center>\n                                <button type=\"button\" class=\"btn btn-primary btn-sm btn-detail\" index=" + index + " data-toggle=\"tooltip\"\n                                    data-placement=\"top\" title=\"Detail\">\n                                    <i class=\"fas fa-list\"></i>\n                                </button>\n                                <button type=\"button\" class=\"btn btn-success btn-sm btn-edit\" index=" + index + "  data-toggle=\"tooltip\"\n                                    data-placement=\"top\" title=\"Edit\">\n                                    <i class=\"fas fa-edit\"></i>\n                                </button>\n                                " + btnBlock + "\n                                <button type=\"button\" class=\"btn btn-danger btn-sm btn-delete\"  index=" + index + "  data-toggle=\"tooltip\"\n                                    data-placement=\"top\" title=\"Delete\">\n                                    <i class=\"fas fa-trash-alt\"></i>\n                                </button>\n                            </center>";
                Datatable.push(ret);
            });
            UsersDATATABLE.fnAddData(Datatable);

            $('#example').on('click', '.btn-detail', function () {
                onDetailClick($(this).attr('index'));
            });

            $('#example').on('click', '.btn-edit', function () {
                onEditClick($(this).attr('index'));
            });

            $('#example').on('click', '.btn-block-user', function () {
                onBlockClick($(this).attr('index'));
            });

            $('#example').on('click', '.btn-unblock-user', function () {
                onUnBlockClick($(this).attr('index'));
            });

            $('#example').on('click', '.btn-delete', function () {
                onDeleteClick($(this).attr('index'));
            });
        };

        var createTableUsersCustomer = function createTableUsersCustomer() {
            var Datatable = [];
            UsersDATATABLE.fnClearTable();
            $.each(UsersList, function (index, item) {
                var ret = [];
                var btnBlock = "                            \n                <button type=\"button\" class=\"btn btn-secondary btn-sm btn-block-user\" index=" + index + " data-toggle=\"tooltip\" data-placement=\"top\" title=\"Block\">\n                    <i class=\"fas fa-times\"></i>\n                </button>";
                if (item.block) {
                    btnBlock = "                            \n                    <button type=\"button\" class=\"btn btn-secondary btn-sm btn-block-user\" index=" + index + " data-toggle=\"tooltip\" data-placement=\"top\" title=\"UnBlock\">\n                        <i class=\"fas fa-unlock\"></i>\n                    </button>";
                }
                ret[0] = item.fname + " " + item.lname;
                ret[1] = item.phone[0].phone_user;
                ret[2] = item.email[0].email_user;
                ret[3] = item.block ? '<b class="text-danger">Block</b>' : 'Unblock';
                ret[4] = item.online ? '<b class="text-success">online <i class="fas fa-circle text-success fa-xs"></i></b>' : '<span class="text-secondary">offline <i class="fas fa-circle text-secondary fa-xs"></i></span>';
                ret[5] = "<center>\n                                <button type=\"button\" class=\"btn btn-primary btn-sm btn-detail\" index=" + index + " data-toggle=\"tooltip\"\n                                    data-placement=\"top\" title=\"Detail\">\n                                    <i class=\"fas fa-list\"></i>\n                                </button>\n                                <button type=\"button\" class=\"btn btn-success btn-sm btn-edit\" index=" + index + "  data-toggle=\"tooltip\"\n                                    data-placement=\"top\" title=\"Edit\">\n                                    <i class=\"fas fa-edit\"></i>\n                                </button>\n                                " + btnBlock + "\n                                <button type=\"button\" class=\"btn btn-danger btn-sm btn-delete\"  index=" + index + "  data-toggle=\"tooltip\"\n                                    data-placement=\"top\" title=\"Delete\">\n                                    <i class=\"fas fa-trash-alt\"></i>\n                                </button>\n                            </center>";
                Datatable.push(ret);
            });
            UsersDATATABLE.fnAddData(Datatable);

            $('#example').on('click', '.btn-detail', function () {
                onDetailClick($(this).attr('index'));
            });

            $('#example').on('click', '.btn-edit', function () {
                onEditClick($(this).attr('index'));
            });

            $('#example').on('click', '.btn-block-user', function () {
                onBlockClick($(this).attr('index'));
            });

            $('#example').on('click', '.btn-unblock-user', function () {
                onUnBlockClick($(this).attr('index'));
            });

            $('#example').on('click', '.btn-delete', function () {
                onDeleteClick($(this).attr('index'));
            });
        };

        var onSaveUserClick = function onSaveUserClick(el) {
            __WEBPACK_IMPORTED_MODULE_0__utility__["b" /* LOADING */].set(el);
            var email_input = $("#add_email_val").val();
            var pwd_input = $("#add_pwd_val").val();
            var fname_input = $("#add_fname_val").val();
            var lname_input = $("#add_lname_val").val();
            var phone_input = $("#add_phone_val").val();
            var type_user_input = null;
            if (config.type === 'COMPANY') {
                type_user_input = $("#add_type_user_val").val();
            }
            $.ajax({
                url: END_POINT + config.create,
                dataType: 'json',
                method: "POST",
                data: {
                    email: email_input,
                    password: pwd_input,
                    fname: fname_input,
                    lname: lname_input,
                    phone: phone_input,
                    sub_type_user: type_user_input
                },
                success: function success(res) {
                    toastr["success"]("Create user success");
                    _this.showLastestDatatable();
                    __WEBPACK_IMPORTED_MODULE_0__utility__["b" /* LOADING */].reset(el);
                    $("#addUser").modal('hide');
                },
                error: function error(res) {
                    console.log(res);
                    __WEBPACK_IMPORTED_MODULE_0__utility__["b" /* LOADING */].reset(el);
                    var errorList = res.responseJSON.errors;
                    var error_target = {
                        email: {
                            el: $("#add_email_val")
                        },
                        password: {
                            el: $("#add_pwd_val")
                        },
                        fname: {
                            el: $("#add_fname_val")
                        },
                        lname: {
                            el: $("#add_lname_val")
                        },
                        phone: {
                            el: $("#add_phone_val")
                        },
                        sub_type_user: {
                            el: $("#add_type_user_val")
                        }
                    };
                    console.log(errorList);
                    __WEBPACK_IMPORTED_MODULE_0__utility__["a" /* ERROR_INPUT */].set(error_target, errorList);
                }
            });
        };

        var onDetailClick = function onDetailClick(key) {
            modalDetail = new ModalDetail();
            modalDetail.create(key);
        };

        var onEditClick = function onEditClick(key) {
            modalEdit = new ModalEdit(config);
            modalEdit.create(key);
        };

        var onBlockClick = function onBlockClick(key) {
            modalBlock = new ModalToggleActive(config);
            modalBlock.create(key);
        };

        var onDeleteClick = function onDeleteClick(key) {
            modalDelete = new ModalDelete(config);
            modalDelete.create(key);
        };

        var updateDatatableData = function updateDatatableData() {
            if (config.type === "COMPANY") {
                createTableUsersCompany();
            } else if (config.type === "CUSTOMER") {
                createTableUsersCustomer();
            }
            $('[data-toggle="tooltip"]').tooltip();
        };

        this.initialAndRun = function () {
            _this.showLastestDatatable();
            $('#btn-add-user').unbind().click(function () {
                modalCreate = new ModalCreate(config);
                modalCreate.resetModal();
                $("#addUser").modal('show');
            });

            $('#btn-save-add-user').unbind().click(function () {
                onSaveUserClick($(this));
            });
        };

        this.showLastestDatatable = function () {
            showDatatableLoadingStatus(true);
            $.ajax({
                url: END_POINT + config.getUsers,
                method: 'GET',
                success: function success(result) {
                    //console.log(result);
                    initialDatatable();
                    UsersList = result.data;
                    showDatatableLoadingStatus(false);
                    updateDatatableData();
                },
                error: function error(_error) {
                    console.log(_error);
                }
            });

            $.ajax({
                url: END_POINT + config.getOnlineUsers,
                method: 'GET',
                data: {
                    type_user: config.type
                },
                success: function success(result) {
                    var sum = 0;
                    for (var i in result.users) {
                        sum += Number(result.users[i].count);
                        if (result.users[i].online === "online") {
                            $("#total-user-online").html(result.users[i].count + " user");
                        } else {
                            $("#total-user-offline").html(result.users[i].count + " user");
                        }
                    }
                    $("#total-user").html(sum + " user");
                },
                error: function error(_error2) {
                    console.log(_error2);
                }
            });
        };
    }

    _createClass(ManagementUsers, null, [{
        key: "refreshData",
        value: function refreshData() {
            return managementUsers.showLastestDatatable();
        }
    }]);

    return ManagementUsers;
}();

var managementUsers = null;

function FatoryCreateManagmentUser(config) {
    managementUsers = new ManagementUsers(config);
    managementUsers.initialAndRun();
}

/***/ }),

/***/ "./resources/js/utility.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export showLoadingModal */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return deepCopy; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return LOADING; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ERROR_INPUT; });

var showLoadingModal = function showLoadingModal(el, status) {
    var loading = " <div id=\"loading-save\" style=\"display:none;\">\n                        <div class=\"lds-ring\">\n                            <div></div>\n                            <div></div>\n                            <div></div>\n                            <div></div>\n                        </div>\n                        <h6 class='text-center'>Saving Data ...</h6>\n                    </div>";
    var _el = el;

    if (!_el.find("#loading-save").length) {
        _el.find(".modal-body").after(loading);
    }

    if (status) {
        _el.find("form").hide();
        _el.find(".modal-footer").hide();
        _el.find("#loading-save").show();
    } else {
        _el.find("form").show();
        _el.find(".modal-footer").show();
        _el.find("#loading-save").hide();
    }
};

var deepCopy = function deepCopy(data) {
    return data.map(function (item) {
        return Object.assign({}, item);
    });
};

var resetText = null;

var LOADING = {
    set: function set(el) {
        resetText = el.html();
        var textLoading = el.attr('data-loading-text');
        el.html(textLoading);
        el.prop('disabled', true);
    },
    reset: function reset(el) {
        el.html(resetText);
        el.prop('disabled', false);
    }
};

var ERROR_INPUT = {
    set: function set(target, errorList) {
        $(".text-alert").remove();
        Object.keys(target).map(function (key) {
            if (errorList[key]) {
                $(target[key].el).removeClass('input-error');
                $(target[key].el).addClass('input-error');
                $(target[key].el).after("<p class=\"text-alert small\" style=\"color:red\">" + errorList[key] + "</p>");

                $(target[key].el).focus(function () {
                    $(target[key].el).removeClass('input-error');
                    $(target[key].el).next(".text-alert").remove();
                });

                setTimeout(function () {
                    $(target[key].el).removeClass('input-error');
                    $(".text-alert").remove();
                }, 6000);
            }
        });
    },
    reset: function reset(el) {
        $(el).removeClass('input-error');
        $(".text-alert").remove();
    }
};

/***/ }),

/***/ 4:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/js/ManagementUsers.js");


/***/ })

/******/ });