<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

$aStats = SCModel::newInstance()->getStats();
$_stats = $aStats;

$aProviders = SCClass::providers();
foreach($aStats as $key => $s) {
    $id = SCClass::provider_id($s['s_provider']);
    if(key_exists( $id, $aProviders) ) {
        unset($aProviders[$id]);
    }
}
foreach($aProviders as $key => $v) {
    $aStats[] = array('s_provider' => $v, 'total'=> 0);
}

?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<h2><?php _e('Statistics', 'socialconnect'); ?></h2>
<table class="uk-table uk-table-hover uk-table-striped uk-table-condensed uk-margin-left" style="width: 300px; float: left;">
    <thead>
    <tr>
        <th><?php _e('Network', 'socialconnect'); ?></th>
        <th><?php _e('Register count','socialconnect'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($aStats as $s) { ?>
    <tr>
        <td><?php echo $s['s_provider']; ?></td>
        <td><?php echo $s['total']; ?></td>
    </tr>
    <?php } ?>
    </tbody>
</table>

<div style="margin-left:1em; float: left;">
    <div id="placeholder" class="graph-placeholder" style="height:350px">
    </div>
</div>

<script type="text/javascript">
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', '<?php _e('Region', 'socialconnect'); ?>');
        data.addColumn('number', '<?php _e('Users per region', 'socialconnect'); ?>');
        data.addRows(<?php echo count($aStats); ?>);
        <?php foreach($aStats as $k => $v) {
        echo "data.setValue(" . $k . ", 0, '" . ( ( $v['s_provider'] == NULL ) ? __('Unknown', 'socialconnect') : $v['s_provider'] ) . "');";
        echo "data.setValue(" . $k . ", 1, " . $v['total'] . ");";
        } ?>
        <?php
        $gTitle = __('Social Network Register Percentage', 'socialconnect');
        if(count($_stats)==0) {
            $gTitle = __('There\'re no statistics yet', 'socialconnect');
        } ?>

        // Create and draw the visualization.
        new google.visualization.PieChart(document.getElementById('placeholder')).draw(data, {backgroundColor: 'transparent',title:'<?php echo osc_esc_js($gTitle); ?>',height: 350});

    }
</script>