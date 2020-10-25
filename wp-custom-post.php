<?php 
/*
    Plugin Name: WP Custom Post
    Plugin URI: https://savitrigpta.com/
    Description: This is the custom post type plugin which we use for movies details
    Version:2.1.0
    Author: Savitri Softweb Solutions
    Author URI: https://savitrigupta.com
 */

/**
 * Register a custom post type called "book".
 *
 * @see get_post_type_labels() for label keys.
 */
function wp_custom_post_movie() {
    $labels = array(
        'name'                  => _x( 'Movies', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Movie', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Movies', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Movie', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'add_new_item'          => __( 'Add New Movie', 'textdomain' ),
        'new_item'              => __( 'New Movie', 'textdomain' ),
        'edit_item'             => __( 'Edit Movie', 'textdomain' ),
        'view_item'             => __( 'View Movie', 'textdomain' ),
        'all_items'             => __( 'All Movies', 'textdomain' ),
        'search_items'          => __( 'Search Movies', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Movies:', 'textdomain' ),
        'not_found'             => __( 'No Movies found.', 'textdomain' ),
        'not_found_in_trash'    => __( 'No Movies found in Trash.', 'textdomain' ),
        'featured_image'        => _x( 'Movie Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'set_featured_image'    => _x( 'Set Movie cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'archives'              => _x( 'Movie archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
        'insert_into_item'      => _x( 'Insert into Movie', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this Movie', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
        'filter_items_list'     => _x( 'Filter movie list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
        'items_list_navigation' => _x( 'Movies list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
        'items_list'            => _x( 'Movies list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'movie' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );
 
    register_post_type( 'movie', $args );
}
 
 add_action( 'init', 'wp_custom_post_movie' );


//--- Add Meta Boxes---///

function wp_cpt_movies_metabox()
{
	add_meta_box("cpt-id","Producer Details","wp_cpt_producer_call","movie","side","high");
	add_meta_box("cpt-author-id","Choose Author","wp_cpt_author_call","movie","side","high");
}

 add_action("add_meta_boxes","wp_cpt_movies_metabox");

function wp_cpt_producer_call($post)
{?>

	<p> 
		<label>Name:</label>
		<?php $name = get_post_meta($post->ID,"wp_cpt_producername",true)?>
		<input type="text" value="<?php echo $name;?>" name="txtProducerName" placeholder="Producer Name"/>
	</p>

	<p> 
		<label>Email:</label>
		<?php $email = get_post_meta($post->ID,"wp_cpt_produceremail",true)?>
		<input type="text" value="<?php echo $email;?>" name="txtProducerEmail" placeholder="Producer Email"/>
	</p>

	<p> 
		<label>Mobile:</label>
		<?php $mobile = get_post_meta($post->ID,"wp_cpt_producermobile",true)?>
		<input type="text" value="<?php echo $mobile;?>" name="txtProducerMobile" placeholder="Producer Mobile"/>
	</p>

<?php }?>

<?php

// Save Custom Post Type Meta Values
add_action("save_post","wp_cpt_save_meta_values",10,2);

function wp_cpt_save_meta_values($post_id, $post)
{
	$txtProducerName = isset($_POST['txtProducerName']) ? $_POST['txtProducerName']:""; 
	$txtProducerEmail = isset($_POST['txtProducerEmail']) ? $_POST['txtProducerEmail']:""; 
	$txtProducerMobile = isset($_POST['txtProducerMobile']) ? $_POST['txtProducerMobile']:""; 

	update_post_meta($post_id,"wp_cpt_producername",$txtProducerName);
	update_post_meta($post_id,"wp_cpt_produceremail",$txtProducerEmail);
	update_post_meta($post_id,"wp_cpt_producermobile",$txtProducerMobile);
}

// Show Producer columns  in datatable

add_filter( 'manage_movie_posts_columns', 'my_edit_movie_columns' ) ;

function my_edit_movie_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Movie' ),
		'produ_name' => __( 'Producer Name' ),
		'produ_email' => __( 'Producer Email' ),
		'produ_mobile' => __( 'Producer Mobile' ),
		'comments'=>__('Comments'),
		'date' => __( 'Date' )
	);

	return $columns;
}
// Show Producer details  in datatable


add_action( 'manage_movie_posts_custom_column', 'my_manage_movie_columns', 10, 2 );

function my_manage_movie_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'duration' column. */
		case 'produ_name' :

			/* Get the post meta. */
			$producername = get_post_meta( $post_id, 'wp_cpt_producername', true );
			/* If no producer name is found, output a default message. */
			if ( empty( $producername ) )
				echo __( 'No Producer Name' );

			/* If there is a duration, append 'minutes' to the text string. */
			else
				echo $producername;
			break;

			/* If displaying the 'duration' column. */
			case 'produ_email' :

			/* Get the post meta. */
			$produceremail = get_post_meta( $post_id, 'wp_cpt_produceremail', true );
			/* If no producer name is found, output a default message. */
			if ( empty( $produceremail ) )
				echo __( 'No Producer Email' );

			/* If there is a duration, append 'minutes' to the text string. */
			else
				echo $produceremail;
			break;

			/* If displaying the 'duration' column. */
			case 'produ_mobile' :

			/* Get the post meta. */
			$producermobile = get_post_meta( $post_id, 'wp_cpt_producermobile', true );
			/* If no producer name is found, output a default message. */
			if ( empty( $producermobile ) )
				echo __( 'No Producer Mobile' );

			/* If there is a duration, append 'minutes' to the text string. */
			else
				echo $producermobile;
			break;

		
	}
}

// Filter Hooks of custom columns 

add_filter("manage_edit-movie_sortable_columns","wp_cpt_sortable_columns");

function wp_cpt_sortable_columns($columns){

	$columns['produ_name'] = "produ_name";
	$columns['produ_email'] = "produ_email";
	$columns['produ_mobile'] = "produ_mobile";
	return $columns;
}

// Create Author Sections 

function wp_cpt_author_call($post)
{?>

<div>
<label>Select Author</label>
<select name="ddauthor">
	<?php
	$users = get_users(array(
		"role"=>"author"
	));

	$saved_author_id = get_post_meta($post->ID,"author_id_movie",true);
	foreach ($users as $key => $value) {
		//print_r($value);
	$selected = "";
	if($saved_author_id == $value->ID){
		$selected = 'selected="selected"';
		}
		?>
<option value="<?php echo $value->ID;?>" <?php echo $selected;?>> <?php echo $value->display_name;?> </option>
<?php }?>
</select>
	</div>

<?php

}

// save author

add_action("save_post","wp_cpt_save_author",10,2);

function wp_cpt_save_author($post_id,$post){
	$author_id = isset($_REQUEST['ddauthor']) ? intval($_REQUEST['ddauthor']):"";
	update_post_meta($post_id,"author_id_movie",$author_id);
}


// show author in dropdown in datatable

add_action("restrict_manage_posts","wp_cpt_author_filter_box");

function wp_cpt_author_filter_box()
{
	global $typenow;
	if($typenow == "movie"){

		$author_id = isset($_GET['filter_by_author']) ? intval($_GET['filter_by_author']):"";
		wp_dropdown_users(array(
			"show_option_none"=>"Select Author",
			"role"=>"author",
			"name"=>"filter_by_author",
			"id"=>"ddfilterauthorid",
			"selected"=>$author_id
		));
	}
}

//Filter with Author Dropdown

add_action("parse_query","wp_cpt_filter_by_author");

function wp_cpt_filter_by_author($query)
{
	global $typenow;
	global $pagenow;

if(isset($_GET['filter_by_author'])){
	$author_id = $_GET['filter_by_author'];
}
else{
	$author_id = "";
	}
	//$author_id = isset($_GET['filter_by_author']) ? intval($_GET['filter_by_author']):"";
	if($typenow == "movie" && $pagenow == "edit.php" && !empty($author_id)){

	$query->query_vars["meta_key"] = "author_id_movie";
	$query->query_vars["meta_value"] = $author_id;
	}
}

// Create custom category 
add_action( 'init', 'wp_cpt_movie_category');

 function wp_cpt_movie_category() {
    register_taxonomy( 
    	'movie_category', 'movie', 
    	array(
        'label'        => __( 'Movie Category' ),
        'rewrite'      => array( 'slug' => 'movie_category' ),
        'hierarchical' => true,
    ) );
}

//show dropdown category in datatable

add_action('restrict_manage_posts', 'tsm_filter_post_type_by_taxonomy');
function tsm_filter_post_type_by_taxonomy() {
	global $typenow;
	$post_type = 'movie'; // change to your post type
	$taxonomy  = 'movie_category'; // change to your taxonomy
	if ($typenow == $post_type) {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'show_option_all' => sprintf( __( 'Show all %s', 'textdomain' ), $info_taxonomy->label ),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
		));
	};
}
/**
 * Filter posts by taxonomy in admin
 * @author  Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_filter('parse_query', 'tsm_convert_id_to_term_in_query');
function tsm_convert_id_to_term_in_query($query) {
	global $pagenow;
	$post_type = 'movie'; // change to your post type
	$taxonomy  = 'movie_category'; // change to your taxonomy
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		
		$q_vars[$taxonomy] = $term->slug;
	}
}

?>
