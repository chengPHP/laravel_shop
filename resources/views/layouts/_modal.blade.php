<!-- Large modal -->
<div class="modal bs-example-modal-lg  animated bounceInDown" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="progress m-b-none">
                <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    <span class="sr-only">100% Complete</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- md-modal -->
<div class="modal bs-example-modal-md  animated bounceInDown"  role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="progress m-b-none">
                <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    <span class="sr-only">100% Complete</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!--sm-modal -->
<div class="modal bs-example-modal-sm  animated bounceInDown"  role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="progress m-b-none">
                <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    <span class="sr-only">100% Complete</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('body').on('hidden.bs.modal','.modal',function(e){
            $(this).removeData();
        });
        // $('body').on('hidden.bs.modal','.bs-example-modal-md',function(e){
        //     $(this).removeData("bs.modal");
        // });
    });
</script>