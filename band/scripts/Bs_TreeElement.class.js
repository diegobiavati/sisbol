/********************************************************************************************
* BlueShoes Framework; This file is part of the php application framework.
* NOTE: This code is stripped (obfuscated). To get the clean documented code goto 
*       www.blueshoes.org and register for the free open source *DEVELOPER* version or 
*       buy the commercial version.
*       
*       In case you've already got the developer version, then this is one of the few 
*       packages/classes that is only available to *PAYING* customers.
*       To get it go to www.blueshoes.org and buy a commercial version.
* 
* @copyright www.blueshoes.org
* @author    Samuel Blume <sam at blueshoes dot org>
* @author    Andrej Arn <andrej at blueshoes dot org>
*/
function Bs_TreeElement() {
this.id;this.parent;this._tree;this.caption;this.url;this.target;this.linkStyle;this.linkTitle;this.linkStatus;this.divStyle;this.onClick;this.isOpen = false;this.visible = true;this.isChecked = 0;this.checkboxName;this.radioButtonSelected;this._checkboxObject;this._level = 0;this._children = new Array;this._undoneChildren;this.imageDir;this.imageHeight;this.icon;this.beforeIconSpan;this.beforeCaptionSpan;this.afterCaptionSpan;this.dataContainer;this._attachedEvents;this._isOutrendered = false;this._errorArray;this.getThis = function() {
return this;}
this.addChild = function(treeElement) {
treeElement.parent = this;if (typeof(this._children) != 'object') this._children = new Array;if (this._children.push) {
this._children.push(treeElement);} else {
this._children[this._children.length] = treeElement;}
treeElement._level = this._level +1;this._updateLevelAndParent(treeElement);this._tree._clearingHouse[treeElement.id] = treeElement;if (this._isOutrendered) {
this.render(true, true);}
}
this.addChildByArray = function(elementData) {
var treeElement = this._tree._createTreeElement(elementData);this.addChild(treeElement);return treeElement;}
this.isChild = function(elementId, bubble) {
for (var i=0, n=this._children.length; i<n; i++) {
if (this._children[i].id == elementId) return true;if (bubble) {
if (this._children[i].isChild(elementId, true)) return true;}
}
return false;}
this.setCaption = function(caption) {
this.caption = caption;if (this._isOutrendered) {
var span = document.getElementById(this._tree._objectId + '_e_' + this.id + '_caption2');if (span) span.innerHTML = caption;}
}
this.render = function(omitDivTags, putIntoPage, lookAhead) {
if (typeof(this._tree.stopWatch) == 'object') this._tree.stopWatch.takeTime('Bs_TreeElement.render() for id: ' + this.id + ' in level: ' + this._level);if (typeof(lookAhead) == 'undefined') {
lookAhead = this._tree.lookAhead;}
if ((this._tree._pseudoElement == this) && !this._tree.showPseudoElement && (lookAhead != -1)) {
lookAhead++;}
var imageDir    = this._getVar('imageDir');var imageHeight = this._getVar('imageHeight');var out      = new Array();var outI     = 0;var evalStr  = '';if (!omitDivTags) {
out[outI++] = '<span id="' + this._tree._objectId + '_e_' + this.id + '"';out[outI++] = ' style="';if (!this.visible) {
out[outI++] = 'display:none;';}
out[outI++] = '">';}
if ((this._level) > 0 || (this._tree.showPseudoElement)) {
out[outI++] = '<nobr>';out[outI++] = '<div style="float:none;"';out[outI++] = ' id="' + this._tree._objectId + '_e_' + this.id + '_drag"';if (this._tree.draggable) {
out[outI++] = ' onDragStart="Bs_Objects['+this._tree._id+'].executeOnElement(\'' + this.id + '\', \'fireEvent\', Array(\'onDragStart\'));"';out[outI++] = ' onDragEnter="Bs_Objects['+this._tree._id+'].executeOnElement(\'' + this.id + '\', \'fireEvent\', Array(\'onDragEnter\'));"';out[outI++] = ' onDragOver="Bs_Objects['+this._tree._id+'].executeOnElement(\'' + this.id + '\', \'fireEvent\', Array(\'onDragOver\'));"';out[outI++] = ' onDrop="Bs_Objects['+this._tree._id+'].executeOnElement(\'' + this.id + '\', \'fireEvent\', Array(\'onDrop\'));"';}
out[outI++] = '>';out[outI++] = '<div style="overflow:visible; height:' + imageHeight + '; ' + this._getVar('divStyle') + '">';var level = this._level;if (!this._tree.showPseudoElement) --level;var obj = this;var outTemp = '';for (var i=0; i<level; i++) {
obj = obj.parent;if (obj.hasSiblingsDown(true)) {
var img = 'line1';} else {
var img = 'empty';}
outTemp = '<img src="' + imageDir + img + '.gif" height="' + imageHeight + '" border="0" align="top">' + outTemp;}
out[outI++] = outTemp;if (this.hasSiblingsDown()) {
var imgNumber = 3;} else {
var imgNumber = 2;}
if (this.hasVisibleChildren()) {
if ((this._level == 0) || (!this._tree.showPseudoElement && (this._level == 1) && ((this._tree.useAutoSequence && (this.id == 1)) || (!this._tree.useAutoSequence && true)))) {
if (this.hasSiblingsDown()) {
imgNumber++;} else {
imgNumber--;}
}
if (this.isOpen) {
var plusImg = 'minus' + imgNumber;var onClick = 'Close';} else {
var plusImg = 'plus' + imgNumber;var onClick = 'Open';}
} else {
var plusImg = 'line' + imgNumber;var onClick = false;}
if (onClick) {
var onClickStr = 'onClick="Bs_Objects['+this._tree._id+'].elementToggleOpenClose(\'' + this.id + '\');"';} else {
var onClickStr = '';}
if (this.onClick) {
var onClick = this.onClick;        onClick = onClick.replace(/__this\.id__/g, this.id); //replace the string __this.id__ with the actual id (int).
out[outI++] = '<span style="cursor:pointer; cursor:hand;" onClick="' + onClick + '">';}
out[outI++] = '<img id="' + this._tree._objectId + '_e_' + this.id + '_openClose" src="' + imageDir + plusImg + '.gif" height="' + imageHeight + '" border="0" ' + onClickStr + ' align="middle"';out[outI++] = ' style="vertical-align:' + ((imageHeight > 16) ? 'middle' : 'top') + '">';if (this.beforeIconSpan) {
out[outI++] = "<span>" + this.beforeIconSpan + "</span>";}
if (this.url) {
var hRef = '<a href="' + this.url + '"';hRef += ' name="' + this._tree._objectId + '_e_' + this.id + '_href"';hRef += ' onkeydown="return Bs_Objects['+this._tree._id+'].executeOnElement(\'' + this.id + '\', \'onKeyDown\', Array(event));"';if (this.target) {
hRef += ' target="' + this.target + '"';}
hRef += ' style="'  + this._getVar('linkStyle') + '"';if (typeof(this.linkTitle)  !== 'undefined') hRef += ' title="'  + this.linkTitle + '"';if (typeof(this.linkStatus) !== 'undefined') {
hRef += ' onmouseover="window.status=\''  + this.linkStatus + '\'; return true;"';hRef += ' onmouseout="window.status=\'\';"';}
hRef += '>';} else {
}
var folderIconId = this._tree._objectId + '_e_' + this.id + '_folder';if (this._getVar('useFolderIcon')) {
if (hRef) out[outI++] = hRef;switch (typeof(this.icon)) {
case 'undefined':
if (this._tree.useLeaf && !this.hasChildren()) {
var folderImg = 'leaf';} else {
var folderImg = 'folder';folderImg += (this.isOpen) ? 'Open' : 'Closed';}
out[outI++] = '<img id="' + folderIconId + '" src="' + imageDir + folderImg + '.gif" height="' + imageHeight + '" border="0" align="top">';break;case 'bool':
case 'boolean':
break;case 'string':
if (this.icon != 'false') {
out[outI++] = '<img id="' + folderIconId + '" src="';if (!this._iconHasPath(this.icon)) out[outI++] = imageDir;out[outI++] = this.icon;if (!this._iconHasExtension(this.icon)) out[outI++] = '.gif';out[outI++] = '" height="' + imageHeight + '" border="0" align="top">';}
}
if (hRef) out[outI++] = '</a>';}
if (this.beforeCaptionSpan) {
out[outI++] = "<span>" + this.beforeCaptionSpan + "</span>";}
if (this._tree.useRadioButton) {
out[outI++] = '<input type="radio"';out[outI++] = ' name="' + this._tree.getRadioButtonName() + '"';out[outI++] = ' id="' + this._tree.getRadioButtonName() + '_' + this.id + '"';out[outI++] = ' value="' + this.id + '"';if (ie && !moz) {
out[outI++] = ' style="height:16px;"';}
if (this.radioButtonSelected) {
out[outI++] = ' checked';}
if (this._tree._disabled) {
out[outI++] = ' readonly disabled';}
out[outI++] = '>';}
if (this._tree.useCheckboxSystem) {
var cleanedCheckboxName = this._cleanCheckboxName(this.checkboxName);var checkboxSpan = cleanedCheckboxName + 'Span';var checkboxObj  = cleanedCheckboxName + 'Obj';out[outI++] = '&nbsp;<span id="' + checkboxSpan + '">';var t = new Bs_Checkbox();t.objectName = checkboxObj;t.checkboxName = this.checkboxName;t.value = this.isChecked;if (this._tree._disabled) t.disabled = true;if (this._getVar('checkboxSystemGuiNochange')) {
t.guiNochange = true;}
var chkImagDir = this._getVar('checkboxSystemImgDir');if (chkImagDir) {
t.imgDir = chkImagDir;} else {
t.imgDir     = "/_bsJavascript/components/checkbox/img/win2k_noBorder/";}
t.imgWidth   = '13';t.imgHeight  = '13';if (this._tree.checkboxSystemWalkTree) {
t.attachOnClick('Bs_Objects['+this._tree._id+'].elementCheckboxEvent(\'' + this.id + '\', ' + checkboxObj + '.value);');}
eval(checkboxObj + ' = t;');this._checkboxObject = t;evalStr += checkboxObj + ".draw('" + checkboxSpan + "');";out[outI++] = '</span>';}
out[outI++] = '&nbsp;';out[outI++] = '<span id="' + this._tree._objectId + '_e_' + this.id + '_caption"';if (this.onClick || this.hasEventAttached('onClickCaption')) {
out[outI++] = ' style="cursor:pointer; cursor:hand;"';} else {
out[outI++] = ' style="cursor:default;"';}
out[outI++] = ' onclick="Bs_Objects['+this._tree._id+'].executeOnElement(\'' + this.id + '\', \'fireEvent\', Array(\'onClickCaption\'));"';out[outI++] = '>';if (hRef) out[outI++] = hRef;out[outI++] = '<span';if (!this.url) {
out[outI++] = ' tabindex="0"';out[outI++] = ' onkeydown="return Bs_Objects['+this._tree._id+'].executeOnElement(\'' + this.id + '\', \'onKeyDown\', Array(event));"';}
out[outI++] = ' id="' + this._tree._objectId + '_e_' + this.id + '_caption2">';out[outI++] = this.caption;out[outI++] = '</span>';if (hRef) out[outI++] = '</a>';out[outI++] = '</span>';if (this.onClick) {
out[outI++] = '</span>';}
out[outI++] = '</div>';if (this.afterCaptionSpan) {
out[outI++] = '<div style="overflow:visible;">' + this.afterCaptionSpan + '</div>';} else {
}
out[outI++] = '</div>';out[outI++] = '</nobr>';}
out[outI++] = '<span id="' + this._tree._objectId + '_e_' + this.id + '_children"';if (!this.isOpen) {
out[outI++] = ' style="display:none;"';}
out[outI++] = '>';if (this.isOpen || (lookAhead > 0) || (lookAhead == -1)) {
for (var i=0, n=this._children.length; i<n; i++) {
if (lookAhead == -1) {
var newLookAhead = -1;} else {
if (this.isOpen) {
var newLookAhead = lookAhead;} else {
var newLookAhead = lookAhead -1;}
}
var t = this._children[i].render(false, false, newLookAhead);out[outI++] = t[0];evalStr    += t[1];}
}
out[outI++] = '</span>';if (!omitDivTags) {
out[outI++] = '</span>';}
out[outI++] = "\n";this._isOutrendered = true;var content = new Array(out.join(''), evalStr);if (putIntoPage) {
var doc = document.getElementById(this._tree._objectId + '_e_' + this.id);if (doc != null) {
doc.innerHTML = content[0];if (content[1] != '') {
eval(content[1]);}
return true;} else {
return false;}
} else {
return content;}
}
this.renderSimple = function(omitDivTags, putIntoPage, lookAhead) {
if (typeof(this._tree.stopWatch) == 'object') this._tree.stopWatch.takeTime('Bs_TreeElement.renderSimple() for id: ' + this.id + ' in level: ' + this._level);if (typeof(lookAhead) == 'undefined') {
lookAhead = this._tree.lookAhead;}
if ((this._tree._pseudoElement == this) && !this._tree.showPseudoElement && (lookAhead != -1)) {
lookAhead++;}
var imageDir    = this._getVar('imageDir');var imageHeight = this._getVar('imageHeight');var out      = new Array;var outI     = 0;var evalStr  = new Array;if (!omitDivTags) {
out[outI++] = '<span id="' + this._tree._objectId + '_e_' + this.id + '"';out[outI++] = ' style="';if (!this.visible) {
out[outI++] = 'display:none;';}
out[outI++] = '">';}
if ((this._level) > 0 || (this._tree.showPseudoElement)) {
out[outI++] = '<nobr>';out[outI++] = '<div style="float:none;"';out[outI++] = ' id="' + this._tree._objectId + '_e_' + this.id + '_drag"';out[outI++] = '>';out[outI++] = '<div style="overflow:visible; height:' + imageHeight + '; ' + this._getVar('divStyle') + '">';var level = this._level;if (!this._tree.showPseudoElement) --level;var obj = this;var outTemp = '';for (var i=0; i<level; i++) {
obj = obj.parent;if (obj.hasSiblingsDown(true)) {
var img = 'line1';} else {
var img = 'empty';}
outTemp = '<img src="' + imageDir + img + '.gif" height="' + imageHeight + '" border="0" align="top">' + outTemp;}
out[outI++] = outTemp;if (this.hasSiblingsDown()) {
var imgNumber = 3;} else {
var imgNumber = 2;}
if (this.hasVisibleChildren()) {
if ((this._level == 0) || (!this._tree.showPseudoElement && (this._level == 1) && ((this._tree.useAutoSequence && (this.id == 1)) || (!this._tree.useAutoSequence && true)))) {
if (this.hasSiblingsDown()) {
imgNumber++;} else {
imgNumber--;}
}
if (this.isOpen) {
var plusImg = 'minus' + imgNumber;var onClick = 'Close';} else {
var plusImg = 'plus' + imgNumber;var onClick = 'Open';}
} else {
var plusImg = 'line' + imgNumber;var onClick = false;}
if (onClick) {
var onClickStr = 'onClick="Bs_Objects['+this._tree._id+'].elementToggleOpenClose(\'' + this.id + '\');"';} else {
var onClickStr = '';}
out[outI++] = '<img id="' + this._tree._objectId + '_e_' + this.id + '_openClose" src="' + imageDir + plusImg + '.gif" height="' + imageHeight + '" border="0" ' + onClickStr + ' align="middle"';out[outI++] = ' style="vertical-align:' + ((imageHeight > 16) ? 'middle' : 'top') + '">';if (this.url) {
var hRef = '<a href="' + this.url + '"';hRef += ' name="' + this._tree._objectId + '_e_' + this.id + '_href"';hRef += ' onkeydown="return Bs_Objects['+this._tree._id+'].executeOnElement(\'' + this.id + '\', \'onKeyDown\', Array(event));"';if (this.target) {
hRef += ' target="' + this.target + '"';}
hRef += ' style="'  + this._getVar('linkStyle') + '"';hRef += '>';}
var folderIconId = this._tree._objectId + '_e_' + this.id + '_folder';if (this._getVar('useFolderIcon')) {
if (hRef) out[outI++] = hRef;switch (typeof(this.icon)) {
case 'undefined':
if (this._tree.useLeaf && !this.hasChildren()) {
var folderImg = 'leaf';} else {
var folderImg = 'folder';folderImg += (this.isOpen) ? 'Open' : 'Closed';}
out[outI++] = '<img id="' + folderIconId + '" src="' + imageDir + folderImg + '.gif" height="' + imageHeight + '" border="0" align="top">';break;case 'bool':
case 'boolean':
break;case 'string':
if (this.icon != 'false') {
out[outI++] = '<img id="' + folderIconId + '" src="';if (!this._iconHasPath(this.icon)) out[outI++] = imageDir;out[outI++] = this.icon;if (!this._iconHasExtension(this.icon)) out[outI++] = '.gif';out[outI++] = '" height="' + imageHeight + '" border="0" align="top">';}
}
if (hRef) out[outI++] = '</a>';}
out[outI++] = '&nbsp;';out[outI++] = '<span id="' + this._tree._objectId + '_e_' + this.id + '_caption"';if (this.onClick) {
out[outI++] = ' style="cursor:pointer; cursor:hand;"';} else {
out[outI++] = ' style="cursor:default;"';}
out[outI++] = ' onClick="Bs_Objects['+this._tree._id+'].executeOnElement(\'' + this.id + '\', \'fireEvent\', Array(\'onClickCaption\'));">';if (hRef) out[outI++] = hRef;out[outI++] = '<span id="' + this._tree._objectId + '_e_' + this.id + '_caption2">' + this.caption + '</span>';if (hRef) out[outI++] = '</a>';out[outI++] = '</span>';out[outI++] = '</div>';out[outI++] = '</div>';out[outI++] = '</nobr>';}
if (typeof(this._tree.stopWatch) == 'object') this._tree.stopWatch.takeTime('Bs_TreeElement.renderSimple() 3');out[outI++] = '<span id="' + this._tree._objectId + '_e_' + this.id + '_children"';if (!this.isOpen) {
out[outI++] = ' style="display:none;"';}
out[outI++] = '>';if (this.isOpen || (lookAhead > 0) || (lookAhead == -1)) {
for (var i=0, n=this._children.length; i<n; i++) {
if (lookAhead == -1) {
var newLookAhead = -1;} else {
if (this.isOpen) {
var newLookAhead = lookAhead;} else {
var newLookAhead = lookAhead -1;}
}
var t = this._children[i].renderSimple(false, false, newLookAhead);out[outI++]             = t[0];evalStr[evalStr.length] = t[1];}
}
out[outI++] = '</span>';if (!omitDivTags) {
out[outI++] = '</span>';}
out[outI++] = "\n";this._isOutrendered = true;var content = new Array(out.join(''), evalStr.join(''));if (putIntoPage) {
var doc = document.getElementById(this._tree._objectId + '_e_' + this.id);if (doc != null) {
doc.innerHTML = content[0];if (content[1] != '') {
eval(content[1]);}
return true;} else {
return false;}
} else {
return content;}
}
this.reset = function() {
this.caption           = null;this.url               = null;this.target            = null;this.onClick           = null;this.isOpen            = false;this.isChecked         = 0;this.checkboxName      = null;this.beforeIconSpan    = null;this.beforeCaptionSpan = null;this.afterCaptionSpan  = null;this.linkStyle         = null;this.linkTitle         = null;this.linkStatus        = null;this.divStyle          = null;}
this.initByArray = function(a, tree, level) {
this._tree   = tree;this._level  = level;if (typeof(this._tree.stopWatch) == 'object') this._tree.stopWatch.takeTime('Bs_TreeElement.initByArray()');if (this._tree.useAutoSequence && (level > 0)) {
this.id      = ++this._tree._elementSequence;} else {
if (typeof(a['id']) == 'undefined') {
this._addError('tree error: useAutoSequence is set to false, but for an array element there is no id defined.');return false;}
this.id = a['id'];}
if (typeof(a['caption'])             != 'undefined') this.caption             = a['caption'];if (typeof(a['url'])                 != 'undefined') this.url                 = a['url'];if (typeof(a['target'])              != 'undefined') this.target              = a['target'];if (typeof(a['isOpen'])              != 'undefined') this.isOpen              = a['isOpen'];if (!this._tree.simple) {
if (typeof(a['linkStyle'])           != 'undefined') this.linkStyle           = a['linkStyle'];if (typeof(a['linkTitle'])           != 'undefined') this.linkTitle           = a['linkTitle'];if (typeof(a['linkStatus'])          != 'undefined') this.linkStatus          = a['linkStatus'];if (typeof(a['divStyle'])            != 'undefined') this.divStyle            = a['divStyle'];if (typeof(a['onClick'])             != 'undefined') this.onClick             = a['onClick'];if (typeof(a['isChecked'])           != 'undefined') this.isChecked           = parseInt(a['isChecked']);if (typeof(a['visible'])             != 'undefined') this.visible             = a['visible'];if (typeof(a['icon'])                != 'undefined') this.icon                = a['icon'];if (typeof(a['imageDir'])            != 'undefined') this.imageDir            = a['imageDir'];if (typeof(a['beforeIconSpan'])      != 'undefined') this.beforeIconSpan      = a['beforeIconSpan'];if (typeof(a['beforeCaptionSpan'])   != 'undefined') this.beforeCaptionSpan   = a['beforeCaptionSpan'];if (typeof(a['afterCaptionSpan'])    != 'undefined') this.afterCaptionSpan    = a['afterCaptionSpan'];if (typeof(a['radioButtonSelected']) != 'undefined') this.radioButtonSelected = a['radioButtonSelected'];if (typeof(a['dataContainer'])       != 'undefined') this.dataContainer       = a['dataContainer'];if (typeof(a['checkboxName']) != 'undefined') {
this.checkboxName  = a['checkboxName'];} else {
if (this._tree.useCheckboxSystem) {
this.checkboxName = 'bsTreeChk_' + this._tree._objectId + '_' + this.id;}
}
if (typeof(a['onClickCaption'])    != 'undefined') {
this.attachEvent('onClickCaption', a['onClickCaption']);}
if (typeof(a['onChangeCheckbox'])    != 'undefined') {
this.attachEvent('onChangeCheckbox', a['onChangeCheckbox']);}
if (typeof(a['events']) != 'undefined') {
for (ev in a['events']) {
this.attachEvent(ev, a['events'][ev]);}
}
}
return true;}
this.exportAsArray = function(withChildren) {
var ret = new Array();if (typeof(this.id)                       != 'undefined') ret['id']                       = this.id;if (typeof(this.caption)                  != 'undefined') ret['caption']                  = this.caption;if (typeof(this.url)                      != 'undefined') ret['url']                      = this.url;if (typeof(this.target)                   != 'undefined') ret['target']                   = this.target;if (typeof(this.onClick)                  != 'undefined') ret['onClick']                  = this.onClick;if (typeof(this.isOpen)                   != 'undefined') ret['isOpen']                   = this.isOpen;if (typeof(this.isChecked)                != 'undefined') ret['isChecked']                = this.isChecked;if (typeof(this.visible)                  != 'undefined') ret['visible']                  = this.visible;if (typeof(this.icon)                     != 'undefined') ret['icon']                     = this.icon;if (typeof(this.imageDir)                 != 'undefined') ret['imageDir']                 = this.imageDir;if (typeof(this.beforeIconSpan)           != 'undefined') ret['beforeIconSpan']           = this.beforeIconSpan;if (typeof(this.afterCaptionSpan)         != 'undefined') ret['afterCaptionSpan']         = this.afterCaptionSpan;if (typeof(this.radioButtonSelected)      != 'undefined') ret['radioButtonSelected']      = this.radioButtonSelected;if (typeof(this.dataContainer)            != 'undefined') ret['dataContainer']            = this.dataContainer;if (typeof(this.checkboxName)             != 'undefined') ret['checkboxName']             = this.checkboxName;if (typeof(this.beforeCaptionSpan)        != 'undefined') ret['beforeCaptionSpan']        = this.beforeCaptionSpan;if (typeof(this.linkStyle)                != 'undefined') ret['linkStyle']                = this.linkStyle;if (typeof(this.linkTitle)                != 'undefined') ret['linkTitle']                = this.linkTitle;if (typeof(this.linkStatus)               != 'undefined') ret['linkStatus']               = this.linkStatus;if (typeof(this.divStyle)                 != 'undefined') ret['divStyle']                 = this.divStyle;if (withChildren) {
ret['children'] = new Array();for (var i=0; i<this._children.length; i++) {
ret['children'][ret['children'].length] = this._children[i].exportAsArray(true);}
}
return ret;}
this.updateObjectByArray = function(a) {
this.reset();if (a['caption'])            this.caption            = a['caption'];if (a['url'])                this.url                = a['url'];if (a['target'])             this.target             = a['target'];if (a['onClick'])            this.onClick            = a['onClick'];if (a['isOpen'])             this.isOpen             = a['isOpen'];if (a['isChecked'])          this.isChecked          = a['isChecked'];if (a['imageDir'])           this.imageDir           = a['imageDir'];if (a['checkboxName']) {
this.checkboxName  = a['checkboxName'];} else {
if (this._tree.useCheckboxSystem) {
this.checkboxName = 'bsTreeCheckbox' + this.id;}
}
if (a['beforeIconSpan'])     this.beforeIconSpan     = a['beforeIconSpan'];if (a['beforeCaptionSpan'])  this.beforeCaptionSpan  = a['beforeCaptionSpan'];if (a['afterCaptionSpan'])   this.afterCaptionSpan   = a['afterCaptionSpan'];}
this.getJavascriptCode = function(varName, recursive) {
var ret = "";if (
(this._tree.useAutoSequence && (this.id > 1))
|| (!this._tree.useAutoSequence && !this.parent)
) {
} else {
ret += varName + " = new Array();\n";if (!this._tree.useAutoSequence) {
ret += varName + "['id'] = \"" + this.id + "\";\n";}
if (this.caption)           ret += varName + "['caption']            = \"" + this.caption            + "\";\n";if (this.url)               ret += varName + "['url']                = \"" + this.url                + "\";\n";if (this.target)            ret += varName + "['target']             = \"" + this.target             + "\";\n";if (this.onClick) {
        //var onClick = this.onClick.replace(/'/g,  "\'");
        var onClick = this.onClick.replace(/"/g,  '\"');
ret += varName + "['onClick']            = \"" + onClick            + "\";\n";}
if (this.imageDir)          ret += varName + "['imageDir']           = \"" + this.imageDir           + "\";\n";if (this.isOpen)            ret += varName + "['isOpen']             = '" + this.isOpen              + "';\n";if (this.isChecked)         ret += varName + "['isChecked']          = '" + this.isChecked           + "';\n";if (this.checkboxName)      ret += varName + "['checkboxName']       = '" + this.checkboxName        + "';\n";if (this.icon)              ret += varName + "['icon']               = \"" + this.icon               + "\";\n";if (this.beforeIconSpan)    ret += varName + "['beforeIconSpan']     = \"" + this.beforeIconSpan     + "\";\n";if (this.beforeCaptionSpan) ret += varName + "['beforeCaptionSpan']  = \"" + this.beforeCaptionSpan  + "\";\n";if (this.afterCaptionSpan)  ret += varName + "['afterCaptionSpan']   = \"" + this.afterCaptionSpan   + "\";\n";if (this.linkStyle)         ret += varName + "['linkStyle']          = \"" + this.linkStyle          + "\";\n";if (this.linkTitle)         ret += varName + "['linkTitle']          = \"" + this.linkTitle          + "\";\n";if (this.linkStatus)        ret += varName + "['linkStatus']         = \"" + this.linkStatus         + "\";\n";if (this.divStyle)          ret += varName + "['divStyle']           = \"" + this.divStyle           + "\";\n";varName += "['children']";}
if (recursive) {
if (this._children.length > 0) {
ret += varName + " = new Array();\n";for (var i=0; i<this._children.length; i++) {
ret += this._children[i].getJavascriptCode(varName + "[" + i + "]", recursive);}
}
}
return ret;}
this.setActive = function() {
var activeElement = this._tree.getActiveElement();if (activeElement != false) {
activeElement.unsetActive();}
this._tree.setActiveElement(this);this._highlight();}
this._highlight = function() {
var elmSetActive = document.getElementById(this._tree._objectId + '_e_' + this.id + '_caption');if (elmSetActive != null) {
elmSetActive.style.backgroundColor = this._getVar('captionBgColor');} else {
setTimeout("Bs_Objects["+this._tree._id+"].executeOnElement('" + this.id + "', '_highlight');", 800);}
}
this.unsetActive = function() {
var e = document.getElementById(this._tree._objectId + '_e_' + this.id + '_caption');if (e != null) e.style.backgroundColor = 'transparent';}
this.toggleOpenClose = function() {
if (this.isOpen) {
if (this.hasEventAttached('onBeforeClose')) {
var status = this.fireEvent('onBeforeClose');if (status != true) return;}
this.close();if (this.hasEventAttached('onAfterClose')) this.fireEvent('onAfterClose');} else {
if (this.hasEventAttached('onBeforeOpen')) {
var status = this.fireEvent('onBeforeOpen');if (status != true) return;}
this.open();if (this.hasEventAttached('onAfterOpen')) this.fireEvent('onAfterOpen');}
}
this.open = function(checkParents) {
if (this.isOpen) return;this.isOpen = true;if (this.hasVisibleChildren()) {
var lookAhead = this._tree.lookAhead;var doRender  = false;for (var i=0; i<this._children.length; i++) {
if (!this._children[i]._isOutrendered) {
doRender = true;break;}
}
if (doRender) this.render(true, true, lookAhead);}
if (true || !doRender) {
if (this._isOutrendered) {
var d = document.getElementById(this._tree._objectId + '_e_' + this.id + '_children');if (d) d.style.display = 'block';this._switchIconsOnToggleOpenClose();} else {
if (checkParents) {
this._renderParentsUp();}
this.render(true, true);}
if (this._tree.rememberState) this._tree._updateStateCookie(this.id, 'open', true);}
if (this._tree.autoCollapse) {
var sib = this.getSiblings();for (var i=0, n=sib.length; i<n; i++) {
if (sib[i].id != this.id) {
sib[i].close();}
}
}
if (this.hasVisibleChildren()) {
var lookAhead = this._tree.lookAhead;var treeElm     = this;for (var j=0, n=treeElm._children.length; j<n; j++) {
if (typeof(treeElm._children[j]._undoneChildren) == 'object') {
for (var k=0, kn=treeElm._children[j]._undoneChildren.length; k<kn; k++) {
var newE = this._tree._createTreeElement(treeElm._children[j]._undoneChildren[k], treeElm._children[j]._level +1);treeElm._children[j].addChild(newE);}
treeElm._children[j]._undoneChildren = false;}
if (treeElm._children[j].hasVisibleChildren()) {
var doRender = false;for (var k=0, kn=treeElm._children[j]._children.length; k<kn; k++) {
if (!treeElm._children[j]._children[k]._isOutrendered) {
var doRender = true;break;}
}
if (doRender) {
treeElm._children[j].render(true, true, lookAhead);}
}
}
}
}
this._renderParentsUp = function() {
if (typeof(this.parent) == 'undefined') this.parent._renderParentsUp();if (this._isOutrendered) return;this.render(true, true);}
this.close = function() {
if (!this.isOpen) return;this.isOpen = false;if (this._isOutrendered) {
var d = document.getElementById(this._tree._objectId + '_e_' + this.id + '_children');d.style.display = 'none';this._switchIconsOnToggleOpenClose();} else {
this.render(true, true);}
if (this._tree.rememberState) this._tree._updateStateCookie(this.id, 'open', false);}
this._switchIconsOnToggleOpenClose = function() {
var openClose = document.getElementById(this._tree._objectId + '_e_' + this.id + '_openClose');if (openClose) openClose.src = this._getSourceOpenCloseIcon();if (this._getVar('useFolderIcon')) {
var folderIconId = this._tree._objectId + '_e_' + this.id + '_folder';var fIcon = document.getElementById(folderIconId);if (fIcon) {
fIcon.src = this._getSourceFolderIcon();}
}
}
this._getSourceOpenCloseIcon = function() {
if (this.hasSiblingsDown()) {
var imgNumber = 3;} else {
var imgNumber = 2;}
if (this.hasVisibleChildren()) {
if ((this._level == 0) || (!this._tree.showPseudoElement && (this._level == 1) && ((this._tree.useAutoSequence && (this.id == 1)) || (!this._tree.useAutoSequence && true)))) {
if (this.hasSiblingsDown()) {
imgNumber++;} else {
imgNumber--;}
}
if (this.isOpen) {
var plusImg = 'minus' + imgNumber;var onClick = 'Close';} else {
var plusImg = 'plus' + imgNumber;var onClick = 'Open';}
} else {
var plusImg = 'line' + imgNumber;}
var imageDir = this._getVar('imageDir');return imageDir + plusImg + '.gif';}
this._getSourceFolderIcon = function() {
var imageDir = this._getVar('imageDir');switch (typeof(this.icon)) {
case 'undefined':
if (this._tree.useLeaf && !this.hasChildren()) {
var folderImg = 'leaf';} else {
var folderImg = 'folder';folderImg += (this.isOpen) ? 'Open' : 'Closed';}
return imageDir + folderImg + '.gif';break;case 'bool':
case 'boolean':
break;case 'string':
if (this.icon != 'false') {
var ret = '';if (!this._iconHasPath(this.icon)) ret += imageDir;ret += this.icon;if (!this._iconHasExtension(this.icon)) ret += '.gif';return ret;}
}
return '';}
this.hasChildren = function() {
return (this._children.length > 0);}
this.hasVisibleChildren = function() {
if (!this._children || !(this._children.length > 0)) {
this._hasVisibleChildren = false;return false;}
for (var i=0, n=this._children.length; i<n; i++) {
if (this._children[i].visible) {
this._hasVisibleChildren = true;return true;}
}
this._hasVisibleChildren = false;return false;}
this.numChildren = function() {
return this._children.length;}
this.childPos = function(id) {
for (var i=0, n=this._children.length; i<n; i++) {
if (this._children[i].id == id) return ++i;}
return false;}
this.hasSiblings = function() {
}
this.hasSiblingsDown = function(ignoreCache) {
if (false && !ignoreCache) {
if (typeof(this._hasSiblingsDown) != 'undefined') return this._hasSiblingsDown;}
try {
var tot = this.parent.numChildren();var pos = this.parent.childPos(this.id);this._hasSiblingsDown = (pos < tot);return this._hasSiblingsDown;} catch (e) {
this._hasSiblingsDown = false;return false;}
}
this.hasSiblingsAbove = function() {
}
this.getSiblings = function() {
try {
return this.parent.getChildren();} catch(e) {
return new Array;}
}
this.getChildren = function() {
return this._children;}
this.getParentId = function() {
try {
return this.parent.id;} catch (e) {
return false;}
}
this.hasParent = function() {
return (this.parent);}
this.attachEvent = function(trigger, yourEvent) {
if (typeof(this._attachedEvents) == 'undefined') {
this._attachedEvents = new Array();}
if (typeof(this._attachedEvents[trigger]) == 'undefined') {
this._attachedEvents[trigger] = new Array(yourEvent);} else {
this._attachedEvents[trigger][this._attachedEvents[trigger].length] = yourEvent;}
}
this.hasEventAttached = function(trigger) {
return ((typeof(this._attachedEvents) != 'undefined') && (typeof(this._attachedEvents[trigger]) != 'undefined'));}
this.fireEvent = function(trigger) {
var ret = true;if (trigger == 'onClickCaption') {
this.setActive();}
if ((typeof(this._attachedEvents) != 'undefined') && (typeof(this._attachedEvents[trigger]) != 'undefined')) {
var e = this._attachedEvents[trigger];if ((typeof(e) == 'string') || (typeof(e) == 'function')) {
e = new Array(e);}
for (var i=0, n=e.length; i<n; i++) {
if (typeof(e[i]) == 'function') {
var status = e[i](this);if (status == false) ret = false;} else if (typeof(e[i]) == 'string') {
        	var ev = e[i].replace(/__this\.id__/g, this.id); //replace the string __this.id__ with the actual id.
        	//ev = ev.replace(/__this__/g, 'this'); //replace the string __this__ with 'this'.
eval(ev);}
}
}
return ret;}
this.onKeyDown = function(event) {
if (event == null)                        return;if (typeof(event)         == 'undefined') return;if (typeof(event.keyCode) == 'undefined') return;switch (event.keyCode) {
case 107:
case 39:
if (this.isOpen) {
if (this.hasVisibleChildren()) {
var treeElm = this.getNextVisibleElement();if (treeElm != null) {
var name = this._tree._objectId + '_e_' + treeElm.id + '_href';var captionSpan = document.getElementsByName(name);if (captionSpan.length > 0) {
captionSpan[1].focus();} else {
name = this._tree._objectId + '_e_' + treeElm.id + '_caption2';captionSpan = document.getElementById(name);if (captionSpan) captionSpan.focus();}
}
}
} else {
this.open();}
return false;case 37:
case 109:
if (this.isOpen && (this._children.length > 0)) {
this.close();} else {
var treeElm = this.parent;if (treeElm != null) {
var name = this._tree._objectId + '_e_' + treeElm.id + '_href';var captionSpan = document.getElementsByName(name);if (captionSpan.length > 0) {
captionSpan[1].focus();} else {
name = this._tree._objectId + '_e_' + treeElm.id + '_caption2';captionSpan = document.getElementById(name);if (captionSpan) captionSpan.focus();}
}
}
return false;case 40:
var treeElm = this.getNextVisibleElement();if (treeElm != null) {
var name = this._tree._objectId + '_e_' + treeElm.id + '_href';var captionSpan = document.getElementsByName(name);if (captionSpan.length > 0) {
captionSpan[1].focus();} else {
name = this._tree._objectId + '_e_' + treeElm.id + '_caption2';captionSpan = document.getElementById(name);if (captionSpan) captionSpan.focus();}
}
return false;case 38:
var treeElm = this.getPreviousVisibleElement();if (treeElm != null) {
var name = this._tree._objectId + '_e_' + treeElm.id + '_href';var captionSpan = document.getElementsByName(name);if (captionSpan.length > 0) {
captionSpan[1].focus();} else {
name = this._tree._objectId + '_e_' + treeElm.id + '_caption2';captionSpan = document.getElementById(name);if (captionSpan) captionSpan.focus();}
}
return false;case 32:
if (this._tree.useCheckboxSystem) {
switch (this.isChecked) {
case 0:
var newCheckboxValue = 2; break;case 2:
var newCheckboxValue = 0; break;case 1:
if (this._tree.checkboxSystemIfPartlyThenFull) {
var newCheckboxValue = 2;} else {
var newCheckboxValue = 0;}
break;}
this.setCheckboxValue(newCheckboxValue);} else if (this._tree.useRadioButton) {
document.getElementById(this._tree.getRadioButtonName() + '_' + this.id).checked = true;}
return false;}
return true;}
this.getPreviousVisibleElement = function() {
var treeElm = null;do {
var sib = this.getSiblings();for (var i=0, n=sib.length; i<n; i++) {
if (sib[i].id == this.id) {
if (i > 0) {
treeElm = sib[--i];if (treeElm.isOpen && treeElm.hasVisibleChildren()) {
treeElm = treeElm._children[treeElm._children.length -1];}
break;}
}
}
if (treeElm == null) {
if (typeof(this.parent) == 'undefined') break;treeElm = this.parent;}
} while (false);return treeElm;}
this.getNextVisibleElement = function() {
var treeElm = null;do {
if (this.isOpen && this.hasVisibleChildren()) {
treeElm = this._children[0];break;}
if (this.hasSiblingsDown()) {
var sib = this.getSiblings();for (var i=0, n=sib.length; i<n; i++) {
if (sib[i].id == this.id) {
treeElm = sib[++i];break;}
}
if (treeElm != null) break;}
var elm = this.parent;do {
var sib = elm.getSiblings();for (var i=0, n=sib.length; i<n; i++) {
if (sib[i].id == elm.id) {
treeElm = sib[++i];break;}
}
if (treeElm != null) break;if (typeof(elm.parent) == 'undefined') break;elm = elm.parent;} while (true);} while (false);return treeElm;}
this._addError = function(str) {
if (typeof(this._errorArray) == 'undefined') {
this._errorArray = new Array(str);} else {
this._errorArray[this._errorArray.length] = str;}
}
this.getLastError = function() {
if (typeof(this._errorArray) != 'undefined') {
if (this._errorArray.length > 0) {
return this._errorArray[this._errorArray.length -1];}
}
return false;}
this._getVar = function(varName) {
if (typeof(this[varName]) != 'undefined') {
return this[varName];} else {
if (this._tree.walkTree && (typeof(this.parent) != 'undefined')) {
return this.parent._getVar(varName);} else if (typeof(this._tree[varName]) != 'undefined') {
return this._tree[varName];} else {
return null;}
}
}
this.onMouseOver = function() {
var img = document.getElementById(this._spanId + 'icon');if (!img.swapOver0) {
img.swapOver0 = new Image();img.swapOver0.src = this.imgDir + 'enabled_0_over.gif';img.swapOver1 = new Image();img.swapOver1.src = this.imgDir + 'enabled_1_over.gif';img.swapOver2 = new Image();img.swapOver2.src = this.imgDir + 'enabled_2_over.gif';img.swapOut0 = new Image();img.swapOut0.src = this.imgDir + 'enabled_0.gif';img.swapOut1 = new Image();img.swapOut1.src = this.imgDir + 'enabled_1.gif';img.swapOut2 = new Image();img.swapOut2.src = this.imgDir + 'enabled_2.gif';}
img.src = img['swapOver' + this.value].src;}
this.onMouseOut = function() {
var img = document.getElementById(this._spanId + 'icon');img.src = img['swapOut' + this.value].src;}
this.setCheckboxValue = function(value, fireEvents, doWalk) {
if (typeof(fireEvents) == 'undefined') fireEvents = true;if (typeof(doWalk)     == 'undefined') doWalk     = true;if (!this.hasChildren()) {
value = (value) ? 2 : 0;} else {
if (this.isChecked == 0) {
if (this._tree.checkboxSystemWalkTree && (this._tree.checkboxSystemWalkTree != 2) && (this._tree.checkboxSystemWalkTree != 3) && this.hasChildren()) {
value = 1;}
}
}
this.isChecked = value;this._checkboxObject.setTo(value, true);if (fireEvents) {
if (this.hasEventAttached('onChangeCheckbox')) this.fireEvent('onChangeCheckbox');}
if (doWalk) {
if ((this._tree.checkboxSystemWalkTree == 3) || (this._tree.checkboxSystemWalkTree == 1) || (this._tree.checkboxSystemWalkTree == 4)) {
this.parent.updateCheckboxFromChild();}
if ((this._tree.checkboxSystemWalkTree == 3) || (this._tree.checkboxSystemWalkTree == 2) || ((this._tree.checkboxSystemWalkTree == 4) && (value == 0))) {
this.checkboxUpdateDown(value);}
}
}
this.checkboxEvent = function(value) {
if (!this.hasChildren()) {
value = (value) ? 2 : 0;} else {
if (this.isChecked == 1) {
if ((!this._tree.checkboxSystemIfPartlyThenFull) || ((this._tree.checkboxSystemWalkTree) && (this._tree.checkboxSystemWalkTree != 2) && (this._tree.checkboxSystemWalkTree != 3))) {
value = 0;} else {
value = 2;}
} else if (this.isChecked == 0) {
if (this._tree.checkboxSystemWalkTree && (this._tree.checkboxSystemWalkTree != 2) && (this._tree.checkboxSystemWalkTree != 3) && this.hasChildren()) {
value = 1;}
}
}
this.isChecked = value;this._checkboxObject.setTo(value, true);if (this.hasEventAttached('onChangeCheckbox')) this.fireEvent('onChangeCheckbox');if ((this._tree.checkboxSystemWalkTree == 3) || (this._tree.checkboxSystemWalkTree == 1) || (this._tree.checkboxSystemWalkTree == 4)) {
this.parent.updateCheckboxFromChild();}
if ((this._tree.checkboxSystemWalkTree == 3) || (this._tree.checkboxSystemWalkTree == 2) || ((this._tree.checkboxSystemWalkTree == 4) && (value == 0))) {
this.checkboxUpdateDown(value);}
}
this.checkboxUpdateDown = function(value) {
for (var i=0; i<this._children.length; i++) {
this._children[i]._updateCheckboxFromParent(value, true);}
}
this.updateCheckboxVisually = function() {
if (typeof(this._checkboxObject) == 'object') {
try {
this._checkboxObject.setTo(this.isChecked);} catch (e) {
}
}
}
this._updateCheckboxFromParent = function(newValue, recursiveDown) {
var backupValue = this.isChecked;this.isChecked = (newValue) ? 2 : 0;var hasChanged = (this.isChecked != backupValue);if (hasChanged) {
this.updateCheckboxVisually();if (this.hasEventAttached('onChangeCheckbox')) this.fireEvent('onChangeCheckbox');}
if (recursiveDown) this.checkboxUpdateDown(newValue, true);}
this.updateCheckboxFromChild = function() {
var backupIsChecked = this.isChecked;var numYes   = 0;var numNo    = 0;var isPartly = false;for (var i=0, n=this._children.length; i<n; i++) {
if (this._children[i].isChecked == 1) {
isPartly = true;this.isChecked = 1;break;} else if (this._children[i].isChecked) {
numYes++;} else {
numNo++;}
if ((numYes > 0) && (numNo > 0)) {
break;}
}
if (!isPartly) {
if ((numYes > 0) && (numNo > 0)) {
this.isChecked = 1;} else if (numYes > 0) {
this.isChecked = 2;} else {
this.isChecked = 0;}
}
if (backupIsChecked != this.isChecked) {
this.updateCheckboxVisually();if (this.hasEventAttached('onChangeCheckbox')) this.fireEvent('onChangeCheckbox');}
if (typeof(this.parent) == 'object') {
this.parent.updateCheckboxFromChild();}
}
this._updateLevelAndParent = function(treeElement) {
if ((typeof(treeElement._children) == 'object') && (treeElement._children.length > 0)) {
for (var i=0, n=treeElement._children.length; i<n; i++) {
treeElement._children[i].parent = treeElement;treeElement._children[i]._level = treeElement._level +1;this._updateLevelAndParent(treeElement._children[i]);}
}
}
this._getLinkStyle = function() {
if (typeof(this.linkStyle)       != 'undefined') return this.linkStyle;if (typeof(this._tree.linkStyle) != 'undefined') return this._tree.linkStyle;return '';}
this._cleanCheckboxName = function(checkboxName) {
		//ret = ret.replace(myReg, "=");
var ret = '';for (var i=0; i<checkboxName.length; i++) {
var chr = checkboxName.charCodeAt(i);if ((chr < 48) || (chr > 57 && chr < 65) || (chr > 90 && chr < 97) || (chr > 122)) {
ret += '_';} else {
ret += checkboxName.substr(i, 1);}
}
return ret;}
this._iconHasExtension = function(iconStr) {
var iconLower = iconStr.toLowerCase();var iconPos   = iconLower.lastIndexOf('.');if (iconPos > -1) {
var iconExt = iconLower.substr(iconPos +1);if ((iconExt != 'gif') && (iconExt != 'png') && (iconExt != 'jpg') && (iconExt != 'jpeg')) {
return false;}
} else {
return false;}
return true;}
this._iconHasPath = function(iconStr) {
if (iconStr.indexOf('://') > -1) return true;if (iconStr.substr(0, 1) == '/') return true;return false;}
}
