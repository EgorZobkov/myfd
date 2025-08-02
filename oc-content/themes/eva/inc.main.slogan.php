<?php
/*
 * Copyright 2016 osclass-pro.com
 *
 * You shall not distribute this theme and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
?>
<div class="header-title">
    <h1 class="title-text"><?php if( osc_get_preference('mainh1-evarevo', 'eva') != '') {
            echo osc_get_preference('mainh1-evarevo', 'eva');
        } ?></h1>
    <?php if( osc_get_preference('maintext-evarevo', 'eva') != '') {?>
    <div class="clip-text">
        <p><?php echo osc_get_preference('maintext-evarevo', 'eva'); ?></p>
    </div>
    <?php } ?>
</div>
