<?php


function my_setup()
{
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        )
    );
}
add_action('after_setup_theme', 'my_setup');


add_action( 'wp_enqueue_scripts', function(){
    wp_register_style(
        'reset_style',
        get_template_directory_uri() . '/css/reset.css',
        array(),
        '1.0',
    );
    wp_enqueue_style(
        'main_style',
        get_template_directory_uri() . '/css/style.css',
        array('reset_style'),
        '1.0'
    );
});

wp_enqueue_script('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true);

function my_script(){ 
    // 独自スクリプトの読み込み
    wp_enqueue_script( 'main-js', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0.0', true );
}
//アクションフックの指定
add_action('wp_enqueue_scripts', 'my_script');

function create_custom_post_type() {
    $labels = array(
        'name'                  => _x('お知らせ', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('お知らせ', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('お知らせ', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('お知らせ', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('お知らせを追加', 'textdomain'),
        'add_new_item'          => __('お知らせを追加', 'textdomain'),
        'new_item'              => __('お知らせ', 'textdomain'),
        'edit_item'             => __('お知らせを編集', 'textdomain'),
        'view_item'             => __('お知らせを表示', 'textdomain'),
        'all_items'             => __('すべてのお知らせ', 'textdomain'),
        'search_items'          => __('お知らせを検索', 'textdomain'),
        'parent_item_colon'     => __('親お知らせ:', 'textdomain'),
        'not_found'             => __('お知らせが見つかりません。', 'textdomain'),
        'not_found_in_trash'    => __('ゴミ箱にお知らせはありません。', 'textdomain'),
        'featured_image'        => _x('アイキャッチ画像', 'Overrides the "Featured Image" phrase for this post type. Added in 4.3', 'textdomain'),
        'set_featured_image'    => _x('アイキャッチ画像を設定', 'Overrides the "Set featured image" phrase for this post type. Added in 4.3', 'textdomain'),
        'remove_featured_image' => _x('アイキャッチ画像を削除', 'Overrides the "Remove featured image" phrase for this post type. Added in 4.3', 'textdomain'),
        'use_featured_image'    => _x('アイキャッチ画像として使用', 'Overrides the "Use as featured image" phrase for this post type. Added in 4.3', 'textdomain'),
        'archives'              => _x('お知らせアーカイブ', 'The post type archive label used in nav menus. Default "Post Archives". Added in 4.4', 'textdomain'),
        'insert_into_item'      => _x('お知らせに挿入', 'Overrides the "Insert into post"/"Insert into page" phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
        'uploaded_to_this_item' => _x('このお知らせにアップロード', 'Overrides the "Uploaded to this post"/"Uploaded to this page" phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
        'filter_items_list'     => _x('お知らせリストを絞り込む', 'Screen reader text for the filter links heading on the post type listing screen. Default "Filter posts list"/"Filter pages list". Added in 4.4', 'textdomain'),
        'items_list_navigation' => _x('お知らせリストナビゲーション', 'Screen reader text for the pagination heading on the post type listing screen. Default "Posts list navigation"/"Pages list navigation". Added in 4.4', 'textdomain'),
        'items_list'            => _x('お知らせリスト', 'Screen reader text for the items list heading on the post type listing screen. Default "Posts list"/"Pages list". Added in 4.4', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'news'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => true,
        'menu_position'      => 5,
        'supports'           => array('title', 'editor', 'thumbnail'),
        'show_in_rest'       => true,
    );

    register_post_type('news', $args);

    // カスタムタクソノミーの登録
    register_taxonomy(
        'news_category',
        'news',
        array(
            'label'        => __('お知らせ用カテゴリー', 'textdomain'),
            'rewrite'      => array('slug' => 'news-category'),
            'hierarchical' => true,
            'show_in_rest' => true,
        )
    );
}

add_action('init', 'create_custom_post_type');

add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');
function wpcf7_autop_return_false() {
  return false;
}
