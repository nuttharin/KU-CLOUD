!function(t){var e={};function n(a){if(e[a])return e[a].exports;var i=e[a]={i:a,l:!1,exports:{}};return t[a].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=t,n.c=e,n.d=function(t,e,a){n.o(t,e)||Object.defineProperty(t,e,{configurable:!1,enumerable:!0,get:a})},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="http://localhost:8080/",n(n.s=11)}({"0v0P":function(t,e,n){"use strict";n.d(e,"f",function(){return i}),n.d(e,"e",function(){return r}),n.d(e,"j",function(){return o}),n.d(e,"a",function(){return l}),e.b=function(t){var e=$(t.parent).find("input, textarea, select");e.each(function(){$(this).change(function(){var n=$(this),a={},i="";e.each(function(){i=$(this).attr("name");var t=$(this).val();a[i]=""==t?null:t});var r=validate(a,t.validate)||{};console.log(n,r),c(n,r[n.attr("name")])})})},e.d=function(t){var e=$(t.parent).find("input, textarea, select"),n=!0,a={};e.each(function(){var t=$(this).attr("name"),e=$(this).val();a[t]=""==e?null:e});var i=validate(a,t.validate)||{};validate.isEmpty(i)?n=!1:(!function(t,e){var n=$(t.parent).find("input, textarea, select");console.log(e);var a=Object.keys(e);n.each(function(){var t=$(this),n=t.attr("name");a.map(function(a){a===n&&c(t,e[n])})})}(t,i),n=!0);return console.log("isError = "+n),n},e.k=function(){$("input, textarea, select").removeClass("has-success"),$("input, textarea, select").removeClass("has-error"),$(".messages-error").html("")},e.h=function(t){var e={};return function t(n,i){Array.isArray(n)?n.forEach(function(e,n){t(e,i.concat(n))}):null===n||"object"!==(void 0===n?"undefined":a(n))?e[i.join("/")]=n:Object.keys(n).forEach(function(e){t(n[e],i.concat(e))})}(t,[]),e},e.i=function(t,e){return Math.floor(Math.random()*(e-t+1))+t},e.g=function(t,e){var n=(t.getTime()-e.getTime())/1e3;return n/=3600,Math.abs(Math.round(n))},e.c=function(t){if(t.getResponseHeader("authorization")){var e=t.getResponseHeader("authorization").split(" ")[1];setCookie("token",e)}};var a="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},i=function(t){return t.map(function(t){return Object.assign({},t)})},r=function(t,e){return t=t.replace("#",""),"rgba("+parseInt(t.substring(0,2),16)+","+parseInt(t.substring(2,4),16)+","+parseInt(t.substring(4,6),16)+","+e/100+")"},o=function(){return"#"+(16777215*Math.random()<<0).toString(16)},s=null,l={set:function(t){s=t.html();var e=t.attr("data-loading-text");t.html(e),t.prop("disabled",!0)},reset:function(t){t.html(s),t.prop("disabled",!1)}};function c(t,e){validate.isEmpty(e)?(t.removeClass("has-error"),t.addClass("has-success"),t.parent().find(".messages-error").html("")):(t.removeClass("has-success"),t.addClass("has-error"),t.parent().find(".messages-error").html(e[0]))}},11:function(t,e,n){t.exports=n("m62b")},SldL:function(t,e,n){!function(t){"use strict";var e,n=Object.prototype,a=n.hasOwnProperty,i="function"==typeof Symbol?Symbol:{},r=i.iterator||"@@iterator",o=i.asyncIterator||"@@asyncIterator",s=i.toStringTag||"@@toStringTag";function l(t,e,n,a){var i=e&&e.prototype instanceof b?e:b,r=Object.create(i.prototype),o=new O(a||[]);return r._invoke=function(t,e,n){var a=d;return function(i,r){if(a===f)throw new Error("Generator is already running");if(a===m){if("throw"===i)throw r;return U()}for(n.method=i,n.arg=r;;){var o=n.delegate;if(o){var s=_(o,n);if(s){if(s===p)continue;return s}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if(a===d)throw a=m,n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);a=f;var l=c(t,e,n);if("normal"===l.type){if(a=n.done?m:u,l.arg===p)continue;return{value:l.arg,done:n.done}}"throw"===l.type&&(a=m,n.method="throw",n.arg=l.arg)}}}(t,n,o),r}function c(t,e,n){try{return{type:"normal",arg:t.call(e,n)}}catch(t){return{type:"throw",arg:t}}}t.wrap=l;var d="suspendedStart",u="suspendedYield",f="executing",m="completed",p={};function b(){}function h(){}function v(){}var g={};g[r]=function(){return this};var y=Object.getPrototypeOf,x=y&&y(y(L([])));x&&x!==n&&a.call(x,r)&&(g=x);var $=v.prototype=b.prototype=Object.create(g);function k(t){["next","throw","return"].forEach(function(e){t[e]=function(t){return this._invoke(e,t)}})}function w(t){var e;this._invoke=function(n,i){function r(){return new Promise(function(e,r){!function e(n,i,r,o){var s=c(t[n],t,i);if("throw"!==s.type){var l=s.arg,d=l.value;return d&&"object"==typeof d&&a.call(d,"__await")?Promise.resolve(d.__await).then(function(t){e("next",t,r,o)},function(t){e("throw",t,r,o)}):Promise.resolve(d).then(function(t){l.value=t,r(l)},function(t){return e("throw",t,r,o)})}o(s.arg)}(n,i,e,r)})}return e=e?e.then(r,r):r()}}function _(t,n){var a=t.iterator[n.method];if(a===e){if(n.delegate=null,"throw"===n.method){if(t.iterator.return&&(n.method="return",n.arg=e,_(t,n),"throw"===n.method))return p;n.method="throw",n.arg=new TypeError("The iterator does not provide a 'throw' method")}return p}var i=c(a,t.iterator,n.arg);if("throw"===i.type)return n.method="throw",n.arg=i.arg,n.delegate=null,p;var r=i.arg;return r?r.done?(n[t.resultName]=r.value,n.next=t.nextLoc,"return"!==n.method&&(n.method="next",n.arg=e),n.delegate=null,p):r:(n.method="throw",n.arg=new TypeError("iterator result is not an object"),n.delegate=null,p)}function j(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function E(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function O(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(j,this),this.reset(!0)}function L(t){if(t){var n=t[r];if(n)return n.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var i=-1,o=function n(){for(;++i<t.length;)if(a.call(t,i))return n.value=t[i],n.done=!1,n;return n.value=e,n.done=!0,n};return o.next=o}}return{next:U}}function U(){return{value:e,done:!0}}h.prototype=$.constructor=v,v.constructor=h,v[s]=h.displayName="GeneratorFunction",t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===h||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,v):(t.__proto__=v,s in t||(t[s]="GeneratorFunction")),t.prototype=Object.create($),t},t.awrap=function(t){return{__await:t}},k(w.prototype),w.prototype[o]=function(){return this},t.AsyncIterator=w,t.async=function(e,n,a,i){var r=new w(l(e,n,a,i));return t.isGeneratorFunction(n)?r:r.next().then(function(t){return t.done?t.value:r.next()})},k($),$[s]="Generator",$[r]=function(){return this},$.toString=function(){return"[object Generator]"},t.keys=function(t){var e=[];for(var n in t)e.push(n);return e.reverse(),function n(){for(;e.length;){var a=e.pop();if(a in t)return n.value=a,n.done=!1,n}return n.done=!0,n}},t.values=L,O.prototype={constructor:O,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=e,this.done=!1,this.delegate=null,this.method="next",this.arg=e,this.tryEntries.forEach(E),!t)for(var n in this)"t"===n.charAt(0)&&a.call(this,n)&&!isNaN(+n.slice(1))&&(this[n]=e)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var n=this;function i(a,i){return s.type="throw",s.arg=t,n.next=a,i&&(n.method="next",n.arg=e),!!i}for(var r=this.tryEntries.length-1;r>=0;--r){var o=this.tryEntries[r],s=o.completion;if("root"===o.tryLoc)return i("end");if(o.tryLoc<=this.prev){var l=a.call(o,"catchLoc"),c=a.call(o,"finallyLoc");if(l&&c){if(this.prev<o.catchLoc)return i(o.catchLoc,!0);if(this.prev<o.finallyLoc)return i(o.finallyLoc)}else if(l){if(this.prev<o.catchLoc)return i(o.catchLoc,!0)}else{if(!c)throw new Error("try statement without catch or finally");if(this.prev<o.finallyLoc)return i(o.finallyLoc)}}}},abrupt:function(t,e){for(var n=this.tryEntries.length-1;n>=0;--n){var i=this.tryEntries[n];if(i.tryLoc<=this.prev&&a.call(i,"finallyLoc")&&this.prev<i.finallyLoc){var r=i;break}}r&&("break"===t||"continue"===t)&&r.tryLoc<=e&&e<=r.finallyLoc&&(r=null);var o=r?r.completion:{};return o.type=t,o.arg=e,r?(this.method="next",this.next=r.finallyLoc,p):this.complete(o)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),p},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.finallyLoc===t)return this.complete(n.completion,n.afterLoc),E(n),p}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.tryLoc===t){var a=n.completion;if("throw"===a.type){var i=a.arg;E(n)}return i}}throw new Error("illegal catch attempt")},delegateYield:function(t,n,a){return this.delegate={iterator:L(t),resultName:n,nextLoc:a},"next"===this.method&&(this.arg=e),p}}}(t.exports)},Xxa5:function(t,e,n){t.exports=n("SldL")},m62b:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),n.d(e,"ManagementUsers",function(){return _}),e.FatoryCreateManagmentUser=function(t){(j=new _(t)).initialAndRun()};var a=n("Xxa5"),i=n.n(a),r=n("0v0P"),o=function(){function t(t,e){for(var n=0;n<e.length;n++){var a=e[n];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(t,a.key,a)}}return function(e,n,a){return n&&t(e.prototype,n),a&&t(e,a),e}}();function s(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function l(t){return function(){var e=t.apply(this,arguments);return new Promise(function(t,n){return function a(i,r){try{var o=e[i](r),s=o.value}catch(t){return void n(t)}if(!o.done)return Promise.resolve(s).then(function(t){a("next",t)},function(t){a("throw",t)});t(s)}("next")})}}var c={sProcessing:'<div class="lds-roller text-center">\n                        <div></div>\n                        <div></div>\n                        <div></div>\n                        <div></div>\n                        <div></div>\n                        <div></div>\n                        <div></div>\n                        <div></div>\n                    </div>',oPaginate:{sNext:"<i class='mdi mdi-chevron-right'></i>",sPrevious:"<i class='mdi mdi-chevron-left'></i>"}},d=null,u=null,f=null,m=null,p=null;toastr.options={closeButton:!1,debug:!1,newestOnTop:!1,progressBar:!0,positionClass:"toast-top-right",preventDuplicates:!1,onclick:null,showDuration:"300",hideDuration:"1000",timeOut:"3000",extendedTimeOut:"1000",showEasing:"swing",hideEasing:"linear",showMethod:"fadeIn",hideMethod:"fadeOut"};var b="http://localhost:8000/api/";validate.validators.presence.message="is required";var h={create:{parent:"form#form-add-user",validate:{email:{presence:!0,email:!0},username:{presence:{allowEmpty:!1},format:{pattern:"[a-zA-Z0-9]+",flags:"i",message:"can only contain a-Z and 0-9"},length:{minimum:4,message:"must be at least 6 characters"}},firstname:{presence:{allowEmpty:!1},length:{maximum:50}},lastname:{presence:{allowEmpty:!1},length:{maximum:50}},phone:{presence:{allowEmpty:!1},format:{pattern:"[0-9]+",flags:"i",message:"can only contain 0-9"},length:{minimum:10,maximum:10}}}},edit:{parent:"form#form-edit-user",validate:{email:{email:!0},firstname:{presence:{allowEmpty:!1},length:{maximum:50}},lastname:{presence:{allowEmpty:!1},length:{maximum:50}},phone:{format:{pattern:"[0-9]+",flags:"i",message:"can only contain 0-9"},length:{minimum:10,maximum:10}}}}},v=function t(e){if(s(this,t),d)return d;this.resetModal=function(){$("#add_email_val").val(""),$("#add_fname_val").val(""),$("#add_phone_val").val(""),$("#add_pwd_val").val(""),$("#add_lname_val").val("")}},g=function t(){if(s(this,t),u)return u;this.create=function(t){if(0===$("#detailUser").length){$("body").append('\n                                <div class="modal fade" id="detailUser">\n                                    <div class="modal-dialog modal-lg">\n                                        <div class="modal-content">\n                                            <div class="modal-header">\n                                                <h5 class="modal-title" id="title-user"></h5>\n                                                <button type="button" class="close" data-dismiss="modal">&times;</button>\n                                            </div>\n        \n                                            <div class="modal-body">\n                                                <h6>Name : <span  id="name-user"><span></h6>\n                                                <h6>Phone</h6>\n                                                <ul class="list-group" id="phone-user">\n                                                    \n                                                </ul>\n                                                <hr/>\n                                                <h6>Email</h6>\n                                                <ul class="list-group" id="email-user" >\n                                                    \n                                                </ul>\n                                            </div>\n        \n                                            <div class="modal-footer">\n                                                \n                                            </div>\n                                        </div>\n                                    </div>\n                                </div>\n                                  ')}$("#title-user").html(w[t].email[0].email_user),$("#name-user").html(w[t].fname+" "+w[t].lname);var e="",n=w[t].phone.map(function(t){return e="",t.is_primary&&(e='<span class="badge badge-pill badge-primary d-flex justify-content-center align-items-center">Primary</span>'),t.is_verify?e+='<span class="badge badge-pill badge-success d-flex justify-content-center align-items-center">Verify success</span>':e+='<span class="badge badge-pill badge-danger d-flex justify-content-center align-items-center">Verify not success</span>','<li class="list-group-item mt-1" style="padding:.375rem .75rem;">\n                            <div class="row">\n                                <div class="col-6">\n                                '+t.phone_user+' \n                                </div>\n                                <div class="col-6 d-flex justify-content-end">\n                                '+e+"\n                                </div>\n                            </div>\n                        </li>"});$("#phone-user").html(n.join(""));var a=w[t].email.map(function(t){return e="",t.is_primary&&(e+='<span class="badge badge-pill badge-primary d-flex justify-content-center align-items-center">Primary</span>'),t.is_verify?e+='<span class="badge badge-pill badge-success d-flex justify-content-center align-items-center">Verify success</span>':e+='<span class="badge badge-pill badge-danger d-flex justify-content-center align-items-center">Verify not success</span>','<li class="list-group-item mt-1" style="padding:.375rem .75rem;">\n                            <div class="row">\n                                <div class="col-6">\n                                '+t.email_user+' \n                                </div>\n                                <div class="col-6 d-flex justify-content-end">\n                                '+e+"\n                                </div>\n                            </div>\n                        </li>"});$("#email-user").html(a.join("")),$("#detailUser").modal("show")}},y=function t(e){s(this,t);var n=0,a=0;if(f)return f;this.create=function(t){if(0===$("#editUser").length){$("body").append('\n                <div class="modal fade" id="editUser">\n                    <div class="modal-dialog modal-lg">\n                        <div class="modal-content">\n                            <div class="modal-header">\n                                <h4 class="modal-title">Edit User Company</h4>\n                                <button type="button" class="close" data-dismiss="modal">&times;</button>\n                            </div>\n\n                            <div class="modal-body">\n                                <form id="form-edit-user">\n                                    <div class="row">\n                                        <div class="col-6">\n                                            <label>Firstname <span class="text-danger">*</span></label>\n                                            <input type="text" name="firstname" id="edit-fname" class="form-control"/>\n                                            <button class="btn btn-primary btn-sm btn-radius mt-2" id="btn-add-email"><i class="fas fa-plus"></i> add email</button>\n                                            <div id="input-add-email">\n                                            </div>\n                                        </div>\n                                        <div class="col-6">\n                                            <label>Lastname <span class="text-danger">*</span></label>\n                                            <input type="text" name="lastname" id="edit-lname" class="form-control"/>\n                                            <button class="btn btn-primary btn-sm btn-radius mt-2" id="btn-add-phone"><i class="fas fa-plus"></i> add phone</button>\n                                            <div id="input-add-phone">\n                                            </div>\n                                        </div>\n                                    </div>\n                                </form>\n                            </div>\n\n                            <div class="modal-footer">\n                                <button type="button" id="btn-edit-submit" class="btn btn-success btn-block btn-submit-edit" data-loading-text="<i class=\'fas fa-circle-notch fa-spin\'></i> Saving . . .">Save</button>\n                            </div>\n                        </div>\n                    </div>\n                </div>'),Object(r.b)(h.edit)}n=0,a=0,$("#btn-edit-submit").unbind().click(function(){l(t)});var e=w[t].phone;n=e.length;var s=null;s=e.map(function(t,e){return t.is_primary?'<li class="list-group-item mt-1" style="padding:.375rem .75rem;">\n                                <div class="row">\n                                    <div class="col-6">\n                                    '+t.phone_user+' \n                                    </div>\n                                    <div class="col-6 d-flex justify-content-end">\n                                        <span class="badge badge-pill badge-primary d-flex justify-content-center align-items-center">Primary</span>\n                                    </div>\n                                </div>\n                            </li>':'<li class="list-group-item mt-1" id="phone-'+t.phone_user+'" style="padding:.375rem .75rem;">\n                            <div class="row">\n                                <div class="col-6">\n                                '+t.phone_user+' \n                                </div>\n                                <div class="col-6 d-flex justify-content-end">\n                                    <div class="form-submit-delete-phone" style="display:none">\n                                        <button type="button" class="btn btn-success btn-sm btn-radius btn-submit-delete-phone" phone="'+t.phone_user+'">\n                                            <i class="fas fa-check"></i>\n                                        </button>\n                                        <button type="button" class="btn btn-danger btn-sm btn-radius btn-cancel-delete-phone">\n                                            <i class="fas fa-times"></i>\n                                        </button>\n                                    </div>\n                                    <i class="far fa-trash-alt btn-confirm-delete-phone" style="color:#e65251;cursor:pointer"></i>\n                                </div>\n                            </div>\n                        </li>'});var c=w[t].email;a=c.length;var d=null;d=c.map(function(t,e){return t.is_primary?'<li class="list-group-item mt-1"  style="padding:.375rem .75rem;">\n                                <div class="row">\n                                    <div class="col-6">\n                                    '+t.email_user+' \n                                    </div>\n                                    <div class="col-6 d-flex justify-content-end">\n                                        <span class="badge badge-pill badge-primary d-flex justify-content-center align-items-center">Primary</span>\n                                    </div>\n                                </div>\n                            </li>':'<li class="list-group-item mt-1" id="email-'+e+'" style="padding:.375rem .75rem;">\n                            <div class="row">\n                                <div class="col-6">\n                                '+t.email_user+' \n                                </div>\n                                <div class="col-6 d-flex justify-content-end">\n                                    <div class="form-submit-delete-email" style="display:none">\n                                        <button type="button" class="btn btn-success btn-sm btn-radius btn-submit-delete-email" email="'+t.email_user+'" item="email-'+e+'">\n                                            <i class="fas fa-check"></i>\n                                        </button>\n                                        <button type="button" class="btn btn-danger btn-sm btn-radius btn-cancel-delete-email">\n                                            <i class="fas fa-times"></i>\n                                        </button>\n                                    </div>\n                                    <i class="far fa-trash-alt btn-confirm-delete-email" style="color:#e65251;cursor:pointer"></i>\n                                </div>\n                            </div>\n                        </li>'}),$("#btn-add-phone").unbind().click(function(){event.preventDefault();var t=' \n                    <div class="input-group">\n                        <input type="text" name="phone" class="add_phone_val form-control mt-1" value={phone}  disabled>\n                        <div class="input-group-append">\n                            <button class="btn btn-danger mt-1 btn-delete-phone" type="button"><i class="fas fa-times"></i></button>  \n                        </div>\n                    </div>'.replace("disabled","");t=t.replace("{phone}",""),n<=2&&(n++,$("#input-add-phone").append(t)),Object(r.b)(h.edit)}),$("#btn-add-email").unbind().click(function(){event.preventDefault();var t='\n                    <div class="input-group">\n                        <input type="text" name="email" class="add_email_val form-control mt-1" value={email}  disabled>\n                            <div class="input-group-append">\n                                <button class="btn btn-danger mt-1 btn-delete-email" type="button"><i class="fas fa-times"></i></button>  \n                            </div>\n                    </div>\n                    '.replace("disabled","");t=t.replace("{email}",""),a<=2&&(a++,$("#input-add-email").append(t)),Object(r.b)(h.edit)}),$("body").unbind().on("click",".btn-delete-email ,.btn-delete-phone",function(){$(this).hasClass("btn-delete-email")?--a:$(this).hasClass("btn-delete-phone")&&--n,$(this).parent().parent().remove()}),$("#edit-fname").val(w[t].fname),$("#edit-lname").val(w[t].lname),$("#input-add-phone").html(s.join("")),$("#input-add-email").html(d.join("")),$("#editUser").modal("show"),Object(r.k)(),$(".btn-confirm-delete-email").unbind().click(function(){$(this).hide(),$(this).parent().find(".form-submit-delete-email").show()}),$(".btn-cancel-delete-email").unbind().click(function(){$(this).parent().hide(),$(this).parent().parent().find(".btn-confirm-delete-email").show()}),$(".btn-submit-delete-email").unbind().click(function(){i($(this).attr("email"),$(this).attr("item"))}),$(".btn-confirm-delete-phone").unbind().click(function(){$(this).hide(),$(this).parent().find(".form-submit-delete-phone").show()}),$(".btn-cancel-delete-phone").unbind().click(function(){$(this).parent().hide(),$(this).parent().parent().find(".btn-confirm-delete-phone").show()}),$(".btn-submit-delete-phone").unbind().click(function(){o($(this).attr("phone"))})};var i=function(t,e){$.ajax({url:b+"company/users/email",method:"DELETE",headers:{authorization:"bearer "+getCookie("token")},data:{email_user:t},success:function(t,n,a){Object(r.c)(a),$("#"+e).remove(),_.refreshData()},error:function(t){console.log(t)}})},o=function(t){$.ajax({url:b+"company/users/phone",method:"DELETE",headers:{authorization:"bearer "+getCookie("token")},data:{phone_user:t},success:function(e,n,a){Object(r.c)(a),$("#phone-"+t).remove(),_.refreshData()},error:function(t){console.log(t)}})},l=function(t){if(!Object(r.d)(h.edit)){r.a.set($("#btn-edit-submit"));var n=$("#edit-fname").val(),a=$("#edit-lname").val(),i=$(".add_phone_val:enabled").map(function(){if(""!=$(this).val().replace(" ",""))return $(this).val()}).get(),o=$(".add_email_val:enabled").map(function(){if(""!=$(this).val().replace(" ",""))return $(this).val()}).get();$.ajax({url:b+e.edit,method:"PUT",headers:{authorization:"bearer "+getCookie("token")},data:{user_id:w[t].user_id,fname:n,lname:a,phone_user:i,email_user:o},success:function(t,e,n){Object(r.c)(n),toastr.success("Success"),r.a.reset($("#btn-edit-submit")),$("#editUser").modal("hide"),_.refreshData()},error:function(t){r.a.reset($("#btn-edit-submit")),console.log(t)}})}}},x=function t(e){if(s(this,t),m)return m;this.create=function(t){if(0===$("#BlockUser").length){$("body").append('\n                <div class="modal fade" id="BlockUser">\n                    <div class="modal-dialog modal-lg">\n                        <div class="modal-content">\n                            <div class="modal-header">\n                                <h4 class="modal-title" id="title-block">Block </h4>\n                                <button type="button" class="close" data-dismiss="modal">&times;</button>\n                            </div>\n\n                            <div class="modal-body">\n                                <form id="form-block-user">\n                                    <h6 id="span-text-confirm-block"></h6>\n                                </form>\n                            </div>\n\n                            <div class="modal-footer" id="btn-toggle-active-footer">\n                                \n                            </div>\n                        </div>\n                    </div>\n                </div>')}var e=w[t].block?"unblock":"block";$("#title-block").html(e+" User"),w[t].block?$("#btn-toggle-active-footer").html('<button type="button" id="btn-toggle-active-submit" class="btn btn-info btn-block" data-loading-text="<i class=\'fas fa-circle-notch fa-spin\'></i> Saving . . .">UnBlock</button>'):$("#btn-toggle-active-footer").html('<button type="button" id="btn-toggle-active-submit" class="btn btn-danger btn-block" data-loading-text="<i class=\'fas fa-circle-notch fa-spin\'></i> Saving . . .">Block</button>'),$("#btn-toggle-active-submit").unbind().click(function(){n(t)}),$("#span-text-confirm-block").html("Are you sure to "+e+" this account name : "+w[t].fname+" "+w[t].lname+" ?"),$("#BlockUser").modal("show")};var n=function(t){r.a.set($("#btn-toggle-active-submit")),$.ajax({url:b+e.block,method:"put",headers:{authorization:"bearer "+getCookie("token")},data:{user_id:w[t].user_id,block:w[t].block?0:1},success:function(t,e,n){Object(r.c)(n),toastr.success("Success"),$("#BlockUser").modal("hide"),r.a.reset($("#btn-toggle-active-submit")),_.refreshData()},error:function(t){r.a.reset($("#btn-toggle-active-submit")),console.log(t)}})}},k=function t(e){if(s(this,t),p)return p;this.create=function(t){if(0===$("#DeleteUser").length){$("body").append('<div class="modal fade" id="DeleteUser">\n                                <div class="modal-dialog modal-lg">\n                                    <div class="modal-content">\n                                        <div class="modal-header">\n                                            <h4 class="modal-title">Delete User Company</h4>\n                                            <button type="button" class="close" data-dismiss="modal">&times;</button>\n                                        </div>\n    \n                                        <div class="modal-body">\n                                            <form id="form-delete-user">\n                                                <h6 id="span-text-confirm"></h6>\n                                            </form>\n                                        </div>\n    \n                                        <div class="modal-footer">\n                                            <button type="button" id="btn-delete-submit" class="btn btn-danger btn-block" data-loading-text="<i class=\'fas fa-circle-notch fa-spin\'></i> Saving . . .">Delete</button>\n                                        </div>\n                                    </div>\n                                </div>\n                            </div>')}$("#span-text-confirm").html("Are you sure to delete this account name : "+w[t].email[0].email_user+" ? "),$("#DeleteUser").modal("show")}},w=[],_=function(){function t(e){var n=this;s(this,t),this.config={getUsers:e.getUsers,getOnlineUsers:e.OnlineUsers,create:e.create,edit:e.edit,block:e.block,unblock:e.unblock,delete:e.delete,type:e.type};var a,o,_,j=null,E=null,O=function(t){t?($(".dataTables_wrapper").hide(),$("#example").hide(),$("#loading").show(),$("#card_table").height("100px")):($("#card_table").height("auto"),$(".dataTables_wrapper").show(),$("#loading").hide(),$(".text-loading").hide(),$("#example").show(),$(".text-static").show())},L=(a=l(i.a.mark(function t(){var n;return i.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return null!=j?(n=j.page.info().page,j.ajax.reload(),j.page(n).draw("page")):(j=$("#example").on("xhr.dt",function(t,e,n,a){Object(r.c)(a)}).DataTable({processing:!0,serverSide:!0,destroy:!0,responsive:!0,language:c,ajax:{url:b+e.getUsers,headers:{authorization:"bearer "+getCookie("token")},dataSrc:function(t){return w=t.data,t.data}},columns:[{mRender:function(t,e,n){return n.fname+" "+n.lname}},{mRender:function(t,e,n){return n.phone[0].phone_user}},{mRender:function(t,e,n){return n.email[0].email_user}},{mData:"block",mRender:function(t,e,n){return t?'<b class="text-danger">Block</b>':"Unblock"}},{data:"sub_type_user"},{mData:"online",mRender:function(t,e,n){return t?'<b class="text-success">online <i class="fas fa-circle text-success fa-xs"></i></b>':'<span class="text-secondary">offline <i class="fas fa-circle text-secondary fa-xs"></i></span>'}},{mRender:function(t,e,n,a){var i='                            \n                            <button type="button" class="btn btn-secondary btn-sm btn-block-user" index='+a.row+' data-toggle="tooltip" data-placement="top" title="Block">\n                                <i class="fas fa-times"></i>\n                            </button>';return n.block&&(i='                            \n                                <button type="button" class="btn btn-secondary btn-sm btn-block-user" index='+a.row+' data-toggle="tooltip" data-placement="top" title="UnBlock">\n                                    <i class="fas fa-unlock"></i>\n                                </button>'),'<center>\n                                            <button type="button" class="btn btn-primary btn-sm btn-detail" index='+a.row+' data-toggle="tooltip"\n                                                data-placement="top" title="Detail">\n                                                <i class="fas fa-list"></i>\n                                            </button>\n                                            <button type="button" class="btn btn-success btn-sm btn-edit" index='+a.row+'  data-toggle="tooltip"\n                                                data-placement="top" title="Edit">\n                                                <i class="fas fa-edit"></i>\n                                            </button>\n                                            '+i+'\n                                            <button type="button" class="btn btn-danger btn-sm btn-delete"  index='+a.row+'  data-toggle="tooltip"\n                                                data-placement="top" title="Delete">\n                                                <i class="fas fa-trash-alt"></i>\n                                            </button>\n                                        </center>'},orderable:!1}]}),$("#example").tooltip({selector:'[data-toggle="tooltip"]'})),t.abrupt("return");case 2:case"end":return t.stop()}},t,this)})),function(){return a.apply(this,arguments)}),U=(o=l(i.a.mark(function t(){var n;return i.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return null!=j?(n=j.page.info().page,j.ajax.reload(),j.page(n).draw("page")):(j=$("#example").on("xhr.dt",function(t,e,n,a){Object(r.c)(a)}).DataTable({processing:!0,serverSide:!0,destroy:!0,responsive:!0,language:c,ajax:{url:b+e.getUsers,headers:{authorization:"bearer "+getCookie("token")},dataSrc:function(t){return w=t.data,t.data}},columns:[{mRender:function(t,e,n){return n.fname+" "+n.lname}},{mRender:function(t,e,n){return n.phone[0].phone_user}},{mRender:function(t,e,n){return n.email[0].email_user}},{mData:"block",mRender:function(t,e,n){return t?'<b class="text-danger">Block</b>':"Unblock"}},{mData:"online",mRender:function(t,e,n){return t?'<b class="text-success">online <i class="fas fa-circle text-success fa-xs"></i></b>':'<span class="text-secondary">offline <i class="fas fa-circle text-secondary fa-xs"></i></span>'}},{mRender:function(t,e,n,a){var i='                            \n                            <button type="button" class="btn btn-secondary btn-sm btn-block-user" index='+a.row+' data-toggle="tooltip" data-placement="top" title="Block">\n                                <i class="fas fa-times"></i>\n                            </button>';return n.block&&(i='                            \n                                <button type="button" class="btn btn-secondary btn-sm btn-block-user" index='+a.row+' data-toggle="tooltip" data-placement="top" title="UnBlock">\n                                    <i class="fas fa-unlock"></i>\n                                </button>'),'<center>\n                                            <button type="button" class="btn btn-primary btn-sm btn-detail" index='+a.row+' data-toggle="tooltip"\n                                                data-placement="top" title="Detail">\n                                                <i class="fas fa-list"></i>\n                                            </button>\n                                            <button type="button" class="btn btn-success btn-sm btn-edit" index='+a.row+'  data-toggle="tooltip"\n                                                data-placement="top" title="Edit">\n                                                <i class="fas fa-edit"></i>\n                                            </button>\n                                            '+i+'\n                                            <button type="button" class="btn btn-danger btn-sm btn-delete"  index='+a.row+'  data-toggle="tooltip"\n                                                data-placement="top" title="Delete">\n                                                <i class="fas fa-trash-alt"></i>\n                                            </button>\n                                        </center>'},orderable:!1}]}),$("#example").tooltip({selector:'[data-toggle="tooltip"]'})),t.abrupt("return");case 2:case"end":return t.stop()}},t,this)})),function(){return o.apply(this,arguments)}),C=(_=l(i.a.mark(function t(){return i.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if("COMPANY"!==e.type){t.next=5;break}return t.next=3,L();case 3:t.next=8;break;case 5:if("CUSTOMER"!==e.type){t.next=8;break}return t.next=8,U();case 8:$("#example").on("click",".btn-detail",function(){var t;t=$(this).attr("index"),(u=new g).create(t)}),$("#example").on("click",".btn-edit",function(){var t;t=$(this).attr("index"),(f=new y(e)).create(t)}),$("#example").on("click",".btn-block-user",function(){var t;t=$(this).attr("index"),(m=new x(e)).create(t)}),$("#example").on("click",".btn-unblock-user",function(){onUnBlockClick($(this).attr("index"))}),$("#example").on("click",".btn-delete",function(){var t;t=$(this).attr("index"),(p=new k(e)).create(t)});case 13:case"end":return t.stop()}},t,this)})),function(){return _.apply(this,arguments)}),D=function(){$.ajax({url:b+e.getAllEmailCustomer,method:"GET",headers:{authorization:"bearer "+getCookie("token")},success:function(t,e,n){Object(r.c)(n),(E=$("#input_bind_email")).empty(),E.data("fastselect")&&E.data("fastselect").destroy(),t.data.map(function(t){E.append('<option value="'+t.user_id+'">'+t.email_user+"</option>")}),E.fastselect()},error:function(t){}})};this.initialAndRun=function(){O(!0),n.showLastestDatatable(),$("#btn-add-user").unbind().click(function(){Object(r.k)(),(d=new v(e)).resetModal(),$("#addUser").modal("show")}),$("#btn-save-add-user").unbind().click(function(){!function(t){if(!Object(r.d)(h.create)){r.a.set(t);var a=$("#add_username").val(),i=$("#add_email_val").val(),o=$("#add_fname_val").val(),s=$("#add_lname_val").val(),l=$("#add_phone_val").val(),c=null;"COMPANY"===e.type&&(c=$("#add_type_user_val").val()),$.ajax({url:b+e.create,dataType:"json",method:"POST",headers:{authorization:"bearer "+getCookie("token")},data:{username:a,email:i,fname:o,lname:s,phone:l,sub_type_user:c},success:function(e,a,i){Object(r.c)(i),console.log(e),toastr.success("Success"),n.showLastestDatatable(),r.a.reset(t),$("#addUser").modal("hide")},error:function(e){console.log(e),r.a.reset(t)}})}}($(this))}),"CUSTOMER"===e.type&&($("#btn_bind_user").unbind().click(function(){$("#bindUser").modal("show")}),$("#btn_save_bind_user").unbind().click(function(){r.a.set($("#btn_save_bind_user")),$.ajax({url:b+e.addCustomerInCompany,method:"POST",headers:{authorization:"bearer "+getCookie("token")},data:{userList:E.val()},success:function(t,e,a){Object(r.c)(a),$("#bindUser").modal("hide"),D(),r.a.reset($("#btn_save_bind_user")),n.showLastestDatatable()},error:function(t){console.log(t)}})}),D()),Object(r.b)(h.create)},this.showLastestDatatable=l(i.a.mark(function t(){return i.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,C();case 2:return t.next=4,$.ajax({url:b+e.getOnlineUsers,method:"GET",headers:{authorization:"bearer "+getCookie("token")},data:{type_user:e.type},success:function(t,e,n){Object(r.c)(n);var a=0;for(var i in t.users)a+=Number(t.users[i].count),"online"===t.users[i].online?$("#total-user-online").html(t.users[i].count+" user"):$("#total-user-offline").html(t.users[i].count+" user");$("#total-user").html(a+" user")},error:function(t){console.log(t)}});case 4:O(!1);case 5:case"end":return t.stop()}},t,this)}))}return o(t,null,[{key:"refreshData",value:function(){return j.showLastestDatatable()}}]),t}(),j=null}});