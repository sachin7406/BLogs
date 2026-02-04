<div class="modal fade" id="blogModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="blogForm">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">New Blog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="blog_id">

                    <div class="mb-3">
                        <label>Blog Title</label>
                        <input type="text" id="title" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea id="description" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Reference Link</label>
                        <input type="text" id="reference_link" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select id="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="saveBtn">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </form>

        </div>
    </div>
</div>
