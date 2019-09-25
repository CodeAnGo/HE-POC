<div class="modal fade" id="aws_setup_modal" tabindex="-1" role="dialog" aria-labelledby="AWS Integration Setup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('aws.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">AWS Integration Setup</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div style="text-align: center;">
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Access Key ID</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="input-group">
                                    <input name="access_key_id" type="text" class="form-control" value="" placeholder="" aria-describedby="basic-addon1" maxlength="20">
                                </div>
                                @error('access_key_id')
                                <span class="form-text text-danger">{{ $message }}</span>
                                @enderror
                                <span class="form-text text-muted">For help setting up Authenticator, <a href="#" class="kt-link">Click Here</a>.</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Secret Access Key</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="input-group">
                                    <input name="secret_access_key" type="text" class="form-control" value="" placeholder="" aria-describedby="basic-addon1" maxlength="40">
                                </div>
                                @error('secret_access_key')
                                <span class="form-text text-danger">{{ $message }}</span>
                                @enderror
                                <span class="form-text text-muted">For help setting up an AWS Access Key, <a href="https://docs.aws.amazon.com/IAM/latest/UserGuide/id_credentials_access-keys.html" class="kt-link">Click Here</a>.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Confirm Integration</button>
                </div>
            </form>
        </div>
    </div>
</div>
