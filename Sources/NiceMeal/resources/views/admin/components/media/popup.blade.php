<div id="{{$name}}-dz" class="row image-list">
</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{$name}}mediaModal">
    Upload Image
</button>

<div class="modal fade" id="{{$name}}mediaModal" tabindex="-1" role="dialog" aria-labelledby="mediaModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Image Management</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="height: auto;overflow-y: hidden">
                <div class="container">
                    <ul class="nav nav-tabs image-tab">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab"
                               href="#{{$name}}-upload">Upload</a>
                        </li>
                        <li class="nav-item image-tab">
                            <a id="{{$name}}-library-tab" class="nav-link" data-toggle="tab"
                               href="#{{$name}}-library">Library</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="{{$name}}-upload" class="tab-pane active">
                            <div class="control-group">
                                <label class="control-label">Upload your image</label>
                                <div class="col-sm-12">
                                    <div class="m-dropzone dropzone m-dropzone--primary" id="{{$name}}-dropzone">
                                        <div class="m-dropzone__msg dz-message needsclick">
                                            <h3 class="m-dropzone__msg-title">
                                                Drop file here or click to upload
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                {!! $errors->first('images', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close
                                    </button>
                                    <button type="button" class="btn btn-primary"
                                            id="{{$name}}_upload_image">Upload
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="{{$name}}-library" class="tab-pane fade in">
                            <label class="control-label">Choose your image</label>
                            <p class="text-danger" style="display: none">Max file has reach, please deselect another
                                file if you want to choose again...</p>
                            <div class="row">
                                <div class="col-12 scroll-image">
                                    <div id="image-wait" style="text-align: center; display: none;">
                                        <i class="fa fa-spinner fa-spin" style="font-size:50px"></i>
                                    </div>
                                    <div class="row checkbox-section {{$name}}-library-section scrollable-gallery">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close
                                </button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"
                                        id="{{$name}}_save_image">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('extra_scripts')
    @parent
    @include('admin.components.media.script')
@endsection
