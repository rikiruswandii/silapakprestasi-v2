/**
 * Current URL
 */
const current_url = window.location.href;

/**
 * DataTable Language
 * Indonesian
 */
let datatableLanguage = {
	'sEmptyTable': 'Tidak ada data yang tersedia pada tabel ini',
	'sProcessing': 'Sedang memproses...',
	'sLengthMenu': '_MENU_',
	'sZeroRecords': 'Tidak ditemukan data yang sesuai',
	'sInfo': '_START_-_END_ dari _TOTAL_',
	'sInfoEmpty': '0-0 dari 0',
	'sInfoFiltered': '',
	'sInfoPostFix': '',
	'sSearch': '',
	'searchPlaceholder': 'Cari ...',
	'sUrl': '',
	'oPaginate': {
		'sFirst': '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevrons-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="11 7 6 12 11 17"></polyline><polyline points="17 7 12 12 17 17"></polyline></svg>',
		'sPrevious': '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="15 6 9 12 15 18"></polyline></svg>',
		'sNext': '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="9 6 15 12 9 18"></polyline></svg>',
		'sLast': '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevrons-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="7 7 12 12 7 17"></polyline><polyline points="13 7 18 12 13 17"></polyline></svg>',
	},
};

function ckeditorError(error) {
	console.error('Oops, something went wrong!');
	console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
	console.warn('Build id: m9wt1741xirn-nohdljl880ze');
	console.error(error);
}

