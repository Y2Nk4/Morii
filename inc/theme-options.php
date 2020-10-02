<?php
/**
 * @author Y2Nk4
 * @link https://photo.y2nk4.com/
 * @copyright [Y2Nk4](https://y2nk4.com/)
 */

$options = array(
    array(
        'title' => '常规选项',
        'id'    => 'general',
        'type'  => 'panelstart'
    ),
    array(
        'title' => '首页设置',
        'type'  => 'subtitle'
    ),
    array(
        'name'  => '首页文字',
        'id'    => $shortname . "_index_title",
        'type'  => 'textarea',
        'std'   => ''
    ),
    array(
        'name'  => '页脚文字',
        'id'    => $shortname . "_footer_title",
        'type'  => 'textarea',
        'std'   => ''
    ),
    array(
        'name'  => '自定义头部内容',
        'id'    => $shortname . "_header",
        'type'  => 'textarea',
        'std'   => ''
    ),
    array(
        'name'  => '页脚JS',
        'id'    => $shortname . "_footer_js",
        'type'  => 'textarea',
        'std'   => ''
    ),
    array(
        'title' => '网站图标',
        'type'  => 'subtitle'
    ),
    array(
        'name'  => 'Favicon 站点图标（URL）',
        'desc'  => '',
        'id'    => $shortname . '_favicon',
        'type'  => 'media',
        'std'   => site_url('favicon.ico')
    ),
    array(
        'name'  => 'iOS 主屏幕图标（URL）',
        'desc'  => '建议尺寸：152x152',
        'id'    => $shortname . '_apple_touch_icon',
        'type'  => 'media',
        'std'   => site_url('apple-touch-icon-precomposed.png')
    ),

    array(
        'name'  => '高清 Favicon 图标（URL）',
        'desc'  => '192x192',
        'id'    => $shortname . '_highres_favicon',
        'type'  => 'media',
        'std'   => site_url('nice-highres.png')
    ),
    array(
        'name'  => 'Windows 8 磁贴图像（URL）',
        'desc'  => '建议尺寸：144x144',
        'id'    => $shortname . '_msapplication_tileimage',
        'type'  => 'media',
        'std'   => site_url('win8-tile-144.png')
    ),
    array(
        'name'  => '网站图标背景色',
        'desc'  => '',
        'id'    => $shortname . '_theme_color',
        'type'  => 'color',
        'std'   => ''
    ),
    array(
        'title' => '搜索引擎优化（SEO）',
        'type'  => 'subtitle'
    ),
    array(
        'name'  => '自定义关键字/描述',
        'desc'  => '启用',
        'id'    => $shortname . "_meta",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => '首页关键字',
        'desc'  => '各关键字间用半角逗号“,”分割，数量在 5 个以内最佳。',
        'id'    => $shortname . "_meta_keywords",
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => '首页描述',
        'desc'  => '用简洁的文字描述本站点，字数建议在 120 个字以内。',
        'id'    => $shortname . "_meta_description",
        'type'  => 'textarea',
        'std'   => ''
    ),
    array(
        'type'  => 'panelend'
    )
);

function morii_add_theme_options_page() {
    global $options;
    if (isset($_GET['page']) && $_GET['page'] == 'morii-theme-options') {
        if (isset($_POST['action']) && 'update' == $_POST['action']) {
            foreach($options as $value) {
                if (isset($value['id'])) {
                    $optionID = $value['id'];
                    if (isset($_POST[$optionID]) && get_option($optionID) != $_POST[$optionID]) {
                        update_option($optionID, $_POST[$optionID]);
                    } elseif (!isset($_POST[$optionID]) && $value['type'] == 'checkbox') {
                        delete_option($optionID);
                    }
                }
            }
            update_option('morii_options_setup', true);
            update_option('morii_update_time', uniqid());
            header('Location: themes.php?page=morii-theme-options&update=true&panel=' . $_POST['panel']);
            die;
        } else if(isset($_GET['page']) && isset($_POST['action']) && 'reset' == $_POST['action'] ) {
            foreach ($options as $value) {
                delete_option($value['id']);
            }
            delete_option('morii_options_setup');
            update_option('morii_update_time', uniqid());
            header('Location: themes.php?page=morii-theme-options&reset=true&panel=' . $_POST['panel']);
            die;
        }
    }
    add_theme_page(__('Theme Options', 'morii'), __('Theme Options', 'morii'), 'edit_theme_options', 'morii-theme-options', 'morii_theme_options_page');
}
add_action('admin_menu', 'morii_add_theme_options_page');

