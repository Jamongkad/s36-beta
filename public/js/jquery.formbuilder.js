/**
 * jQuery Form Builder Plugin
 * Copyright (c) 2009 Mike Botsko, Botsko.net LLC (http://www.botsko.net)
 * http://www.botsko.net/blog/2009/04/jquery-form-builder-plugin/
 * Originally designed for AspenMSM, a CMS product from Trellis Development
 * Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * Copyright notice and license must remain intact for legal use
 */
(function ($) {
	$.fn.formbuilder = function (options) {
		// Extend the configuration options with user-provided
		var defaults = {
			save_url: false,
			load_url: false,
			control_box_target: false,
			serialize_prefix: 'frmb',
			messages: {
				save				: "Save",
				add_new_field		: "Add new field",
				text				: "Text Field",
				title				: "Title",
				paragraph			: "Paragraph",
				checkboxes			: "Checkboxes",
				radio				: "Radio",
				select				: "Select List",
				text_field			: "Text Field",
				label				: "Label",
				paragraph_field		: "Paragraph Field",
				select_options		: "Select Options",
				add					: "Add",
				checkbox_group		: "Checkbox Group",
				remove_message		: "Are you sure you want to remove this element?",
				remove				: "Remove",
				radio_group			: "Radio Group",
				selections_message	: "Allow Multiple Selections",
				hide				: "Hide",	
				show				: "Show"
			}
		};
		var opts = $.extend(defaults, options);
		var frmb_id = 'frmb-' + $('ul[id^=frmb-]').length++;

		return this.each(function () {
			var ul_box = $(this).append('<div class="form-builder-field-setup"></div>');
			var ul_obj = $('.form-builder-field-setup').append($(this).append('<ul id="' + frmb_id + '" class="frmb ui-sortable '+frmb_id+'"></ul>').find('ul'));
			var field = '', field_type = '', last_id = 1, help, form_db_id;
			// Add a unique class to the current element
			// load existing form data
			if (opts.load_url) {
				$.getJSON(opts.load_url, function(json) {
					form_db_id = json.form_id;
					fromJson(json.form_structure);
				});
			}
			// Create form control select box and add into the editor
			var controlBox = function (target) {
					var select = '';
					var box_content = '';
					var save_button = '';
					var box_id = frmb_id + '-control-box';
					var save_id = frmb_id + '-save-button';
					// Add the available options
					select += '<option value="0">' + opts.messages.add_new_field + '</option>';
					select += '<option value="input_text">' + opts.messages.text + '</option>';
					//select += '<option value="textarea">' + opts.messages.paragraph + '</option>';
					select += '<option value="checkbox">' + opts.messages.checkboxes + '</option>';
					select += '<option value="radio">' + opts.messages.radio + '</option>';
					select += '<option value="select">' + opts.messages.select + '</option>';
					// Build the control box and search button content
					box_content += '<div class="form-builder-field-selector"><div class="form-builder-select"><select id="' + box_id + '" class="frmb-control valid">' + select + '</select></div></div>';
					//save_button = '<input type="submit" id="' + save_id + '" class="frmb-submit" value="' + opts.messages.save + '"/>';
					// Insert the control box into page
					if (!target) {
						$(ul_obj).before(box_content);
					} else {
						$(target).append(box_content);
					}
					// Insert the search button
					//$(ul_obj).after(save_button);
					// Set the form save action
					$('#' + save_id).click(function () {
						save();
						return false;
					});
					// Add a callback to the select element
					$('#' + box_id).change(function () {
                        if($('.form-builder-field-setup ul li').length !== 3) { 
                            appendNewField($(this).val());
                            $(this).val(0).blur();
                            // This solves the scrollTo dependency
                            $('html, body').animate({
                                scrollTop: $('#frm-' + (last_id - 1) + '-item').offset().top
                            }, 500);
                            return false;
                        } else {
                        	$(this).val(0).blur();
                            alert("You can only create 3 custom fields.");
                        }

					});
				}(opts.control_box_target);
			// Json parser to build the form builder
			var fromJson = function (json) {
					var values = '';
					var options = false;
					// Parse json
					$(json).each(function () {
						// checkbox type
						if (this.cssClass === 'checkbox') {
							options = [this.title];
							values = [];
							$.each(this.values, function () {
								values.push([this.value, this.baseline]);
							});
						}
						// radio type
						else if (this.cssClass === 'radio') {
							options = [this.title];
							values = [];
							$.each(this.values, function () {
								values.push([this.value, this.baseline]);
							});
						}
						// select type
						else if (this.cssClass === 'select') {
							options = [this.title, this.multiple];
							values = [];
							$.each(this.values, function () {
								values.push([this.value, this.baseline]);
							});
						}
						else {
							values = [this.values];
						}
						appendNewField(this.cssClass, values, options, this.required);
					});
				};
			// Wrapper for adding a new field
			var appendNewField = function (type, values, options, required) {
					field = '';
					field_type = type;
					if (typeof (values) === 'undefined') {
						values = '';
					}
					switch (type) {
					case 'input_text':
						appendTextInput(values, required);
						break;
					case 'textarea':
						appendTextarea(values, required);
						break;
					case 'checkbox':
						appendCheckboxGroup(values, options, required);
						break;
					case 'radio':
						appendRadioGroup(values, options, required);
						break;
					case 'select':
						appendSelectList(values, options, required);
						break;
					}

                    //remove style when typing to make validation css disappear
                    $(document).delegate('#form-builder input', 'keyup', function() {
                        $(this).removeAttr('style');
                    }); 
				};
			// single line input type="text"
			var appendTextInput = function (values, required) {
					field += '<label>' + opts.messages.label + '</label>';
					field += '<input class="fld-title" id="title-' + last_id + '" type="text" value="' + values + '" maxlength="40"/>';
					help = '';
					appendFieldLi(opts.messages.text, field, required, help);
				};
			// multi-line textarea
			var appendTextarea = function (values, required) {
					field += '<label>' + opts.messages.label + '</label>';
					field += '<input type="text" value="' + values + '" />';
					help = '';
					appendFieldLi(opts.messages.paragraph_field, field, required, help);
				};
			// adds a checkbox element
			var appendCheckboxGroup = function (values, options, required) {
					var title = '';
					if (typeof (options) === 'object') {
						title = options[0];
					}
					field += '<div class="chk_group">';
					field += '<div class="frm-fld"><label>' + opts.messages.title + '</label>';
					field += '<input type="text" name="title" id="checkBoxGroup' + last_id + '" value="' + title + '" /></div>';
					field += '<div class="false-label">' + opts.messages.select_options + '</div>';
					field += '<div class="fields">';
					if (typeof (values) === 'object') {
						for (i = 0; i < values.length; i++) {
							field += checkboxFieldHtml(values[i]);
						}
					} else {
						field += checkboxFieldHtml('');
					}

					if(values.length >= 3 ) add_style = "display:none";
					else add_style = "";
					field += '<div class="add-area"><a href="#" class="add add_ck" style="'+add_style+'">' + opts.messages.add + '</a></div>';
					field += '</div>';
					field += '</div>';
					help = '';
					appendFieldLi(opts.messages.checkbox_group, field, required, help);
				};
			// Checkbox field html, since there may be multiple 
			var checkboxFieldHtml = function (values) {

					var checked = false; 
                    var subject_id = get_random_int(1, 100);
					var value = '';
					if (typeof (values) === 'object') {
						value = values[0];
						checked = ( values[1] === 'false' || values[1] === 'undefined' ) ? false : true;
					}
					field = '';
					field += '<div>';
					field += '<input type="checkbox"' + (checked ? ' checked="checked"' : '') + ' />';
					field += '<input type="text" id="checkbox' + subject_id + '" value="' + value + '" />';
					field += '<a href="#" class="remove_elm" title="' + opts.messages.remove_message + '">&nbsp;' + opts.messages.remove + '</a>';
					field += '</div>';
					return field;
				};
			// adds a radio element
			var appendRadioGroup = function (values, options, required) {
					var title = '';
					if (typeof (options) === 'object') {
						title = options[0];
					}
					field += '<div class="rd_group">';
					field += '<div class="frm-fld"><label>' + opts.messages.title + '</label>';
					field += '<input type="text" name="title" id="radioBoxGroup' + last_id + '" value="' + title + '" /></div>';
					field += '<div class="false-label">' + opts.messages.select_options + '</div>';
					field += '<div class="fields">';
					if (typeof (values) === 'object') {
						for (i = 0; i < values.length; i++) {
							field += radioFieldHtml(values[i], 'frm-' + last_id + '-fld');
						}
					}
					else {
						field += radioFieldHtml('', 'frm-' + last_id + '-fld');
					}

					if(values.length >= 3 ){add_style = "display:none"; }
					else{ add_style = "display:block"; }

					field += '<div class="add-area"><a href="#" class="add add_rd" style="'+add_style+'">' + opts.messages.add + '</a></div>';
					field += '</div>';
					field += '</div>';
					help = '';
					appendFieldLi(opts.messages.radio_group, field, required, help);
				};
			// Radio field html, since there may be multiple
			var radioFieldHtml = function (values, name) {
					var checked = false;
                    var subject_id = get_random_int(1, 100);
					var value = '';
					if (typeof (values) === 'object') {
						value = values[0];
						checked = ( values[1] === 'false' || values[1] === 'undefined' ) ? false : true;
					}
					field = '';
					field += '<div>';
					field += '<input type="radio"' + (checked ? ' checked="checked"' : '') + ' name="radio_' + name + '" />';
					field += '<input type="text" id="checkbox' + subject_id + '" value="' + value + '" />';
					field += '<a href="#" class="remove_elm" title="' + opts.messages.remove_message + '">&nbsp;' + opts.messages.remove + '</a>';
					field += '</div>';
					return field;
				};
			// adds a select/option element
			var appendSelectList = function (values, options, required) {
					var multiple = false;
					var title = '';
					if (typeof (options) === 'object') {
						title = options[0];
						multiple = options[1] === 'checked' ? true : false;
					}

					field += '<div class="opt_group">';
					field += '<div class="frm-fld"><label>' + opts.messages.title + '</label>';
					field += '<input type="text" name="title" id="selectBoxGroup' + last_id + '" value="' + title + '" /></div>';
					field += '';
					field += '<div class="false-label">' + opts.messages.select_options + '</div>';
					field += '<div class="fields">';
					field += '<input type="checkbox" name="multiple"' + (multiple ? 'checked="checked"' : '') + '>';
					field += '<label class="auto">' + opts.messages.selections_message + '</label>';
					if (typeof (values) === 'object') {
						for (i = 0; i < values.length; i++) {
							field += selectFieldHtml(values[i], multiple);
						}
					}
					else {
						field += selectFieldHtml('', multiple);
					}
					field += '<div class="add-area"><a href="#" class="add add_opt">' + opts.messages.add + '</a></div>';
					field += '</div>';
					field += '</div>';
					help = '';
					appendFieldLi(opts.messages.select, field, required, help);
				};
			// Select field html, since there may be multiple
			var selectFieldHtml = function (values, multiple) {
					if (multiple) {
						return checkboxFieldHtml(values);
					}
					else {
						return radioFieldHtml(values);
					}
				};
			// Appends the new field markup to the editor
			var appendFieldLi = function (title, field_html, required, help) {
					if (required) {
						required = required === 'checked' ? true : false;
					}
					var li = '';
					li += '<li id="frm-' + last_id + '-item" class="' + field_type + '">';
					li += '<div class="legend grids">';
					li += '<a id="frm-' + last_id + '" class="toggle-form" href="#">' + opts.messages.hide + '</a> ';
					li += '<a id="del_' + last_id + '" class="del-button delete-confirm" href="#" title="' + opts.messages.remove_message + '"><span>&nbsp;' + opts.messages.remove + '</span></a>';
					li += '<strong id="txt-title-' + last_id + '">' + title + '</strong></div>';
					li += '<div id="frm-' + last_id + '-fld" class="frm-holder">';
					li += '<div class="frm-elements">';
					li += field;
					li += '</div>';
					li += '</div>';
					li += '</li>';
					$('.form-builder-field-setup ul').append(li);
					$('#frm-' + last_id + '-item').hide();
					$('#frm-' + last_id + '-item').animate({
						opacity: 'show',
						height: 'show'
					}, 'slow');
					last_id++;
				};
			// handle field delete links
            $(document).delegate('.remove_elm', 'click', function(e) {
                var child = $(this).parents('.fields').children('div').children('input[type=text]').length;                
                if(child <= 3){
                	$($(this).parent()).parent().find('.add-area .add').show();
                }
                if(child == 1) {
                    alert('Must have atleast one element!');
                }else {
                    
                    $(this).parent('div').animate({
                        opacity: 'hide',
                        height: 'hide',
                        marginBottom: '0px'
                    }, 'fast', function () {
                        $(this).remove();
                    }); 

                }
			    e.preventDefault(); 
            });

			// handle field display/hide
			$('.toggle-form').live('click', function () {
				var target = $(this).attr("id");
				if ($(this).html() === opts.messages.hide) {
					$(this).removeClass('open').addClass('closed').html(opts.messages.show);
					$('#' + target + '-fld').animate({
						opacity: 'hide',
						height: 'hide'
					}, 'slow');
					return false;
				}
				if ($(this).html() === opts.messages.show) {
					$(this).removeClass('closed').addClass('open').html(opts.messages.hide);
					$('#' + target + '-fld').animate({
						opacity: 'show',
						height: 'show'
					}, 'slow');
					return false;
				}
				return false;
			});
			// handle delete confirmation
			$('.delete-confirm').live('click', function () {
				var delete_id = $(this).attr("id").replace(/del_/, '');
				if (confirm($(this).attr('title'))) {
					$('#frm-' + delete_id + '-item').animate({
						opacity: 'hide',
						height: 'hide',
						marginBottom: '0px'
					}, 'slow', function () {
						$(this).remove();
					});
				}
				return false;
			});
			// Attach a callback to add new checkboxes
            $(document).delegate('.add_ck', 'click', function(e) {
 
                var checkbox_child_count = $(this).parents('.fields').children('div').children('input[type=checkbox]').length;                
				$(this).parent().before(checkboxFieldHtml());
                checkbox_child_count += 1;
                if(checkbox_child_count == 3){
                	$(this).hide();
                }
				e.preventDefault();
            });

			// Attach a callback to add new options for select dropdowns
			$('.add_opt').live('click', function () {
				$(this).parent().before(selectFieldHtml('', false));
				return false;
			});
			// Attach a callback to add new radio fields
			$('.add_rd').live('click', function () {
                var radio_child_count = $(this).parents('.fields').children('div').children('input[type=radio]').length;
            	$(this).parent().before(radioFieldHtml(false, $(this).parents('.frm-holder').attr('id')));        
                radio_child_count += 1;
                if(radio_child_count == 3){
                	$(this).hide();
                }
				return false;
			});
			// saves the serialized data to the server 
			var save = function () {
					if (opts.save_url) {
						$.ajax({
							type: "POST",
							url: opts.save_url,
							data: $(ul_obj).serializeFormList({
								prepend: opts.serialize_prefix
							}) + "&form_id=" + form_db_id,
							success: function () {}
						});
					}
				};
		});
	};
})(jQuery);
/**
 * jQuery Form Builder List Serialization Plugin
 * Copyright (c) 2009 Mike Botsko, Botsko.net LLC (http://www.botsko.net)
 * Originally designed for AspenMSM, a CMS product from Trellis Development
 * Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * Copyright notice and license must remain intact for legal use
 * Modified from the serialize list plugin
 * http://www.botsko.net/blog/2009/01/jquery_serialize_list_plugin/
 */
