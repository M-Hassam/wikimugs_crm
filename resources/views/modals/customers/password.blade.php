<div class="modal fade" tabindex="-1" id="change_password">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Password</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <form action="{{ route('customers.update_password') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="customer_id" class="customer_id">
                    <label class="form-label">Enter Password</label>
                    <input class="form-control" id="password" required="" type="text" name="password">
                    <label class="form-label">Confirm Password</label>
                    <input class="form-control" id="confirm_password" required="" type="text" name="password">
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-primary" id="update_pass_btn" type="submit">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>