<?php
    $menu_items = menu_items();

?>

<aside class="sidenav">

    <ul class="side-menu list-group p-0">
        <li class="list-group-item">
            <div class="d-flex justify-content-center align-items-center flex-column my-2">
  <h4 class="m-0">Crazy</h4>
            <h5 class="m-0">Collections</h5>
            </div>
          
        </li>
        <?php foreach ($menu_items as $index => $item) {?>

        <?php if (! empty($item['children'])) {?>
        <li class="list-group-item">
            <a class="" data-bs-toggle="collapse" href="#submenu<?php echo $index;?>" role="button"
                aria-expanded="false" aria-controls="submenu<?php echo $index;?>">
                <?php echo svg_icon($item['icon']);?>
                <?php echo $item['title'];?>
            </a>
            <ul class="collapse submenu" id="submenu<?php echo $index;?>">
                <?php foreach ($item['children'] as $child) {?>
                <li class="list-group-item">
                    <a href="<?php echo $child['url'];?>" class=""> <?php echo svg_icon($child['icon']);?>
                        <span><?php echo $child['title'];?></span></a>
                </li>
                <?php }?>
            </ul>
        </li>
        <?php }?>
        <?php if (empty($item['children'])) {?>
        <li class="list-group-item">
            <a href="<?php echo $item['url'];?>" class=""> <?php echo svg_icon($item['icon']);?>
                <span><?php echo $item['title'];?></span></a>
        </li>
        <?php }?>


        <?php }?>


    </ul>
</aside>