<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
<style>
    .note-editing-area{
        background-color: #ffffff;
    }
    .modal{
        z-index: 10001!important;
    }
</style>

<div class="container p-0">
    <?php
    $return_folder == 'categorii' ? $return_url = base_url('admin/categorii') : $return_url = base_url('admin/categorii/'.$continut->categorie_id);
    ?>
    <a href="<?php echo $return_url; ?>" class="btn btn-primary mt-3 mb-3"><i class="fas fa-arrow-left"></i> Inapoi</a>
    <h1><?php echo $continut->nume; ?></h1>
    <h6>Adaugare / editare text special</h6>
    <hr>
    <div id="summernote"><?php echo $continut->aditional_info; ?></div>
    <a href="javascript:saveText()" class="btn btn-success mt-3 mb-3"><i class="fas fa-check"></i> Salveaza</a>
    <a href="<?php echo $return_url; ?>" class="btn btn-danger mt-3 mb-3"><i class="fas fa-times"></i> Renunta / Inapoi</a>

    <script>
        $(document).ready(function(){

            $('#summernote').summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['stilizare',['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['tabel',['table','link','video','picture']],
                    ['misc',['codeview','undo','redo']]
                ],
                callbacks:{
                    onImageUpload: function(image) {
                        //uploadImage(image[0],'img');
                        var nrpoze = image.length;
                        for ( i = 0; i < nrpoze; i++){
                            //console.log(image[i]);
                            uploadImage(image[i],'img');
                        }
                    }
                }
            });

            function uploadImage(image,folder) {
                var data = new FormData();
                data.append("image", image);
                data.append("folder",folder);
                $.ajax({
                    url: '<?php echo base_url('admin/ajax/uploadImg'); ?>',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    type: "post",
                    success: function(data) {
                        console.log(data);
                        var image = $('<img>').attr({
                            'src': '/upload/'+folder+'/' + data,
                            'style': 'width: 100%'
                        });
                        $('#summernote').summernote("insertNode", image[0]);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }

            window.saveText = function saveText(){
                var markup = $('#summernote').summernote('code');

                $.ajax({
                    url: '<?php echo site_url("admin/ajax/saveText"); ?>',
                    type: 'POST',
                    data: {text: markup, id: <?php echo $continut->ID; ?>, ceedit: '<?php echo $return_folder; ?>'}
                }).done(function(){
                    alert('pagina salvata cu succes');
                }).fail(function(){
                    alert('pagina nesalvata');
                })
            }

        })

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
</div>