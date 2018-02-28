/* jce - 2.6.24 | 2018-01-24 | http://www.joomlacontenteditor.net | Copyright (C) 2006 - 2018 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
!function(window,$,tinymce,tinyMCEPopup){var iw,ih,CaptionDialog={settings:{},init:function(){var el,ed=tinyMCEPopup.editor,n=ed.selection.getNode(),self=this;tinyMCEPopup.restoreSelection(),el=ed.dom.getParent(n,".mce-item-caption"),"IMG"!=n.nodeName&&(n=ed.dom.select("img",el)[0]),$("#insert").click(function(e){self.insert(),e.preventDefault()}),$("#help").click(function(e){Wf.help("caption"),e.preventDefault()}),TinyMCE_Utils.fillClassList("text_classlist"),Wf.init();var img=new Image;if(img.onload=function(){iw=img.width,ih=img.height},img.src=n.src,$("#caption_image").attr({src:n.src}),null!=el){$("#insert").button("option","label",tinyMCEPopup.getLang("update","Update",!0)),ed.dom.removeClass(el,"mceVisualAid"),tinymce.each(["top","right","bottom","left"],function(o){$("#padding_"+o).val(self.getAttrib(el,"padding-"+o));var v=self.getAttrib(el,"margin-"+o);"inherit"!==v&&$("#margin_"+o).val(v)}),$("#border_width").val(function(){var v=self.getAttrib(el,"border-width");return 0==$('option[value="'+v+'"]',this).length&&$(this).append(new Option(v,v)),v}),$("#border_style").val(this.getAttrib(el,"border-style")),$("#border_color").val(this.getAttrib(el,"border-color")),$("#border").is(":checked")||$.each(["border_width","border_style","border_color"],function(i,k){$("#"+k).val(self.settings.defaults[k])}),$("#align").val(this.getAttrib(el,"align")),$("#bgcolor").val(this.getAttrib(el,"background-color")),tinymce.each(ed.dom.select("div,span",el),function(c){ed.dom.removeClass(c,"mceVisualAid"),el.firstChild===c&&$("#text_position").val("top"),$("#text_align").val(ed.dom.getStyle(c,"text-align")),tinymce.each(["top","right","bottom","left"],function(o){$("#text_padding_"+o).val(self.getAttrib(c,"padding-"+o))}),tinymce.each(["top","right","bottom","left"],function(o){var v=self.getAttrib(c,"margin-"+o);"inherit"!==v&&$("#text_margin_"+o).val(v)}),$("#text_color").val(self.getAttrib(c,"color")),$("#text_bgcolor").val(self.getAttrib(c,"background-color")),$("#text").val(c.innerHTML||""),$("#text_classes").val(ed.dom.getAttrib(c,"class"))});var cls=ed.dom.getAttrib(el,"class");cls=tinymce.trim(cls.replace(/((jce|wf)_caption|mce-item-caption)/gi," ")),$("#classes").val(cls)}else $.each(this.settings.defaults,function(k,v){switch(k){case"padding":case"margin":case"text_padding":case"text_margin":$.each(["top","right","bottom","left"],function(i,s){"margin"==k&&(v=self.getAttrib(n,"margin-"+s)),$("#"+k+"_"+s).val(v)});break;default:$n=$("#"+k),$n.is(":checkbox")?$n.prop("checked",!!v):$n.val(v)}}),$("#align").val(this.getAttrib(n,"align")),$("#text").val(ed.dom.getAttrib(n,"title")||ed.dom.getAttrib(n,"alt")||tinyMCEPopup.getLang("caption_dlg.text","Caption Text"));$(":input").on("change",function(){self.updateCaption()}).change(),$("#border").on("border:change",function(){self.updateCaption()}),$(".uk-equalize-checkbox").on("equalize:change",function(){self.updateCaption()}),this.updateText(),this.updateCaption(),$(".uk-equalize-checkbox").trigger("equalize:update")},insert:function(){tinyMCEPopup.restoreSelection();var c,w,h,txt,v,mw,ed=tinyMCEPopup.editor,s=ed.selection,n=s.getNode(),style=ed.dom.serializeStyle(ed.dom.parseStyle($("#caption").get(0).style.cssText));el=ed.dom.getParent(n,".mce-item-caption"),"IMG"!=n.nodeName&&(n=ed.dom.select("img",el)[0]);var w=ed.dom.getAttrib(n,"width"),h=ed.dom.getAttrib(n,"height");(w||h)&&(w&&/%/.test(w)&&(w=Math.round(parseInt(iw)*parseInt(w)/100)),!w&&h&&(w=Math.round(iw*h/ih))),ed.dom.hasClass(n,"mce-item-media")||(ed.getParam("caption_responsive",1)&&(ed.dom.setAttrib(n,"width",w||iw),ed.dom.setStyle(n,"width","100%")),ed.dom.setAttrib(n,"height",null),ed.dom.setStyle(n,"height","")),mw=w||iw,tinymce.each(["margin","padding","float"],function(k){v=ed.dom.getStyle(n,k,!0),""!=v&&null!=v&&"undefined"!=v||(v="auto","float"===k&&(v="none"),ed.dom.setStyle(n,k,v))});var s=ed.dom.serializeStyle(ed.dom.parseStyle(n.style.cssText));ed.dom.setAttribs(n,{style:s,"data-mce-style":s});var ct={style:ed.dom.serializeStyle(ed.dom.parseStyle($("#caption_text").get(0).style.cssText)),class:$("#text_classes").val()};if(txt=$("#text").val(),n=ed.dom.getParent(n,"A")||n,null!=el)if("SPAN"!==el.nodeName&&dom.remove(el,!0),c=ed.dom.select("span, div",el)[0]){if("SPAN"!==c.nodeName){var span=ed.dom.create("span");ed.dom.replace(span,c,!0),c=span}txt?(ed.dom.setAttribs(c,ct),ed.dom.setHTML(c,txt)):(ed.dom.remove(c),c=null)}else txt&&(c=ed.dom.create("span",ct,txt));else ed.formatter.apply("wfcaption"),txt&&(c=ed.dom.create("span",ct,txt));c&&(ed.dom.setStyle(c,"display","block"),c.removeAttribute("_mce_style"),c.removeAttribute("data-mce-style"),c&&("top"==$("#text_position").val()?el.insertBefore(c,n):ed.dom.insertAfter(c,n))),el=ed.dom.getParent(n,".mce-item-caption"),ed.dom.removeClass(el,"jce_caption"),ed.dom.addClass(el,"wf_caption"),ed.dom.setAttrib(el,"style",style),ed.dom.addClass(el,$("#classes").val()),ed.dom.setStyle(el,"max-width",mw+"px"),ed.getParam("caption_responsive",1)&&ed.dom.setStyle(el,"width","100%"),ed.dom.setStyle(el,"height",""),ed.undoManager.add(),ed.nodeChanged(),tinyMCEPopup.close()},updateText:function(v){v||(v=$("#text").val()),/<\w+([^>]*)>/.test(v)?$("#caption_text").html(v):$("#caption_text").text(v)},updateCaption:function(){var k,v,$c=$("#caption"),$ct=$("#caption_text"),m=0,p=0;if($("#caption_image").attr("style",$("#style").val()),$("#text").val()){"top"==$("#text_position").val()?$ct.insertBefore("#caption_image"):$ct.insertAfter("#caption_image"),$ct.css("text-align",$("#text_align").val()),tinymce.each(["top","right","bottom","left"],function(o){v=$("#text_padding_"+o).val(),p+=parseInt(v),$ct.css("padding-"+o,/[^a-z]/i.test(v)?v+"px":v)}),0==p&&$ct.css("padding",""),$.each(["top","right","bottom","left"],function(i,o){v=$("#text_margin_"+o).val(),m+=parseInt(v),$ct.css("margin-"+o,/[^a-z]/i.test(v)?v+"px":v)}),0==m&&$ct.css("margin","");$("#text_color").val();$ct.css("color",function(){var v=$("#text_color").val();return v?"#"+v:""}),$ct.css("background-color",function(){var v=$("#text_bgcolor").val();return v?"#"+v:""}),$ct.html($("#text").val())}switch($c.css("background-color",function(){var v=$("#bgcolor").val();return v?"#"+v:""}),$.each(["width","color","style"],function(i,k){v="",$("#border").is(":checked")&&(v=$("#border_"+k).val()),"inherit"==v&&(v=""),"width"==k&&(v=/[^a-z]/i.test(v)?v+"px":v),"color"==k&&"#"!==v.charAt(0)&&(v="#"+v),$c.css("border-"+k,v)}),$.each(["top","right","bottom","left"],function(i,k){v=$("#padding_"+k).val(),v&&(p+=parseInt(v)),$c.css("padding-"+k,/[^a-z]/i.test(v)?v+"px":v)}),0==p&&$c.css("padding",""),$.each(["top","right","bottom","left"],function(i,k){v=$("#margin_"+k).val(),v&&(m+=parseInt(v)),v&&/[^\d]/i.test(v)===!1&&(v+="px"),$c.css("margin-"+k,v)}),0==m&&$c.css("margin",""),$c.css({float:"","vertical-align":""}),v=$("#align").val()){case"center":k={"margin-left":"auto","margin-right":"auto",display:"block"},v=null,$("#margin_left, #margin_right").val("auto");break;case"left":case"right":k="float";break;case"top":case"middle":case"bottom":k="vertical-align";break;default:"auto"===$("#margin_left").val()&&$("#margin_left").val(""),"auto"===$("#margin_right").val()&&$("#margin_right").val(""),k={"margin-left":$("#margin_left").val(),"margin-right":$("#margin_right").val(),display:""}}$c.css(k,v)},getAttrib:function(e,at){var v,ed=tinyMCEPopup.editor;switch(at){case"width":case"height":return ed.dom.getAttrib(e,at)||ed.dom.getStyle(e,at)||"";case"align":if(v=ed.dom.getAttrib(e,"align"))return v;if(v=ed.dom.getStyle(e,"float"))return v;if(v=ed.dom.getStyle(e,"vertical-align"))return v;if("auto"===ed.dom.getStyle(e,"margin-left")&&"auto"===ed.dom.getStyle(e,"margin-right"))return"center";break;case"margin-top":case"margin-bottom":case"padding-top":case"padding-bottom":if(v=ed.dom.getStyle(e,at))return/\d/.test(v)&&(v=v.replace(/[^-\d]+/g,"")),v;if(v=ed.dom.getAttrib(e,"vspace"))return parseInt(v.replace(/[^-\d]+/g,""));break;case"margin-left":case"margin-right":case"padding-left":case"padding-right":if(v=ed.dom.getStyle(e,at))return/\d/.test(v)&&(v=v.replace(/[^-\d]+/g,"")),v;if(v=ed.dom.getAttrib(e,"hspace"))return parseInt(v.replace(/[^\d]+/g,""));break;case"border-width":case"border-style":return v="",tinymce.each(["top","right","bottom","left"],function(n){var s=at.replace(/-/,"-"+n+"-"),sv=ed.dom.getStyle(e,s);(""!==sv||sv!=v&&""!==v)&&(v=""),sv&&(v=sv)}),""!==v&&$("#border").prop("checked",!0),"border-width"!=at&&"border-style"!=at||""!==v||(v="inherit"),"border-color"==at&&(v=Wf.String.toHex(v)),"border-width"==at&&/[0-9][a-z]/.test(v)&&(v=parseFloat(v)),v;case"color":case"border-color":case"background-color":return v=ed.dom.getStyle(e,at),Wf.String.toHex(v)}},setClasses:function(n,v){var $tmp=$("<span/>").addClass($("#"+n).val()).addClass(v);$("#"+n).val($tmp.attr("class"))},openHelp:function(){Wf.help("caption")}};tinyMCEPopup.onInit.add(CaptionDialog.init,CaptionDialog),window.CaptionDialog=CaptionDialog}(window,jQuery,tinymce,tinyMCEPopup);