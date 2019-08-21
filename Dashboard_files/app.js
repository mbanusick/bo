var path = document.getElementById("path").dataset;
APP_NAME = path.appName;
URL      = path.path;
CSS_URL  = path.cssPath;
JS_URL   = path.jsPath;

//@Function returns matching element or object
function q(i) {
	return typeof i == "object" ? i : document.querySelector(i);
}

//@Function returns all match elements
function Q(i) {
	return document.querySelectorAll(i);
	
}

//@getting form nme 
function getForm(formName) {
	return document.forms.namedItem(formName);
}

//@Function prepares element or object for css styling
function S(i) {
	return q(i).style;
}

/*
requirejs.config({
	baseUrl : JS_URL,
	paths: {
		jQuery: [
			"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min",
			"lib/jquery-3.2.1.min",
		],
		qrCode: "lib/jquery-qrcode-0.14.0.min",
		moment: "lib/moment",
		//popper : "lib/popper.min",
		/*bootstrap:  [
			"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min",
			"lib/bootstrap.min",
		]

		//themeScript: "theme/script",
		//themeCore : "theme/core",

		payment: "script/payment",
		investment: "script/investment",
		withdrawRequest: "script/withdraw_request",
		settings: "script/settings",
		register: "script/register"
	
	},
	shim: {
		//"themeScript": {deps: ["themeCore"]},
		"qrCode" : {deps : ["jQuery"]}
		
	}
});,*/