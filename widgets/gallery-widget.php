<?php

class Elementor_Rbny_Gallery_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'gallery with images';
	}

	public function get_title() {
		return __( 'gallery with images', 'rbny' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'rbny' ];
	}

	protected function _register_controls() {

		// repeater (item)
		// 		- name (title)
		// 		- main image (image)
		//      - description (text)
		//      - gallery images (gallery)
		//      - 

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'column_count',
			[
				'label' => __( 'Number of images (columns) in row', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'3' => 3,
					'4' => 4,
				],
				'default' => '3',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title', [
				'label' => __( 'Title', 'rbny' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'List Title' , 'rbny' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Main Image', 'rbny' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'gallery',
			[
				'label' => __( 'Images slider in popup', 'rbny' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		$repeater->add_control(
			'list_content', [
				'label' => __( 'Content in popup', 'rbny' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'List Content' , 'rbny' ),
				'show_label' => false,
			]
		);

		$this->add_control(
			'gallery_list',
			[
				'label' => __( 'Gallery', 'rbny' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => __( 'Gallery item #1', 'rbny' ),
						'list_content' => __( 'Item content. Click the edit button to change this text.', 'rbny' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'content_section_form',
			[
				'label' => __( 'Contact Form 7 shortcode', 'rbny' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ct7_shortcode', [
				'label' => __( 'Contact Form 7 shortcode', 'rbny' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Contact Form 7 shortcode' , 'rbny' ),
				'label_block' => true,
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
			$settings = $this->get_settings_for_display();

			$column_count = '';
			if ( $settings['column_count'] == 3 ) {
				$column_count = '4';
			} else {
				$column_count = '3';
			}
		?>
		
		<div class="rbny-gallery-elementor-widget">
			<div class="rbny-row">
			
			<?php if ( ! empty( $settings['gallery_list'] ) ) : ?>
				<?php foreach( $settings['gallery_list'] as $key => $gallery_item ): ?>

					<div class="rbny-col-<?php echo $column_count; ?>">
						<div class="rbny-item" style="background-image: url(<?php echo $gallery_item['image']['url'] ?>);" data-rbny="<?php echo $key; ?>">
							<div class="rbny-item__content">
								<p class="rbny-item__title"><?php echo $gallery_item['list_title']; ?></p>
							</div>
						</div>
					</div>
				
				<?php endforeach; ?>
			<?php endif; ?>

			</div>
		</div>

		<!-- popup -->
		<div class="rbny-overlay">
			<div class="rbny-popup">
				<div class="rbny-popup__container">
					<div class="rbny-popup__close">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M11.1044 10.0008L19.7707 1.33445C20.0758 1.02933 20.0758 0.534647 19.7707 0.22957C19.4656 -0.0755077 18.9709 -0.0755467 18.6658 0.22957L9.9995 8.89588L1.33323 0.22957C1.02811 -0.0755467 0.533427 -0.0755467 0.228349 0.22957C-0.0767284 0.534686 -0.0767674 1.02937 0.228349 1.33445L8.89462 10.0007L0.228349 18.667C-0.0767674 18.9722 -0.0767674 19.4668 0.228349 19.7719C0.380888 19.9245 0.580848 20.0007 0.780809 20.0007C0.980769 20.0007 1.18069 19.9245 1.33327 19.7719L9.9995 11.1056L18.6658 19.7719C18.8183 19.9245 19.0183 20.0007 19.2182 20.0007C19.4182 20.0007 19.6181 19.9245 19.7707 19.7719C20.0758 19.4668 20.0758 18.9721 19.7707 18.667L11.1044 10.0008Z" fill="#0A1500"></path>
						</svg>                    
					</div>
					
					<?php if ( ! empty( $settings['gallery_list'] ) ) : ?>
						<?php foreach( $settings['gallery_list'] as $key => $gallery_item ): ?>

						<div class="rbny-popup__content rbny-popup__content-<?php echo $key; ?>">
							<div class="rbny-popup__wrapper">

								<?php if ( ! empty( $gallery_item['gallery'] ) ) : ?>
									<div class="rbny-popup__slider-col">
										<div class="rbny-popup__slider-<?php echo $key; ?>">

											<?php foreach( $gallery_item['gallery'] as $gallery_img ): ?>
												<div class="rbny-popup__slider-item">
													<div class="rbny-img">
														<img src="<?php echo $gallery_img['url'] ?>" alt="">
													</div>
												</div>
											<?php endforeach; ?>

										</div>
									</div>
								<?php endif; ?>
			
								<div class="rbny-popup__info">
									<div class="rbny-popup__info-content">
										<p class="rbny-popup__info-title"><?php echo $gallery_item['list_title']; ?></p>
										<div class="rbny-popup__info-text">
											<?php echo $gallery_item['list_content']; ?>
										</div>
										<div class="rbny-popup__info-btn">
											<button class="rbny-btn">Perido de encomenda</button>
										</div>
									</div>
									
									
									<div class="rbny-popup__form-wrapper">
										<?php echo do_shortcode($settings['ct7_shortcode']); ?>
												
										<!-- <form action="/" class="rbny-popup__form">

											<input class="order_name" type="hidden" name="order_name" value="">
											<input type="hidden" name="action" value="order_form_submit">
											<div class="rbny-form-control">
												<input type="email" name="email" placeholder="Your Email" required="required">
											</div>
											<div class="rbny-form-control">
												<input type="text" name="name" placeholder="Your Name" required="required">
											</div>
											<div class="rbny-form-control">
												<textarea name="text_field" cols="30" rows="10" placeholder="Demo text field"></textarea>
											</div>
											<div class="rbny-form__btn-wrapper">
												<button class="rbny-btn">Submit</button>
											</div>
										</form> -->
										<!-- <div class="form-success">
											<p class="">Thank you for your order!</p>
											<p>We will call you back within 15 minutes</p>
										</div> -->
									</div>

								</div>
			
							</div>
						</div>

						<?php endforeach; ?>
					<?php endif; ?>

				</div>
			</div>
		</div>

		<?php
	}

	protected function _content_template() {
		?>

		{{ settings.image.url }}
		<div class="rbny-gallery-elementor-widget">
			<div class="rbny-row">
			
			<# if ( settings.gallery_list ) { #>
				<# _.each( settings.gallery_list, function( key, gallery_item ) { #>

					<div class="rbny-col-<?php echo $column_count; ?>">
						<div class="rbny-item" style="background-image: url({{ gallery_item.image.url }});" data-rbny="{{ key }}">
							<div class="rbny-item__content">
								<p class="rbny-item__title">{{ gallery_item.list_title }}</p>
							</div>
						</div>
					</div>
				
				<# }); #>
			<# } #>

			</div>
		</div>

		<!-- popup -->
		<div class="rbny-overlay">
			<div class="rbny-popup">
				<div class="rbny-popup__container">
					<div class="rbny-popup__close">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M11.1044 10.0008L19.7707 1.33445C20.0758 1.02933 20.0758 0.534647 19.7707 0.22957C19.4656 -0.0755077 18.9709 -0.0755467 18.6658 0.22957L9.9995 8.89588L1.33323 0.22957C1.02811 -0.0755467 0.533427 -0.0755467 0.228349 0.22957C-0.0767284 0.534686 -0.0767674 1.02937 0.228349 1.33445L8.89462 10.0007L0.228349 18.667C-0.0767674 18.9722 -0.0767674 19.4668 0.228349 19.7719C0.380888 19.9245 0.580848 20.0007 0.780809 20.0007C0.980769 20.0007 1.18069 19.9245 1.33327 19.7719L9.9995 11.1056L18.6658 19.7719C18.8183 19.9245 19.0183 20.0007 19.2182 20.0007C19.4182 20.0007 19.6181 19.9245 19.7707 19.7719C20.0758 19.4668 20.0758 18.9721 19.7707 18.667L11.1044 10.0008Z" fill="#0A1500"></path>
						</svg>                    
					</div>
					
					<# if ( settings.gallery_list ) { #>
						<# _.each( settings.gallery_list, function( key, gallery_item ) { #>

						<div class="rbny-popup__content rbny-popup__content-{{ key }}">
							<div class="rbny-popup__wrapper">

								<# if ( gallery_item.gallery ) { #>
									<div class="rbny-popup__slider-col">
										<div class="rbny-popup__slider-{{ key }}">

											<# _.each( gallery_item.gallery, function( gallery_img ) { #>
												<div class="rbny-popup__slider-item">
													<div class="rbny-img">
														<img src="{{ gallery_img.url }}" alt="">
													</div>
												</div>
											<# }); #>

										</div>
									</div>
								<# } #>
			
								<div class="rbny-popup__info">
									<div class="rbny-popup__info-content">
										<p class="rbny-popup__info-title">{{ gallery_item.list_title }}</p>
										<div class="rbny-popup__info-text">
											{{ gallery_item.list_content }}
										</div>
										<div class="rbny-popup__info-btn">
											<button class="rbny-btn">Perido de encomenda</button>
										</div>
									</div>
									
									
									<div class="rbny-popup__form-wrapper">
										<form action="" class="rbny-popup__form">
											<input class="order_name" type="hidden" name="order_name" value="">
											<input type="hidden" name="action" value="order_form_submit">
											<div class="rbny-form-control">
												<input type="email" name="email" placeholder="Your Email" required="required">
											</div>
											<div class="rbny-form-control">
												<input type="text" name="name" placeholder="Your Name" required="required">
											</div>
											<div class="rbny-form-control">
												<textarea name="text_field" cols="30" rows="10" placeholder="Demo text field"></textarea>
											</div>
											<div class="rbny-form__btn-wrapper">
												<button class="rbny-btn">Submit</button>
											</div>
										</form>
										<div class="form-success">
											<p class="">Thank you for your order!</p>
											<p>We will call you back within 15 minutes</p>
										</div>
									</div>

								</div>
			
							</div>
						</div>

						<# }); #>
					<# } #>

				</div>
			</div>
		</div>
		<?php
	}


}