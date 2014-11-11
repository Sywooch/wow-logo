$(function(){
    var slider = $( '.web-slider' );

    slider.each(function(){
        new webSlider1( {
            obj: $(this),
            items: $(this).find( '.web-slider_item' ),
            btnNext: $(this).find( '.web-slider__next' ),
            btnPrev: $(this).find('.web-slider__prev')
        } );
    });

});

var webSlider1 = function( params ){
    this.obj = params.obj;
    this.elems = {
        btnPrev: params.btnPrev,
        btnNext: params.btnNext,
        items: params.items
    };
    this.action = false;
    this.duration = params.duration || 3000;

    this.init();
};
    webSlider1.prototype = {
        init: function(){
            var self = this;

            self.core = self.core();
            self.core.build();
        },
        core: function(){
            var self = this,
                elems = self.elems;

            return {
                build: function(){
                    var count = elems.items.length,
                        i,
                        points = $( '<ul class="web-slider__points"></ul>' );


                    for( i = 0; i < count; i++ ){
                        points.append( '<li></li>' );
                    }
                    self.obj.append( points );

                    elems.points = points.find( 'li' );

                    elems.points.eq( 0 ).addClass( 'active' );
                    elems.items.eq( 0 ).css( { display: 'block' } );

                    self.core.controls();

                    self.core.slideToNext();
                },
                slideToNext: function(){
                    self.timer = setTimeout( function(){
                        elems.btnNext.trigger( 'click' );
                    }, self.duration );
                },
                controls: function(){
                    elems.btnPrev.on( {
                        'click': function(){
                            var index = ( ( elems.points.filter( '.active' ).index() - 1 ) == -1 ) ? (elems.points.length - 1) :( elems.points.filter( '.active' ).index() - 1 );

                            self.slideTo( index );
                        }
                    } );
                    elems.btnNext.on( {
                        'click': function(){
                            var index = ( ( elems.points.filter( '.active' ).index() + 1 ) == elems.points.length )? 0:( elems.points.filter( '.active' ).index() + 1 );

                            self.slideTo( index );
                        }
                    } );
                    elems.points.on( {
                        'click': function(){
                            var curItem = $( this );

                            if( !curItem.hasClass( 'active' ) ){
                                self.slideTo( curItem.index() );
                            }
                        }
                    } );
                    self.obj.on( {
                        'mouseover': function(){
                            clearTimeout( self.timer );
                        },
                        'mouseleave': function(){
                            self.core.slideToNext();
                        }
                    } );
                }
            };
        },
        slideTo: function( index ) {
            var self = this,
                elems = self.elems,
                activeIndex = elems.points.filter( '.active' ).index(),
                direction,
                curW = 100,
                activeItem = elems.items.eq( activeIndex ),
                activePoint = elems.points.eq( activeIndex ),
                newItem = elems.items.eq( index),
                newPoint = elems.points.eq( index );

            clearTimeout( self.timer );
            if( !self.action ){
                self.action = true;

                if( activeIndex < index ){
                    direction = 1;
                } else {
                    direction = -1;
                }

                if( activeIndex == 0 && index == ( elems.points.length - 1 ) ){
                    direction = -1;
                } else if ( activeIndex == ( elems.points.length - 1 )  && index == 0 ){
                    direction = 1;
                }

                activePoint.removeClass( 'active' );
                newPoint.addClass( 'active' );

                newItem.css( {
                    display: 'block',
                    left: curW * -direction,
                    opacity: 0
                } );
                activeItem.animate( {
                    left: curW * direction,
                    opacity: 0
                }, 300, function() {
                    $( this ).css( { display: 'none' } );
                    self.action = false;
                    self.core.slideToNext();
                } );
                newItem.animate( {
                    left: 0,
                    opacity: 1
                }, 300 );
            }

        }
    };