/**
 * Stridewel International - Admin Dashboard Custom Enhancements (CMS 2.0)
 * Global Select2, CKEditor 5, Modal/Toast Bootstrap Compatibility Shims
 */

// Global Bootstrap 5 to Bootstrap 4 Compatibility Shim
(function() {
    if (typeof window.bootstrap === 'undefined') {
        window.bootstrap = {};
    }
    if (!window.bootstrap.Modal) {
        window.bootstrap.Modal = function(element, options) {
            this.element = typeof element === 'string' ? document.querySelector(element) : element;
            this.show = function() { if (window.jQuery && this.element) window.jQuery(this.element).modal('show'); };
            this.hide = function() { if (window.jQuery && this.element) window.jQuery(this.element).modal('hide'); };
            this.toggle = function() { if (window.jQuery && this.element) window.jQuery(this.element).modal('toggle'); };
        };
        window.bootstrap.Modal.getInstance = function(element) {
            return new window.bootstrap.Modal(element);
        };
        window.bootstrap.Modal.getOrCreateInstance = function(element, options) {
            return new window.bootstrap.Modal(element, options);
        };
    }
    if (!window.bootstrap.Toast) {
        window.bootstrap.Toast = function(element, options) {
            this.element = typeof element === 'string' ? document.querySelector(element) : element;
            this.options = options || { delay: 3000 };
            this.show = function() {
                if (!this.element) return;
                var $el = window.jQuery ? window.jQuery(this.element) : null;
                if ($el && typeof $el.toast === 'function' && typeof $el.toast.Constructor !== 'undefined') {
                    $el.toast(this.options).toast('show');
                } else {
                    this.element.classList.add('show');
                    var el = this.element;
                    var delay = (this.options && this.options.delay) || 3000;
                    clearTimeout(window._bsToastTimer);
                    window._bsToastTimer = setTimeout(function() {
                        if (el) el.classList.remove('show');
                    }, delay);
                }
            };
            this.hide = function() {
                if (!this.element) return;
                var $el = window.jQuery ? window.jQuery(this.element) : null;
                if ($el && typeof $el.toast === 'function' && typeof $el.toast.Constructor !== 'undefined') {
                    $el.toast('hide');
                } else {
                    this.element.classList.remove('show');
                }
            };
        };
        window.bootstrap.Toast.getInstance = function(element) {
            return new window.bootstrap.Toast(element);
        };
        window.bootstrap.Toast.getOrCreateInstance = function(element, options) {
            return new window.bootstrap.Toast(element, options);
        };
    }

    // Global Admin Toast Notification Helper
    window.showAdminToast = function(message, isSuccess = true) {
        var toastEl = document.getElementById('crudToast');
        var toastMsg = document.getElementById('crudToastMessage');
        var toastIcon = document.getElementById('crudToastIcon');
        if (toastEl) {
            if (toastMsg) toastMsg.textContent = message;
            if (toastIcon) {
                toastIcon.className = isSuccess ? 'fa-solid fa-circle-check text-success fs-5' : 'fa-solid fa-circle-xmark text-danger fs-5';
            }
            toastEl.classList.add('show');
            clearTimeout(window._adminToastTimer);
            window._adminToastTimer = setTimeout(function() {
                toastEl.classList.remove('show');
            }, 3500);
        }
        if (window.jQuery && typeof window.jQuery.toast === 'function') {
            try {
                window.jQuery.toast({
                    heading: isSuccess ? 'Success' : 'Notice',
                    text: message,
                    icon: isSuccess ? 'success' : 'error',
                    position: 'top-right',
                    loader: true,
                    loaderBg: isSuccess ? '#10b981' : '#ef4444',
                    hideAfter: 3500,
                    stack: 5
                });
            } catch(e) {}
        }
    };
})();

