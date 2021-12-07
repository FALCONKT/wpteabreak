(function ($) {
	// IEなら処理回避
	var userAgent = window.navigator.userAgent.toLowerCase();
	if (userAgent.indexOf('msie') != -1 || userAgent.indexOf('trident') != -1) {
		return;
	}


	// 初期表示時
	$( 'input[name=_wpcf7]' ) . each( function() {
		$(this).after('<input type="hidden" name="_wpcf7cp" value="status_input" />');
		return false;
	});


	// ボタンラベルの変更
	$( 'input.wpcf7-submit' ) . attr( 'value', data_arr . cfm_btn );


	// メッセージが存在する場合はスクロール
	$($.find("input[name=_wpcf7_unit_tag]")).each(function () {
		var formElm = $(this).parents("form");
		var responseOutput = formElm.find('div.wpcf7-response-output');
		if (responseOutput.text().length !== 0) {
			var position = responseOutput.offset().top;
			var speed = 500;
			$("html, body").animate({ scrollTop: position - position / 5 }, speed, "swing");
		}
		return false;
	});


	// 確認ボタン押下で確認画面を表示
	var wpcf7cp_confirm = function(unit_tag) {
		const NEW_LINE_CODE = /\r\n|\r|\n/;	// 改行コード
		const PATH_CODE = /[\\\/]/;			// Path区切りコード
		const NEW_LINE_TAG = '<br />';		// 改行タグ

		// ステータスを入力状態から確認状態に変更
		$( 'input[name=_wpcf7cp]' ) . each( function() {
			$(this).val('status_confirm');
			return false;
		});

		var textAreaList = new Array(); 			// テキストエリアのタイトル名を保持するリスト
		var noTitleDammyStr = 'CF7CfmPlsNoTitle';	// タイトルが存在しない場合のダミー文字列
		var noTitleOuterHTMLs = [];					// タイトルが存在しない親P要素のHTML配列

		var dispList = new Array(); // タイトル、入力値を保持するリスト

		// 対象フォーム検索
		$( 'input[name=_wpcf7_unit_tag]' ).each(function(){
			if($(this).val() == unit_tag) {
				var formElm = $(this).parents("form");

				// form全体を非表示にする
				formElm.addClass('wpcf7cp-form-hide');

				// 送信完了メッセージを非表示にする
				var responseOutput = formElm.find('div.wpcf7-response-output');
				responseOutput.addClass("wpcf7cp-force-hide");

				// 入力値取得: avoid-confirmクラス付与要素は回避
				var checkboxNum = 1;
				var radioNum = 1;
				formElm . find( 'input, select, textarea' ) . filter( ':not(.avoid-confirm)' ) . each( function() {
					var title = null;
					var val = null;
					var tagName = $(this).prop("tagName");

					if ("INPUT" == tagName) {
						var inputType = $(this).attr("type");

						switch (inputType) {
							case "submit":
							case "button":
							case "hidden":
							case "image":
								// 処理不要
								break;
							case "radio":
							case "checkbox":
								if ( ! $(this) . is( ':checked' ) ) {
									break;
								}

								title = wpcf7cp_get_title( $( this ) );

								val = $( this ) . val();
								if( '1' === val || 'on' === val ) {
									val = data_arr . checked_msg;
								}
								break;

							case "file":
								title = wpcf7cp_get_title($(this));
								val = $(this).val().split(PATH_CODE).pop();
								break;

							default:
								title = wpcf7cp_get_title($(this));
								val = $(this).val();
						}

					} else if ("TEXTAREA" == tagName) {
						title = wpcf7cp_get_title($(this));
						// サニタイズ & 改行コード変換
						val = $(this).val().replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;').replace(/`/g, '&#x60;').replace(/\r?\n/g, NEW_LINE_TAG);
						textAreaList.push(title);

					} else if("SELECT" == tagName) {
						title = wpcf7cp_get_title($(this));
						val = $(this).val();
					}

					// 有効なタイトルのない場合はouterHTMLに基づくシステム文字列を適用
					if ( ! title ) {
						var outerHTML = $( this ) . parents( 'p' ) . prop( 'outerHTML' );
						var k = $ . inArray( outerHTML, noTitleOuterHTMLs );
						if ( k === -1 ) {
							// 同一のouterHTMLが未格納なら新たなINPUTセットとして処理
							noTitleOuterHTMLs . push( outerHTML );
							k = noTitleOuterHTMLs . length - 1;
						}
						title = noTitleDammyStr + k;
					}

					// 入力値をリストにセット
					if ( title !== null && val !== null ) {
						dispList[title] = ( typeof dispList[title] === 'undefined' ) ? val : dispList[title] + '、' + val ;
					}
				});
			}
		});

		// 確認画面表示
		$( 'div.wpcf7' ).each(function(){
			var cfm_btn_edit = data_arr.cfm_btn_edit;				// 修正ボタン名
			var cfm_btn_mail_send = data_arr.cfm_btn_mail_send;		// この内容で送信するボタン名

			// 確認内容生成
			var wrapperDivObj = $( '<div id="wpcf7cpcnf">' ) . appendTo( this );
			var tableObj = $( '<table>' ) . appendTo( wrapperDivObj );
			for (key in dispList) {
				// タイトルが空欄の場合
				var keyToShow = key;
				var regexp = new RegExp( '^' + noTitleDammyStr + '[0-9]+$');
				if ( keyToShow . match( regexp ) ) {
					// システム文字列を除去して空タイトル表示
					keyToShow = '';
				}

				var title = $('<p></p>').text(keyToShow);
				var titleElm = $('<th>').append(title);
				var val = $.inArray(key, textAreaList) == -1 ? $('<p></p>').text(dispList[key]) : $('<p></p>').html(dispList[key]);
				var valElm = $('<td>').append(val);
				var rowElm = $('<tr>').append(titleElm).append(valElm);

				tableObj . append( rowElm );
			}

			// 修正、送信ボタン生成
			var btnTableElm = $( '<div class="wpcf7cp-btns">' ) . append(
				$(
					'<button type="button" class="wpcf7-form-control wpcf7cp-cfm-edit-btn">' + cfm_btn_edit + '</button>'
				) . click( function() {
					wpcf7cp_edit();
				} )
			) . append(
				$(
					'<button type="button" class="wpcf7-form-control wpcf7-submit wpcf7cp-cfm-submit-btn">' + cfm_btn_mail_send + '</button>'
				) . click( function() {
					wpcf7cp_mail_send();
				} )
			);
			wrapperDivObj . append( btnTableElm );

			// 確認画面トップまでスクロール
			var position = $(this).offset().top;
			var speed = 500;
			$("html, body").animate({scrollTop: position - position / 4 }, speed, "swing");
		});
	}


	// 確認画面から「修正」ボタンで編集画面に復帰
	var wpcf7cp_edit = function(){
		// 確認画面の修正ボタン押下時の処理
		// 非表示としたformを再表示する
		$( '.wpcf7cp-form-hide' ) . each( function() {
			$(this).removeClass("wpcf7cp-form-hide");
		});

		// ステータスを確認状態から入力状態に戻す
		$( 'input[name=_wpcf7cp]' ).each( function() {
			$(this).val('status_input');
			return false;
		});

		// 確認画面を閉じる
		$( '#wpcf7cpcnf' ) . each( function() {
			$(this) . remove();
			return false;
		});
	}


	// 確認画面からメールを送信
	var wpcf7cp_mail_send = function(){
		// 確認画面の、この内容で送信するボタン押下時の処理
		$( '.wpcf7-form' ) . submit();
	}


	// タイトル取得
	var wpcf7cp_get_title = function (element) {
		var title = null;

		// タイプの取得
		var thisObj = $( element );
		var inputType = thisObj . attr( 'type' );

		// checkbox/radioの場合はlegend要素を最優先
		if ( inputType === 'checkbox' || inputType === 'radio' ) {
			var legend = thisObj.closest('fieldset').find('legend');
			if (legend.length) {
				// filedset/legendが適用されていればタイトルに使用
				title = legend.text();
			}
		}

		if ( ! title ) {
			// name対応label要素によるタイトル取得
			var nameVal = thisObj . attr( 'name' );
			if ( inputType !== 'radio' ) {
				var labelObjWithForAttr = $( 'label[for="' + nameVal + '"]' );
				if ( labelObjWithForAttr ) {
					title = labelObjWithForAttr . text();
				}

				// 親label要素（CF7方式）でのタイトル取得
				if ( ! title ) {
					var closestLabelObj = thisObj . closest( 'label' );
					if ( closestLabelObj ) {
						if ( inputType === 'select' ) {
							// セレクトメニューならオプション要素を除去
							closestLabelObj . find( 'option' ) . remove();
						}
						title = closestLabelObj . text();
					}
				}
			}

			// クラス名による明示に対応
			if ( ! title ) {
				var classLabelObj = $( '.title-contactform7.for-' + nameVal );
				if ( classLabelObj ) {
					title = classLabelObj . text();
				}
			}

			// テーブルの同一行に存在する.title-contactform7要素に対応
			if ( ! title ) {
				var closestTrObj = thisObj . closest( 'tr' );
				if ( closestTrObj ) {
					var labelInSameTrObj = closestTrObj . find( '.title-contactform7' );
					if ( labelInSameTrObj ) {
						title = labelInSameTrObj . text();
					}
				}
			}
		}

		if ( title) {
			title = $ . trim( title );
		}

		return title;
	};


	// CF7のAJAXイベント
	document . addEventListener( 'wpcf7submit', function( event ) {
		if ( 'wpcf7cp_confirm' === event.detail.status) {
			wpcf7cp_confirm( event.detail.unitTag );
		}
	}, false );
} )( jQuery );
