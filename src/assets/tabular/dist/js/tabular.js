/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

(function ($) {
    $.fn.tabularWidget = function (options) {
        var _options = $.extend({
                selector: '.repeater',
                deleteMessage: 'Are you sure you want to delete this element?',
                minOverFlowMessage: 'You cann\'t remove element. Minimal count is :min:',
                maxOverFlowMessage: 'You cann\'t add element. Maximum count is :max:',
                messageShow: function (message, options, element) {
                    alert(message);
                },
                deletePrompt: function (message, options, element) {
                    return confirm(message);
                },
            }, options), i, $form,
            repeaterOptions = $.extend({
                // (Optional)
                // start with an empty list of repeaters. Set your first (and only)
                // "data-repeater-item" with style="display:none;" and pass the
                // following configuration flag
                initEmpty: false,
                // (Optional)
                // "defaultValues" sets the values of added items.  The keys of
                // defaultValues refer to the value of the input's name attribute.
                // If a default value is not specified for an input, then it will
                // have its value cleared.
                defaultValues: {
                    'text-input': ''
                },
                // (Optional)
                // "show" is called just after an item is added.  The item is hidden
                // at this point.  If a show callback is not given the item will
                // have $(this).show() called on it.
                show: function (a, b, c, d, e, f) {
                    $(this).slideDown();
                    var index = parseInt($(this).attr('tabular-index')),
                        options = _self.repeaterOptions[index];
                    $(this).find('has-error').removeClass('has-error');
                    $(this).find('help-block').empty();
                    options.lastIndex += 1;
                    $(this).data('tabular-index', options.lastIndex);

                    var validationList = _self.renameInputs(options, $(this).find('input, textarea, select, checkbox'), options.$form.find('[data-repeater-item]').length - 1);

                    if (typeof options.origin.max === 'number') {
                        var current = options.$form.find(':has([data-repeater-list]):first').find('[data-repeater-item]').length;

                        if (current > options.origin.max) {
                            _self.dropValidation(this, index, options, options.lastIndex);
                            options.origin.messageShow(options.origin.maxOverFlowMessage.replace(':max:', options.origin.max), options, this);
                            $(this).remove();

                            return;
                        }
                    }

                    _self.addValidators(validationList);
                },
                // (Optional)
                // "hide" is called when a user clicks on a data-repeater-delete
                // element.  The item is still visible.  "hide" is passed a function
                // as its first argument which will properly remove the item.
                // "hide" allows for a confirmation step, to send a delete request
                // to the server, etc.  If a hide callback is not given the item
                // will be deleted.
                hide: function (deleteElement) {
                    var index = $(this).attr('tabular-index'),
                        inputIndex = $(this).data('tabular-index'),
                        options = _self.repeaterOptions[index];

                    if (options.origin.deletePrompt(options.origin.deleteMessage, options, this)) {
                        if (typeof options.origin.min === 'number') {
                            var current = options.$form.find(':has([data-repeater-list]):first').find('[data-repeater-item]').length;
                            if (parseInt(options.origin.min) === current) {
                                options.origin.messageShow(options.origin.minOverFlowMessage.replace(':min:', options.origin.min), options, this);
                            }
                        }
                    }
                    _self.dropValidation(this, index, options, inputIndex);
                    $(this).slideUp(deleteElement);
                },
                // (Optional)
                // You can use this if you need to manually re-index the list
                // for example if you are using a drag and drop library to reorder
                // list items.
                ready: function (setIndexes) {
                    this.$form.yiiActiveForm([], []);
                    var options = this;
                    this.$form.find('[data-repeater-item]').each(function (index) {
                        $(this).attr('tabular-index', options.index);
                        $(this).data('tabular-index', index);
                        options.lastIndex = index;
                        _self.renameInputs(options, $(this).find('input, select, textarea, checkbox'), index);
                    })
                },
                // (Optional)
                // Removes the delete button from the first list item,
                // defaults to false.
                isFirstItemUndeletable: true
            }, _options.repeaterOptions);

        function findValidation(options, attribute) {
            options = options.origin;

            if (typeof options.clientValidation !== 'object') {
                return;
            }

            for (var i in options.clientValidation) {
                if (!options.clientValidation.hasOwnProperty(i) || (typeof options.clientValidation[i] !== 'object')) {
                    continue;
                }

                if (options.clientValidation[i].name === attribute) {
                    return options.clientValidation[i];
                }
            }
        }

        function findAttribute(attribute, $form) {
            var data = $form.data('yiiActiveForm');

            if (typeof data === 'undefined') {
                return false;
            }

            if (typeof data.attribute === 'undefined') {
                return false;
            }

            for (var i in data.attributes) {
                if (!data.attributes.hasOwnProperty(i)) {
                    continue;
                }

                if (data.aattributes[i].id === attribute) {
                    return true;
                }
            }

            return false;
        }

        this.addValidators = function (validators) {
            if (typeof validators === 'object' && validators.length) {
                for (var i in validators) {
                    if (validators.hasOwnProperty(i)) {
                        repeaterOptions.$form.yiiActiveForm('add', validators[i]);
                    }
                }
            }
        }

        this.renameInputs = function (options, $elements, index) {
            $elements = $elements || options.$form.find('input, textarea, select, checkbox');
            index = index || 0;
            var validations = [];

            $elements.each(function () {
                if (!$(this).data('origin-name')) {
                    return;
                }
                var inputData = getAttrData(this, options, index);

                inputData.$this.attr({
                    name: inputData.inputName,
                    id: inputData.id
                });

                if (inputData.$parent.hasClass(inputData._class)) {
                    inputData.$parent.removeClass(inputData._class);
                }

                inputData.$parent.addClass(inputData.parentClass);

                if (inputData.validation && !findAttribute(inputData.id, inputData.$form)) {
                    validation = inputData.validation || {};
                    validation.id = inputData.id;
                    validation.container = '.' + inputData.parentClass;
                    validation.input = '#' + inputData.id;
                    validations.push(validation);
                }
            });

            return validations;
        };

        function getAttrData(elem, options, index) {
            var $this = elem ? $(elem) : $(this),
                name = $this.attr('name'),
                originName = $this.attr('data-origin-name'),
                repeaterName = $(options.$form).find('[data-repeater-list]').eq(0).data('repeater-list'),
                additional = (options.origin.additionalName ? options.origin.additionalName : ''),
                inputName = repeaterName + (additional.length ? '[' + additional + '][' : '[')
                    + index.toString() + '][' + originName + ']',
                _class = 'field-' + additional.toLocaleLowerCase() + '-' + originName.toLowerCase(),
                $parent = $this.parent(),
                parentClass = 'field-' + repeaterName.toLowerCase() + '-' + (additional.length ? additional.toLowerCase() + '-' : '') + index + '-' + originName.toLowerCase(),
                validation = findValidation(options, originName),
                id = parentClass.replace('field-', '');

            return {
                $this: $this,
                $form: options.$form,
                name: name,
                originName: originName,
                repeaterName: repeaterName,
                additional: additional,
                inputName: inputName,
                _class: _class,
                $parent: $parent,
                parentClass: parentClass,
                validation: validation,
                id: id
            };
        }

        this.dropValidation = function (element, index, options, inputIndex) {
            $elements = $(element).find('input, textarea, select, checkbox');
            index = index || 0;

            $elements.each(function () {
                if (!$(this).data('origin-name')) {
                    return;
                }
                var inputData = getAttrData(this, options, inputIndex);

                options.$form.yiiActiveForm('remove', inputData.id);
            });
        };

        this.getOption = function (name) {
            return typeof _options[name] !== "undefined" ? _options[name] : null;
        };

        this.setOption = function (name, value) {
            if (typeof name === "undefined") {
                return;
            }

            _options[name] = value;
        };

        this.getRepeater = function (ind) {
            if (typeof _self.repeatersd[ind] === 'undefined') {
                return;
            }

            return this.repeaters[ind];
        };


        this.repeaters = [];
        this.repeaterOptions = [];
        this.$forms = $(_options.selector);

        var _self = this;

        clearAttributes = function () {
            var _break = false;
            if (_self.$forms.length) {
                _self.$forms.each(function (index) {
                    $form = $(this);

                    var $repeaters = $form.find('[data-repeater-item]');
                    $repeaters.attr('tabular-index', index);

                    repeaterOptions.$form = $form;
                    repeaterOptions.origin = _options;
                    repeaterOptions.index = index;
                    if (!$repeaters.length) {
                        _break = true;
                    }

                    $repeaters.each(function (index) {
                        $elements = $(this).find('input, textarea, select, checkbox');
                        index = index || 0;

                        $elements.each(function () {
                            if (!$(this).data('origin-name')) {
                                return;
                            }

                            var data = $form.data('yiiActiveForm');

                            _break = typeof data === 'object';
                            if (_break) {
                                clearInterval(interval);
                                var title = $(this).data('origin-name');
                                $form.yiiActiveForm('remove', $(this).attr('id'));
                                for (var i = 0; i < 5; i++) {
                                    $form.yiiActiveForm('remove', _options.repeaterName.toLowerCase() + '-' + _options.additionalName.toLowerCase() + '-' + index + '-' + title);
                                    $form.yiiActiveForm('remove', _options.additionalName.toLowerCase() + '-' + index + '-' + title);
                                    $form.yiiActiveForm('remove', options.additionalName.toLowerCase() + '-' + title);
                                }
                            }
                        });
                        _self.addValidators(_self.renameInputs(repeaterOptions, $elements, index));
                    });

                    if (_break) {
                        _self.repeaters.push($form.repeater(repeaterOptions));
                        _self.repeaterOptions.push(repeaterOptions);
                    }
                });
            }

            return _break;
        };

        var interval = setInterval(function () {
            clearAttributes();
        }, 30);

        return this;
    };
})(jQuery);