(function($) {
    'use strict';

    window.initAdminSelect2 = function(context) {
        if (typeof $.fn.select2 === 'undefined') {
            return;
        }

        var $scope = context ? $(context) : $(document);
        
        $scope.find('select:not(.no-select2):not(.sw-select)').each(function() {
            var $select = $(this);
            if ($select.hasClass('select2-hidden-accessible') || $select.data('select2')) {
                return;
            }

            var placeholder = $select.attr('placeholder') || $select.data('placeholder') || 'Search or select...';
            var allowClear = $select.data('allow-clear') === true || $select.data('allow-clear') === 'true';
            var isModal = $select.closest('.modal').length > 0;

            var config = {
                width: '100%',
                dropdownAutoWidth: false,
                placeholder: placeholder,
                allowClear: allowClear,
                minimumResultsForSearch: 0
            };

            // Fix z-index and positioning inside Bootstrap modals
            if (isModal) {
                config.dropdownParent = $select.closest('.modal');
            }

            $select.select2(config);
        });
    };

    // Global instances storage
    window.ckeditor5Instances = window.ckeditor5Instances || {};

    // Helper to initialize CKEditor 5 on a specific textarea element
    window.initCKEditor5OnElement = function(el) {
        if (!el || el.dataset.ckeditorInitialized === 'true') {
            return;
        }

        var id = el.id;
        if (!id) {
            id = 'ck_' + (el.name || 'editor') + '_' + Math.random().toString(36).substring(2, 7);
            el.id = id;
        }

        // 1. If CKEditor 5 Super-Build is available
        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.ClassicEditor) {
            el.dataset.ckeditorInitialized = 'true';
            
            var config = {
                toolbar: {
                    items: [
                        'sourceEditing', '|',
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', 'code', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', 'alignment', '|',
                        'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'undo', 'redo', 'showBlocks'
                    ],
                    shouldNotGroupWhenFull: true
                },
                removePlugins: [
                    'AIAssistant', 'CKBox', 'CKFinder', 'EasyImage', 'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges', 'RealTimeCollaborativeRevisionHistory', 'PresenceList',
                    'Comments', 'TrackChanges', 'TrackChangesData', 'RevisionHistory', 'Pagination', 'WProofreader',
                    'MathType', 'SlashCommand', 'Template', 'DocumentOutline', 'FormatPainter', 'TableOfContents',
                    'PasteFromOfficeEnhanced', 'CaseChange', 'MultiLevelList'
                ],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn', 'tableRow', 'mergeTableCells',
                        'tableProperties', 'tableCellProperties'
                    ]
                },
                placeholder: 'Compose rich corporate content here...'
            };

            CKEDITOR.ClassicEditor.create(el, config)
                .then(function(editor) {
                    window.ckeditor5Instances[id] = editor;
                    
                    // Maintain backward-compatibility with legacy CKEDITOR.instances[id]
                    if (!CKEDITOR.instances) CKEDITOR.instances = {};
                    CKEDITOR.instances[id] = {
                        getData: function() { return editor.getData(); },
                        setData: function(data) { editor.setData(data); },
                        editor: editor
                    };

                    // Auto sync data to textarea on every change
                    editor.model.document.on('change:data', function() {
                        el.value = editor.getData();
                    });

                    // Ensure form submission always transmits latest editor HTML
                    if (el.form) {
                        $(el.form).on('submit', function() {
                            el.value = editor.getData();
                        });
                    }
                })
                .catch(function(error) {
                    console.warn('CKEditor 5 init failed on #' + id, error);
                    el.dataset.ckeditorInitialized = 'false';
                });
        } 
        // 2. Fallback to CKEditor 4 if CKEditor 5 is not loaded
        else if (typeof CKEDITOR !== 'undefined' && typeof CKEDITOR.replace === 'function') {
            if (!CKEDITOR.instances[id]) {
                try {
                    el.dataset.ckeditorInitialized = 'true';
                    CKEDITOR.replace(id, {
                        height: 220,
                        toolbar: 'Full'
                    });
                } catch(e) {
                    console.warn('CKEditor 4 fallback error on #' + id, e);
                }
            }
        }
    };

    // Override or setup CKEDITOR.replace for CKEditor 5 compatibility
    if (typeof CKEDITOR !== 'undefined' && CKEDITOR.ClassicEditor) {
        window._originalCKEditorReplace = CKEDITOR.replace;
        CKEDITOR.replace = function(elementOrId) {
            var target = typeof elementOrId === 'string' ? document.getElementById(elementOrId) : elementOrId;
            if (target) {
                window.initCKEditor5OnElement(target);
            }
        };
    }

    window.initAdminCKEditor = function(context) {
        var $scope = context ? $(context) : $(document);
        // Only initialize CKEditor on textareas explicitly marked for rich-text articles/blogs/stories
        $scope.find('textarea.ckeditor, textarea[data-ckeditor="true"], textarea.rich-editor, textarea[id^="editor"], textarea#b_detail, textarea#story_content').each(function() {
            var $el = $(this);
            // Never initialize on plain inputs, short descriptions, or elements with no-ckeditor
            if ($el.hasClass('no-ckeditor') || $el.data('no-ckeditor') === true || $el.attr('no-ckeditor')) {
                return;
            }
            if ($el.attr('rows') === '1' || $el.attr('rows') === '2' || $el.attr('rows') === '3') {
                return;
            }
            window.initCKEditor5OnElement(this);
        });
    };

    $(document).ready(function() {
        // 1. Initialize Select2 on document ready
        window.initAdminSelect2();

        // 2. Initialize CKEditor on document ready
        window.initAdminCKEditor();

        // 3. Re-initialize Select2 & CKEditor when Bootstrap modals are opened
        $(document).on('shown.bs.modal', function(e) {
            window.initAdminSelect2(e.target);
            window.initAdminCKEditor(e.target);
        });

        // 3. File Input helper: show chosen filename in feedback if present
        $(document).on('change', 'input[type="file"]', function() {
            var files = this.files;
            if (files && files.length > 0) {
                var fileName = files[0].name;
                var $help = $(this).siblings('.file-selected-name');
                if ($help.length === 0) {
                    $help = $('<div class="file-selected-name small text-success fw-bold mt-1"><i class="fa-solid fa-file-image me-1"></i> Selected: <span></span></div>');
                    $(this).after($help);
                }
                $help.find('span').text(fileName + ' (' + (files[0].size / 1024).toFixed(1) + ' KB)');
            }
        });

        // 4. Fallback for Bootstrap 4 / 5 dropdown toggling
        $(document).on('click', '[data-toggle="dropdown"], [data-bs-toggle="dropdown"]', function(e) {
            var $parent = $(this).closest('.dropdown');
            if ($parent.length) {
                setTimeout(function() {
                    if (!$parent.hasClass('show') && !$parent.hasClass('open')) {
                        $parent.addClass('show open');
                        $parent.find('.dropdown-menu').addClass('show');
                    }
                }, 50);
            }
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown.show, .dropdown.open').removeClass('show open').find('.dropdown-menu.show').removeClass('show');
            }
        });

        // 5. Bootstrap 4 / 5 Modal Compatibility
        $(document).on('click', '[data-bs-dismiss="modal"], [data-dismiss="modal"], .modal-close-btn, .close, .btn-close', function(e) {
            e.preventDefault();
            $(this).closest('.modal').modal('hide');
        });
        $(document).on('click', '[data-bs-toggle="modal"], [data-toggle="modal"]', function(e) {
            var target = $(this).attr('data-bs-target') || $(this).attr('data-target') || $(this).data('bsTarget') || $(this).data('target') || $(this).attr('href');
            if (target && $(target).length) {
                e.preventDefault();
                $(target).modal('show');
            }
        });

        // 5.1 Bootstrap 4 / 5 Tab Compatibility
        $(document).on('click', '[data-bs-toggle="tab"], [data-toggle="tab"], [data-bs-toggle="pill"], [data-toggle="pill"]', function(e) {
            e.preventDefault();
            if (typeof $.fn.tab === 'function') {
                $(this).tab('show');
            }
        });

        // 6. Sidebar Hover Expand & Content Shift Interactivity
        var $sidebar = $('#sidebar, .sidebar');
        var $pageContainer = $('#page-container');
        var $content = $('#content.content');

        // Smooth Mouse Enter / Leave expanding & auto-shifting right content section
        $sidebar.on('mouseenter', function() {
            $(this).addClass('sidebar-expanded');
            $pageContainer.addClass('sidebar-expanded');
            if ($(window).width() >= 768) {
                $content.css('margin-left', '250px');
            }
        }).on('mouseleave', function() {
            $(this).removeClass('sidebar-expanded');
            $pageContainer.removeClass('sidebar-expanded');
            if ($(window).width() >= 768) {
                $content.css('margin-left', '68px');
            }
        });

        // Submenu Accordion / Dropdown Toggle (Parent items ONLY toggle submenus, NO navigation)
        $(document).on('click', '.sidebar .has-sub > a, .sidebar-parent-toggle', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var $parentLi = $(this).closest('li.has-sub');
            var $subMenu = $parentLi.children('.sub-menu');
            var isExpanded = $parentLi.hasClass('expand') || $parentLi.hasClass('active');

            // Force sidebar and content to stay expanded during interaction
            $sidebar.addClass('sidebar-expanded');
            $pageContainer.addClass('sidebar-expanded');
            if ($(window).width() >= 768) {
                $content.css('margin-left', '250px');
            }

            if (isExpanded) {
                $subMenu.stop(true, true).slideUp(220, function() {
                    $parentLi.removeClass('expand active');
                });
            } else {
                // Close other open submenus for a clean accordion effect
                $parentLi.siblings('.has-sub').removeClass('expand active').children('.sub-menu').stop(true, true).slideUp(220);

                $parentLi.addClass('expand active');
                $subMenu.stop(true, true).slideDown(220);
            }
        });

        // Mobile Sidebar Toggle support
        $(document).on('click', '[data-click="sidebar-toggled"]', function(e) {
            e.preventDefault();
            $('#page-container').toggleClass('page-sidebar-toggled');
            $sidebar.toggleClass('sidebar-expanded');
        });
    });
})(jQuery);
