function getAry(){
	var result=new Array();
	var args=arguments;
	var i=0;
	var imax=args.length;
	for(; i<imax; i++){
		result[i] = args[i];
	}
	return result;
}
function getCheckboxValue(namen){
	var ckb = document.getElementsByName(namen);
	var res=new Array(ckb.length);
	for(i=0; i<ckb.length; i++) {
		if(ckb[i].checked==true){
			res[i]=ckb[i].value;
		}
	}
	return res;
}
function getCheckedValue(namen){
	var ckb = document.getElementsByName(namen);
	var res=new Array(ckb.length);
	for(i=0; i<ckb.length; i++) {
		if(ckb[i].checked==true){
			return ckb[i].value;
		}
	}
}

function chgDisabled_id(nm,val) {
	var obj = document.getElementById(nm);
	obj.disabled=val;
	return false;
}
function chgChecked_id(nm,val) {
	var obj = document.getElementById(nm);
	obj.checked=val;
	return false;
}
function chgHidden_id(nm,val) {
	var set='';
	if(val){
		set='none';
	}
	var obj = document.getElementById(nm);
	obj.style.display=set;
	return false;
}
function chgDisabled_name(nm,val) {
	var obj = document.getElementsByName(nm);
	var imax=obj.length;
	var i=0;
	for(; i<imax; i++) {
		obj[i].disabled=val;
	}
	return false;
}
function chgChecked_name(nm,val) {
	var obj = document.getElementsByName(nm);
	var imax=obj.length;
	var i=0;
	for(; i<imax; i++) {
		obj[i].checked=val;
	}
	return false;
}
function chgHidden_name(nm,val) {
	var set='';
	if(val){
		set='none';
	}
	var obj = document.getElementsByName(nm);
	var imax=obj.length;
	var i=0;
	for(; i<imax; i++) {
		obj[i].style.display=set;
	}
	return false;
}
function chgStyle_name(type,nm,val){
	switch(type){
		case 'disabled':
			if(nm instanceof Array){
				var imax=nm.length;
				var i=0;
				for(; i<imax; i++){
					chgDisabled_name(nm[i],val);
				}
			}else{
				chgDisabled_name(nm,val);
			}
			return false;
			break;
		case 'checked':
			if(nm instanceof Array){
				var imax=nm.length;
				var i=0;
				for(; i<imax; i++){
					chgChecked_name(nm[i],val);
				}
			}else{
				chgChecked_name(nm,val);
			}
			return false;
			break;
		case 'hidden':
			if(nm instanceof Array){
				var imax=nm.length;
				var i=0;
				for(; i<imax; i++){
					chgHidden_name(nm[i],val);
				}
			}else{
				chgHidden_name(nm,val);
			}
			return false;
			break;
		default:
			return false;
			break;
	}
}
function chgValue_name(nm,val) {
	var obj = document.getElementsByName(nm);
	var imax=obj.length;
	var i=0;
	for(; i<imax; i++) {
		obj[i].value=val;
	}
	return false;
}


function submitform(frmn){
	var fm = document[frmn];
	fm.submit();
}
function make_hidden(name,value,formname){
	var tag = document.createElement('input');
	tag.type='hidden';
	tag.name=name;
	tag.value=value;
	if(formname){
		document.forms[formname].appendChild(tag);
	}else{
		document.forms[0].appendChild(tag);
	}
}
function allDisabledOff(){
	var i=0;
	var j=0;
	for(;i<document.forms.length;i++){
		for(;j<document.forms[i].elements.length;j++){
			document.forms[i].elements[j].disabled=false;
		}
	}
}
function checkall(namen,check) {
	var ckallow = document.getElementsByName(namen);
	for(i=0; i<ckallow.length; i++) {
		ckallow[i].checked=check;
	}
}

function getAreaRange(obj) {
	var isIE = (navigator.appName.toLowerCase().indexOf('internet explorer')+1?1:0);
	var pos = new Object();

	if (isIE) {
		obj.focus();
		var range = document.selection.createRange();
		var clone = range.duplicate();
		clone.moveToElementText(obj);
		clone.setEndPoint( 'EndToEnd', range );
		pos.start = clone.text.length - range.text.length;
		pos.end = clone.text.length - range.text.length + range.text.length;
	} else if(window.getSelection()) {
		pos.start = obj.selectionStart;
		pos.end = obj.selectionEnd;
	}

//	alert(pos.start + "," + pos.end);
	return pos;
}
function surroundHTML(tag,obj,opt) {
	if(opt==undefined){
		opt='';
	}else{
		opt=' '+opt;
	}
	var target = document.getElementById(obj);
	var pos = getAreaRange(target);

	var val = target.value;
	var range = val.slice(pos.start, pos.end);
	var beforeNode = val.slice(0, pos.start);
	var afterNode = val.slice(pos.end);
	var insertNode;

	if (range || pos.start != pos.end) {
	insertNode = '<' + tag + opt + '>' + range + '</' + tag + '>';
	target.value = beforeNode + insertNode + afterNode;
	} else if (pos.start == pos.end) {
		insertNode = '<' + tag + opt + '>' + '</' + tag + '>';
		target.value = beforeNode + insertNode + afterNode;
	}
}
function addEvent( element, eventName, func ){
	if ( element.addEventListener ){ element.addEventListener( eventName, func, false ); }
	else if ( element.attachEvent ){ element.attachEvent( "on" + eventName, func );      }
}
function currentElem(evt,tag){
	if(evt.currentTarget){
		return evt.currentTarget;
	}else{
		var elem=window.event.srcElement;
		while(elem.tagName.toLowerCase() != tag){
			if(elem.tagName.toLowerCase() == 'body'){break;}
			elem=elem.parentNode;
		}
		return elem;
	}
}