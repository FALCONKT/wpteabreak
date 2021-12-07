<?php


class ContactForm7CfmPls {

	public function __construct() {
		// Contact Form 7 が存在するかチェック。存在しなければ警告表示
		add_action( 'admin_notices', array($this,'wpcf7cp_check_for_manage_top' ));
		add_filter( 'plugin_row_meta', array($this,'wpcf7cp_check_for_plugin_list'), 10, 2 );

		// 国際化
		add_action( 'plugins_loaded',array($this, 'wpcf7cp_load_textdomain' ));

		// scripts,cssの読み込み
		add_action( 'wpcf7_enqueue_scripts', array($this,'wpcf7cp_enqueue_scripts') );
		add_action( 'wpcf7_enqueue_styles',array($this, 'wpcf7cp_enqueue_styles' ));

		// メール送信判断
		add_filter( 'wpcf7_skip_mail', array( $this, 'wpcf7cp_skip_mail' ) );

		// 確認ボタン押下時の送信ボタンのステータスを戻す（mail_sent → wpcf7cp_confirm）
		add_filter( 'wpcf7_feedback_response', array( $this, 'wpcf7cp_btn_status_back' ) );
	}

	function wpcf7cp_check_for_manage_top() {
		// Contact Form 7 チェック
		if ( class_exists( 'ContactForm7CfmPls' ) && !class_exists( 'WPCF7_ContactForm' ) ) {
			// 当プラグインのクラスが存在する、かつ、Contact Form 7 のクラスが存在しない場合は警告表示する
			printf('<div class="error"><p><strong>Contact Form 7 confirm plus: </strong>%s</p></div>', __('Contact Form 7 must be installed and activated', WPCF7CP_PLUGIN_NAME ));

		} else if ( class_exists( 'ContactForm7CfmPls' ) && class_exists( 'WPCF7_ContactForm' ) ) {
			// 当プラグインのクラスが存在する、かつ、Contact Form 7 のクラスが存在する場合
			// Contact Form 7 のバージョンが 5.4.2 以上か確認し、これ未満であれば警告表示する
			if (version_compare(WPCF7_VERSION, "5.4.2") < 0) {
				printf('<div class="error"><p><strong>Contact Form 7 confirm plus: </strong>%s</p></div>', __('Contact Form 7 must be version 5.4.2 or later', WPCF7CP_PLUGIN_NAME ));
			}
		}

		// ブラウザチェック
		if ( ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false || strpos( $_SERVER['HTTP_USER_AGENT'], 'Trident' ) !== false ) && strpos( $_SERVER['HTTP_USER_AGENT'], 'Win' ) !== false ) {
			// IEの場合は警告表示
			printf('<div class="error"><p><strong>Contact Form 7 confirm plus: </strong>%s</p></div>', __('Internet Explorer is not supported', WPCF7CP_PLUGIN_NAME ));
		}
	}

	public function wpcf7cp_check_for_plugin_list( $links, $file ) {
		$pos = strpos( $file, '/' );
		if( false !== $pos ){
			$plugin_name = substr( $file , 0, $pos );

			// Contact Form 7 チェッック
			if ( WPCF7CP_PLUGIN_NAME == $plugin_name && !class_exists( 'WPCF7_ContactForm' ) ) {
				// 当プラグイン表示時、かつ、Contact Form 7 のクラスが存在しない場合は警告表示する
				$links[] = '<br /><br /><span style="color:red">※' . __('Contact Form 7 must be installed and activated', WPCF7CP_PLUGIN_NAME) . '.</span>';

			} else if ( WPCF7CP_PLUGIN_NAME == $plugin_name && class_exists( 'WPCF7_ContactForm' ) ) {
				// 当プラグイン表示時、かつ、Contact Form 7 のクラスが存在する場合
				// Contact Form 7 のバージョンが 5.4.2 以上か確認し、これ未満であれば警告表示する
				if (version_compare(WPCF7_VERSION, "5.4.2") < 0) {
					$links[] = '<br /><br /><span style="color:red">※' . __('Contact Form 7 must be version 5.4.2 or later', WPCF7CP_PLUGIN_NAME) . '.</span>';
				}
			}

			// ブラウザチェック
			if ( WPCF7CP_PLUGIN_NAME == $plugin_name && ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false || strpos( $_SERVER['HTTP_USER_AGENT'], 'Trident' ) !== false ) && strpos( $_SERVER['HTTP_USER_AGENT'], 'Win' ) !== false ) {
				// IEの場合は警告表示
				$links[] = '<br /><br /><span style="color:red">※' . __('Internet Explorer is not supported', WPCF7CP_PLUGIN_NAME) . '.</span>';
			}
		}
		return $links;
	}

	public function wpcf7cp_enqueue_scripts() {
	   $in_footer = true;
		if ( 'header' === WPCF7_LOAD_JS )
			$in_footer = false;

		// scriptファイル読み込み
		// 国際化したボタン名をscriptに渡す
		$data_arr = array(
			// 'jquery', 'jquery-form',
			'cfm_title_suffix' => __('confirm', WPCF7CP_PLUGIN_NAME),
			'cfm_btn' => __('confirm', WPCF7CP_PLUGIN_NAME),
			'cfm_btn_edit' => __('edit', WPCF7CP_PLUGIN_NAME),
			'cfm_btn_mail_send' => __('send mail', WPCF7CP_PLUGIN_NAME),
			'checked_msg' => __( 'checked', WPCF7CP_PLUGIN_NAME ),
		);
		wp_enqueue_script( 'contact-form-7-confirm-plus',
			$this->get_plugin_url( 'assets/js/scripts.js' ),
			get_template_directory_uri(), WPCF7CP_VERSION, $in_footer );
		wp_localize_script( 'contact-form-7-confirm-plus', 'data_arr', $data_arr );

		// jquery-ui-dialog読み込み
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_style( 'jquery-ui-dialog-min-css', includes_url().'css/jquery-ui-dialog.min.css' );
	}

	public function wpcf7cp_enqueue_styles(){
		// cssファイル読み込み
		wp_enqueue_style( 'contact-form-7-confirm-plus',
			$this->get_plugin_url( 'assets/css/styles.css' ),
			array(), WPCF7CP_VERSION, 'all' );
	}

	public function wpcf7cp_skip_mail() {
		$status_sanitized = sanitize_text_field( $_POST["_wpcf7cp"] );	// サニタイズ後のPOST値

		if ( isset( $status_sanitized ) && 'status_confirm' == $status_sanitized ) {
			// 確認状態の場合はメール送信する
			return false;
		} else {
			// 入力状態の場合はメール送信しない
			remove_all_actions( 'wpcf7_submit' );
			return true;
		}
	}

	public function wpcf7cp_btn_status_back( $items ) {
		if($items['status'] == 'mail_sent' ) {
			$items["message"]  = "";
			$items["mailSent"] = false;
			$items["status"] = 'wpcf7cp_confirm';
		}
		return $items;
	}

	public function get_plugin_url( $path = '' ) {
		// プラグインURLを付加したパスを返却
		$url = untrailingslashit( WPCF7CP_PLUGIN_URL );

		if ( ! empty( $path ) && is_string( $path ) && false === strpos( $path, '..' ) )
			$url .= '/' . ltrim( $path, '/' );

		return $url;
	}

	function wpcf7cp_load_textdomain( $locale = null ) {
		global $l10n;

		$domain = WPCF7CP_PLUGIN_NAME;

		if ( get_locale() == $locale ) {
			$locale = null;
		}

		if ( empty( $locale ) ) {
			if ( is_textdomain_loaded( $domain ) ) {
				// テキストドメインの翻訳が存在する
				return true;
			} else {
				// テキストドメインの翻訳が存在しない
				// プラグイン用の国際化用ファイル（MOファイル）をロードする
				return load_plugin_textdomain( $domain, false, $domain . '/languages' );
			}
		} else {
			$mo_orig = $l10n[$domain];
			// テキストドメインの翻訳をアンロードする
			unload_textdomain( $domain );

			$mofile = $domain . '-' . $locale . '.mo';
			$path = WP_PLUGIN_DIR . '/' . $domain . '/languages';

			if ( $loaded = load_textdomain( $domain, $path . '/'. $mofile ) ) {
				return $loaded;
			} else {
				$mofile = WP_LANG_DIR . '/plugins/' . $mofile;
				return load_textdomain( $domain, $mofile );
			}

			$l10n[$domain] = $mo_orig;
		}

		return false;
	}


};

$contactForm7CfmPls = new ContactForm7CfmPls();
