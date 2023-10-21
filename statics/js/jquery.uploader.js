(function ($) {
  $.fn.uploader = function (opts) {
    let uploading = false;
    let isCancel = false;
    let queueItem = $('<div class="uploadifive-queue-item">\
                        <a class="close" href="#">X</a>\
                        <div>\
                            <span class="filename"></span> &nbsp; \
                            <span class="fileinfo">0%</span>\
                        </div>\
                        <div class="progress">\
                            <div class="progress-bar progress-bar-striped"></div>\
                        </div>\
                    </div>');
    let defaults = {
      auto: true,
      buttonText: '选择文件',
      buttonClass: 'btn btn-primary',
      fileObjName: 'file',
      fileSplitSize: 3 * 1024 * 1024,
      fileTypeExts: '',
      formData: {},
      queueItem: queueItem,
      queueID: '#queue-list',
      uploader: ''
    };
    let option = $.extend(defaults, opts);
    let formatFileSize = function (size, byKB) {
      if (size > 1024 * 1024 && !byKB) {
        size = (Math.round(size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
      } else {
        size = (Math.round(size * 100 / 1024) / 100).toString() + 'KB';
      }
      return size;
    };
    let getFileTypes = function (str) {
      let i = 0;
      let result = [];
      let data = str.split(";");
      let len = data.length;
      for (i; i < len; i++) {
        result.push(data[i].split(".").pop());
      }
      return result;
    };
    let mimetypeMap = {
      zip: ['application/x-zip-compressed'],
      jpg: ['image/jpeg'],
      png: ['image/png'],
      gif: ['image/gif'],
      doc: ['application/msword'],
      xls: ['application/msexcel'],
      docx: ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
      xlsx: ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
      ppt: ['application/vnd.ms-powerpoint '],
      pptx: ['application/vnd.openxmlformats-officedocument.presentationml.presentation'],
      mp3: ['audio/mp3'],
      mp4: ['video/mp4'],
      pdf: ['application/pdf'],
      apk: ['application/vnd.android']
    };
    let getMimetype = function (name) {
      return mimetypeMap[name];
    };
    let getAcceptString = function (str) {
      let i = 0;
      let types = getFileTypes(str);
      let result = [];
      let len = types.length;
      let mime;
      for (i; i < len; i++) {
        mime = getMimetype(types[i]);
        if (mime) {
          result.push(mime);
        }
      }
      return result.join(',');
    };
    let checkFile = function (file) {
      let arr = [];
      let types = getFileTypes(option.fileTypeExts);
      if (types.length > 0) {
        if ($.inArray(file.name.split('.').pop().toLowerCase(), types) < 0) {
          alert('文件 ' + file.name + ' 类型不允许！');
          return false;
        }
      }
      return true;
    };
    let sendPiece = function (index, total, file) {
      let start = (index - 1) * option.fileSplitSize;
      let end = Math.min(file.size, start + option.fileSplitSize);
      let form = new FormData;
      if (index === 0) {
        return;
      }
      if (index === total) {
        $(option.queueID).find('.fileinfo').append(' &nbsp; 最后处理中，请稍等...');
      }
      for (i in option.formData) {
        form.append(i, option.formData[i]);
      }
      form.append('index', index);
      form.append('total', total);
      form.append('name', file.name);
      form.append('size', file.size);
      form.append('lastModified', file.lastModified);
      form.append('cancel', isCancel ? 1 : 0);
      form.append('file', file.slice(start, end));
      $.ajax({
        url: option.uploader,
        type: 'POST',
        async: true,
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
          let next = data.next;
          let rate;
          if (data.error !== 0) {
            if (data.msg) {
              $(option.queueID).find('.fileinfo').text(data.msg);
            }
            return false;
          }
          if (data.cancel) {
            $(option.queueID).html('');
            uploading = false;
            isCancel = false;
            return true;
          }
          rate = (index / total * 10000) / 100;
          rate = rate.toFixed(2);
          $(option.queueID).find('.fileinfo').text(rate + '%');
          $(option.queueID).find('.progress-bar').css('width', rate + '%');
          if (index === total) {
            uploading = false;
            $(option.queueID).find('.fileinfo').text('上传完毕');
            $(option.queueID).find('.close').unbind('click');
            $(option.queueID).find('.close').click(function () {
              $(option.queueID).html('');
            });
            return true;
          }
          return sendPiece(next, total, file);
        }
      });
    };
    let fileInput = $(this);
    let button = $('<a href="javascript:;">').attr('class', option.buttonClass).text(option.buttonText);
    button.click(function () {
      $(this).prev('input').trigger('click');
    });
    fileInput.attr('accept', getAcceptString(option.fileTypeExts)).hide();
    fileInput.after(button).change(function (e) {
      let file = e.target.files[0];
      let fileItem = option.queueItem.clone();
      let filename = file.name;
      let filesize = file.size;
      let filepieces = Math.ceil(filesize / option.fileSplitSize);
      if (uploading) {
        alert('已有文件在上传中！');
        return false;
      }
      if (!checkFile(file)) {
        return false;
      }
      $(option.queueID).html(fileItem);
      fileItem.find('.filename').text(filename);
      fileItem.find('.fileinfo').text('0%');
      fileItem.find('.close').click(function () {
        $(option.queueID).find('.fileinfo').text('正在取消');
        isCancel = true;
      });
      uploading = true;
      sendPiece(1, filepieces, file);
    });
  }
})(jQuery);