(function ($) {
	$.fn.serializeFormList = function (options) {
		// Extend the configuration options with user-provided
		var defaults = {
			prepend: 'ul',
			is_child: false,
			attributes: ['class']
		};
		var opts = $.extend(defaults, options);
		if (!opts.is_child) {
			opts.prepend = '&' + opts.prepend;
		}
		var serialStr = '';
		// Begin the core plugin
		this.each(function () {
			var ul_obj = this;
			var li_count = 0;
			var c = 1;
			$(this).children().each(function () {

				for (att = 0; att < opts.attributes.length; att++) {
 
					var key = (opts.attributes[att] === 'class' ? 'cssClass' : opts.attributes[att]);
					serialStr += opts.prepend + '[' + li_count + '][' + key + ']=' + encodeURIComponent($(this).attr(opts.attributes[att]));
					// append the form field values
					if (opts.attributes[att] === 'class') {
						serialStr += opts.prepend + '[' + li_count + '][required]=' + encodeURIComponent($('#' + $(this).attr('id') + ' input.required').attr('checked'));
						serialStr += opts.prepend + '[' + li_count + '][groupId]=' + $(this).find('input').attr('id');
						switch ($(this).attr(opts.attributes[att])) {
						case 'input_text':
							serialStr += opts.prepend + '[' + li_count + '][values]=' + encodeURIComponent($('#' + $(this).attr('id') + ' input[type=text]').val());
							break;
						case 'textarea':
							serialStr += opts.prepend + '[' + li_count + '][values]=' + encodeURIComponent($('#' + $(this).attr('id') + ' input[type=text]').val());
							break;
						case 'checkbox':
							c = 1;
							$('#' + $(this).attr('id') + ' input[type=text]').each(function () {
								if ($(this).attr('name') === 'title') {
									serialStr += opts.prepend + '[' + li_count + '][title]=' + encodeURIComponent($(this).val());
								}
								else {
									serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][value]=' + encodeURIComponent($(this).val());
									serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][baseline]=' + $(this).prev().attr('checked');
									serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][id]=' + $(this).attr('id');
								}
								c++;
							});
							break;
						case 'radio':
							c = 1;
							$('#' + $(this).attr('id') + ' input[type=text]').each(function () {
								if ($(this).attr('name') === 'title') {
									serialStr += opts.prepend + '[' + li_count + '][title]=' + encodeURIComponent($(this).val());
								}
								else {
									serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][value]=' + encodeURIComponent($(this).val());
									serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][baseline]=' + $(this).prev().attr('checked');
									serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][id]=' + $(this).attr('id');
								}
								c++;
							});
							break;
						case 'select':
							c = 1;
							serialStr += opts.prepend + '[' + li_count + '][multiple]=' + $('#' + $(this).attr('id') + ' input[name=multiple]').attr('checked');
							$('#' + $(this).attr('id') + ' input[type=text]').each(function () {
								if ($(this).attr('name') === 'title') {
									serialStr += opts.prepend + '[' + li_count + '][title]=' + encodeURIComponent($(this).val());
								}
								else {
									serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][value]=' + encodeURIComponent($(this).val());
									serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][baseline]=' + $(this).prev().attr('checked');
									serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][id]=' + $(this).attr('id');
								}
								c++;
							});
							break;
						}
					}
				}
				li_count++;
			});
		});
		return (serialStr);
	};
})(jQuery);


function get_random_int(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
