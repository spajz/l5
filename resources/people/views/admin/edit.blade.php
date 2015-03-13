<div id="pjax-container">

    {{ Former::horizontal_open_for_files()->route("admin.{$moduleLower}.update", $item->id)->method('put')->data_pjax() }}

    <div class="row">
        <div class="col-xs-12">
            <div class="widget-box">
                <div class="widget-title">
                            <span class="icon">
                                <i class="fa fa-align-justify"></i>
                            </span>
                    <h5>Base information</h5>
                </div>
                <div class="widget-content nopadding">

                    <div class="form-group">
                        <label for="status" class="control-label col-lg-2 col-md-3 col-sm-3">Status</label>
                        <div class="col-lg-10 col-md-9 col-sm-9">
                            <input class="form-control" id="email" type="text" name="email" value="{{ $status }}" disabled="disabled">
                        </div>
                    </div>

                    {{ Former::text('first_name') }}

                    {{ Former::text('last_name') }}

                    {{ Former::text('email') }}

                    {{ Former::text('phone') }}

                    {{ Former::text('age') }}

                    {{ Former::text('email2')->label('Email 2') }}

                    {{ Former::text('ip') }}

                    {{ Form::hidden('id', $item->id) }}

                    <div class="form-group">
                        <label for="status" class="control-label col-lg-2 col-md-3 col-sm-3">Image</label>
                        <div class="col-lg-10 col-md-9 col-sm-9">
                            <img src="{{ url('media/images/valentinesday/cards/original/' . $item->image) }}" class="img-responsive">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-md-offset-3 col-sm-offset-3 col-lg-10 col-md-9 col-sm-9">
                            <input class="btn btn-success btn-sm" type="submit" value="Save" name="save[edit]" data-pjax="1">&nbsp;
                            <input class="btn btn-success btn-sm" type="submit" value="Save & Exit" name="save[exit]">&nbsp;
                            <input class="btn btn-warning btn-sm" type="submit" value="Approve & Publish to Wall & Gallery" name="save[publish]" data-bb="submit">&nbsp;
                            <input class="btn btn-warning btn-sm" type="submit" value="Approve & Publish to Gallery" name="save[publish-gallery]" data-bb="submit">&nbsp;
                            <input class="btn btn-inverse btn-sm" type="submit" value="Reject" name="save[reject]" data-bb="submit">&nbsp;
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{ Former::close() }}

</div>