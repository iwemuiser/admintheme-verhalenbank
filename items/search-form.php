<?php
//"Identifier", "Title", "Subject", "Description"
//make a setting for this in the plugin
$medium_commonly_searched_fields = explode(",", get_option('mediumsearchablefields'));
#$medium_commonly_searched_fields = array(43, 50, 49); #TEMPORARY

$collections_search_options = array(1 => "Nederlandse volksverhalen", null => __("Complete website"));

$selected_collection = @$_REQUEST['collection'] ? @$_REQUEST['collection'] : 1; 

$all_table_options = get_table_options('Element', null, array(
    'record_types' => array('Item', 'All'),
    'sort' => 'alphaBySet')
);

$merged_table_options = $all_table_options["Dublin Core"] + $all_table_options["Itemtype metadata"];

if (!empty($formActionUri)):
    $formAttributes['action'] = $formActionUri;
else:
    $formAttributes['action'] = url(array('controller'=>'items',
                                          'action'=>'browse'));
endif;
$formAttributes['method'] = 'GET';
?>

<form <?php echo tag_attributes($formAttributes);?>>
    
    <div>
        <input type="submit" class="submit" name="submit_search" id="submit_search_advanced" value="<?php echo __('Search'); ?>" />
        <INPUT TYPE="button" onClick="parent.location='<?php echo url('items/search')?>'"value="<?php echo __('Reset form'); ?>" />
    </div>

    <div class="field">
        <?php echo $this->formLabel('collection-search', __('Search By Collection')); ?>
        <div class="inputs">
        <?php
            echo $this->formRadio(
                'collection',
                $selected_collection,
                array('id' => 'collection-search'),
                $collections_search_options
            );
        ?>
        </div>
    </div>
    <div id="search-keywords" class="field">
        <?php echo $this->formLabel('keyword-search', __('All metadata fields')); ?>
        <div class="inputs">
        <?php
            echo $this->formText(
                'search',
                @$_REQUEST['search'],
                array('id' => 'keyword-search', 'size' => '40')
            );
        ?>
        </div>
        <?php echo $this->formLabel('tag-search', __('Search By Tags')); ?>
        <div class="inputs">
        <?php
            echo $this->formText('tags', @$_REQUEST['tags'],
                array('size' => '40', 'id' => 'tag-search')
            );
        ?>
        </div>
    </div>
    
<!-- This is where the alternative search form starts -->
    <div id="search-by-certain-fields" class="field">
        <?php
        if (!empty($_GET['advanced'])) {
            $search = $_GET['advanced'];
/*            print "<pre>";
            print_r($search);
            print "</pre>";*/
        } else {
            $search = array();
        }
        ?>
        <div class="label"><?php echo __('Commonly used fields search'); ?></div>
        <center>
        <table width=90%>
        <?php
        foreach ($medium_commonly_searched_fields as $i => $table_option):?>
            <tr>
            <td>
                <div><?php echo $merged_table_options[$table_option];?></div>
            </td>
            <?php 
            echo $this->formHidden(
                "keywordsearch[$i][element_id]",
                $table_option,
                array('hidden' => true)
            );?>
<!--            <td><?php
            echo $this->formSelect(
                "advanced[$i][type]",
                array_key_exists($i, $search) ? $search[$i]["type"] : "",#get_option('mediumsearchstyle'),
                array("style" => "margin-bottom:0;"),
                label_table_options(array(
                    'contains' => __('contains'),
                    'does not contain' => __('does not contain'),
                    'is exactly' => __('is exactly'),
                    'is empty' => __('is empty'),
                    'is not empty' => __('is not empty'))
                )
            );?></td>-->
            <td><?php
            echo $this->formText(
                "keywordsearch[$i][terms]",
                array_key_exists($i, $search) ? $search[$i]["terms"] : "",
                array("style" => "margin-bottom:0;")
            );?></td>
            </tr>
        <?php endforeach; ?>
        </table>
    </div>


    <?php if(is_allowed('Users', 'browse')): ?>
    <div class="field">
    <?php
        echo $this->formLabel('user-search', __('Search By User'));?>
        <div class="inputs">
        <?php
            echo $this->formSelect(
                'user',
                @$_REQUEST['user'],
                array('id' => 'user-search'),
                get_table_options('User')
            );
        ?>
        </div>
    </div>
    <?php endif; ?>

    <?php fire_plugin_hook('public_items_search', array('view' => $this)); ?>
    <div>
        <input type="submit" class="submit" name="submit_search" id="submit_search_advanced" value="<?php echo __('Search'); ?>" />
        <INPUT TYPE="button" onClick="parent.location='<?php echo url('items/search')?>'"value="<?php echo __('Reset form'); ?>" />
    </div>
</form>

<?php echo js_tag('items-search'); ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        Omeka.Search.activateSearchButtons();
    });
</script>
