<div class="container p-0">
    <a class="btn btn-primary mt-3 mb-3" href="<?php echo base_url('admin/categorii'); ?>"><i class="fas fa-arrow-left"></i> Inapoi la categorii</a>
    <h1 class="text-uppercase"><?php echo $categorie->nume; ?></h1>
    <div class="small"><b>Header: </b><?php echo $categorie->header; ?></div>
    <div class="small mb-2"><b>Footer: </b><?php echo $categorie->footer; ?></div>
    <div class="small mb-2"><b>Extra text: </b>
        <div><?php echo $categorie->aditional_info; ?></div>
    </div>
    <?php if($categorie->activ == 1): ?>
        <div class="alert alert-success">
            Aceasta categorie este activa!<br>
            Modificarile produselor vor fi vizibile in timp real pe site.
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            Aceasta categorie este inactiva!<br>
            Modificarile produselor din aceasta categorie vor fi vizbile dupa activarea categoriei.
        </div>
    <?php endif; ?>
    <hr>
    <div id="ajax-produse">Se incarca...</div>
</div>
<?php $produseID = $categorie->ID; ?>

<!-- Modal -->
<div class="modal fade" id="addProdModal" tabindex="-1" role="dialog" aria-labelledby="addProdModalLabel" aria-hidden="true" style="z-index: 99999;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProdModalLabel">Adauga produs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input id="permanent-cat-id" value="<?php echo $produseID; ?>" class="d-none">
                <?php echo form_open('admin/ajax/addCategory','id="adauga-produse-form"'); ?>
                <input id="catID-input" name="catID-input" type="number" class="d-none" value="<?php echo $produseID;?>">
                <input id="prodID-input" name="prodID-input" type="number" class="d-none">
                <div class="form-group">
                    <label for="nume-produs-input">Nume produs</label>
                    <input class="form-control" type="text" id="nume-produs-input" name="nume-produs-input" required autocomplete="off">
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="pret1-produs-input">Pret 1</label>
                            <input class="form-control" type="number" id="pret1-produs-input" name="pret1-produs-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="pret2-produs-input">Pret 2</label>
                            <input class="form-control" type="number" id="pret2-produs-input" name="pret2-produs-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="pret3-produs-input">Pret 3</label>
                            <input class="form-control" type="number" id="pret3-produs-input" name="pret3-produs-input" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gramaj-produs-input">Gramaj</label>
                    <input class="form-control" type="text" id="gramaj-produs-input" name="gramaj-produs-input" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="ingrediente-produs-input">Ingrediente</label>
                    <textarea class="form-control" id="ingrediente-produs-input" name="ingrediente-produs-input" rows="3"></textarea>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="picant" name="picant" value="1">
                    <label class="form-check-label" for="picant">Picant</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="special" name="special" value="1">
                    <label class="form-check-label" for="special">Special</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="nou" name="nou" value="1">
                    <label class="form-check-label" for="nou">Nou</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="livrabil" name="livrabil" value="1">
                    <label class="form-check-label" for="livrabil">Livrabil</label>
                </div>
                <?php echo form_close();?>
                <a id="gotospecial-link" href="" style="display: none">Adauga text special</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Anuleaza</button>
                <button type="button" class="btn btn-primary" id="adauga-produs-submit"><i class="fas fa-check"></i> Salveaza</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){

        var prodId =  <?php echo ($produseID); ?>;

        window.refreshProds = function refreshProds(){
            $('[data-toggle="tooltip"]').tooltip('hide');
            $.ajax({
                url: '<?php echo site_url('admin/ajax/getProduseById/'.$produseID); ?>'
            }).done(function(data){
                $('#ajax-produse').html(data);
                fasortabil();
                $('[data-toggle="tooltip"]').tooltip();
            })
        }

        refreshProds();

        window.openEditForm = function openEditForm(id){
            var catID = $('#permanent-cat-id').val();
            $('#adauga-produse-form')[0].reset();
            $('#prodID-input').val(id);
            $('#catID-input').val(catID);
            $('#addProdModal').modal();
            if(id>0){

                $('#addProdModalLabel').html('Editeaza produs');
                getProdDetails(id);
                //$('#gotospecial-link').show();
                //$('#gotospecial-link').prop("href", "<?php echo site_url(); ?>linktobechanged/" + id);

            } else {
                $('#addProdModalLabel').html('Adauga produs');
                $('#livrabil').prop('checked', true);
            }
        };

        window.getProdDetails = function getProdDetails(id){
            $.ajax({
                url: '<?php echo site_url("admin/ajax/getSingleProdById"); ?>',
                type: 'POST',
                data: {prodID: id}
            })
                .done(function(e){
                    var obj = jQuery.parseJSON(e);
                    console.log(obj);
                    $('#nume-produs-input').val(obj.nume);
                    $('#pret1-produs-input').val(obj.pret1);
                    $('#pret2-produs-input').val(obj.pret2);
                    $('#pret3-produs-input').val(obj.pret3);
                    $('#gramaj-produs-input').val(obj.gramaj);
                    $('#ingrediente-produs-input').val(obj.ingrediente);

                    if(obj.picant == 1){
                        $('#picant').prop('checked', true);
                    } else {
                        $('#picant').prop('checked', false);
                    }
                    if(obj.special == 1){
                        $('#special').prop('checked', true);
                    } else {
                        $('#special').prop('checked', false);
                    }
                    if(obj.nou == 1){
                        $('#nou').prop('checked', true);
                    } else {
                        $('#nou').prop('checked', false);
                    }
                    if(obj.livrabil == 1){
                        $('#livrabil').prop('checked', true);
                    } else {
                        $('#livrabil').prop('checked', false);
                    }
                })
        }

        $('#adauga-produs-submit').click(function(){
            $( "#adauga-produse-form" ).submit();
        });

        $( "#adauga-produse-form" ).submit(function(event){
            event.preventDefault();
            if($.trim($('#nume-produs-input').val()) == ""){
                $('#nume-produs-input').focus();
            } else {
                $.ajax({
                    url: '<?php echo site_url('admin/ajax/addOrEditProd'); ?>',
                    data: $('form#adauga-produse-form').serialize(),
                    type: 'post',
                    success: function (m) {
                        refreshProds();
                        $('#adauga-produse-form')[0].reset();
                        $('#addProdModal').modal('hide');
                    }
                })
            }
        });

        window.stergeProdus = function stergeProdus(id,nume){
            if (window.confirm("Sigur vrei sa stergi produsul: "+nume+"? Aceasta actiune nu poate fi revocata!")){
                $.ajax({
                    url: '<?php echo site_url("admin/ajax/stergeProdus");?>',
                    type: 'POST',
                    data: {prodID: id},
                })
                    .done(function() {
                        $("#item_"+id).remove();
                        $('[data-toggle="tooltip"]').tooltip('hide');
                    })
                    .fail(function() {
                        alert ("Eroare - nu am putut sterge produsul!");
                    });
            }
        }

        window.actdezactP = function actdezactP(id,newval){
            $.ajax({
                url: '<?php echo site_url("admin/ajax/actdezactP");?>',
                type: 'POST',
                data: {prodID: id, newval: newval},
            })
                .done(function() {
                    refreshProds();
                })
                .fail(function() {
                    alert ("A aparut o eroare - nu putem activa/dezactiva produsul.");
                });
        }


        $('#addProdModal').on('shown.bs.modal', function(e){
            $('#nume-produs-input').focus();
        });
        $('#addProdModal').on('hide.bs.modal', function(e){
            $('#gotospecial-link').hide();
        })

        /*
         * Close modal by back button
         * */
        window.onhashchange = function(){
            if(window.location.hash !=''){
                //
            } else {
                $('#addProdModal').modal('hide');
            }
        };

        window.fasortabil = function fasortabil(){
            $('#sortabil').sortable({
                handle: ".draga",
                update: function(event,ui){
                    var postData = $(this).sortable('serialize');
                    console.log(postData);
                    $.post("<?php echo base_url('admin/ajax/ordoneazaProduse'); ?>", {list: postData}, function(o){
                        console.log(o);
                    }, 'json');
                }
            });
        };

        window.liveSearch = function liveSearch() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("searchTableInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("tabel-produse");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

    });
    /*
     *Overlay de incarcare al paginii
     */
    $(document).ajaxStart(function(){
        $.LoadingOverlay("show", {
            image       : "",
            text        : "Se incarca..."
        });
    });
    $(document).ajaxStop(function(){
        $.LoadingOverlay("hide");
    });
</script>