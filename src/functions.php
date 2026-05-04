<?php
/**
 * Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Polente DE
 */

if ( ! function_exists( 'polentede_setup' ) ) :
	function polentede_setup() {
		load_theme_textdomain( 'polentede', get_template_directory() . '/languages' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'polentede_setup' );

/**
 * Register block patterns.
 */
function polentede_register_block_patterns() {
	register_block_pattern_category(
		'polentede',
		array( 'label' => __( 'Polente DE', 'polentede' ) )
	);
}
add_action( 'init', 'polentede_register_block_patterns' );

/**
 * Enqueue front-end styles with cache-busting.
 */
function polentede_enqueue_styles() {
	$theme_version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style(
		'polentede-style',
		get_template_directory_uri() . '/style.min.css',
		array(),
		$theme_version
	);
}
add_action( 'wp_enqueue_scripts', 'polentede_enqueue_styles' );

/**
 * Enqueue editor styles so the block editor matches the front end.
 */
function polentede_editor_assets() {
	add_editor_style( 'style.min.css' );
}
add_action( 'after_setup_theme', 'polentede_editor_assets' );

/**
 * Output a meta description suitable for SEO.
 *
 * Singular: post excerpt or trimmed content.
 * Front/blog: site description (tagline).
 * Archives: term/author description if present, otherwise a generated label.
 */
function polentede_meta_description() {
	$description = '';

	if ( is_singular() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post ) {
			$excerpt = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_strip_all_tags( strip_shortcodes( $post->post_content ) );
			$description = wp_trim_words( $excerpt, 30, '…' );
		}
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( $term && ! empty( $term->description ) ) {
			$description = wp_strip_all_tags( $term->description );
		} else {
			$description = sprintf(
				/* translators: %s: archive title */
				__( 'Articles filed under %s.', 'polentede' ),
				single_term_title( '', false )
			);
		}
	} elseif ( is_author() ) {
		$author = get_queried_object();
		if ( $author && ! empty( $author->description ) ) {
			$description = wp_strip_all_tags( $author->description );
		}
	} elseif ( is_search() ) {
		$description = sprintf(
			/* translators: %s: search query */
			__( 'Search results for “%s”.', 'polentede' ),
			get_search_query()
		);
	}

	if ( '' === $description ) {
		$description = get_bloginfo( 'description', 'display' );
	}

	$description = trim( preg_replace( '/\s+/u', ' ', $description ) );

	if ( '' !== $description ) {
		printf(
			'<meta name="description" content="%s">' . "\n",
			esc_attr( wp_html_excerpt( $description, 160, '…' ) )
		);
	}
}
add_action( 'wp_head', 'polentede_meta_description', 1 );

/**
 * Output Open Graph and Twitter Card tags for richer social previews.
 */
function polentede_social_meta() {
	$site_name = get_bloginfo( 'name' );
	$locale    = get_locale();
	$type      = is_singular( 'post' ) ? 'article' : 'website';
	$title     = wp_get_document_title();
	$url       = is_singular() ? get_permalink() : home_url( add_query_arg( null, null ) );

	$description = '';
	if ( is_singular() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post ) {
			$source      = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_strip_all_tags( strip_shortcodes( $post->post_content ) );
			$description = wp_trim_words( $source, 30, '…' );
		}
	}
	if ( '' === $description ) {
		$description = get_bloginfo( 'description', 'display' );
	}

	$image = '';
	if ( is_singular() && has_post_thumbnail() ) {
		$image = get_the_post_thumbnail_url( null, 'large' );
	} elseif ( has_custom_logo() ) {
		$logo_id = get_theme_mod( 'custom_logo' );
		if ( $logo_id ) {
			$src = wp_get_attachment_image_src( $logo_id, 'full' );
			if ( $src ) {
				$image = $src[0];
			}
		}
	}

	echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( $site_name ) . '">' . "\n";
	echo '<meta property="og:locale" content="' . esc_attr( $locale ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";

	if ( '' !== $description ) {
		echo '<meta property="og:description" content="' . esc_attr( wp_html_excerpt( $description, 200, '…' ) ) . '">' . "\n";
	}
	if ( '' !== $image ) {
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
	}

	echo '<meta name="twitter:card" content="' . ( '' !== $image ? 'summary_large_image' : 'summary' ) . '">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( '' !== $description ) {
		echo '<meta name="twitter:description" content="' . esc_attr( wp_html_excerpt( $description, 200, '…' ) ) . '">' . "\n";
	}
	if ( '' !== $image ) {
		echo '<meta name="twitter:image" content="' . esc_url( $image ) . '">' . "\n";
	}

	if ( is_singular( 'post' ) ) {
		$published = get_the_date( DATE_W3C );
		$modified  = get_the_modified_date( DATE_W3C );
		echo '<meta property="article:published_time" content="' . esc_attr( $published ) . '">' . "\n";
		echo '<meta property="article:modified_time" content="' . esc_attr( $modified ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'polentede_social_meta', 2 );

/**
 * Emit JSON-LD structured data for the site and current post.
 */
function polentede_structured_data() {
	$graph = array();

	$graph[] = array(
		'@type' => 'WebSite',
		'@id'   => home_url( '/#website' ),
		'url'   => home_url( '/' ),
		'name'  => get_bloginfo( 'name' ),
		'description' => get_bloginfo( 'description', 'display' ),
		'inLanguage'  => str_replace( '_', '-', get_locale() ),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => home_url( '/?s={search_term_string}' ),
			),
			'query-input' => 'required name=search_term_string',
		),
	);

	if ( is_singular( 'post' ) ) {
		$post   = get_queried_object();
		$author = get_userdata( (int) $post->post_author );

		$article = array(
			'@type'         => 'BlogPosting',
			'@id'           => get_permalink( $post ) . '#article',
			'mainEntityOfPage' => get_permalink( $post ),
			'headline'      => get_the_title( $post ),
			'datePublished' => get_the_date( DATE_W3C, $post ),
			'dateModified'  => get_the_modified_date( DATE_W3C, $post ),
			'inLanguage'    => str_replace( '_', '-', get_locale() ),
			'url'           => get_permalink( $post ),
			'isPartOf'      => array( '@id' => home_url( '/#website' ) ),
		);

		if ( $author ) {
			$article['author'] = array(
				'@type' => 'Person',
				'name'  => $author->display_name,
				'url'   => get_author_posts_url( $author->ID ),
			);
		}

		if ( has_post_thumbnail( $post ) ) {
			$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'large' );
			if ( $src ) {
				$article['image'] = array(
					'@type'  => 'ImageObject',
					'url'    => $src[0],
					'width'  => (int) $src[1],
					'height' => (int) $src[2],
				);
			}
		}

		$excerpt = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_strip_all_tags( strip_shortcodes( $post->post_content ) );
		$article['description'] = wp_html_excerpt( wp_trim_words( $excerpt, 30, '…' ), 200, '…' );

		$graph[] = $article;
	}

	$payload = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'polentede_structured_data', 5 );

