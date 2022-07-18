<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\VapeFlavor[]|\Cake\Collection\CollectionInterface $vapeFlavors
 */
?>
<style>
    .vape-image{
        width: 50px;
        height: 50px;
    }
    .dataTables_wrapper .dataTables_length select{
        padding: 10px;
    }
    input[type="search"]{
        width: 70%;
        display: inline;
    }
    #brand-selector{
        width: auto;
        padding-right: 30px;
    }

</style>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Vape Flavor'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Disposable Vapes'), ['controller' => 'DisposableVapes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Disposable Vape'), ['controller' => 'DisposableVapes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<?php echo $this->Flash->render(); ?>
<div class="vapeFlavors index large-9 medium-8 columns content">
    <h3><?= __('Vape Flavors') ?></h3>
    <select id="brand-selector">
        <option value="all" selected>All brands</option>
        <?php foreach($vapeBrands as $vapeBrand){

         ?>
            <option value="<?php echo $vapeBrand->disposable_vape_brand. " ". $vapeBrand->disposable_vape_variant;?>">
                <?php echo $vapeBrand->disposable_vape_brand. " ". $vapeBrand->disposable_vape_variant;?>
            </option>
        <?php } ?>
    </select>
    <table id="flavor-table" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" style="width: 25%">Brand Variant</th>
                <th scope="col" style="width: 25%">Flavor Name</th>
                <th scope="col">Stock</th>
                <th scope="col">Box</th>
                <th scope="col">Sold</th>
                <th scope="col">Image</th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vapeFlavors as $vapeFlavor): ?>
            <tr>
                <td><?= $vapeFlavor->has('disposable_vape') ? $this->Html->link($vapeFlavor->disposable_vape->disposable_vape_brand. " " . $vapeFlavor->disposable_vape->disposable_vape_variant, ['controller' => 'DisposableVapes', 'action' => 'edit', $vapeFlavor->disposable_vape->disposable_vape_id], ['style' => 'color: '. $vapeFlavor->vape_image_color]) : '' ?></td>
                <td class="vape-flavors"><?= h($vapeFlavor->vape_flavors_name) ?></td>
                <td><?php
                    $vapeStock = $vapeFlavor->vape_stock;
                    $vapeBoxSize = $vapeFlavor->disposable_vape->disposable_vape_box_size;
                    echo $vapeStock; ?></td>
                <?php
                $class = "vape-image";
                if($vapeFlavor->vape_image_color == "#000000"){
                    $class = "vape-image not-colored";
                } ?>
                <td><?php echo " (";
                    if($vapeStock/$vapeBoxSize>0)
                    {echo floor($vapeStock/$vapeBoxSize);}
                    else
                    {echo (int)ceil($vapeStock/$vapeBoxSize);}
                    echo "+".$vapeStock%$vapeBoxSize.
                    ")" ?></td>
                <td><?php echo $vapeFlavor->vape_sold; ?></td>
                <td><?= $this->Html->image('vapes/'.$vapeFlavor->vape_image, ['class' => $class, 'vape_flavor_id' => $vapeFlavor->vape_flavors_id]) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $vapeFlavor->vape_flavors_id], ['target' => '_blank']) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $vapeFlavor->vape_flavors_id], ['confirm' => __('Are you sure you want to delete # {0}?', $vapeFlavor->vape_flavors_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    let flavorTable = $("#flavor-table").DataTable({
        paging: false
    });

    $("#brand-selector").on('change', function (){
        let selectedVal = $("#brand-selector option:selected").val()
        if(selectedVal==="all"){
            flavorTable.search("").draw();
        }
        else{
            flavorTable.search(selectedVal).draw();
        }
    })

    function componentToHex(c) {
        let hex = c.toString(16);
        return hex.length === 1 ? "0" + hex : hex;
    }

    function rgbToHex(r, g, b) {
        return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
    }

    getFontColor();

    function getAverageRGB(imgEl) {

        let blockSize = 5, // only visit every 5 pixels
            defaultRGB = {r: 0, g: 0, b: 0}, // for non-supporting envs
            canvas = document.createElement('canvas'),
            context = canvas.getContext && canvas.getContext('2d'),
            data, width, height,
            i = -4,
            length,
            rgb = {r: 0, g: 0, b: 0},
            count = 0;

        if (!context) {
            return defaultRGB;
        }

        height = canvas.height = imgEl.naturalHeight || imgEl.offsetHeight || imgEl.height;
        width = canvas.width = imgEl.naturalWidth || imgEl.offsetWidth || imgEl.width;

        context.drawImage(imgEl, 0, 0);

        data = context.getImageData(0, 0, width, height);

        length = data.data.length;

        while ((i += blockSize * 4) < length) {
            if (data.data[i] !== 255 && data.data[i + 1] !== 255 && data.data[i + 2] !== 255 && data.data[i] !== 0 && data.data[i + 1] !== 0 && data.data[i + 2] !== 0) {
                ++count;
                rgb.r += data.data[i];
                rgb.g += data.data[i + 1];
                rgb.b += data.data[i + 2];
            }

        }

        // ~~ used to floor values
        rgb.r = ~~(rgb.r / count);
        rgb.g = ~~(rgb.g / count);
        rgb.b = ~~(rgb.b / count);

        return rgb;

    }


    function getFontColor() {
        let csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;

        let colorArray = [];
        let flavor_id = 0;
        let hex = "#00000";
        $(".not-colored").each(function () {
            let image = $(this);
            flavor_id = $(this).attr("vape_flavor_id");
            image.crossOrigin = "";
            let rgb = getAverageRGB(image[0]);
            if (rgb.r < 100 && rgb.g < 100 && rgb.b < 100) {
                if ((rgb.r - rgb.g > 5) || (rgb.r - rgb.b > 5)) {
                    rgb.r = rgb.r * 3;
                }
                if ((rgb.g - rgb.r > 5) || (rgb.g - rgb.b > 5)) {
                    rgb.g = rgb.g * 3;
                }
                if ((rgb.b - rgb.r > 5) || (rgb.b - rgb.g > 5)) {
                    rgb.b = rgb.b * 3;
                }
            } else if (rgb.r > 180 && rgb.g > 180 && rgb.b > 180) {
                if ((rgb.r - rgb.g < 5) || (rgb.r - rgb.b < 5)) {
                    rgb.r = rgb.r / 1.2;
                }
                if ((rgb.g - rgb.r < 5) || (rgb.g - rgb.b < 5)) {
                    rgb.g = rgb.g / 1.2;
                }
                if ((rgb.b - rgb.r < 5) || (rgb.b - rgb.g < 5)) {
                    rgb.b = rgb.b / 1.2;
                }
            }
            hex = rgbToHex(parseInt(rgb.r),parseInt(rgb.g),parseInt(rgb.b));
            let colorObj = {};
            colorObj.vape_flavors_id = flavor_id;
            colorObj.vape_image_color = hex;
            colorArray.push(colorObj);
        })
        $.ajax({
            headers: {
                'X-CSRF-Token': csrfToken
            },
            type: "post",
            url: "<?php echo $this->Url->build([
                "controller" => "vapeFlavors",
                "action" => "updateColor"]);
                ?>",
            data: {"colorJson": JSON.stringify(colorArray)}
        });
    }
</script>
