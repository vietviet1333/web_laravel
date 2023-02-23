var AG = {
	init: function() {
		this.Main.init();
		if(template.indexOf('index') != -1){
			this.Index.init();
		}		
		if(template == 'collection'){
			this.Collection.init();
		}
		if(template == 'page.about'){
			this.PageAbout.init();
		}
		if(template == 'search'){
			this.PageSearch.init();
		}
		if(template == 'customers[register]' || template == 'customers[login]'){
			this.Register.init();
		}
	}
}
AG.All = {
	update_cart: function(id, quantity) {
		var line = {
			line: id,
			quantity: quantity
		};
		$.ajax({
			type: 'POST',
			url: "/cart/change.js",
			data: line,
			dataType: "json",
			success: function(datas) {
				AG.Main.getModalCart(false); // false để không dropdown minicart
				$('.count-holder').html(datas.item_count);
				$('.orders-cart .orders-cart-bottom .tax .orders-total').html(Haravan.formatMoney(datas.total_price, formatMoney));
				$('.orders-cart .orders-cart-bottom .amount .orders-total').html(Haravan.formatMoney(datas.total_price, formatMoney));
				if ($('.sticky-right').hasClass('active')) {
					//$('.cart-mobile .flex-box').html('<span>' + datas.items.length + ' Món</span><span>' + Haravan.formatMoney(datas.total_price, formatMoney) + '</span><span>Đóng</span>');
					$('.cart-mobile .flex-box .cartmb--1 b').html(datas.items.length);
					$('.cart-mobile .flex-box .cartmb--2').html(Haravan.formatMoney(datas.total_price, formatMoney));
					$('.cart-mobile .flex-box .cartmb--3').html('Đóng');
				} else {
					//$('.cart-mobile .flex-box').html('<span>' + datas.items.length + ' Món</span><span>Xem chi tiết</span><span>' + Haravan.formatMoney(datas.total_price, formatMoney) + '</span>');
					$('.cart-mobile .flex-box .cartmb--1 b').html(datas.items.length);
					$('.cart-mobile .flex-box .cartmb--2').html(Haravan.formatMoney(datas.total_price, formatMoney));
					$('.cart-mobile .flex-box .cartmb--3').html('Xem chi tiết');
				}
				for (i = 0; i < datas.items.length; i++) {
					var id = datas.items[i].variant_id;
					var price = Haravan.formatMoney(datas.items[i].line_price, formatMoney);
					$('.orders-cart .cart-item[data-id="' + id + '"] .quantity-selector').val(datas.items[i].quantity);
					$('.orders-cart .cart-item[data-id="' + id + '"] .cart-item-price p').html(price);
				}
			}
		});
	},
	minusQuickview: function($this, hasUpdate) {
		var self = this;
		var val = parseInt($this.parent().find('input').val());
		var id = $this.parents('.select-quantity').data('id');
		if (val != undefined) {
			if (val > 1) {
				$this.next().val(val - 1);
				if (val == 2) $this.addClass('disabled');
			}
			if(hasUpdate && (val-1 >= 1)){
				self.update_cart(id, val - 1);
			}
		} else {
			console.log('error: Not see elemnt ' + jQuery('input[name="quantity"]').val());
		}
		var $input = $this.parent().find('input[name="quantity"]').eq(0);
		if ($input.attr('data-limit') == '' || $input.attr('data-limit') == null) return false;
		var qty = $input.val(),
				limit = parseInt($input.attr('data-limit'));
		if (isNaN(limit)) return false;
		if (qty > limit && limit > 0 ) {
			$input.val(limit);
		}
	},
	plusQuickview: function($this, hasUpdate) {		
		var self = this;
		var val = parseInt($this.parent().find('input').val());
		var id = $this.parents('.select-quantity').data('id');
		var dataMax = parseInt($this.parent().find('input').attr('data-limit'));
		if (val != undefined) {
			$this.prev().val(val + 1);
			$this.parent().find('.btn-sub').removeClass('disabled');
			if(hasUpdate && ((val+1) <= dataMax || dataMax == 0) ){
				self.update_cart(id, val + 1);
			}
		} else {
			console.log('error: Not see elemnt ' + jQuery('input[name="quantity"]').val());
		}

		var $input = $this.parent().find('input[name="quantity"]').eq(0);
		if ($input.attr('data-limit') == '' || $input.attr('data-limit') == null || $input.attr('data-limit') == 0) return false;
		var qty = $input.val(),
				limit = parseInt($input.attr('data-limit'));
		if (isNaN(limit)) return false;
		if (qty > limit && limit > 0 ) {
			$this.parents('.cart-item').find('.variant_error').fadeIn();
			$input.val(limit);		
		}
	}
}
AG.Main = {
	init: function(){
		this.scrollFixedHeader();
		this.searchAutoHeader();
		this.actionIconHeader();
		this.menuMobile();
		this.toggleSidebar();
		this.footerAccordion();
		this.addListSharing();
		this.recapcha();
		this.deleteCart();
		this.buyInLoop();
		this.formSubmit();
		this.miniAccountPhone();
		this.modalQuickViewMobile();
	},
	minus: function(){
		if ($('.block-quantity input[name="quantity"]').val() != undefined ) {
			var currentVal = parseInt($('.block-quantity input[name="quantity"]').val());
			if (!isNaN(currentVal) && currentVal > 1) {
				$('.block-quantity input[name="quantity"]').val(currentVal - 1);
			}
		}else {
			console.log('error: Not see elemnt ' + $('.block-quantity input[name="quantity"]').val());
		}
	},
	plus: function(){
		if ( $('.block-quantity input[name="quantity"]').val() != undefined ) {
			var currentVal = parseInt($('.block-quantity input[name="quantity"]').val());
			if (!isNaN(currentVal)) {
				$('.block-quantity input[name="quantity"]').val(currentVal + 1);
			} else {
				$('.block-quantity input[name="quantity"]').val(1);
			}
		}else {
			console.log('error: Not see elemnt ' + $('.block-quantity input[name="quantity"]').val());
		}
	},
	recapcha: function(){
		$('#header-login-panel form#customer_login').submit(function(e) { 
			var self = $(this);
			if($(this)[0].checkValidity() == true){
				e.preventDefault();
				grecaptcha.ready(function() {
					grecaptcha.execute('6LdD18MUAAAAAHqKl3Avv8W-tREL6LangePxQLM-', {action: 'submit'}).then(function(token) {
						self.find('input[name="g-recaptcha-response"]').val(token);
						self.unbind('submit').submit();
					}); 
				});
			}
		});
		$('#header-recover-panel form').submit(function(e) { 
			var self = $(this);
			if($(this)[0].checkValidity() == true){
				e.preventDefault();
				grecaptcha.ready(function() {
					grecaptcha.execute('6LdD18MUAAAAAHqKl3Avv8W-tREL6LangePxQLM-', {action: 'submit'}).then(function(token) {
						self.find('input[name="g-recaptcha-response"]').val(token);
						self.unbind('submit').submit();
					}); 
				});
			}
		});
	},
	deleteCart: function(){
		$(document).on('click', '.remove-cart a', function(){
			var line = parseInt($(this).attr('data-index'));
			var params = {
				type: 'POST',
				url: '/cart/change.js',
				data: 'quantity=0&line=' + line,
				dataType: 'json',
				success: function(cart) {
					AG.Main.getModalCart();
					if(template == 'index'){
						$.ajax({
							type:'GET',
							url: '/cart?view=update',
							success: function(data){
								$('.ajax-here').html(data);
							}
						});
					}
				},
				error: function(XMLHttpRequest, textStatus) {
					Haravan.onError(XMLHttpRequest, textStatus);
				}
			};
			$.ajax(params);
		});
	},
	cloneItem: function(product,i){
		var item_product = $('#clone-item-cart').find('.item_2');
		if ( product.image == null ) {
			item_product.find('img').attr('src','//theme.hstatic.net/200000291375/1000738823/14/no_image.jpg?v=325').attr('alt', product.url);
		} else {
			item_product.find('img').attr('src',Haravan.resizeImage(product.image,'small')).attr('alt', product.url);
		}
		item_product.find('a:not(.remove-cart)').attr('href', product.url).attr('title', product.url);
		item_product.find('.pro-title-view').html(product.title);
		item_product.find('.pro-quantity-view .qty-value').html(product.quantity);
		item_product.find('.pro-price-view').html(Haravan.formatMoney(product.price,formatMoney));
		item_product.find('.remove-cart').html('<a href="javascript:void(0);" data-index="' + (i+1) + '" ><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve"> <g><path d="M500,442.7L79.3,22.6C63.4,6.7,37.7,6.7,21.9,22.5C6.1,38.3,6.1,64,22,79.9L442.6,500L22,920.1C6,936,6.1,961.6,21.9,977.5c15.8,15.8,41.6,15.8,57.4-0.1L500,557.3l420.7,420.1c16,15.9,41.6,15.9,57.4,0.1c15.8-15.8,15.8-41.5-0.1-57.4L557.4,500L978,79.9c16-15.9,15.9-41.5,0.1-57.4c-15.8-15.8-41.6-15.8-57.4,0.1L500,442.7L500,442.7z"/></g> </svg></a>');
		var title = '';
		if(product.variant_options.indexOf('Default Title') == -1){
			$.each(product.variant_options,function(i,v){
				title = title + v + ' / ';
			});
			title = title + '@@';
			title = title.replace(' / @@','')
			item_product.find('.variant').html(title);
		}else {
			item_product.find('.variant').html('');
		}
		var data_append = item_product.clone().removeClass('d-none');
		$('#cart-view').append(data_append);
	},
	getModalCart: function(show){
		var cart = null;
		$('#cartform').hide();
		$('#myCart #exampleModalLabel').text("Giỏ hàng");
		$.getJSON('/cart.js', function(cart, textStatus) {
			if(cart) {
				if (cart.item_count == 0){
					$(".btn-check a").addClass("disabled");
				}
				else{
					$(".btn-check a").removeClass("disabled");
				}
				$('.count-holder').html(cart.item_count);
				if($('.sticky-right').hasClass('active')){
					//$('.cart-mobile .flex-box').html('<span>'+cart.items.length+' Món</span><span>'+Haravan.formatMoney(cart.total_price, formatMoney)+'</span><span>Đóng</span>');
					$('.cart-mobile .flex-box .cartmb--1 b').html(cart.items.length);
					$('.cart-mobile .flex-box .cartmb--2').html(Haravan.formatMoney(cart.total_price, formatMoney));
					$('.cart-mobile .flex-box .cartmb--3').html('Đóng');
				}
				else{
					//$('.cart-mobile .flex-box').html('<span>'+cart.items.length+' Món</span><span>'+Haravan.formatMoney(cart.total_price, formatMoney)+'</span><span>Xem chi tiết</span>');
					$('.cart-mobile .flex-box .cartmb--1 b').html(cart.items.length);
					$('.cart-mobile .flex-box .cartmb--2').html(Haravan.formatMoney(cart.total_price, formatMoney));
					$('.cart-mobile .flex-box .cartmb--3').html('Xem chi tiết');

				}
				$('.count-holder').html(cart.item_count);
				//$('.cart-mobile .flex-box').html('<span>'+cart.items.length+' Món</span><span>'+Haravan.formatMoney(cart.total_price, "")+'</span><span>Đóng</span>');
				$('#cartform').show();
				$('.line-item:not(.original)').remove();
				$.each(cart.items,function(i,item){
					var total_line = 0;
					var total_line = item.quantity * item.price;
					tr = $('.original').clone().removeClass('original').appendTo('table#cart-table tbody');
					if(item.image != null)
						tr.find('.item-image').html("<img src=" + Haravan.resizeImage(item.image,'small') + ">");
					else
						tr.find('.item-image').html("<img src='//theme.hstatic.net/200000291375/1000738823/14/no_image.jpg?v=325'>");
					vt = item.variant_options;
					if(vt.indexOf('Default Title') != -1)
						vt = '';
					tr.find('.item-title').children('a').html(item.product_title + '<br><span>' + vt + '</span>').attr('href', item.url);
					tr.find('.item-quantity').html("<input id='quantity1' name='updates[]' min='1' type='number' value=" + item.quantity + " class='' />");
					if ( typeof(formatMoney) != 'undefined' ){
						tr.find('.item-price').html(Haravan.formatMoney(total_line, formatMoney));
					}else {
						tr.find('.item-price').html(Haravan.formatMoney(total_line, ''));
					}
					tr.find('.item-delete').html("<a href='javascript:void(0);' data-index='" + (i+1) + "' ><i class='fa fa-times'></i></a>");
				});
				$('.item-total').html(Haravan.formatMoney(cart.total_price, formatMoney));
				$('.modal-title').children('b').html(cart.item_count);
				$('.icon-header-control--cart-count').html(cart.item_count);
				if(cart.item_count == 0){				
					$('#exampleModalLabel').html('Giỏ hàng của bạn đang trống. Mời bạn tiếp tục mua hàng.');
					$('#cart-view').html('<tr class="item-cart_empty"><td><div class="svgico-mini-cart"> <svg width="81" height="70" viewBox="0 0 81 70"><g transform="translate(0 2)" stroke-width="4" stroke="#1e2d7d" fill="none" fill-rule="evenodd"><circle stroke-linecap="square" cx="34" cy="60" r="6"></circle><circle stroke-linecap="square" cx="67" cy="60" r="6"></circle><path d="M22.9360352 15h54.8070373l-4.3391876 30H30.3387146L19.6676025 0H.99560547"></path></g></svg></div> Hiện chưa có sản phẩm</td></tr>');
					$('#cartform').hide();
				}
				else{			
					$('#exampleModalLabel').html('Bạn có ' + cart.item_count + ' sản phẩm trong giỏ hàng.');
					$('#cartform').removeClass('hidden');
					$('#cart-view').html('');
				}
				if ($('#cart-pos-product').length > 0 ) {
					$('#cart-pos-product span').html(cart.item_count + ' sản phẩm');
				}
				$.each(cart.items,function(i,item){
					AG.Main.cloneItem(item,i);
				});
				$('#total-view-cart').html(Haravan.formatMoney(cart.total_price, formatMoney));
			}
			else{
				$('#exampleModalLabel').html('Giỏ hàng của bạn đang trống. Mời bạn tiếp tục mua hàng.');
				$('.icon-header-control--cart-count').html(cart.item_count);
				if ( $('#cart-pos-product').length > 0 ) {
					$('#cart-pos-product span').html(cart.item_count + ' sản phẩm');
				}
				$('#cart-view').html('<tr class="item-cart_empty"><td><div class="svgico-mini-cart"> <svg width="81" height="70" viewBox="0 0 81 70"><g transform="translate(0 2)" stroke-width="4" stroke="#1e2d7d" fill="none" fill-rule="evenodd"><circle stroke-linecap="square" cx="34" cy="60" r="6"></circle><circle stroke-linecap="square" cx="67" cy="60" r="6"></circle><path d="M22.9360352 15h54.8070373l-4.3391876 30H30.3387146L19.6676025 0H.99560547"></path></g></svg></div> Hiện chưa có sản phẩm</td></tr>');
				$('#cartform').hide();
			}
		});
		if(show != false){
			if(!$('.header-action_cart').hasClass('js-action-show')){
				$('body').removeClass("locked-scroll");
				$('.header-action-item').removeClass('js-action-show');
			}
			if($('.mainHeader').hasClass('hSticky')){
				$('.mainHeader').addClass("hSticky-nav");
				setTimeout(function(){
					$('.mainHeader').addClass("hSticky-up");
				}, 300);
				setTimeout(function(){
					$('.header-action_cart').addClass("js-action-show");
					$('body').addClass("locked-scroll");
				}, 500);
			}
			else{
				$('.header-action_cart').addClass("js-action-show");
				$('body').addClass("locked-scroll");
				$('html, body').animate({
					scrollTop: 0			
				}, 600);
			}
		}
	},
	fixHeightProduct(data_parent, data_target, data_image) {
		var box_height = 0;
		var box_image = 0;
		var boxtarget = data_parent + ' ' + data_target;
		var boximg = data_parent + ' ' + data_target + ' ' + data_image;
		$(boximg).css('height', 'auto');
		$($(boxtarget)).css('height', 'auto');
		$($(boxtarget)).removeClass('fixheight');
		$($(boxtarget)).each(function() {
			if ($(this).find(data_image + ' .lazyloaded').height() > box_image) {
				box_image = $(this).find($(data_image)).height();
			}
		});
		if (box_image > 0) {
			$(boximg).height(box_image);
		}
		$($(boxtarget)).each(function() {
			if ($(this).height() > box_height) {
				box_height = $(this).height();
			}
		});
		$($(boxtarget)).addClass('fixheight');
		if (box_height > 0) {
			$($(boxtarget)).height(box_height);
		}
		try {
			fixheightcallback();
		} catch (ex) {}
	},
	boxAccount: function(type){
		$('.site_account .site_account_panel_list .site_account_panel ').removeClass('is-selected');
		var newheight = $('.site_account .site_account_panel_list .site_account_panel#' + type).addClass('is-selected').height();
		if($('.site_account_panel').hasClass('is-selected')){
			$('.site_account_panel_list').css("height", newheight);
		}
	},
	scrollFixedHeader: function(){
		var $parentHeader = $('.mainHeader--height');
		var parentHeight = $parentHeader.find('.mainHeader').outerHeight();
		var $header = $('.mainHeader'),  $body = $('body');
		var offset_sticky_header = $header.outerHeight() + 100;
		var offset_sticky_down = 0;
		$parentHeader.css('min-height', parentHeight );	
		var resizeTimer = false,
				resizeWindow = $(window).prop("innerWidth");
		$(window).on("resize", function() {
			if (resizeTimer) {clearTimeout(resizeTimer)	}
			resizeTimer = setTimeout(function() {
				var newWidth = $(window).prop("innerWidth");
				if (resizeWindow != newWidth) {
					$header.removeClass('hSticky-up').removeClass('hSticky-nav').removeClass('hSticky');
					$parentHeader.css('min-height', '' );	
					resizeTimer = setTimeout(function() {
						parentHeight = $parentHeader.find('.mainHeader').outerHeight();
						$parentHeader.css('min-height', parentHeight );	
					}, 50);
					resizeWindow = newWidth
				}
			}, 200)
		});
		setTimeout(function() {
			$parentHeader.css('min-height', '' );		
			parentHeight = $parentHeader.find('.mainHeader').outerHeight();
			$parentHeader.css('min-height', parentHeight );	
			if($(window).width() < 992){
				var height_orders_cate = $('.listmenu-site-nav').outerHeight();
				$('.listmenu-site-nav').css('height',height_orders_cate);
			}
			$(window).scroll(function() {	
				if($(window).scrollTop() > offset_sticky_header && $(window).scrollTop() > offset_sticky_down) {		
					if($(window).width() > 991){		
						$('body').removeClass('locked-scroll').removeClass("locked-scroll-menu");
						$('.header-action-item').removeClass('js-action-show');
					}		
					$header.addClass('hSticky');	
					$body.addClass('scroll-body');
					var height_head = $('.mainHeader').outerHeight();
					$('html').attr('style',"--header-height:"+height_head+'px;');
					if($(window).scrollTop() > offset_sticky_header + 150){
						$header.removeClass('hSticky-up').addClass('hSticky-nav');	
						$body.removeClass('scroll-body-up').addClass('scroll-body-nav');
					};
				} 
				else {
					if($(window).scrollTop() > offset_sticky_header + 150 && ($(window).scrollTop() - 150) + $(window).height()  < $(document).height()) {
						$header.addClass('hSticky-up');	
						$body.addClass('scroll-body-up');
						var height_head = $('.mainHeader').outerHeight();
						$('html').attr('style',"--header-height:"+height_head+'px;');
					}	
				}
				if ($(window).scrollTop() <= offset_sticky_down && $(window).scrollTop()   <= offset_sticky_header ) {
					$header.removeClass('hSticky-up').removeClass('hSticky-nav');
					$body.removeClass('scroll-body-up').removeClass('scroll-body-nav').removeClass('scroll-body');
					var height_head = $('.mainHeader--height').outerHeight();
					$('html').attr('style',"--header-height:"+height_head+'px;');
					if($(window).scrollTop()  <= offset_sticky_header - 100){
						$header.removeClass('hSticky');
					}
				}
				if($(window).width() < 992){
					if(template == 'index'){
						var menu_bar_offset_top = $(".listmenu-site-nav").offset().top;
						var height_head = $('.mainHeader').outerHeight();
						if($(window).scrollTop() > menu_bar_offset_top){
							$(".orders-cate").addClass('orders-fixed');
						}
						else{
							if($('body').hasClass('scroll-body-up')){
								if($(window).scrollTop() < (menu_bar_offset_top - (height_orders_cate*2+10))){
									$(".orders-cate").removeClass('orders-fixed');
								}
							}
							else{
								$(".orders-cate").removeClass('orders-fixed');
							}
						}
						if($('body').hasClass('scroll-body-up')){
							if($(window).scrollTop() > (menu_bar_offset_top - height_head)){
								$(".orders-cate").addClass('orders-fixed');
							}
						}
					}
				}
				offset_sticky_down = $(window).scrollTop();
			});	
		}, 300)
	},
	actionIconHeader: function(){
		$('.header-action_clicked').click(function(e){
			e.preventDefault();		
			if($(this).parents('.header-action-item').hasClass('js-action-show')){
				$('body').removeClass("locked-scroll-menu").removeClass('locked-scroll');
				$(this).parents('.header-action-item').removeClass('js-action-show');
			}
			else{				
				$('body').removeClass("locked-scroll-menu");
				$('.header-action-item').removeClass('js-action-show');
				$('body').addClass('locked-scroll');	
				$(this).parents('.header-action-item').addClass('js-action-show');
				if($(this).parents('.header-action-item').hasClass('header-action_menu')){			
					$('body').addClass("locked-scroll-menu");
				}
			}		
		});
		$('.header-action_cart .header-action__link ').click(function(e){
			e.preventDefault();		
			if($(this).parents('.header-action-item').hasClass('js-action-show')){
				$('body').removeClass("locked-scroll-menu").removeClass('locked-scroll');
				$(this).parents('.header-action-item').removeClass('js-action-show');
			}
			else{
				$('body').removeClass("locked-scroll-menu");
				$('.header-action-item').removeClass('js-action-show');		
				$('body').addClass('locked-scroll');	
				if(template.indexOf('index') != -1){
					if($(window).width() < 768){						
						$('.cart-mobile').click();
					}
					else{
						$(this).parents('.header-action-item').addClass('js-action-show');	
					}
				}
				else{				
					$(this).parents('.header-action-item').addClass('js-action-show');	
				}
			}			
		});

		$('body').on('click', '.js-link', function(e){
			e.preventDefault();
			AG.Main.boxAccount($(this).attr('aria-controls'));
		});
		$('body').on('click', '#site-overlay', function(e){
			$('body').removeClass('locked-scroll').removeClass("locked-scroll-menu");
			$('.header-action-item').removeClass('js-action-show');
		});
		$('.site_account input').blur(function(){
			var tmpval = $(this).val();
			if(tmpval == '') {
				$(this).removeClass('is-filled');
			} else {
				$(this).addClass('is-filled');
			}
		});
	},
	searchAutoHeader: function(){
		$('.ultimate-search').submit(function(e) {
			e.preventDefault();
			var q = $(this).find('input[name=q]').val();
			if(q.indexOf('script') > -1 || q.indexOf('>') > -1){
				alert('Từ khóa của bạn có chứa mã độc hại ! Vui lòng nhập lại key word khác');
				$(this).find('input[name=q]').val('');
			}
			else{
				var q_follow = 'product';
				var query = encodeURIComponent('(title:product contains ' + q + ')');
				if( !q ) {
					window.location = '/search?type='+ q_follow +'&q=*';
					return;
				}	
				else {
					window.location = '/search?type=' + q_follow +'&q=filter=' + query;
					return;
				}
			}
		});
		var $input = $('.ultimate-search input[type="text"]');
		$input.bind('keyup change paste propertychange', function() {
			var key = $(this).val(),
					$parent = $(this).parents('.wpo-wrapper-search'),
					$results = $(this).parents('.wpo-wrapper-search').find('.smart-search-wrapper');

			if(key.indexOf('script') > -1 || key.indexOf('>') > -1){
				alert('Từ khóa của bạn có chứa mã độc hại ! Vui lòng nhập lại key word khác');
				$(this).val('');
				$('.ultimate-search input[type="text"]').val('');
			}
			else{
				if(key.length > 0 ){
					$(this).attr('data-history', key);
					$('.ultimate-search input[type="text"]').val($(this).val());
					var q_follow = 'product',
							str = '';
					str = '/search?q=filter=(title:product contains ' + key + ')&view=ultimate-product';
					$.ajax({
						url: str,
						type: 'GET',
						async: true,
						success: function(data){
							$results.find('.resultsContent').html(data);
						}
					})
					if(!$('.header-action_search').hasClass('js-action-show')){
						$('body').removeClass("locked-scroll");
						$('.header-action-item').removeClass('js-action-show');
					}
					$(".ultimate-search").addClass("expanded");
					$results.fadeIn();
				}
				else{
					$('.ultimate-search input[type="text"]').val($(this).val());
					$(".ultimate-search").removeClass("expanded");
					$results.fadeOut();
				}
			}

		})
		$('body').click(function(evt) {
			var target = evt.target;
			if (target.id !== 'ajaxSearchResults' && target.id !== 'inputSearchAuto') {
				$("#ajaxSearchResults").hide();
			}
			if (target.id !== 'ajaxSearchResults-mb' && target.id !== 'inputSearchAuto-mb') {
				$("#ajaxSearchResults-mb").hide();
			}
			if (target.id !== 'ajaxSearchResults-3' && target.id !== 'inputSearchAuto-3') {
				$("#ajaxSearchResults-3").hide();
			}
		});
		$('body').on('click', '.ultimate-search input[type="text"]', function() {
			if ($(this).is(":focus")) {
				if ($(this).val() != '') {
					$(".ajaxSearchResults").show();
				}
			} else {
			}
		})
		$('body').on('click', '.ultimate-search .search-close', function(e){
			e.preventDefault();
			$(".ajaxSearchResults").hide();
			$(".ultimate-search").removeClass("expanded");
			$(".ultimate-search").find('input[name=q]').val('');
		})
	},
	menuMobile: function(){
		$('.btn-menu-mobile').click(function(){
			$('body').addClass('show-menu-mobile');
			$('.cart-mobile').parent('.sticky-right').addClass('modal-quickview-show')
		});
		$('#overlay-menu-mobile').click(function(){
			$('body').removeClass('show-menu-mobile');
			$('.cart-mobile').parent('.sticky-right').removeClass('modal-quickview-show')
		});
		$('.toggle-sub-menu').click(function(){
			$(this).next().slideToggle();
			$(this).find('i').toggleClass('fa-minus');
		});
		$('.list-root li a').click(function(e){
			if ($(this).find('i').length){
				e.preventDefault();
				var menu_child_id = $(this).parent().data('menu-root');
				$('.list-root').addClass('mm-subopened');
				$('#' + menu_child_id).addClass('mm-opened');
			} 
		})
		$('.list-child li:first-child a').click(function(){
			$(this).parents('.list-child').removeClass('mm-opened');
			$('.list-root').removeClass('mm-subopened');
		})
		$('.list-child li.level-2 a').click(function(e){
			if ($(this).find('i').length){
				e.preventDefault();
				var menu_sub_id = $(this).parent().data('menu-root');
				$('li.level-2').addClass('mm-subopened');
				$('#' + menu_sub_id).addClass('mm-sub');
			} 
		})
		$('.sub-child li:first-child a').click(function(){
			$(this).parents('.sub-child').removeClass('mm-sub');
			$('.list-child').removeClass('mm-subopened');
		})
		$(document).on("click",".sub-child li.level-3 a",function(e){
			if ($(this).find('i').length){
				e.preventDefault();
				var menu_subnav_id = $(this).parent().data('menu-root');
				$('li.level-3').addClass('mm-open-3');
				$('#' +  menu_subnav_id).addClass('mm-sub-3');
			} 
		});
		$(document).on("click",".sub-child-3 li:first-child a",function(e){
			$(this).parents('.sub-child-3').removeClass('mm-sub-3');
			$('.sub-child').removeClass('mm-open-3');
		});
	},
	footerAccordion: function(){
		$('.footer-title h3').on('click', function(){
			$(this).parents('.footer-accordion-item').toggleClass('active-toggle').find('.footer-content,.footer-social').stop().slideToggle(400);
		});
	},
	toggleSidebar: function(){
		$('.plus-nClick1').click(function(e){
			e.preventDefault();
			$(this).parents('.level0').toggleClass('opened');
			$(this).parents('.level0').children('ul').slideToggle(200);
		});
		$('.plus-nClick2').click(function(e){
			e.preventDefault();
			$(this).parents('.level1').toggleClass('opened');
			$(this).parents('.level1').children('ul').slideToggle(200);
		});
		// Dropdown sidebar
		$('.sidebox-title .htitle').click(function(){
			if ($(window).width() <= 991) {
				$(this).parents('.group-sidebox').toggleClass('is-open').find('.sidebox-content-togged').slideToggle('medium');
			}
		}); 
	},
	addListSharing: function(){
		if ($('.addThis_listSharing').length > 0){
			$(window).scroll(function(){
				if($(window).scrollTop() > 100 ) {
					$('.addThis_listSharing').addClass('is-show');
				} else {
					$('.addThis_listSharing').removeClass('is-show');
				}
			});
			$('.body-popupform form.contact-form').submit(function(e){
				var self = $(this);
				if($(this)[0].checkValidity() == true){
					e.preventDefault();
					grecaptcha.ready(function() {
						grecaptcha.execute('6LdD18MUAAAAAHqKl3Avv8W-tREL6LangePxQLM-', {action: 'submit'}).then(function(token) {
							self.find('input[name="g-recaptcha-response"]').val(token);
							$.ajax({
								type: 'POST',
								url:'/contact',
								data: $('.body-popupform form.contact-form').serialize(),			 
								success:function(data){		
									$('.modal-contactform.fade.show').modal('hide');
									setTimeout(function(){ 				
										$('.modal-succesform').modal('show');					
										setTimeout(function(){	
											$('.modal-succesform.fade.show').modal('hide');							
										}, 5000);
									},300);
								},				
							})
						}); 
					});
				}
			});
			$(".modal-succesform").on('hidden.bs.modal', function(){
				location.reload();
			});
		}
		if ($(window).width() < 768 && $('.layoutProduct_scroll').length > 0 ) {
			var curScrollTop = 0;
			$(window).scroll(function(){	
				var scrollTop = $(window).scrollTop();
				if(scrollTop > curScrollTop  && scrollTop > 200 ) {
					$('.layoutProduct_scroll').removeClass('scroll-down').addClass('scroll-up');
				}
				else {
					if (scrollTop > 200 && scrollTop + $(window).height() + 150 < $(document).height()) {
						$('.layoutProduct_scroll').removeClass('scroll-up').addClass('scroll-down');	
					}
				}
				if(scrollTop < curScrollTop  && scrollTop < 200 ) {
					$('.layoutProduct_scroll').removeClass('scroll-up').removeClass('scroll-down');
				}
				curScrollTop = scrollTop;
			});
		}	
	},
	buyInLoop: function(){
		$('.btn-addcart').click(function(e){
			e.preventDefault();
			if($('.header-action_cart').hasClass('js-action-show')){
				$('body').removeClass("locked-scroll");
				$('.header-action-item').removeClass('js-action-show');
			}
			var url = $(this).attr('data-link');		

			if($(window).width() > 768){
				$.ajax({
					url:url +'?view=quickview',
					success:function(e){
						$('#quick-view-modal').html(e);		
						$('#quick-view-modal').modal("show");
						$('#quick-view-modal').on('shown.bs.modal', function () {
							if($('#quickview-des__toggle').height() > 150){ 
								$('#quickview-des__toggle').addClass('opened'); 
								$('.quickview-des__trigger .btn-toggle').addClass('btn-viewmore').find('span').html('Xem thêm chi tiết sản phẩm +');
							}		
						});
					}
				})
			}
			else{
				e.preventDefault();
				var prolink = $(this).data('link');
				var protitle = $(this).parents('.product-detail').find('.proloop-name a').text();
				$('body').addClass('block-scroll');	
				$('.wrapper-quickview').addClass('show-quickview');
				$('.modal-detailProduct').removeClass('fixed_pro').html(''); 
				$('.modal-detailProduct--scroll').parent('.modal-detailProduct').find('.modal-detailProduct--scroll').css({ 'height': '100%' });
				$.ajax({ 
					url: prolink + "?view=quickview",	
					async: true,
					success:function(data){
						$('.paramlink-topbar').find('.purl-title span').html(protitle);
						setTimeout(function(){
							$(".modal-detailProduct").html(data); 
						},300);
					}
				});
			}


		});
	},
	formSubmit: function(){
		if($('#form-customer-footer').length > 0){
			$('#form-customer-footer form.contact-form').submit(function(e) { 
				var self = $(this);
				if($(this)[0].checkValidity() == true){
					e.preventDefault();
					grecaptcha.ready(function() {
						grecaptcha.execute('6LdD18MUAAAAAHqKl3Avv8W-tREL6LangePxQLM-', {action: 'submit'}).then(function(token) {
							self.find('input[name="g-recaptcha-response"]').val(token);
							self.unbind('submit').submit();
						}); 
					});
				}
			});
		}
	},
	miniAccountPhone: function(){
		$(".method-login-mini-account").click(function(){
			var data = $(this).attr('data-login');
			var heightBoxMiniAccount = $('.site_account_panel.is-selected').height();
			$('.site_account_panel.is-selected').parent().css("height", heightBoxMiniAccount);
			$(".method-login-mini-account[data-login!='"+data+"']").removeClass("active");
			$(".method-login-mini-account[data-login='"+data+"']").addClass("active");
			$(".method-login-mini-cart[data-login!='"+data+"']").addClass("d-none");
			$(".method-login-mini-cart[data-login='"+data+"']").removeClass("d-none");
		});
	},
	modalQuickViewMobile: function(){
		$(document).on("click", ".product-sharing", function(){
			$(this).toggleClass('sharing-active');
		});	
		$(document).on('click', '.quickview-close', function(e){
			$(".wrapper-quickview").removeClass('show-quickview');
			$('body').removeClass('block-scroll');
		});
	},
}
AG.Index = {
	init: function(){
		this.sliderMainBanner();
		this.sliderListOrder();
		this.renderCart();
		this.listOrderCustomer();
		this.functionOrder();
		this.loadMore();
		this.renderProdTag();
		this.copyCoupon();
	},
	sliderMainBanner: function(){
		$('#sliderBanner').owlCarousel({
			items:1,
			nav: true,
			navText: [
				'<i class="fas fa-arrow-left"></i>',
				'<i class="fas fa-arrow-right"></i>',
			],
			dots: true,		
			touchDrag: true,
			lazyLoad:true,	
			autoplay:true,
			autoplayTimeout:8000,
			smartSpeed:800,
			loop: true
		});
	},
	sliderListOrder: function(){
		if($(window).width() < 1199){
			var param = {
				margin:10,
				loop:false,
				autoWidth:true,
				dots:false,
				nav: false,
				items:4,
				stagePadding: 50,
			}
			if($('.inner-content-order .item-content-order').length > 4 && $(window).width() < 767){
				param.loop = true;
			}
			$('.inner-content-order').owlCarousel(param);
		}
	},
	renderCart: function(){
		$.ajax({
			type:'GET',
			url: '/cart?view=update',
			success: function(data){
				$('.ajax-here').html(data);
			}
		});
		AG.Main.getModalCart(false);
	},
	listOrderCustomer: function(){
		$(document).on("click",".overflow-a-order", function(){
			var url = $(this).attr("data-handle");
			var orderID = $(this).parents(".inner-item-content-order").find(".item-content-name a").html();
			$.ajax({
				url: url + "?view=detail",
				success: function(order){
					$("#order-detail .modal-body").html(order);
					$("#order-detail h3").html("Chi tiết đơn hàng " + orderID);
					$("#order-detail").modal("show");
				}
			});
		});
		$("#order-detail .close-popup-contact").click(function(){
			$("#order-detail").modal("hide");
		});
		$(document).on("click", ".action-re-buy button", function(e){
			e.preventDefault();
			var listID = '';
			$(".item-order").each(function(){
				var id = $(this).attr("id");
				var quantity = parseInt($(this).find(".quantity").html());
				if (listID == ''){
					listID = id + ":" + quantity;
				}else{
					listID = listID + "," + id + ":" + quantity;
				}
			});
			var array_add = listID.split(',');
			var length_array_Add = array_add.length;
			var count_end_add = 0;
			var count_error = 0;
			$.each(array_add, function(i,v){
				var data = 'quantity=' + v.split(':')[1] + '&id=' + v.split(':')[0];
				var params = {
					type: 'POST',
					url: '/cart/add.js',
					async: false,
					data: data,
					dataType: 'json',
					success: function(line_item) {
						count_end_add++;
						if(count_end_add == length_array_Add){
							$("#order-detail").modal("hide");
							$.ajax({
								type:'GET',
								url: '/cart?view=update',
								success: function(data){
									$('.ajax-here').html(data);
								}
							});
							AG.Main.getModalCart(false);// false để không dropdown minicart
							if($(window).width() < 992){
								$('.cart-mobile').click();
							}
							else{
								$('html, body').animate({
									scrollTop: $('#section-order-content').offset().top
								}, 600);
							}
						}
					},
					error: function(XMLHttpRequest, textStatus) {
						count_error++;
					}
				};
				$.ajax(params);
			});
			if(count_error != 0){
				alert("Một số sản phẩm trong đơn đã hết hàng!");
			}
		});
		$(document).on("click", ".action-buy", function(e){
			e.preventDefault();
			var listID = $(this).attr("data-id");
			var array_add = listID.split(',');
			var length_array_Add = array_add.length;
			var count_end_add = 0;
			var count_error = 0;
			$.each(array_add, function(i,v){
				var data = 'quantity=' + v.split(':')[1] + '&id=' + v.split(':')[0];
				var params = {
					type: 'POST',
					url: '/cart/add.js',
					async: false,
					data: data,
					dataType: 'json',
					success: function(line_item) {
						count_end_add++;
						if(count_end_add == length_array_Add){
							$("#order-detail").modal("hide");
							$.ajax({
								type:'GET',
								url: '/cart?view=update',
								success: function(data){
									$('.ajax-here').html(data);
								}
							});
							AG.Main.getModalCart(false); // false để không dropdown minicart
							if($(window).width() < 992){
								$('.cart-mobile').click();
							}
							else{
								$('html, body').animate({
									scrollTop: $('#section-order-content').offset().top
								}, 600);
							}
						}
					},
					error: function(XMLHttpRequest, textStatus) {
						count_error++;
					}
				};
				$.ajax(params);
			});
			if(count_error != 0){
				alert("Một số sản phẩm trong đơn đã hết hàng!");
			}
		});
		$(".ajax-order a").click(function(e){
			e.preventDefault();
			var url = $(this).attr("href");
			var orderID = $(this).html();
			$.ajax({
				url: url + "?view=detail",
				success: function(order){
					$("#order-detail .modal-body").html(order);
					$("#order-detail h3").html("Chi tiết đơn hàng " + orderID);
					$("#order-detail").modal("show");
				}
			});
		});
	},
	triggerQuickview: function(){
		if (window.location.href.indexOf("?p=") != -1){
			var handle = window.location.href.split("?p=")[1];
			$.ajax({
				url: '/products/' + handle +'?view=quickview',
				success:function(e){
					$('#quick-view-modal').html(e);									
					$('#quick-view-modal').modal("show");
					$('#quick-view-modal').on('shown.bs.modal', function () {
						if($('#quickview-des__toggle').height() > 150){ 
							$('#quickview-des__toggle').addClass('opened'); 
							$('.quickview-des__trigger .btn-toggle').addClass('btn-viewmore').find('span').html('Xem thêm chi tiết sản phẩm +');
						}						
					});
				}
			});
		}
	},
	functionOrder: function(){
		$('.orders-cate a[href^="#"]').bind('click.smoothscroll',function(e){
			e.preventDefault();
			var target = this.hash,
					$target = $(target);
			$('html, body').stop().animate( {
				'scrollTop': $target.offset().top
			}, 900, 'swing', function () {});
		});
		function check_time(){
			var hstart = parseInt(19);
			var mstart = parseInt(45);
			var hend = parseInt(6);
			var check_time = new Date();
			var hours = check_time.getHours();
			var minute = check_time.getMinutes();
			if(hours == hstart){
				if(minute >= mstart ){
					$('.top-bar').removeClass('hide');
					$('.btn-check a').addClass('over-time').html('Đã ngưng nhận đơn hôm nay');
					$('.action-cart a').addClass('over-time');
				}else{
					$('.top-bar').addClass('hide');
					$('.btn-check a').removeClass('over-time').html('Thanh toán');
					$('.action-cart a').removeClass('over-time');
				}
			}else{
				if (hours < hend || hours > hstart){
					$('.top-bar').removeClass('hide');
					$('.btn-check a').addClass('over-time').html('Đã ngưng nhận đơn hôm nay ');
					$('.action-cart a').addClass('over-time');
				}else{
					$('.top-bar').addClass('hide');
					$('.btn-check a').removeClass('over-time').html('Thanh toán');
					$('.action-cart a').removeClass('over-time');
				}
			}
			if($('#header-pick-time').length > 0){
				//var text_delivery = parseInt($('.cart-time--action .textday').text());
				//	if(!isNaN(text_delivery)){		
				var text_delivery = $('.cart-time--action .textday').text();						
				if(text_delivery.indexOf('Giao ngay') == -1 && text_delivery.indexOf('Chọn thời gian') == -1){
					$('.btn-check a').removeClass('over-time').html('Thanh toán');
					$('.action-cart a').removeClass('over-time');
				}
			}
		}
		if($('#header-pick-time').length > 0){ check_time(); }

		var fix_d = new Date(), choise_day = '';
		var dayf = fix_d.getTime();
		var check_hours = fix_d.getHours();
		var one = dayf + 86400000;
		var two = dayf + (86400000*2);
		one = new Date(one);
		two = new Date(two);
		choise_day += '<option data-check="oke" value="'+ fix_d.getFullYear() +'-'+ format_date(fix_d.getDate()) +'-'+ format_date(fix_d.getMonth() + 1) +'" >Hôm nay</option>';
		choise_day += '<option data-check="" value="'+ fix_d.getFullYear() +'-'+ format_date(one.getDate()) +'-'+ format_date(one.getMonth() + 1) +'" >Ngày '+ format_date(one.getDate()) +'-'+ format_date(one.getMonth() + 1) +'</option>';
		choise_day += '<option data-check="" value="'+ fix_d.getFullYear() +'-'+ format_date(two.getDate())+'-'+ format_date(two.getMonth() + 1) +'" >Ngày '+ format_date(two.getDate()) +'-'+ format_date(two.getMonth() + 1) +'</option>';
		$('.choise-day').html(choise_day);
		function format_date(num){
			if( num < 10 )
				return '0'+num;
			else
				return num;
		}

		$(".cart-time--choise input[name='timeRadios']").on('change', function(){						
			/*$(".side-cart--time").removeClass('js-opacity-time');*/				
			var checked =  $(this).is(":checked") ;

			if ($(".cart-time--choise input[name='timeRadios']:checked").val() == 'timeNow') {
				$('.cart-time--select').slideUp(500);
				var _this = $(this);
				var time = 'Giao ngay';
				//$('.btn-choise-time span').html(time);
				$(".cart-time--action .textday").html('<i class="far fa-clock" aria-hidden="true"></i> '+ time);
				$.ajax({
					type: "POST",
					url: "/cart/update.js",
					data: "note=Giao ngay",
					dataType: "json",
					success: function(a) {
						_this.parents('.action-acc').toggleClass('active');
						check_time();
					},
				});			
			}
			else if($(".cart-time--choise input[name='timeRadios']:checked").val() == 'timeDate') {	
				$('.cart-time--select').slideDown(500);
			}

		}); 
		$('.choise-day').change(function(){
			var check = $(this).find('option:checked').data('check');
			if(check == 'oke'){
				$('.choise-time option').each(function(){
					var hourse = $(this).data('hours');
					if(hourse <= check_hours) $(this).attr('disabled','disabled').removeAttr('selected');
				});
				$('.choise-time option:not([disabled])').eq(0).trigger('click').attr('selected', true).prop('selected',true);
			}else{
				$('.choise-time option').removeAttr('disabled').removeAttr('selected');
				$('.choise-time option').eq(0).attr('selected', true).prop('selected',true);
			}
			if($('.choise-time option:not([disabled])').length == 0){
				$('.btn-choise-submit, .sub-choise-now').addClass('disabled');
			}else{
				$('.btn-choise-submit, .sub-choise-now').removeClass('disabled');
			}
			if(check_hours >= 20){
				$('.sub-choise-now').addClass('disabled');
			}else{
				$('.sub-choise-now').removeClass('disabled');
			}
		});
		$('.choise-day option:first-child').trigger('change');
		$('.btn-choise-submit').click(function(e){
			e.preventDefault();
			var time = $('.choise-day').val() + ' ' + $('.choise-time').val();

			$('.cart-time--select').slideUp(500);
			$(".cart-time--choise input[value='timeDate']").prop('checked', false);
			$(".cart-time--action .textday").html('<i class="far fa-clock" aria-hidden="true"></i> '+ time);
			var _this = $(this);
			$.ajax({
				type: "POST",
				url: "/cart/update.js",
				data: "note=" + time,
				dataType: "json",
				success: function(a) {
					_this.parents('.action-acc').toggleClass('active');
					check_time();
				},
			});
		});
		$('.cart-mobile').click(function(){
			if($(this).parent('.sticky-right').hasClass('active')){				
				$(this).parent('.sticky-right').removeClass('active');
				$(this).find('.flex-box span').eq(2).html('Xem chi tiết');			
				$('body').removeClass('locked-scroll').removeClass('cart-open');
			}else{
				$('body').removeClass('locked-scroll').addClass('cart-open');
				$(this).parent('.sticky-right').addClass('active');
				$(this).find('.flex-box span').eq(2).html('Đóng');
			}
		});
		$('.overlay-order').click(function(){
			$('body').removeClass('locked-scroll').removeClass('cart-open');
			$('.cart-mobile').parent('.sticky-right').removeClass('active');
			$('.cart-mobile').find('.flex-box span').eq(2).html('Xem chi tiết');			
			$('body').removeClass('locked-scroll').removeClass('locked-scroll-menu');
		});
		$(document).on('click','.order-item:not(.disabled)',function(e){
			e.preventDefault();
			var link = $(this).data('link');
			$('body').addClass('block-scroll');
			if($(window).width() > 768){
				$.ajax({
					url:link +'?view=quickview',
					success:function(e){
						$('#quick-view-modal').html(e);		
						$('#quick-view-modal').modal("show");
						$('#quick-view-modal').on('shown.bs.modal', function () {
							if($('#quickview-des__toggle').height() > 150){ 
								$('#quickview-des__toggle').addClass('opened'); 
								$('.quickview-des__trigger .btn-toggle').addClass('btn-viewmore').find('span').html('Xem thêm chi tiết sản phẩm +');
							}		
						});
					}
				})
			}
			else{
				e.preventDefault();
				var prolink = $(this).data('link');
				var protitle = $(this).find('.order-info h3').text();
				$('body').addClass('block-scroll');	
				$('.wrapper-quickview').addClass('show-quickview');
				$('.modal-detailProduct').removeClass('fixed_pro').html(''); 
				$('.modal-detailProduct--scroll').parent('.modal-detailProduct').find('.modal-detailProduct--scroll').css({ 'height': '100%' });
				$.ajax({ 
					url: prolink + "?view=quickview",	
					async: true,
					success:function(data){
						$('.paramlink-topbar').find('.purl-title span').html(protitle);
						setTimeout(function(){
							$(".modal-detailProduct").html(data); 
						},300);
					}
				});
			}
		});
		$('#quick-view-modal').on('show.bs.modal', function () {
			$('.cart-mobile').parent('.sticky-right').addClass('modal-quickview-show')
		});
		$('#quick-view-modal').on('hide.bs.modal', function() {
			$('.cart-mobile').parent('.sticky-right').removeClass('modal-quickview-show');
			$('body').removeClass('block-scroll');
		});	
		$('.orders-cart').on('click','.cart-item-remove',function(e){
			e.preventDefault();
			var id = $(this).data('id');
			$.ajax({
				type:'POST',
				url: "/cart/change.js",
				data: "quantity=0&id=" + id,
				success: function(datas){
					$.ajax({
						type:'GET',
						url: '/cart?view=update',
						success: function(data){
							$('.ajax-here').html(data);
						}
					});
					AG.Main.getModalCart(false);
				}
			});
		});
		$('.orders-cart').on('click', '.btn-plus', function(e) {
			e.preventDefault();
			AG.All.plusQuickview($(this), true);
		});
		$('.orders-cart').on('click', '.btn-sub', function(e) {
			e.preventDefault();
			AG.All.minusQuickview($(this), true);
		});
		$('.sticky-right').click(function(e){
			var target = e.target;
			if (!$(target).closest('.cart-mobile').length && !$(target).closest('.orders-cart').length ) {
				$('.sticky-right').removeClass('active');
				$('body').removeClass('cart-open');
				$('.cart-mobile .flex-box span').eq(2).html('Xem chi tiết');
			}
		})

		$('#quick-view-modal').on('click','.product-title img',function(){
			var item = $('#quick-view-modal .list-img').html();
			if($('.slider-img .product-img-owl').hasClass('owl-loaded')){
				$('.slider-img .product-img-owl').html('').owlCarousel('destroy');
			}
			$('.slider-img .product-img-owl').html(item).owlCarousel({
				items:1,
				nav: false,
				dots: true,
				loop:false
			});
			$('.slider-img').removeClass('hide');
		});
		$('.slider-img-close').click(function(){
			$('.slider-img').addClass('hide');
		});
		var lastId,
				topMenu = $(".orders-cate ul"),
				menuItems = topMenu.find("a"),
				scrollItems = menuItems.map(function () {
					if (0 === $(this).attr("href").indexOf("#")) {
						var e = $($(this).attr("href"));
						if (e.length) return e;
					}
				});
		$(window).scroll(function () {
			if (($(".main-header").length > 0 && $(window).scrollTop() > 0 ? $(".main-header").addClass("fixed") : $(".main-header").removeClass("fixed"), $(window).width() < 768)) {
				$(window).scrollTop() > 0 ? $(".orders-cate").addClass("top") : $(".orders-cate").removeClass("top");
				var e = 0,
						t = !0;
				if (
					($(".orders-cate li").each(function () {
						t && (e += $(this).outerWidth()), $(this).hasClass("active") && (t = !1);
					}),
					 e > $(window).width() && $(".orders-cate li.active").length > 0)
				) {
					var a = e - $(window).width() + 20;
					$(".orders-cate ul").css("transform", "translateX(-" + a + "px)");
				} else $(".orders-cate ul").css("transform", "translateX(0)");
			}
			var i = $(this).scrollTop() + 80,
					n = scrollItems.map(function () {
						if ($(this).offset().top < i) return this;
					}),
					s = (n = n[n.length - 1]) && n.length ? n[0].id : "";
			lastId !== s &&
				((lastId = s),
				 menuItems
				 .parent()
				 .removeClass("active")
				 .end()
				 .filter("[href='#" + s + "']")
				 .parent()
				 .addClass("active"));
		});
		$(".orders-cate ul li a").click(function (e) {
			e.preventDefault();
			var t = $(this).attr("href"),
					a = $(t).offset().top - 70;
			$(window).width() < 768 && (a = $(t).offset().top - 75), $("body,html").animate({ scrollTop: a + "px" }, 500);
		});
		var slug = function (e) {
			return (e = (e = (e = (e = (e = (e = (e = (e = (e = (e = (e = e.toLowerCase()).replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a")).replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e")).replace(/ì|í|ị|ỉ|ĩ/g, "i")).replace(
				/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,
				"o"
			)).replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u")).replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y")).replace(/đ/g, "d")).replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g, "-")).replace(/-+-/g, "-")).replace(/^\-+|\-+$/g, ""));
		}
		var $filter = $('.search-product input[type="text"]');
		$filter.bind("keyup change paste propertychange", function () {
			var e = $(this).val();
			e.length > 0
				? ((e = slug(e)),
					 $(this).attr("data-history", e),
					 $(".orders-cate li").removeClass("active"),
					 $(".orders-block, .order-item li").addClass("d-none"),
					 $(".orders-block").each(function () {
				var t = $(this);
				t.find(".order-item li").each(function () {
					-1 != $(this).data("value").indexOf(e) && ($(this).removeClass("d-none"), t.removeClass("d-none"));
				});
			}))
			: $(".orders-block, .order-item li").removeClass("d-none");
		});
	},
	loadMore: function(){
		$(document).on('click','.orders-book__more', function(e){
			e.preventDefault();
			var $this = $(this);
			var handle = $(this).attr('data-url');
			var id = $this.attr('data-id');
			var parent = $this.parents('.orders-block__list');
			var param = {
				url: handle,
				success: function(data){
					$this.parent().remove();
					parent.append(data);
					//	$('.orders-block__list[data-id='+id+']').append(data);
				}
			}
			$.ajax(param);
		});
	},
	renderProdTag: function (){		
		$('.orders-block .orders-block__tags').each(function() {
			var curTag = $(this).attr('data-tags');
			var self = $(this);
			var param = {
				url: '/collections/all/'+ curTag+'?view=order',
				success: function(data){
					self.html('');
					self.append(data);

				}
			};
			$.ajax(param);
		});
	},
	copyCoupon: function(){
		$(document).on('click', '.orders-cart-coupon .cpi-button', function(e){ 
			e.preventDefault();	
			var copyText = $(this).attr('data-coupon');
			var el = document.createElement('textarea');	
			el.value = copyText ;
			el.setAttribute('readonly', '');
			el.style.position = 'absolute';
			el.style.left = '-9999px';
			document.body.appendChild(el);		
			el.select();
			document.execCommand('copy');
			document.body.removeChild(el);
			/*	$('.orders-cart-payment .btn-link').addClass('btncode').attr('href', '/checkout?couponcode='+ copyText);*/
			$(this).html('Đã sao chép').addClass('disabled');
			$('.coupon-note').slideDown(300);
		});
	},
}
AG.Collection = {
	init: function (){
		this.fixHeightCollection();
		this.scrollOurMenu();
	},
	fixHeightCollection: function(){
		$(document).on('lazyloaded', function(e){
			AG.Main.fixHeightProduct('.listProduct-row', '.product-resize', '.image-resize');
			$(window).resize(function() {
				AG.Main.fixHeightProduct('.listProduct-row', '.product-resize', '.image-resize');
			});
		});
	},
	scrollOurMenu: function(){
		setTimeout(function() {
			$(window).scroll(function() {	
				if($(window).scrollTop() >= $('.collection-content-category').offsetTop) {		
					$('.collection-content-category').addClass("sticky")	;
				} 
				else {
					$('.collection-content-category').removeClass("sticky")	;
				}
			});	
		}, 300)

	},
}
AG.PageSearch = { 
	init: function (){
		this.fixHeightSearch();
		this.submitFormSearch();
	},
	fixHeightSearch: function(){
		setTimeout(function() {
			AG.Main.fixHeightProduct('.search-list-results', '.product-resize', '.image-resize');
			$(window).resize(function() {
				AG.Main.fixHeightProduct('.search-list-results', '.product-resize', '.image-resize');
			});
		}, 1000);		
	},
	submitFormSearch: function(){
		$('form.search-page').submit(function(e){
			e.preventDefault();
			var q = $(this).find('input[type="text"]').val();
			if(q.indexOf('script') > -1 || q.indexOf('>') > -1){
				alert("Key word của bạn có chứa mã độc hại");
				$(this).find('input[type="text"]').val('');
			}
			else{
				window.location.href= "/search?type=product&q="+ $('input.search_box').val() ;
			}
		})
	}
}
AG.PageAbout = {
	init: function(){
		this.sliderAbout();
	},
	sliderAbout: function(){
		$('.slider-about--owl').owlCarousel({
			items:1,
			nav: true,
			navText: [
				'<div class="prev-button"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path style="fill:#2196F3;" d="M511.189,259.954c1.649-3.989,0.731-8.579-2.325-11.627l-192-192c-4.237-4.093-10.99-3.975-15.083,0.262c-3.992,4.134-3.992,10.687,0,14.82l173.803,173.803H10.667C4.776,245.213,0,249.989,0,255.88c0,5.891,4.776,10.667,10.667,10.667h464.917L301.803,440.328c-4.237,4.093-4.355,10.845-0.262,15.083c4.093,4.237,10.845,4.354,15.083,0.262c0.089-0.086,0.176-0.173,0.262-0.262l192-192C509.872,262.42,510.655,261.246,511.189,259.954z"/><path d="M309.333,458.546c-5.891,0.011-10.675-4.757-10.686-10.648c-0.005-2.84,1.123-5.565,3.134-7.571L486.251,255.88L301.781,71.432c-4.093-4.237-3.975-10.99,0.262-15.083c4.134-3.992,10.687-3.992,14.82,0l192,192c4.164,4.165,4.164,10.917,0,15.083l-192,192C314.865,457.426,312.157,458.546,309.333,458.546z"/><path d="M501.333,266.546H10.667C4.776,266.546,0,261.771,0,255.88c0-5.891,4.776-10.667,10.667-10.667h490.667c5.891,0,10.667,4.776,10.667,10.667C512,261.771,507.224,266.546,501.333,266.546z"/></svg></div>',
				'<div class="next-button"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path style="fill:#2196F3;" d="M511.189,259.954c1.649-3.989,0.731-8.579-2.325-11.627l-192-192c-4.237-4.093-10.99-3.975-15.083,0.262c-3.992,4.134-3.992,10.687,0,14.82l173.803,173.803H10.667C4.776,245.213,0,249.989,0,255.88c0,5.891,4.776,10.667,10.667,10.667h464.917L301.803,440.328c-4.237,4.093-4.355,10.845-0.262,15.083c4.093,4.237,10.845,4.354,15.083,0.262c0.089-0.086,0.176-0.173,0.262-0.262l192-192C509.872,262.42,510.655,261.246,511.189,259.954z"/><path d="M309.333,458.546c-5.891,0.011-10.675-4.757-10.686-10.648c-0.005-2.84,1.123-5.565,3.134-7.571L486.251,255.88L301.781,71.432c-4.093-4.237-3.975-10.99,0.262-15.083c4.134-3.992,10.687-3.992,14.82,0l192,192c4.164,4.165,4.164,10.917,0,15.083l-192,192C314.865,457.426,312.157,458.546,309.333,458.546z"/><path d="M501.333,266.546H10.667C4.776,266.546,0,261.771,0,255.88c0-5.891,4.776-10.667,10.667-10.667h490.667c5.891,0,10.667,4.776,10.667,10.667C512,261.771,507.224,266.546,501.333,266.546z"/></svg></div>'
			],
			dots: true,		
			touchDrag: true,
			loop: true
		});
	}
}
AG.Register = {
	init: function(){
		this.actionBtnMethod();
	},
	actionBtnMethod: function(){
		$(".account-method-login button").click(function(){
			var data_btn = $(this).attr("data-button");
			$(".account-method-login button[data-button!="+data_btn+"]").removeClass("active");
			$(".account-method-login button[data-button="+data_btn+"]").addClass("active");
			$(".method-form[data-form!="+data_btn+"]").addClass("d-none");
			$(".method-form[data-form="+data_btn+"]").removeClass("d-none");
		});
	},
	checkPhone: function(phone){
		var validate = 0;
		var check1 = phone.slice(0,3);
		var check2 = phone.slice(0,2);
		if(check1 == '+84') phone = phone.replace('+84','0');
		if(check2 == '84') phone = phone.replace('84','0');
		if(phone == ''){
			validate = 1;
		}
		else{
			if((phone.length == 10 || phone.length == 11 || phone.length == 12) && $.isNumeric(phone)){
				validate = 0;
			}
			else{
				if(!$.isNumeric(phone)){
					validate = 2;
				}
				else if(phone.length < 10 || phone.length > 10){
					validate = 3;
				}
			}
		}
		return validate;
	}
}
$(document).ready(function() {
	AG.init();
});