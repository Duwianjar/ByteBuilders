<section class="space-y-6">
    <h2>
        Delete Depository
    </h2>

    <p class="mt-1">
        The depository cannot be deleted if there is still transaction history.
    </p>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal" {{ count($history) > 0 ? 'disabled' : '' }}>
        Delete {{ $depository->name }}
    </button>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('depositories.destroy', $depository->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Are you sure you want to delete your depository?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>Once this depository is deleted, all its resources and data will be permanently deleted.</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete {{ $depository->name }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
