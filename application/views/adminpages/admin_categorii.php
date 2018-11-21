
<div class="container p-0">
    <h1>Categorii</h1>
    <hr>
    <div id="ajax-categorii">Se incarca...</div>
</div>

<!-- Modal -->
<div class="modal fade" id="addCatModal" tabindex="-1" role="dialog" aria-labelledby="addCatModalLabel" aria-hidden="true" style="z-index: 99999;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCatModalLabel">Adauga categorie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open('admin/ajax/addCategory','id="adauga-categorie-form"'); ?>
                <input id="catID-input" name="catID-input" type="number" class="d-none">
                <div class="form-group">
                    <label for="nume-categorie-input">Nume categorie</label>
                     <input class="form-control" type="text" id="nume-categorie-input" name="nume-categorie-input" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="header-form-cat">Header</label>
                    <textarea class="form-control" id="header-categorie-input" name="header-categorie-input" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="footer-form-cat">Footer</label>
                    <textarea class="form-control" id="footer-categorie-input" name="footer-categorie-input" rows="3"></textarea>
                </div>
                <?php echo form_close();?>
                <a id="gotospecial-link" href="" style="display: none">Adauga text special</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Anuleaza</button>
                <button type="button" class="btn btn-primary" id="adauga-categorie-submit"><i class="fas fa-check"></i> Salveaza</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){

        window.refreshCat = function refreshCat(){
            $('[data-toggle="tooltip"]').tooltip('hide');
            $.ajax({
                url: '<?php echo base_url();?>admin/ajax/getCategoriiAll?' + Math.random()
            }).done(function(data){
                $('#ajax-categorii').html(data);
                fasortabil();
                $('[data-toggle="tooltip"]').tooltip();
            })
        };

        refreshCat();

        window.fasortabil = function fasortabil(){
            $('#sortabil').sortable({
                handle: ".draga",
                update: function(event,ui){
                    var postData = $(this).sortable('serialize');
                    console.log(postData);
                    $.post("<?php echo base_url('admin/ajax/ordoneazaCategorii'); ?>", {list: postData}, function(o){
                        //console.log(o);
                    }, 'json');
                }
            });
        };

        window.openEditForm = function openEditForm(id){
            $('#adauga-categorie-form')[0].reset();
            $('#catID-input').val(id);
            $('#addCatModal').modal();
            if(id>0){
                $('#addCatModalLabel').html('Editeaza categorie');
                getCatDetails(id);
                $('#gotospecial-link').show();
                $('#gotospecial-link').prop("href", "<?php echo site_url(); ?>admin/textEditor/categorii/" + id);
            } else {
                $('#addCatModalLabel').html('Adauga categorie');
            }
        }

        $('#addCatModal').on('shown.bs.modal', function(e){
            $('#nume-categorie-input').focus();
        })
        $('#addCatModal').on('hide.bs.modal', function(e){
            $('#gotospecial-link').hide();
        })

        window.getCatDetails = function getCatDetails(id){
            $.ajax({
                url: '<?php echo site_url("admin/ajax/getCatDetails"); ?>',
                type: 'POST',
                data: {catID: id}
            })
                .done(function(e){
                    var obj = jQuery.parseJSON(e);
                    //console.log(obj);
                    $('#nume-categorie-input').val(obj.nume);
                    $('#header-categorie-input').val(obj.header);
                    $('#footer-categorie-input').val(obj.footer);
                })
        }

        $('#adauga-categorie-submit').click(function(){
            $( "#adauga-categorie-form" ).submit();
        })

        $( "#adauga-categorie-form" ).submit(function( event ) {
            event.preventDefault();
            if($.trim($('#nume-categorie-input').val()) == ""){
                $('#nume-categorie-input').focus();
            } else {
                $.ajax({
                    url: '<?php echo site_url('admin/ajax/addOrEditCategory'); ?>',
                    data: $('form#adauga-categorie-form').serialize(),
                    type: 'post',
                    success: function(m){
                        refreshCat();
                        $('#adauga-categorie-form')[0].reset();
                        $('#addCatModal').modal('hide');
                    }
                })
            }
        });

        /*
         * Close modal by back button
         * */
        window.onhashchange = function(){
            if(window.location.hash !=''){
                //
            } else {
                $('#addCatModal').modal('hide');
            }
        }

        window.stergeCategoria = function stergeCategoria(id,nume){
            if (window.confirm("Sigur vrei sa stergi categoria "+nume+"? Aceasta actiune nu poate fi revocata si va sterge toate produsele aferente categoriei!")){
                $.ajax({
                    url: '<?php echo site_url("admin/ajax/stergecategorie");?>',
                    type: 'POST',
                    data: {catID: id},
                })
                    .done(function() {
                        $("#item_"+id).remove();
                    })
                    .fail(function() {
                        alert ("Eroare - nu am putut sterge categoria!");
                    });
            }
        }

        window.actdezact = function actdezact(id,newval){
            $.ajax({
                url: '<?php echo site_url("admin/ajax/actdezact");?>',
                type: 'POST',
                data: {catID: id, newval: newval},
            })
                .done(function() {
                    refreshCat();
                })
                .fail(function() {
                    alert ("A aparut o eroare - nu putem activa/dezactiva categoria.");
                });
        }

        window.liveSearch = function liveSearch() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("searchTableInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("tabel-categorii");
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
        $('[data-toggle="tooltip"]').tooltip('hide');
        $.LoadingOverlay("show", {
            image       : "",
            text        : "Se incarca..."
        });
    });
    $(document).ajaxStop(function(){
        $.LoadingOverlay("hide");
    });
</script>
