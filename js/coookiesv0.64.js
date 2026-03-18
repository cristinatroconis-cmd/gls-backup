/*jQuery('.ui-aceptar-cookies').click(function() {
  jQuery('#cookieconsent-container').addClass('d-none');
    jQuery('body').removeClass('no-scroll');
});*/

var listadoCookies=['funcionales','analiticas','sociales','comportamentales'];
listadoCookies=listadoCookies.filter(e=>document.cookie.indexOf(e)!=-1);

function getCookie(c_name) {
    var c_value = document.cookie,
        c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1) c_start = c_value.indexOf(c_name + "=");
    if (c_start == -1) {
        c_value = null;
    } else {
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1) {
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start, c_end));
    }
    return c_value;
}


	if(listadoCookies.length>0){
		var listado = jQuery('.ios:checkbox:checked').map(function() {
			return jQuery(this).attr("data-id");
		}).get();
		setcookie(listado);
		if (getCookie("funcionales")){
			dataLayer.push({'event':'funcionales'});
		}
		if (getCookie("analiticas")){
			dataLayer.push({'event':'analiticas'});
		}
		/*if (getCookie("sociales")){
			console.log('sociales');
			dataLayer.push({'event':'sociales'});
		}*/
		if (getCookie("comportamentales")){
			dataLayer.push({'event':'comportamentales'});
		}
	}
	else{
		/*NO COOKIES */
		jQuery('#cookieconsent-container').removeClass('d-none');
		jQuery('body').addClass('no-scroll');
	}
	
function checkchecks() {
	var listado = jQuery('.ios:checkbox:checked').map(function() {
    	return jQuery(this).attr("data-id");
	}).get();
	setcookie(listado);
}

function setcookie(aceptadas) {
	var hoy = new Date(Date.now() + 86400e3);
	var year = new Date(Date.now() + 31536000e3);
	// +1 day from now
	//hoy = hoy.toUTCString();
	//hoy = hoy.toGMTString();
	//year = year.toUTCString();
	document.cookie = "funcionales=funcionales ; expires=" + hoy + "; path=/; SameSite=Strict;";
  for (var i=0;i<aceptadas.length; i++){
    switch(aceptadas[i]){
        
    	case 'analiticas':
			document.cookie = "analiticas=analiticas ; path=/; expires=" + year + "; SameSite=Strict;";
			dataLayer.push({'event':'analiticas'});
			jQuery('#ios-analiticas').prop('checked',true);
      		break;
    	/*case 'sociales':
      		document.cookie = "sociales=sociales ; expires=" + year + "; path=/; SameSite=Strict;";
			dataLayer.push({'event':'sociales'});
			jQuery('#ios-sociales').prop('checked',true);
      	break;*/
      	case 'comportamentales':
      		document.cookie = "comportamentales=comportamentales ; expires=" + year + "; path=/; SameSite=Strict;";
			dataLayer.push({'event':'comportamentales'});
			jQuery('#ios-comportamentales').prop('checked',true);
      	break;
  	}
  }
	jQuery('#cookieconsent-container').addClass('d-none');
    jQuery('body').removeClass('no-scroll');
}  
	
function delete_cookie(name) {
  document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
 