/**
 * Emit a canonical URL for non-singular contexts where core does not.
 */
function polentede_extra_canonical() {
	if ( is_singular() ) {
		return; // Core handles this via rel_canonical().
	}

	$url = '';
	if ( is_front_page() || is_home() ) {
		$url = home_url( '/' );
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$url = get_term_link( get_queried_object() );
	} elseif ( is_author() ) {
		$url = get_author_posts_url( get_queried_object_id() );
	} elseif ( is_post_type_archive() ) {
		$url = get_post_type_archive_link( get_query_var( 'post_type' ) );
	}

	if ( $url && ! is_wp_error( $url ) ) {
		echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'polentede_extra_canonical', 3 );

/**
 * Add a meaningful aria-label to navigation blocks for screen-reader users.
 */
function polentede_navigation_aria_label( $block_content, $block ) {
	if ( false === stripos( $block_content, '<nav' ) ) {
		return $block_content;
	}
	if ( false !== stripos( $block_content, 'aria-label=' ) ) {
		return $block_content;
	}

	$label = ! empty( $block['attrs']['ariaLabel'] )
		? $block['attrs']['ariaLabel']
		: __( 'Site navigation', 'polentede' );

	return preg_replace(
		'/<nav\b/',
		'<nav aria-label="' . esc_attr( $label ) . '"',
		$block_content,
		1
	);
}
add_filter( 'render_block_core/navigation', 'polentede_navigation_aria_label', 10, 2 );

/**
 * Provide an aria-label for the comments pagination region.
 */
function polentede_comments_pagination_aria_label( $block_content ) {
	if ( false === stripos( $block_content, '<nav' ) ) {
		return $block_content;
	}
	if ( false !== stripos( $block_content, 'aria-label=' ) ) {
		return $block_content;
	}
	return preg_replace(
		'/<nav\b/',
		'<nav aria-label="' . esc_attr__( 'Comments pagination', 'polentede' ) . '"',
		$block_content,
		1
	);
}
add_filter( 'render_block_core/comments-pagination', 'polentede_comments_pagination_aria_label', 10, 1 );

/**
 * Provide an aria-label for the query (post list) pagination region.
 */
function polentede_query_pagination_aria_label( $block_content ) {
	if ( false === stripos( $block_content, '<nav' ) ) {
		return $block_content;
	}
	if ( false !== stripos( $block_content, 'aria-label=' ) ) {
		return $block_content;
	}
	return preg_replace(
		'/<nav\b/',
		'<nav aria-label="' . esc_attr__( 'Posts pagination', 'polentede' ) . '"',
		$block_content,
		1
	);
}
add_filter( 'render_block_core/query-pagination', 'polentede_query_pagination_aria_label', 10, 1 );

/**
 * Force decoding="async" and add a sensible default loading attribute on
 * content images that core may have left with eager loading. WP already adds
 * loading="lazy" by default; this is a belt-and-braces fallback for output
 * generated outside the standard image pipeline.
 */
function polentede_image_attributes( $attr ) {
	if ( empty( $attr['decoding'] ) ) {
		$attr['decoding'] = 'async';
	}
	if ( empty( $attr['loading'] ) ) {
		$attr['loading'] = 'lazy';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'polentede_image_attributes' );

/**
 * Ensure a user-friendly aria-label on social link list.
 */
function polentede_social_links_aria_label( $block_content, $block ) {
	if ( false === stripos( $block_content, '<ul' ) ) {
		return $block_content;
	}
	if ( false !== stripos( $block_content, 'aria-label=' ) ) {
		return $block_content;
	}
	return preg_replace(
		'/<ul\b/',
		'<ul aria-label="' . esc_attr__( 'Social media links', 'polentede' ) . '" role="list"',
		$block_content,
		1
	);
}
add_filter( 'render_block_core/social-links', 'polentede_social_links_aria_label', 10, 2 );