function morii_theme_options_page() {
    global $shortname, $options;
    $optionsSetuped = get_option('morii_options_setup') == true;

    wp_enqueue_script('wp-color-picker');
    wp_enqueue_style('wp-color-picker');

    wp_enqueue_media();
    ?>

    <div class="wrap">
        <h2>Morii 主题选项</h2>

        <?php
        if (isset($_GET['update']) && $_GET['update']) echo '<div class="updated"><p><strong>设置已保存。</strong></p></div>';
        if (isset($_GET['reset']) && $_GET['reset']) echo '<div class="updated"><p><strong>设置已重置。</strong></p></div>';
        ?>

        <div class="wp-filter">

            <ul class="filter-links">
                <?php
                global $currentTheme, $activePanelName;

                $activePanelName = empty($_GET['panel']) ? 'general' : $_GET['panel'];

                foreach ($options as $value ) {
                    if ( $value['type'] == 'panelstart' ) echo '<li><a href="#panel_' . $value['id'] . '" data-panel="' . $value['id'] . '" ' . ( $value['id'] == $activePanelName ? 'class="current"' : '' ) . '>' . $value['title'] . '</a></li>';
                }
                ?>
            </ul>

            <div class="search-form"><label class="screen-reader-text" for="wp-filter-search-input">筛选主题选项…</label><input placeholder="筛选主题选项…" type="search" id="wp-filter-search-input" class="wp-filter-search"></div>
        </div>

        <form method="post">
            <?php
            foreach ($options as $value) {
                switch ( $value['type'] ) {
                    case 'panelstart':
                        echo '<div class="panel" id="panel_' . $value['id'] . '" ' . ( $value['id'] == $activePanelName ? ' style="display:block"' : '' ) . '><table class="form-table">';
                        break;
                    case 'panelend':
                        echo '</table></div>';
                        break;
                    case 'subtitle':
                        echo '<tr><th colspan="2"><h3>' . $value['title'] . '</h3></th></tr>';
                        break;
                    case 'text':
                        ?>
                        <tr id="row-<?php echo $value['id']; ?>">
                            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
                            <td>
                                <label>
                                    <input name="<?php echo $value['id']; ?>" class="regular-text" id="<?php echo $value['id']; ?>" type='text' value="<?php if ( $optionsSetuped || get_option( $value['id'] ) != '') { echo stripslashes(get_option( $value['id'] )); } else { echo $value['std']; } ?>" />
                                    <span class="description"><?php if (isset($value['desc'])) echo $value['desc']; ?></span>
                                </label>
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'media':
                        ?>
                        <tr id="row-<?php echo $value['id']; ?>">
                            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
                            <td>
                                <label>
                                    <input name="<?php echo $value['id']; ?>" class="regular-text" id="<?php echo $value['id']; ?>" type='text' value="<?php if ( $optionsSetuped || get_option( $value['id'] ) != '') { echo stripslashes(get_option( $value['id'] )); } else { echo $value['std']; } ?>" />
                                    <input type="button" value="上传/选择" class="button mediaupload-button">
                                    <span class="description"><?php if (isset($value['desc'])) echo $value['desc']; ?></span>
                                </label>
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'number':
                        ?>
                        <tr id="row-<?php echo $value['id']; ?>">
                            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
                            <td>
                                <label>
                                    <input name="<?php echo $value['id']; ?>" class="small-text" id="<?php echo $value['id']; ?>" type="number" value="<?php if ( $optionsSetuped || get_option( $value['id'] ) != '') { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" />
                                    <span class="description"><?php if (isset($value['desc'])) echo $value['desc']; ?></span>
                                </label>
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'color':
                        ?>
                        <tr id="row-<?php echo $value['id']; ?>">
                            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
                            <td>
                                <label>
                                    <input name="<?php echo $value['id']; ?>" class="small-text" id="<?php echo $value['id']; ?>" type="color" value="<?php if ( $optionsSetuped || get_option( $value['id'] ) != '') { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" />
                                    <span class="description"><?php if (isset($value['desc'])) echo $value['desc']; ?></span>
                                </label>
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'textarea':
                        ?>
                        <tr id="row-<?php echo $value['id']; ?>">
                            <th><?php echo $value['name']; ?></th>
                            <td>
                                <p><label for="<?php echo $value['id']; ?>"><?php echo $value['desc']; ?></label></p>
                                <p><textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" rows="10" cols="50" class="large-text code"><?php if ( $optionsSetuped || get_option( $value['id'] ) != '') { echo stripslashes(get_option( $value['id'] )); } else { echo $value['std']; } ?></textarea></p>
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'select':
                        ?>
                        <tr id="row-<?php echo $value['id']; ?>">
                            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
                            <td>
                                <label>
                                    <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                                        <?php foreach ($value['options'] as $option) : ?>
                                            <option value="<?php echo $option; ?>" <?php selected( get_option( $value['id'] ), $option); ?>>
                                                <?php echo $option; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="description"><?php if (isset($value['desc'])) echo $value['desc']; ?></span>
                                </label>
                            </td>
                        </tr>

                        <?php
                        break;
                    case 'radio':
                        ?>
                        <tr id="row-<?php echo $value['id']; ?>">
                            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
                            <td>
                                <?php foreach ($value['options'] as $name => $option) : ?>
                                    <label>
                                        <input type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id'] . '_' . $option; ?>" value="<?php echo $option; ?>" <?php checked( get_option( $value['id'], $value['std'] ), $option); ?>>
                                        <?php echo $name; ?>
                                    </label>
                                <?php endforeach; ?>
                                <p><span class="description"><?php if (isset($value['desc'])) echo $value['desc']; ?></span></p>
                            </td>
                        </tr>

                        <?php
                        break;
                    case 'checkbox':
                        ?>
                        <tr id="row-<?php echo $value['id']; ?>">
                            <th><?php echo $value['name']; ?></th>
                            <td>
                                <label>
                                    <input type='checkbox' name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="1" <?php echo checked(get_option($value['id']), 1); ?> />
                                    <span><?php if (isset($value['desc'])) echo $value['desc']; ?></span>
                                </label>
                            </td>
                        </tr>

                        <?php
                        break;
                    case 'checkboxs':
                        ?>
                        <tr id="row-<?php echo $value['id']; ?>">
                            <th><?php echo $value['name']; ?></th>
                            <td>
                                <?php $checkboxsValue = get_option( $value['id'] );
                                if ( !is_array($checkboxsValue) ) $checkboxsValue = array();
                                foreach ( $value['options'] as $id => $title ) : ?>
                                    <label>
                                        <input type="checkbox" name="<?php echo $value['id']; ?>[]" id="<?php echo $value['id']; ?>[]" value="<?php echo $id; ?>" <?php checked( in_array($id, $checkboxsValue), true); ?>>
                                        <?php echo $title; ?>
                                    </label>
                                <?php endforeach; ?>
                                <span class="description"><?php if (isset($value['desc'])) echo $value['desc']; ?></span>
                            </td>
                        </tr>

                        <?php
                        break;
                }
            }
            ?>
            <p class="submit">
                <input name="submit" type="submit" class="button button-primary" value="保存更改"/>
                <input type="hidden" name="action" value="update" />
                <input type="hidden" name="panel" value="<?php global $activePanelName; echo $activePanelName; ?>" id="active_panel_name" />
            </p>
        </form>
        <form method="post">
            <p class="submit">
                <input name="reset" type="submit" class="button button-secondary" value="重置选项" onclick="return confirm('你确定要重置主题选项吗？');"/>
                <input type="hidden" name="action" value="reset" />
            </p>
        </form>
    </div>
    <style>
        .panel{display:none}
        .panel h3{margin:0;font-size:1.2em;font-weight:bold}
        .wp-filter{padding: 0 20px;margin-bottom: 0;}
        .wp-filter .drawer-toggle:before{content:"\f463";color: #fff!important;background: #e14d43;border-radius: 50%;box-shadow:inset 0 0 0 2px #e14d43, 0 0 0 2px #e14d43;}
        #wp-filter-search-input{display:none;}
        .wrap.searching .nav-tab-wrapper a,.wrap.searching .panel tr,body.show-filters .wrap form{display:none}
        .wrap.searching .panel{display:block !important}
        .panel th{font-weight:normal}
        #panel_cssjs textarea{ height: 400px; }
        .filter-drawer ul{list-style-type:disc;list-style-position: inside;}
        .filter-drawer li{display: list-item;width: auto;list-style-type: inherit;}
        label.color_scheme { display: inline-block; border-radius: 50%; width: 40px; height: 40px; overflow: hidden; margin: 0 9px 0 0; position: relative; cursor: pointer; }
        label.turquoise { background: #1abc9c; }
        label.emerland { background: #2ecc71; }
        label.peter-river { background: #3498db; }
        label.amethyst { background: #9b59b6; }
        label.wet-asphalt { background: #34495e; }
        label.sun-flower { background: #f1c40f; }
        label.carrot { background: #e67e22; }
        label.alizarin { background: #e74c3c; }
        label.diy { background: url(<?php echo get_template_directory_uri(); ?>/inc/color_diy.jpg); }
        label.color_scheme input { margin: 12px!important; padding: 0; vertical-align: top; opacity: 0; cursor: pointer; }
        label.color_scheme input:checked {opacity: 1; }
        @media screen { #wp-filter-search-input{display:inline-block;} }
        #row-morii_color_scheme_standardized_color, #row-morii_color_scheme_auxiliary_color { display: none }
    </style>
    <style id="theme-options-filter"></style>
    <script>
        jQuery(function ($) {
            var $body = $("body");
            var $themeOptionsFilter = $("#theme-options-filter");
            var $wpFilterSearchInput = $("#wp-filter-search-input");
            var mediaUploader;

            $(".mediaupload-button").click(function(event) {
                var $input = $(this).prev("input");

                event.preventDefault();

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                };

                mediaUploader = wp.media({
                    title: "选择文件",
                    button: {
                        text: "选择文件"
                    },
                    multiple: false
                });

                mediaUploader.on("select", function() {
                    var attachment = mediaUploader.state().get("selection").first().toJSON();
                    $input.val(attachment.url);
                });

                mediaUploader.open();
            });

            $("[name=morii_color_scheme]").each(function(){
                var $label = $(this).parent(),
                    $input = $(this).clone();
                $label.addClass($(this).val() + " color_scheme").attr("title", $label.text().replace(/^\s+|\s+$/g,"")).empty().append($input);
            });
            $(".color_scheme input").change(function(){
                $("#row-morii_color_scheme_standardized_color, #row-morii_color_scheme_auxiliary_color").toggle(this.value == "diy");
            }).last().triggerHandler("change");

            $("#morii_theme_color").wpColorPicker();
            $("#morii_color_scheme_standardized_color").wpColorPicker();
            $("#morii_color_scheme_auxiliary_color").wpColorPicker();
            $("#morii_msapplication_tilecolor").wpColorPicker();

            $(".drawer-toggle").click(function () {
                $body.toggleClass("show-filters");
                return false;
            });

            $(".filter-links a").click(function () {
                $(this).addClass("current").parent().siblings().children().removeClass("current");
                $(".panel").hide();
                $($(this).attr("href")).show();
                $("#active_panel_name").val($(this).data("panel"));
                $body.removeClass("show-filters");
                return false;
            });

            if ($wpFilterSearchInput.is(":visible")) {
                var wrap = $(".wrap");

                $(".panel tr").each(function (el) {
                    $(this).attr("data-searchtext", $(this).text().replace(/\r|\n|px/g, '').replace(/ +/g, ' ').replace(/^\s+|\s+$/g, '').toLowerCase());
                });

                $wpFilterSearchInput.on("input", function () {
                    var text = $(this).val().trim().toLowerCase();
                    if (text != "") {
                        wrap.addClass("searching");
                        $themeOptionsFilter.text(".wrap.searching .panel tr[data-searchtext*='" + text + "']{display:block}");
                    } else {
                        wrap.removeClass("searching");
                        $themeOptionsFilter.text("");
                    };
                });
            };

            $(".wrap form").submit(function(){
                $(".submit .button").prop("disabled", true);
                $(this).find(".submit .button").val("正在提交…");
            });
        });
    </script>
    <?php
}

function morii_theme_activated() {
    if ( get_option('morii_options_setup') == '' ) echo '<div class="error"><p><b>新主题已启用。该主题支持选项，请访问<a href="themes.php?page=morii-theme-options">主题选项</a>页面进行配置。<a href="themes.php?page=morii-theme-options">立即配置</a></b></p></div>';
}
add_action('admin_footer', 'morii_theme_activated');
