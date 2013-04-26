<?php
$pageTitle = __('Search Items');
echo head(
    array(
        'title' => $pageTitle,
        'bodyclass' => 'items advanced-search',
        'bodyid' => 'advanced-search-page'
    )
);


if (!empty($_GET['style'])) {
    $search_style = $_GET['style'];
} else {
    $search_style = "medium";
}
?>

<ul id="section-nav" class="navigation">
    <li class="<?php if (isset($_GET['style']) &&  $_GET['style'] == 'medium') {echo 'current';} ?>">
        <a href="<?php echo html_escape(url('items/search?style=medium')); ?>"><?php echo __('Advanced Search'); ?></a>
    </li>
    <li class="<?php if (isset($_GET['style']) && $_GET['style'] == 'advanced') {echo 'current';} ?>">
        <a href="<?php echo html_escape(url('items/search?style=advanced')); ?>"><?php echo __('Very advanced Search'); ?></a>
    </li>
</ul>

<?php 
if ($search_style == "medium"){
    echo $this->partial('items/search-form-medium.php', array('formAttributes' =>
                        array('id'=>'advanced-search-form')));
}
elseif ($search_style == "advanced"){
    echo $this->partial('items/search-form.php', array('formAttributes' =>
                        array('id'=>'advanced-search-form')));
}?>
<?php
echo foot();
?>
