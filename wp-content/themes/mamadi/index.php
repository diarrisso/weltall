<?php get_header(); ?>
        <div class="container">
            <?php if (have_posts()) : ?>
                <div>
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div>
                                <h2 >
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div>
                                    <span><?php echo get_the_date(); ?></span>
                                    <span ><?php the_author(); ?></span>
                                </div>
                            </div>

                            <div>
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" >
                                <div>
                                    <span><?php esc_html_e('Read More', 'mamadi'); ?></span>
                                </div>
                            </a>

                        </article>
                    <?php endwhile; ?>
                </div>

                <div>
                    <?php the_posts_navigation(); ?>
                </div>

            <?php else : ?>
                <div>
                    <p><?php esc_html_e('No content found', 'mamadi'); ?></p>
                </div>
            <?php endif; ?>
        </div>

<?php get_footer(); ?>