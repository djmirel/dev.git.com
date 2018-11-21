<?php if($produse): ?>

    <input type="text" id="searchTableInput" class="w-100 mt-2 mb-2 form-control" onkeyup="liveSearch()" placeholder="Cautare rapida..." title="Cauta...">
    <div class="table-responsive-md">
        <table class="table" id="tabel-produse">
            <thead>
            <tr>
                <th scope="col" class="text-center maxim-20" style="width: 5%">#</th>
                <th scope="col" style="width: 59%">Nume produs</th>
                <th scope="col" style="width: 10%" class="text-center">Pret</th>
                <th scope="col" style="width: 10%">Gramaj</th>
                <th scope="col"style="width: 10%">Edit</th>
                <th scope="col" style="width: 2%"><i class="fas fa-trash"></i></th>
                <th scope="col" style="width: 2%"><i class="fas fa-eye"></i></th>
                <th scope="col" style="width: 2%"><i class="far fa-newspaper"></i></th>
            </tr>
            </thead>
            <tbody class="font-12" id="sortabil">
                <?php foreach ($produse as $produs): ?>
                <tr class="bg-inerhit" id="item_<?php echo $produs->ID; ?>">
                    <th scope="row" class="text-center draga" style="vertical-align:middle">
                        <i class="fas fa-arrows-alt"></i>
                    </th>
                    <td>
                        <?php echo $produs->nume; ?>
                        <?php if($produs->nou == 1): ?>
                            <span class="badge badge-primary">Nou</span>
                        <?php endif; ?>
                        <?php if($produs->special == 1): ?>
                            <span class="badge badge-warning">Special</span>
                        <?php endif; ?>
                        <?php if($produs->picant == 1): ?>
                            🌶️
                        <?php endif; ?>
                        <?php if($produs->activ == 0): ?>
                            <span class="text-muted small">(inactiv)</span>
                        <?php endif;?>
                    </td>
                    <td class="text-center">
                        <?php echo $produs->pret1; ?>
                        <?php echo  ($produs->pret2 ? ' / '.$produs->pret2 : ''); ?>
                        <?php echo  ($produs->pret3 ? ' / '.$produs->pret3 : ''); ?>
                    </td>
                    <td><?php echo $produs->gramaj; ?></td>
                    <td><a href="javascript:openEditForm(<?php echo $produs->ID; ?>)">Edit</a></td>
                    <td>
                        <a class="text-danger" href="javascript:stergeProdus('<?php echo $produs->ID;?>','<?php echo $produs->nume; ?>')" data-toggle="tooltip" data-placement="left" title="Sterge">
                            <i class="fas fa-times"></i>
                        </a>
                    </td>
                    <td>
                        <?php if($produs->activ == 0): ?>
                            <a class="text-success" href="javascript:actdezactP(<?php echo $produs->ID; ?>,1)" data-toggle="tooltip" data-placement="left" title="Activeaza"><i class="fas fa-eye"></i></a>
                        <?php else: ?>
                            <a class="text-danger" href="javascript:actdezactP(<?php echo $produs->ID; ?>,0)" data-toggle="tooltip" data-placement="left" title="Dezactiveaza"><i class="far fa-eye-slash"></i></a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo base_url('admin/textEditor/produse/'.$produs->ID); ?>"><i class="far fa-newspaper"></i></a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>


<?php else: ?>
Nu sunt produse definite pentru aceasta categorie.
<?php endif; ?>
<hr>
<a href="#modaldeschis" class="btn btn-primary" onclick="openEditForm(0)">
    <i class="fas fa-folder-plus"></i> Adauga produs
</a>