var modal = (function($) {
	var curIndex = 0,
	btnArr = {
		close: $('<button type="button" data-dismiss="modal" class="btn btn-danger">关闭</button>'),
		ok: $('<button type="button" class="btn btn-primary">确定</button>'),
		yes: $('<button type="button" class="btn btn-success">是</button>'),
		no: $('<button type="button" class="btn btn-warning">否</button>'),
		accept: $('<button type="button" class="btn btn-info">接收</button>')
	}

	function init () {
		$.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner = 
	      '<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
	        '<div class="progress progress-striped active">' +
	          '<div class="progress-bar" style="width: 100%;"></div>' +
	        '</div>' +
	      '</div>';
		var modal = $('<div class="modal fade" tabindex="-1">')
					.append($('<div class="modal-header">')
						.append($('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'))
						.append($('<h4 class="modal-title"></h4>')))
					.append($('<div class="modal-body">'))
					.append($('<div class="modal-footer">'))
					.hide()
		$('body')
			.append(modal.attr('id', 'modal0'))
			.append(modal.clone().attr('id', 'modal1'))
			.append(modal.clone().attr('id', 'modal2'))
	}

	function modal (options) {
		var options = options || {
			title: '',
			message: '',
			btns: ['close']
		}
		var curModal = $('#modal' + curIndex)
		curIndex = ++curIndex % 3
		$('.modal').modal('hide')
		curModal.children('.modal-header').children('.modal-title').html(options.title || 'default')
		curModal.children('.modal-body').html(options.message || '')
		var btns = curModal.children('.modal-footer')
		btns.children().remove()
		$(btnArr).each(function(i) {
			if(i > 0) $(this).unbind()
		})
		for(var i in options.click || (options.click = [])) {
			btnArr[i].click(options.click[i])
		}
		for(var i in options.btns || (options.btns = ['close'])) {
			btns.append(btnArr[options.btns[i]])
		}
		curModal.modal('show')
	}
	init()
	return modal
})($)

var checkRedirect = function(json) {
	if(json && json.data && json.data.redirect)
		setTimeout(function() {
			window.location.href=json.data.redirect
		}, 5000)
}