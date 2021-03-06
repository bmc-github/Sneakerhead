try {

var PickPoint = PickPoint || new function () {
    /*
     * CDMPickpointProtocol Class
     */
    var CDMPickpointProtocol = {

        PICKPOINT_PROTOCOL_MARK :"@PPP_RU_WGT20@",

        /**
         *
         * @param {string} rawdata
         * @returns {object}
         */
        parse : function (rawdata){
            /*
             * Message Format:
             * <PICKPOINT_PROTOCOL_MARK><ActionName>
             * or
             * <PICKPOINT_PROTOCOL_MARK><ActionName>;<JSONData>
             */
            var part = rawdata.substr(CDMPickpointProtocol.PICKPOINT_PROTOCOL_MARK.length);
            var data_offset = part.indexOf(";");
            var data = null;

            if ( data_offset< 0) {
                action = part;
            } else {
                action = part.substr(0,data_offset);
                data = JSON.parse( part.substr(data_offset+1) );
            }

            return {
                action:action,
                data:data
            }
        },

        /**
         *
         * @param {string} action
         * @param {object} data
         * @returns {string}
         */
        build : function (action,data){
            var text = CDMPickpointProtocol.PICKPOINT_PROTOCOL_MARK;
            text += action.toString();
            if (data) {
                text += ";"+JSON.stringify(data);
            }
            return text;
        },

        isMessage : function( possible_msg ){
            return possible_msg.toString().indexOf(CDMPickpointProtocol.PICKPOINT_PROTOCOL_MARK) == 0;
        }
    }

    /*
     * Log text or object in console
     * @param {type} text
     * @returns {void}
     */
    this.log = function (text) {
	if (console)
	    console.log(text);
        else
            alert(text);
    }

    /*
     * Local Environment
     */
    var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
    var eventer = window[eventMethod];
    var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

    /*
     * Local Variables
     */
    var self = this;
    var container = null;
    var initial_container = null;
    var iframe = null;
    var iframe_site_mode = false;
    var backgroundshade = null;
    var loadLevel = 0;
    var _callback = null;
    var firstload = true;
    var siteShowFlag = false;
    var c_height = 690;
    var c_workwidth = 1175;
    var inner_width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    var c_width = parseInt(inner_width,10) > c_workwidth ? c_workwidth : inner_width - 50;
    var c_zIndex = 9999999;

    var storedparams = {};
    var ScriptPath = "";
    var ScriptSource = "";

    /**
     * _fireLoadLevel
     * @returns {void}
     */
    this._fireLoadLevel = function () {
	// Count loaded major elements
        eventer(messageEvent, self._onmessage, false);
        // Send options to server
        self._sendrawmsg(CDMPickpointProtocol.build('init', {
            ref: window.location,
            params: storedparams
        }));
    }

    /**
     * getBrowserVersion
     * @returns {array}
     */
    this.getBrowserVersion = function () {
	var ua = navigator.userAgent.toLowerCase(),
		rwebkit = /(webkit)[ \/]([\w.]+)/,
		ropera = /(opera)(?:.*version)?[ \/]([\w.]+)/,
		rmsie = /(msie) ([\w.]+)/,
		rmozilla = /(mozilla)(?:.*? rv:([\w.]+))?/;

	var match = rwebkit.exec(ua) ||
		ropera.exec(ua) ||
		rmsie.exec(ua) ||
		ua.indexOf("compatible") < 0 && rmozilla.exec(ua) || [];

	return {
	    browser: match[1] || "",
	    version: match[2].match(/^([\d]+).*$/)[1] || "0"
	};
    };


    /**
     * _onmessage event
     * @returns {void}
     */
    this._onmessage = function (e) {
	if (e.origin.indexOf("pickpoint.ru") < 0)
	    return;
	var data = e[e.message ? "message" : "data"];
	if (CDMPickpointProtocol.isMessage(data)) {
	    var m = CDMPickpointProtocol.parse(data);
	    switch (m.action) {
		case "frameresize":
		    c_height = m.data.h;
		    container.style.height = c_height + "px";
		    break;
		case "close":
		    self.close();
		    break;
		case "select":
		    if (_callback && typeof _callback == "function") {
			_callback(m.data);
                        if (iframe) { iframe.blur() };
                    } else
			self.log("callback function definition is wrong");

                    if (!iframe_site_mode) self.close();

		    break;
	    }
	}
    }


    /**
     * Send Cross Domain Message To IFrame
     * @param {object} data
     * @returns {void}
     */
    this._sendrawmsg = function (data) {
	iframe.contentWindow.postMessage(data, ScriptPath);
    }


    /**
     * Close widget
     * @returns {void}
     */
    this.close = function () {
	backgroundshade.style.display = "none";
	container.style.display = "none";
    }


    /**
     * Force load for fast access
     * @returns {void}
     */
    this.preload = function (params) {
	//if (firstload) {
	var query = "";
	iframe.src = "about:blank";
	storedparams = {
	    sitemode: false
	};

	if (params) {

	    //
	    // LEGACY SUPPORT

	    if (params.flags1)
		for (var i = params.flags1.length; i--; )
		    params.flags1[i] = parseInt(params.flags1[i]);
	    if (params.flags2)
		for (var i = params.flags2.length; i--; )
		    params.flags2[i] = parseInt(params.flags2[i]);
	    if (params.flags3)
		for (var i = params.flags3.length; i--; )
		    params.flags3[i] = parseInt(params.flags3[i]);
	    //

	    if (params.flags3 && params.flags3.indexOf(111) >= 0) {
		query += "&qiwi=1";
            }
	    if (params.flags3 && params.flags3.indexOf(102) >= 0)
		storedparams.excludemode = true;
	    if (params.city && typeof params.city == "string")
		storedparams.city = params.city;
	    if (params.fromcity && typeof params.fromcity == "string")
		storedparams.fromcity = params.fromcity;
	    if (params.mode)
		storedparams.pointmode = params.mode;

	    if (params.flags1 || params.flags2 || params.flags3) {
		storedparams.onlycats = [];
                if (params.flags1)
                    storedparams.onlycats = storedparams.onlycats.concat(params.flags1);
                if (params.flags2)
                    storedparams.onlycats = storedparams.onlycats.concat(params.flags2);
                if (params.flags3)
                    storedparams.onlycats = storedparams.onlycats.concat(params.flags3);
	    }

	    if (params.cities)
		storedparams.limitcities = params.cities;
	    if (params.numbers)
		storedparams.limitnumbers = params.numbers;
	    if (params.snumbers)
		storedparams.showspecialnumbers = params.snumbers;
	    if (params.postamat_name)
		storedparams.postamat_name = params.postamat_name;
	    if (params.wfilters)
		storedparams.widget_visible_filters = params.wfilters;
            if (params.inpost)
		storedparams.inpost = params.inpost;

	    if (params.hideCloseButton){
		storedparams.hideCloseButton = params.hideCloseButton;
	    }

            if (params.theme){
                storedparams.theme = params.theme;
                switch(storedparams.theme.type){
                    case "simple":
                            if (storedparams.theme.bgcolor !== undefined){
                                container.style.backgroundColor = storedparams.theme.bgcolor;
                                query += "&bgcolor="+escape(storedparams.theme.bgcolor);
                            }
                        break;
                }
            }

            if (params.returningWidgetDesciption){
                storedparams.returningWidgetDesciption = params.returningWidgetDesciption;
            }

            if (params.noselect){
                storedparams.noselect = params.noselect;
            }

            if (params.ikn)
		query += "&ikn="+params.ikn;

            if (params.noheader)
		query += "&noheader=1";
	}

	if (siteShowFlag) {
	    query += "&site=1";
	    storedparams.sitemode = true;
	}

	iframe.src = ScriptPath + "?" + query;
	firstload = false;
	//}
    }


    /**
     * Open widget
     * @param {function} callback
     * @param {object} params
     * @returns {boolean}
     */
    this.open = function (callback, params) {
        try {

            if (params && params.iframe) {
				self.log("Pickpoint widget in local Iframe mode");
                if (iframe.parentNode  == container) container.removeChild(iframe);
                var nc = document.getElementById(params.iframe);
                if (!nc) {
                    alert("Target iframe container not found: \""+params.iframe+"\"");
                    return false;
                }

                if (!params) params = {};
                params.hideCloseButton = true;
                iframe_site_mode = true;

                container = nc;
                nc.appendChild(iframe);
                if (container.style.height) {
					nc.style.height = container.style.height;
				}
            } else {
				backgroundshade.style.display = "block";
				container.style.display = "block";
			}

            self.preload(params);

            if (!callback)
                return alert("No callback!");
            _callback = callback;
            var bv = self.getBrowserVersion();
            if (bv.browser == 'msie' && bv.version < 9) {
                alert("Unsupported version of MSIE.");
                if (console && console.warning)
                    console.warning("Unsupported version of browser");
            }
            if (params && params.zIndex) {
                backgroundshade.style.zIndex = params.zIndex;
                container.style.zIndex = params.zIndex + 1;
            }



            self.resize();
        } catch (err) {
            self.log(err);
        }
    };


    /**
     * Force load for fast access
     * @returns {void}
     */
    this.siteShow = function (container_id, params) {
		var nc = document.getElementById(container_id);
		container.removeChild(iframe);
		nc.appendChild(iframe);
		nc.style.height = container.style.height;
		container = nc;
		siteShowFlag = true;
		this.preload(params);
    }

    this.siteShowWithCallback = function (container_id, callback, params) {
	var nc = document.getElementById(container_id);
	if (!callback)
	    return alert("No callback!");
	_callback = callback;
	if (!params) params = {}
	params.hideCloseButton = true;
	container.removeChild(iframe)
	nc.appendChild(iframe);
	nc.style.height = container.style.height;
        container = nc;
	this.preload(params);
    }


    /**
     * Initialize CSS and create IFrame
     * @returns {void}
     */
    this._init = function () {
	self.log("PickPoint Widget Init...");
	backgroundshade = document.createElement('div');
	with (backgroundshade.style) {
	    background = "#aaa";
	    opacity = "0.5";
	    position = "fixed";
	    left = "0px";
	    top = "0px";
	    bottom = "0px";
	    right = "0px";
	    display = "none";
	    zIndex = c_zIndex;
	}
	backgroundshade.onclick = function () {
	    self.close();
	}

	document.body.appendChild(backgroundshade);

	container = document.createElement('div');
        initial_container = container;
	with (container.style) {
	    height = c_height + "px";
	    width = c_width + "px";
	    position = "absolute";
	    backgroundColor = "#fff";
	    border = "1px solid #222";
	    borderRadius = "10px";
	    display = "none";
	    zIndex = parseInt(backgroundshade.style.zIndex) + 1;
	    boxSizing = "content-box";
	}
	document.body.appendChild(container);



	iframe = document.createElement('iframe');
	with (iframe.style) {
	    borderRadius = container.style.borderRadius;
	    border = "0px";
	    borderCollapse = "collapse";
	    width = "100%";
	    height = "100%";
	    overflow = "hidden";
	}
	container.appendChild(iframe);
	iframe.onload = function () {
            if (iframe.src!="" && iframe.src!="about:blank") {
                self._fireLoadLevel();
            }
	};

	if (window.addEventListener)
	    window.addEventListener("resize", self.resize);


    };


    /**
     * Check for DOM Ready state
     * @returns {bool}
     */
    this.isDOMReady = function () {
	if (document && document.body && document.readyState) {
	    return document.readyState === "complete" || document.readyState === "interactive";
	} else
	    return false;
    }

    this.reqestIframeHeight = function (){
        self._sendrawmsg(CDMPickpointProtocol.build('reqestIframeHeight'));
    }

    /**
     * Recalculate widget position due window resize
     * @returns {void}
     */
    this.resize = function () {


	var inner_width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth
	c_width = inner_width> c_workwidth ? c_workwidth : inner_width - (iframe_site_mode?20:50);

	container.style.width = "100%";
	container.style.maxWidth = c_width + "px";

	var w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

	var h = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

	var doc = document.documentElement;
	var scrollleft = (window.pageXOffset || doc.scrollLeft) - (doc.clientLeft || 0);
	var scrolltop = (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0);

	var left = Math.max(0, (w - c_width) / 2) + scrollleft;
	var top = Math.max(0, (h - c_height) / 2) + scrolltop;

	if (left < 0)
	    left = 0;
	if (top < 0)
	    top = 0;

        if (!iframe_site_mode) {
            container.style.left = left + "px";
            container.style.top = top + "px";
        }

    }


    /**
     * Run code when DOM ready, or use force to run code when body is accessible
     * @returns {void}
     */
    this.ready = function (callback, force) {
	if (this.isDOMReady()) {
	    callback();
	} else if (force && document.body) {
	    callback();
	} else {
	    document[eventMethod](eventMethod == "addEventListener" ? "DOMContentLoaded" : "onDOMContentLoaded", callback, false);
	}
    }


    /* ********************************************************************************************
     Singleton constructor
     *********************************************************************************************** */
    try {
	ScriptSource = document.currentScript ? document.currentScript.src : (function (scripts) {
	    var scripts = document.getElementsByTagName('script');
	    if (scripts.length <= 0)
		return "";
	    var script = scripts[scripts.length - 1];

	    if (script.getAttribute.length !== undefined) {
		return script.src
	    }

	    return script.getAttribute('src', -1)
	}());
	ScriptPath = ScriptSource.match(/(.+)\//ig);
	ScriptPath = ScriptPath ? ScriptPath[0] : "";
    } catch (e) {
	self.log("Failed to determine ScriptPath variable: " + e.message);
    }


    if (ScriptPath == "" || !ScriptSource.match(/postamat\.js$/i)) {
	ScriptPath = (location.protocol == 'https:' ? "https:" : "http:") + "//pickpoint.ru/select/";
    }

    // Same Origin
    ScriptPath = ScriptPath.replace("//www.", "//");

    this.ready(function () {
	self._init();
    }, true);


};
} catch (err) {
    if (console!==undefined){
        console.log(err);
    } else {
        alert(err);
    }
}
