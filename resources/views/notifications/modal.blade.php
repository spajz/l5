<div id="overlay-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content panel-:type">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">{{ $title or '&nbsp;' }}</h4>
            </div>

            <div class="modal-body">
                <p>:message</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
