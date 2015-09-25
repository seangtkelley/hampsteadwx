@extends('layouts.master')

@section('title', 'Home')

@section('navbar-type', 'fixed-top')


@section('content')
  <script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.js"></script>
  <script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image-ios.js"></script>
  <script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image-orientation.js"></script>
  <script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image-meta.js"></script>
  <script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image-exif.js"></script>
  <script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image-exif-map.js"></script>
  <div class="container">
    <form action="{{route('summaries.submit')}}" enctype="multipart/form-data" method="POST">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
      <h2>Submit Summary</h2>
      <h4>Summary must be in .CSV format.</h4>

      <script>
        $(document).ready(function() {
          $(".monthSelect").select2({
            placeholder: "Select a Month"
          });
          $(".yearSelect").select2({
            placeholder: "Select a Year"
          });
          /*'use strict';
            // Change this to the location of your server-side upload handler:
            var url = '{{route('summaries.submit.handleFile')}}';
            uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)*
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });
            $('#fileupload').fileupload({
                url: url,
                dataType: 'json',
                autoUpload: false,
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                maxFileSize: 999000,
                // Enable image resizing, except for Android and Opera,
                // which actually support image resizing, but fail to
                // send Blob objects via XHR requests:
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                previewMaxWidth: 100,
                previewMaxHeight: 100,
                previewCrop: true
            }).on('fileuploadadd', function (e, data) {
                data.context = $('<div/>').appendTo('#files');
                $.each(data.files, function (index, file) {
                    var node = $('<p/>')
                            .append($('<span/>').text(file.name));
                    if (!index) {
                        node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                    }
                    node.appendTo(data.context);
                });
            }).on('fileuploadprocessalways', function (e, data) {
                var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
                if (file.preview) {
                    node
                        .prepend('<br>')
                        .prepend(file.preview);
                }
                if (file.error) {
                    node
                        .append('<br>')
                        .append($('<span class="text-danger"/>').text(file.error));
                }
                if (index + 1 === data.files.length) {
                    data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
                }
            }).on('fileuploadprogressall', function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }).on('fileuploaddone', function (e, data) {
                $.each(data.result.files, function (index, file) {
                    if (file.url) {
                        var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                        $(data.context.children()[index])
                            .wrap(link);
                    } else if (file.error) {
                        var error = $('<span class="text-danger"/>').text(file.error);
                        $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                    }
                });
            }).on('fileuploadfail', function (e, data) {
                $.each(data.files, function (index) {
                    var error = $('<span class="text-danger"/>').text('File upload failed.');
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                });
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');*/
        });
      </script>
      <div class="row betterRow">
        <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <!-- The file upload form used as target for the file upload widget
          <span class="btn btn-success fileinput-button">
          <i class="glyphicon glyphicon-plus"></i>
          <span>Add files...</span>
          <!-- The file input field used as target for the file upload widget
          <input id="fileupload" type="file" name="files[]" multiple>
          </span>
          <br>
          <br>
          <!-- The global progress bar
          <div id="progress" class="progress">
              <div class="progress-bar progress-bar-success"></div>
          </div>
          <!-- The container for the uploaded files
          <div id="files" class="files"></div>
        </div>-->

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 30px;"><h4>CSV Summary:</h4></div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 30px;"></div>
        <input id="fileupload" class="col-xs-12 col-sm-12 col-md-4 col-lg-4" type="file" name="csvFile" />
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="min-height: 30px;" ></div>


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 30px;"><h4>Date:</h4></div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 30px;"></div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
          <select class="monthSelect" name="month" style="width: 100%">
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
          </select>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
          <select class="yearSelect" name="year" style="width: 100%">
            <option value="2011">2011</option>
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
          </select>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 30px;"></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 30px;"><h4>Password:</h4></div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 30px;"></div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="min-height: 30px;">
          <input type="password" name="password" class="form-control" placeholder="Enter Password" />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 30px;" ></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 30px;"></div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
          <input type="submit" name="submit" id="submit" class="btn btn-success" style="width: 100%" value="Calculate Summary" />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" style="min-height: 30px;"></div>

      </div>
    </form>
  </div>
@endsection
