<?php get_header(); ?>
    <main>
        <div class="container">
            <h2 class="text-center mb-5">Unsere Kategorien</h2>
            <div class="row justify-content-center">
                <?php
                $product_categories = get_terms(array(
                    'taxonomy' => 'product_cat',
                    'hide_empty' => true,
                    'parent' => 0,
                    'number' => 6
                ));

                if (!empty($product_categories)) :
                    foreach ($product_categories as $category) :
                        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                        $image = wp_get_attachment_url($thumbnail_id);
                        $category_link = get_term_link($category);
                        ?>
                        <div class="col-md-4 mb-4">
                            <a href="<?php echo esc_url($category_link); ?>" class="category-card">
                                <div class="category-image">
                                    <?php if ($image) : ?>
                                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($category->name); ?>" loading="lazy">
                                    <?php else : ?>
                                        <div class="no-image">
                                            <span></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <h3><?php echo esc_html($category->name); ?></h3>
                            </a>
                        </div>
                    <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
</main>

<?php get_footer(); ?>