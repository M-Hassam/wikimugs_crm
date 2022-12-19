<div class="modal fade" tabindex="-1" id="followup_comments_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Follow Up Remarks</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <form action="{{ route('leads.status') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="status" value="3">
                    <input type="hidden" name="lead_id" class="lead_id">
                    <input type="hidden" name="comment_check" class="comment_check" value="">
                    <textarea class="form-control" required="" name="comment"></textarea>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-primary" type="submit">Add Remarks</button>
                </div>
            </form>
        </div>
    </div>
</div>