<?php
$title = get_field( 'title' );

$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
	$countries = implode( ',', $selectCountry );
} else {
	$countries = '';
}

$BlockId  = get_field( 'block_id' );
$BlockCss = get_field( 'block_css' );
?>

<div class="content-panel plum-bg <?= $BlockCss; ?>"
     data-country="<?= esc_attr( $countries ) ?>"
     id="<?= $BlockId; ?>">
    <div class="container white-text">
        <div class="yellow-title--section fade-in in-view">
            <h2 class="h5 snug"><?= $title ?></h2>
        </div>
        <ul class="container-office">
			<?php if ( have_rows( 'main_office' ) ) : ?>
				<?php while ( have_rows( 'main_office' ) ) : the_row();
					$title = get_sub_field( 'title' );
					?>
                    <li class="main-office-list">
                        <div class="main-office">
                            <div class="main-office-content">
                                <p class="h6"><?= $title ?></p>
                                <svg width="18" height="16" viewBox="0 0 18 16" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.625156 8L13.8846 8" stroke="currentcolor" stroke-width="1.84615"
                                          stroke-miterlimit="10"></path>
                                    <path d="M10.4715 15.3846C10.4715 11.3231 13.4254 8 17.0356 8" stroke="currentcolor"
                                          stroke-width="1.84615" stroke-miterlimit="10"></path>
                                    <path d="M10.4715 0.617187C10.4715 4.67873 13.4254 8.0018 17.0356 8.0018"
                                          stroke="currentcolor" stroke-width="1.84615" stroke-miterlimit="10"></path>
                                </svg>
                            </div>

                            <div class="sub-office-list">
								<?php if ( have_rows( 'sub_office' ) ) : ?>
									<?php while ( have_rows( 'sub_office' ) ) : the_row();
										$subOffice = get_sub_field( 'sub_office_name' );
										$address1  = get_sub_field( 'address_1' );
										$address2  = get_sub_field( 'address_2' );
										$city      = get_sub_field( 'city' );
										$country   = get_sub_field( 'country' );
										$areaCode  = get_sub_field( 'area_code' );
										?>
                                        <div class="sub-office">
                                            <div class="sub-office-content">
                                                <p class="h6"><?= esc_html( $subOffice ) ?></p>
                                                <svg width="18" height="16" viewBox="0 0 18 16" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0.625156 8L13.8846 8" stroke="currentcolor"
                                                          stroke-width="1.84615" stroke-miterlimit="10"></path>
                                                    <path d="M10.4715 15.3846C10.4715 11.3231 13.4254 8 17.0356 8"
                                                          stroke="currentcolor" stroke-width="1.84615"
                                                          stroke-miterlimit="10"></path>
                                                    <path d="M10.4715 0.617187C10.4715 4.67873 13.4254 8.0018 17.0356 8.0018"
                                                          stroke="currentcolor" stroke-width="1.84615"
                                                          stroke-miterlimit="10"></path>
                                                </svg>
                                            </div>

                                            <div class="address-office">

                                                <p><?= esc_html( $address1 ) ?></p>
                                                <p><?= esc_html( $address2 ); ?></p>
                                                <p>
                                                    <span><?= esc_html( $city ); ?></span>
                                                    <span><?= esc_html( $country ); ?></span>
                                                    <span><?= esc_html( $areaCode ); ?></span>
                                                </p>
                                                <div class="loopnumb">
													<?php if ( have_rows( 'contact_list' ) ) : ?>
														<?php while ( have_rows( 'contact_list' ) ) : the_row();
															$icon       = get_sub_field( 'icon' );
															$number     = get_sub_field( 'number' );
															$linkNumber = get_sub_field( 'link_number' );

															?>

                                                            <div class="phone-numb">
																<?php if ( ! empty( $icon ) ): ?>
                                                                    <img src="<?= esc_url( $icon['url'] ); ?>"
                                                                         alt="<?= esc_attr( $icon['alt'] ); ?>"
                                                                         class="icon-size-medium"/>
																<?php else: ?>
                                                                    <img src="" alt="" style="display: none;"/>
																<?php endif; ?>
                                                                <p>
                                                                    <a href="<?= esc_html( $linkNumber ); ?>"><?= esc_html( $number ); ?></a>
                                                                </p>
                                                            </div>


														<?php endwhile; ?>
													<?php endif; ?>
                                                </div>
                                            </div>


                                        </div>
									<?php endwhile; ?>
								<?php endif; ?>
                            </div>

                        </div>
                    </li>
				<?php endwhile; ?>
			<?php endif; ?>
        </ul>
    </div>
</div>