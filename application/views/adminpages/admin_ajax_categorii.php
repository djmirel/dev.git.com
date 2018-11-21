<?php if($categorii): ?>

    <input type="text" id="searchTableInput" class="w-100 mt-2 mb-2 form-control" onkeyup="liveSearch()" placeholder="Cautare rapida..." title="Cauta...">

    <div class="table-responsive-md">
    <table class="table" id="tabel-categorii">
    <thead>
        <tr>
            <th scope="col" class="text-center maxim-20" style="width: 5%">#</th>
            <th scope="col" style="width: 71%">Nume categorie</th>
            <th scope="col"style="width: 10%">Edit</th>
            <th scope="col" style="width: 10%">Produse</th>
            <th scope="col" style="width: 2%"><i class="fas fa-trash"></i></th>
            <th scope="col" style="width: 2%"><i class="far fa-newspaper"></i></th>
        </tr>
    </thead>
    <tbody class="font-12" id="sortabil">
    <?php foreach ($categorii as $categorie): ?>
        <tr class="bg-inerhit" id="item_<?php echo $categorie->ID; ?>">
            <th scope="row" class="text-center draga" style="vertical-align:middle">
                <i class="fas fa-arrows-alt"></i>
            </th>
            <td>
                <?php if($categorie->activ == 0): ?>
                    <div>
                        <span class="text-uppercase text-danger text-14 weight-600"><?php echo $categorie->nume; ?></span>
                        <span class="small text-secondary"> (inactiv) </span>
                    </div>
                    <div class="text-12">
                        <a class="text-success" onclick="actdezact(<?php echo $categorie->ID; ?>,1)"><i class="far fa-eye"></i> Activeaza</a>
                    </div>
                <?php else: ?>
                    <div>
                        <span class="text-uppercase text-14 weight-600"><?php echo $categorie->nume; ?></span>
                    </div>
                    <div class="text-12">
                        <a class="text-warning" onclick="actdezact(<?php echo $categorie->ID; ?>,0)"><i class="far fa-eye-slash"></i> Dezactiveaza</a>
                    </div>
                <?php endif; ?>
            </td>
            <td style="vertical-align:middle"><a href="#modaldeschis" onclick="openEditForm(<?php echo $categorie->ID; ?>)" class="text-14">Edit</a></td>
            <td style="vertical-align:middle" class="text-14">
                <a href="<?php echo site_url('admin/categorii/'.$categorie->ID); ?>">Produse</a>
            </td>
            <td style="vertical-align:middle">
                <?php if($categorie->activ == 0): ?>
                    <a class="text-danger" onclick="stergeCategoria(<?php echo $categorie->ID; ?>,'<?php echo $categorie->nume; ?>')" data-toggle="tooltip" data-placement="left" title="Sterge"><i class="fas fa-times"></i> </a>
                <?php else: ?>
                    <a class="text-muted" data-toggle="tooltip" data-placement="left" title="Nu poti sterge. Mai intai dezactiveaza!"><i class="fas fa-times"></i> </a>
                <?php endif; ?>
            </td>
            <td style="vertical-align:middle">
                <a href="<?php echo base_url('admin/textEditor/categorii/'.$categorie->ID); ?>" ><i class="far fa-newspaper"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    </div>
<?php else: ?>
    Nu sunt categorii definite
<?php endif; ?>
<hr>
<a href="#modaldeschis" class="btn btn-primary" onclick="openEditForm(0)">
    <i class="fas fa-folder-plus"></i> Adauga categorie
</a>
