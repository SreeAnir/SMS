<div class="modal" id="profileImgModal" tabindex="-1" aria-labelledby="profileImgModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileImgModalLabel">Profile Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex  justify-content-center">
                    <div class="text-secondary col-8">
                       <label> Please provide your photo with size 80 X 80 and less than 2MB for better view.</label>
                    </div>
                    <div class="text-center profile-img col-4">
                        <img id="previewImage" class="rounded-circle"  src="{{  auth()->user()->profile_photo_url}} "  alt="Profile Picture">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="update_confirm" type="button" class="btn btn-primary">Update Image</button>
                </div>
            </div>
        </div>
    </div>
</div>
