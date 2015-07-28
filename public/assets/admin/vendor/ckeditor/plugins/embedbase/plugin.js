/*
 Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
*/
(function(){CKEDITOR.plugins.add("embedbase",{lang:"en",requires:"widget,notificationaggregator",onLoad:function(){CKEDITOR._.jsonpCallbacks={}},init:function(){CKEDITOR.dialog.add("embedBase",this.path+"dialogs/embedbase.js")}});var j={_attachScript:function(d,c){var e=new CKEDITOR.dom.element("script");e.setAttribute("src",d);e.on("error",c);CKEDITOR.document.getBody().append(e);return e},sendRequest:function(d,c,e,a){function b(){g&&(g.remove(),delete CKEDITOR._.jsonpCallbacks[h],g=null)}var i=
{},c=c||{},h=CKEDITOR.tools.getNextNumber(),g;c.callback="CKEDITOR._.jsonpCallbacks["+h+"]";CKEDITOR._.jsonpCallbacks[h]=function(a){setTimeout(function(){b();e(a)})};g=this._attachScript(d.output(c),function(){b();a&&a()});i.cancel=b;return i}};CKEDITOR.plugins.embedBase={createWidgetBaseDefinition:function(d){var c,e=d.lang.embedbase;return{mask:!0,template:"<div></div>",pathName:e.pathName,_cache:{},urlRegExp:/^((https?:)?\/\/|www\.)/i,init:function(){this.on("sendRequest",function(a){this._sendRequest(a.data)},
this,null,999);this.on("dialog",function(a){a.data.widget=this},this);this.on("handleResponse",function(a){if(!a.data.html){var b=this._responseToHtml(a.data.url,a.data.response);null!==b?a.data.html=b:(a.data.errorMessage="unsupportedUrl",a.cancel())}},this,null,999)},loadContent:function(a,b){function c(d){f.response=d;e._handleResponse(f)&&(e._cacheResponse(a,d),b.callback&&b.callback())}var b=b||{},e=this,d=this._getCachedResponse(a),f={url:a,callback:c,errorCallback:function(a){e._handleError(f,
a);b.errorCallback&&b.errorCallback(a)}};if(d)setTimeout(function(){c(d)});else return b.noNotifications||(f.task=this._createTask()),this.fire("sendRequest",f),f},isUrlValid:function(a){return this.urlRegExp.test(a)&&!1!==this.fire("validateUrl",a)},getErrorMessage:function(a,b,c){(c=d.lang.embedbase[a+(c||"")])||(c=a);return(new CKEDITOR.template(c)).output({url:b||""})},_sendRequest:function(a){var b=this,c=j.sendRequest(this.providerUrl,{url:encodeURIComponent(a.url)},a.callback,function(){a.errorCallback("fetchingFailed")});
a.cancel=function(){c.cancel();b.fire("requestCanceled",a)}},_handleResponse:function(a){a.task&&a.task.done();var b={url:a.url,html:"",response:a.response};if(!1!==this.fire("handleResponse",b))return this._setContent(a.url,b.html),!0;a.errorCallback(b.errorMessage);return!1},_handleError:function(a,b){a.task&&(a.task.cancel(),d.showNotification(this.getErrorMessage(b,a.url),"warning"))},_responseToHtml:function(a,b){return"photo"==b.type?'<img src="'+CKEDITOR.tools.htmlEncodeAttr(b.url)+'" alt="'+
CKEDITOR.tools.htmlEncodeAttr(b.title||"")+'" style="max-width:100%;height:auto" />':"video"==b.type||"rich"==b.type?b.html:null},_setContent:function(a,b){this.setData("url",a);this.element.setHtml(b)},_createTask:function(){if(!c||c.isFinished())c=new CKEDITOR.plugins.notificationAggregator(d,e.fetchingMany,e.fetchingOne),c.on("finished",function(){c.notification.hide()});return c.createTask()},_cacheResponse:function(a,b){this._cache[a]=b},_getCachedResponse:function(a){return this._cache[a]}}},
_jsonp:j}})();