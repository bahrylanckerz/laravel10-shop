<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">Are you sure went delete data?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Data that has been deleted cannot be recovered.</div>
            <div class="modal-footer">
                <form id="formDelete" action="" method="post">
                    @csrf
                    <input type="hidden" name="_method" value="delete">
                    <button type="button" class="btn btn-secondary btn-icon-split" data-dismiss="modal">
                        <span class="icon text-white-50">
                            <i class="fas fa-times"></i>
                        </span>
                        <span class="text">Cancel</span>
                    </button>
                    <button type="submit" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-trash"></i>
                        </span>
                        <span class="text">Delete</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function modalDelete(id, url){
        var url = url;
        var newUrl = url.replace('ID', id);
        $('#formDelete').attr('action', newUrl);
        $('#modalDelete').modal('show');
    }
</script>