$(document).ready(function () {
	/**
	 * Toogle Show Password
	 */
	if ($('#show-password').length > 0) {
		$('#show-password').on('click', function (evt) {
			evt.preventDefault();

			let password = $(this).parent().parent().find('input[name="password"]');
			let type = password.attr('type');
			let submit = $('button[type="submit"]');

			if (type == 'password') {
				password.attr('type', 'text');
				submit.attr('disabled', 'disabled');
			} else {
				password.attr('type', 'password');
				submit.removeAttr('disabled');
			}
		});
	}

	/**
	 * Automatic Show Alert
	 */
	if ($('.notyf').length > 0) {
		const notyf = new Notyf();
		const $notyf = $('.notyf');

		let type = $notyf.data('type');
		let message = $notyf.data('message');
		let duration = $notyf.data('duration');
		let ripple = $notyf.data('ripple');
		let dismissible = $notyf.data('dismissible');
		let position = {
			x: $notyf.data('x'),
			y: $notyf.data('y')
		};

		if (type && message && duration) {
			notyf.open({
				type,
				message,
				duration,
				ripple,
				dismissible,
				position,
			});
		}
	}

	/**
	 * DataTable
	 */
	if ($('.datatable').length > 0) {
		const datatable = $('.datatable');
		const serverside = datatable.data('serverside');

		if (serverside) {
			datatable.DataTable({
				language: datatableLanguage,
				lengthMenu: [
					[10, 25, 50, 100, -1],
					[10, 25, 50, 100, 'Semua']
				],
				processing: true,
				serverSide: true,
				ajax: serverside,
				order: [],
				columns: dtColumn,
			});
		} else {
			datatable.DataTable({
				language: datatableLanguage,
				lengthMenu: [
					[10, 25, 50, 100, -1],
					[10, 25, 50, 100, 'Semua']
				],
			});
		}
	}

	/**
	 * Dropify
	 */
	if ($('.dropify').length > 0) {
		$('.dropify').dropify();
	}

	/**
	 * Select2
	 */
	$('.select2.tags').select2({
		theme: 'bootstrap-5',
		tags: true,
		dropdownParent: $('#modal-form')
	});

	$('.select2').on('select2:open', function () {
		$('.select2-search__field').focus();
	});

	/**
	 * Select2 Autofocus
	 */
	$(document).on('select2:open', () => {
		document.querySelector('.select2-search__field').focus();
	});

	/**
	 * Top offset for CKEditor 5
	 */
	let viewportTopOffset = 112;
	if (window.innerWidth <= 767) {
		viewportTopOffset = 56;
	}

	/**
	 * WatchDog for CKEditor 5
	 */
	try {
		const watchdog = new CKSource.EditorWatchdog();
		window.watchdog = watchdog;
		watchdog.setCreator((element, config) => {
			return CKSource.Editor
				.create(element, config)
				.then(editor => {
					return editor;
				});
		});
		watchdog.setDestructor(editor => {
			return editor.destroy();
		});
		watchdog.on('error', ckeditorError);
	} catch (err) { }

	/**
	 * CKEditor
	 * Full Toolbar
	 */
	if ($('.full-editor').length > 0) {
		watchdog.create(document.querySelector('.full-editor'), {
			mediaEmbed: {
				previewsInData: true
			},
			toolbar: {
				viewportTopOffset,
				shouldNotGroupWhenFull: true,
				items: [
					'fontsize',
					'fontcolor',
					'fontbackgroundcolor',
					'|',
					'bold',
					'italic',
					'underline',
					'strikethrough',
					'subscript',
					'superscript',
					'|',
					'link',
					'specialcharacters',
					'|',
					'bulletedList',
					'numberedList',
					'-',
					'alignment',
					'outdent',
					'indent',
					'|',
					'findandreplace',
					'|',
					'imageUpload',
					'blockQuote',
					'insertTable',
					'mediaEmbed',
					'|',
					'undo',
					'redo'
				]
			},
			language: 'id',
			image: {
				toolbar: [
					'imageTextAlternative',
					'imageStyle:inline',
					'imageStyle:block',
					'imageStyle:side'
				]
			},
			table: {
				contentToolbar: [
					'tableColumn',
					'tableRow',
					'mergeTableCells',
					'tableCellProperties',
					'tableProperties'
				]
			},
			licenseKey: '',
		}).catch(ckeditorError);
	}

	/**
	 * CKEditor
	 * Minimal Toolbar
	 */
	if ($('.minimal-editor').length > 0) {
		watchdog.create(document.querySelector('.minimal-editor'), {
			mediaEmbed: {
				previewsInData: true
			},
			toolbar: {
				viewportTopOffset,
				shouldNotGroupWhenFull: true,
				items: [
					'bold',
					'italic',
					'underline',
					'strikethrough',
					'subscript',
					'superscript',
					'|',
					'link',
					'specialcharacters',
					'|',
					'findandreplace',
					'|',
					'undo',
					'redo'
				]
			},
			language: 'id',
			image: {
				toolbar: [
					'imageTextAlternative',
					'imageStyle:inline',
					'imageStyle:block',
					'imageStyle:side'
				]
			},
			table: {
				contentToolbar: [
					'tableColumn',
					'tableRow',
					'mergeTableCells',
					'tableCellProperties',
					'tableProperties'
				]
			},
			licenseKey: '',
		}).catch(ckeditorError);
	}

	/**
	 * Litepicker
	 * Date Picker
	 */
	if ($('#datepicker').length > 0 && window.Litepicker) {
		new Litepicker({
			element: document.getElementById('datepicker'),
			buttonText: {
				previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>`,
				nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg>`
			}
		});
	}

	/**
	 * Magnific Popup
	 */
	if ($('.magnific-popup').length > 0) {
		$('a.magnific-popup').magnificPopup({
			type: 'image',
			closeOnContentClick: false,
			closeBtnInside: false,
			image: {
				verticalFit: true
			}
		});
	}

	/**
	 * CRUD Modal
	 */
	$(document).on('click', '.add-button', function (evt) {
		evt.preventDefault();

		let formSection = $('#modal-form form');
		let pageTitle = formSection.data('page');
		let insertAction = formSection.data('insert');

		formSection.find(':hidden').removeAttr('style');
		formSection.find('input:not([type="hidden"])').val('');
		formSection.find('select').val('').trigger('change');
		formSection.find('textarea').html('');
		formSection.find('input[type="radio"]').prop('checked', true);

		formSection.find('.modal-title').html('Tambah ' + pageTitle);
		formSection.attr('action', insertAction);
	});

	$(document).on('click', '.edit-button', function (evt) {
		evt.preventDefault();

		let formSection = $('#modal-form form');
		let pageTitle = formSection.data('page');
		let updateAction = formSection.data('update');

		let thisData = $(this).data();
		for (key in thisData) {
			if (key !== 'id' && key !== 'hidden') {
				let nameAttribute = '[name="' + key + '"]';
				let valueField = thisData[key];

				formSection.find('input' + nameAttribute).val(valueField);
				formSection.find('select' + nameAttribute).val(valueField).trigger('change');
				formSection.find('textarea' + nameAttribute).html(valueField);
				formSection.find('input[type="radio"]' + nameAttribute).prop('checked', valueField);
			}

			if (key === 'hidden') {
				let { hidden } = thisData;
				let field = hidden.split(',');

				for (input in field) {
					let nameAttribute = '[name="' + field[input] + '"]';

					formSection.find('input' + nameAttribute).parent().css('display', 'none');
					formSection.find('select' + nameAttribute).parent().css('display', 'none');
					formSection.find('textarea' + nameAttribute).parent().css('display', 'none');
					formSection.find('input[type="radio"]' + nameAttribute).parent().css('display', 'none');
				}
			}
		}

		formSection.find('.modal-title').html('Ubah ' + pageTitle);
		formSection.attr('action', updateAction + '/' + thisData.id);
	});

	$(document).on('click', '.delete-button', function (evt) {
		evt.preventDefault();

		let name = $(this).data('name');
		let url = $(this).data('url');

		$('.delete-modal-spesific-name').html(name);
		$('.delete-modal-do-delete').attr('action', url);
	});

	if ($('#modal-form').length > 0) {
		let formModal = document.getElementById('modal-form');

		formModal.addEventListener('hidden.bs.modal', function () {
			let formSection = $('#modal-form form');

			formSection.find(':hidden').removeAttr('style');
			formSection.find('input:not([type="hidden"])').val('');
			formSection.find('select').val('').trigger('change');
			formSection.find('textarea').html('');
			formSection.find('input[type="radio"]').prop('checked', true);

			formSection.find('.modal-title').html('');
			formSection.attr('action', '');
		});
	}

	if ($('#modal-danger').length > 0) {
		let deleteModal = document.getElementById('modal-danger');

		deleteModal.addEventListener('hidden.bs.modal', function () {
			$('.delete-modal-spesific-name').html('');
			$('.delete-modal-do-delete').attr('action', '');
		});
	}
});