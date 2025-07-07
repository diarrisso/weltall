<?php get_header(); ?>
<main>
    <div class="container">
        <?php if (have_posts()) : ?>
            <div>
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div>
                            <h2>
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div>
                                <span ><?php echo get_the_date(); ?></span>
                                <span><?php the_author(); ?></span>
                            </div>
                        </div>
                        <div>
                            <?php the_excerpt(); ?>
                        </div>
                        <footer class="entry-footer">
                            <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
                        </footer>
                    </article>
                <?php endwhile; ?>
            </div>

        <?php else : ?>
            <div>
                No content found
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>

