<!--Modal-->
<form role="form" method="GET" action="{{ route('admin.posts.index') }}" enctype="multipart/form-data">
    <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-filter"></i> Advanced search
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="title">Título</label>
                                <input class="form-control" name="title" id="title" type="text">
                            </div>
                        </div>
                    </div>
                    <!--OPCIONES--->
                    <div class="form-row">
                        <div class="form-group col-sm-3 offset-sm-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="published">Published</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" name="published" value="0" />
                                    <label class="c-switch c-switch-label c-switch-primary">
                                        <input class="c-switch-input" type="checkbox" name="published" id="published"
                                            value="1">
                                        <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="featured">Featured</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" name="featured" value="0" />
                                    <label class="c-switch c-switch-label c-switch-primary">
                                        <input class="c-switch-input" type="checkbox" name="featured"
                                            id="featured" value="1">
                                        <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
