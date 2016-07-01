<?php get_header(); ?>
<div class="col-md-12">
  <div class="card">
    <div class="card-block">
      <h1 class="card-title"><?php the_title(); ?></h4>
    </div>
    <div class="card-block">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>市町村</th>
            <th>学校名</th>
            <th>文化祭名</th>
            <th>詳細ページ</th>
          </tr>
        </thead>
        <tbody>
<?php
  $args = array(
            'meta_query'  =>  array(
                                'meta'=>array(
                                          'key'  =>  'address',
                                          'type' =>  'CHAR',
                                        )
                              ),
            'post_type'   => 'post',
            'order'       => 'ASC',
            'orderby'     => 'meta',
            'nopaging'    => true,
          );
  $posts = query_posts($args);
  $tmp = array();
  foreach ( $posts as $post ):
    if ( in_array( get_field('schoolName', $post->ID), $tmp) ) {
      continue;
    } ?>
        <tr>
          <td>
<?php
  $category      = get_the_category( $post->ID );
  $cayrgory_name = $category[0]->name; ?>
            <a href="<?php echo get_category_link( $category[0]->cat_ID ); ?>"><?php echo $cayrgory_name; ?></a>
          </td>
          <td><?php the_field('schoolName', $post->ID); ?></td>
          <td><?php the_field('name', $post->ID); ?></td>
          <td class="year">
<?php
    if ( is_other_year_post( get_field('schoolName', $post->ID) ) ):
      $args = array(
              'meta_value' => get_field('schoolName', $post->ID),
              );
      $result = get_posts($args);

      foreach ( $result as $post ):
        $start_date = date_create( get_field('startDate', $post->ID) ); ?>
            <a href="<?php echo get_permalink($post->ID); ?>"><?php echo date_format($start_date, 'Y'); ?>年</a>
<?php
      endforeach;

    else:
      $start_date = date_create( get_field('startDate', $post->ID) ); ?>
            <a href="<?php echo get_permalink($post->ID); ?>"><?php echo date_format($start_date, 'Y'); ?>年</a>
<?php
    endif; ?>
          </td>
        </tr>
<?php
          $tmp[] = get_field('schoolName', $post->ID);
  endforeach;
?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php get_footer(); ?>
