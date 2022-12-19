<div class="modal fade" tabindex="-1" id="followup_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Follow Up Email</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <form action="{{ route('leads.follow_mail') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="lead_email" class="lead_email">
                    <input type="hidden" name="lead_id" class="lead_id">
                    <textarea class="summernote email_content" name="email_content">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem similique earum necessitatibus nesciunt! Quia id expedita asperiores voluptatem odit quis fugit sapiente assumenda sunt voluptatibus atque facere autem, omnis explicabo.</textarea>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-primary" type="submit">Send Email</button>
                </div>
            </form>
        </div>
    </div>
</div>