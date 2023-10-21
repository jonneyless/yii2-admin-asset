$(document).ready(function () {
  // 窄版列表modal
  let $modalTemplateList = $('<div id="modal-list" class="modal fade" style="display: none;">').append($('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">').append($('<div class="modal-content">').append($('<div class="modal-header">').append($('<h3 class="modal-title" id="modal-list-title"></h3>')).append($('<button type="button" class="close" data-dismiss="modal" aria-label="Close">').append($('<span aria-hidden="true">').text('x')))).append($('<div class="modal-body">')).append($('<div class="modal-footer">').append($('<button type="button" class="btn btn-primary" data-dismiss="modal">').text('确定')))));
  // 宽版列表modal
  let $modalTemplateListLarge = $('<div id="modal-list-large" class="modal fade" style="display: none;">').append($('<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">').append($('<div class="modal-content">').append($('<div class="modal-header">').append($('<h3 class="modal-title" id="modal-list-title"></h3>')).append($('<button type="button" class="close" data-dismiss="modal" aria-label="Close">').append($('<span aria-hidden="true">').text('x')))).append($('<div class="modal-body">')).append($('<div class="modal-footer">').append($('<button type="button" class="btn btn-primary" data-dismiss="modal">').text('确定')))));
  // 详情modal
  let $modalTemplateDetail = $('<div id="modal-detail" class="modal fade" style="display: none;">').append($('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">').append($('<div class="modal-content">').append($('<div class="modal-body">'))));
  // Json modal
  let $modalTemplateJson = $('<div id="modal-json" class="modal fade" style="display: none;">').append($('<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">').append($('<div class="modal-content">').append($('<div class="modal-body">'))));
  // modal map
  let $modalTemplateMap = {
    "#modal-list": $modalTemplateList,
    "#modal-list-large": $modalTemplateListLarge,
    "#modal-detail": $modalTemplateDetail,
    "#modal-json": $modalTemplateJson
  };
  let ModalLink = $('a[data-act="modal"]');
  // 遍历页面初始化 modal
  ModalLink.each(function () {
    let target = $(this).data('target');
    let url = $(this).attr('href');
    $(this).data('modal-link', url).attr('href', 'javascript:;');
    if ($(target).length > 0) {
      return;
    }
    $('body').append($modalTemplateMap[target]);
    $(target).on('hidden.bs.modal', function (event) {
      $(target).find('.modal-title').text('');
      $(target).find('.modal-body').html('');
    });
  });
  // 弹窗按钮
  ModalLink.click(function () {
    let target = $(this).data('target');
    let title = $(this).attr('title');
    let url = $(this).data('modal-link');
    let content = $(this).data('modal-content');
    if (!title) {
      title = $(this).data('original-title');
    }
    if (target === '#modal-json') {
      eval("data = " + content);
      $(target).find('.modal-body').html(data);
      $(target).find('.modal-title').text(title);
      $(target).modal('show');
      $(target).find('.modal-body').beautifyJSON({
        type: "plain"
      });
    } else if (url && url !== 'javascript:;') {
      $.get(url, function (req) {
        if (req.code !== 0) {
          return;
        }
        if (req.data.html) {
          $(target).find('.modal-body').html(req.data.html);
        }
        $(target).find('.modal-title').text(title);
        $(target).modal('show');
      }, 'json');
    } else if (content) {
      $(target).find('.modal-body').html(content);
      if (title) {
        $(target).find('.modal-title').text(title);
      }
      $(target).modal('show');
    }
    return false;
  });
  // 复制按钮
  $(document).on('click', '[data-copy]', function () {
    let content = $(this).data('copy');
    let aux = document.createElement("input");
    aux.setAttribute("value", content);
    document.body.appendChild(aux);
    aux.select();
    document.execCommand("copy");
    document.body.removeChild(aux);
    toastr.success('复制成功');
  });
  // 导入按钮
  $(document).on('click', '[data-import]', function () {
    let url = $(this).data('import');
    let form = $('.data-import-form');
    if (form.length < 1) {
      form = $('<form>')
      .attr('class', 'data-import-form')
      .attr('method', 'post')
      .attr('enctype', 'multipart/form-data')
      .hide()
      .append($('<input>')
      .attr('type', 'file')
      .attr('name', 'file'));
      $('body').append(form);
    }
    form.attr('action', url);
    form.children('input').click().change(function () {
      let formData = new FormData();
      formData.append('file', $('.data-import-form > input[name=file]')[0].files[0]);
      $.ajax({
        url: url, type: 'POST', cache: false, data: formData, processData: false, contentType: false
      }).done(function (res) {
        form.remove();
      }).fail(function (res) {
        form.remove();
      });
    });
  });
  $('body').everyTime('5s', 'message-notify', function () {
    console.log('消息通知');
    $.post('/api/messages/notify', function (req) {
      if (req.code === 0 && req.data.items) {
        for (let i = 0; i < req.data.items.length; i++) {
          let type = req.data.items[i].type;
          let title = req.data.items[i].title;
          let message = req.data.items[i].message;
          if (type === 'success') {
            if (title) {
              toastr.success(message, title);
            } else {
              toastr.success(message);
            }
          } else if (type === 'info') {
            if (title) {
              toastr.info(message, title);
            } else {
              toastr.info(message);
            }
          } else if (type === 'warning') {
            if (title) {
              toastr.warning(message, title);
            } else {
              toastr.warning(message);
            }
          } else if (type === 'error') {
            if (title) {
              toastr.error(message, title);
            } else {
              toastr.error(message);
            }
          }
        }
      }
    }, 'json');
  });
});