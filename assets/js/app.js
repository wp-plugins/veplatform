(function (window){
  'use strict';

  function veProductCloseInfo( currentEvent, me, infoContentId ) {
    var infoContent = document.getElementById( infoContentId );
    infoContent.className = "hidden";
  }

  function veProductOpenInfo( currentEvent, me, infoContentId, allInfoContent ) {

    var infoContent = document.getElementById( infoContentId );

    if(infoContent.className == "") {
      infoContent.className = "hidden";

      return;
    }

    for(var i = 0; i < allInfoContent.length; i++) {
      document.getElementById( allInfoContent[i] ).className = "hidden";
    }

    infoContent.className = "";
  }

  function veProductSelected( currentEvent, me, productListId, productSelected ) {
    var productList = document.getElementById( productListId );
    var idx = veFindItemByValue( productList, productSelected );
    if( idx != null ) {
      productList.options[ idx ].selected = !productList.options[ idx ].selected;
    }
  }

  function veProductLoad( currentEvent, me ) {
    me.disabled = me.checked;
  }

  var veEvents = {
    "vecontact_moreinfo": {
          "click": {
            prevent: true,
            funct: veProductOpenInfo,
            args: [ "vecontact_info_content", [ "vecontact_info_content", "veprompt_info_content" ] ]
          }
    },
    "vecontact_closeinfo": {
          "click": {
              prevent: true,
            funct: veProductCloseInfo,
            args: [ "vecontact_info_content" ]
          }
    },
    "veassist_moreinfo": {
          "click": {
            prevent: true,
            funct: veProductOpenInfo,
            args: [ "veprompt_info_content", [ "vecontact_info_content", "veprompt_info_content" ] ]
          }
    },
    "veprompt_closeinfo": {
          "click": {
            prevent: true,
            funct: veProductCloseInfo,
            args: [ "veprompt_info_content" ]
           }
    },
    "contactCb": {
          "click": {
            funct: veProductSelected,
            args: [ "veplatform_options_settings_products", "vecontact" ]
          },
          "load":{
              funct: veProductLoad
          }
    },
    "promptCb": {
          "click": {
              funct: veProductSelected,
            args: [ "veplatform_options_settings_products", "veprompt" ]
        },
          "load": {
              funct: veProductLoad
          }
    }
  };

  function veAddEvent( evnt, elem, func ) {
     if( elem.addEventListener ) { // W3C DOM
        elem.addEventListener( evnt, func, false );
     } else if( elem.attachEvent ) { // IE DOM
        elem.attachEvent( "on"+evnt, func );
     } else { // No much to do
        elem[ evnt ] = func;
     }
  }

  function veFindItemByValue( element, value ){
      var index = null;
      for( var i = 0; index == null && i < element.options.length; i++ ) {
          if( element.options[i].value === value ) {
              index = i;
          }
      }
      return index;
  }

  function veCall( currentEvent, me, funct, args ) {
    var new_args;

    if( typeof funct === "function" ) {
        new_args = [ currentEvent, me ];
        if( args ) new_args = new_args.concat( args );
        funct.apply( null, new_args );
    }
  }

  window.onload = function( onloadEvent ) {
    var onloadEvent = onloadEvent || window.event;

    for( var elementId in veEvents ){
      if(veEvents.hasOwnProperty(elementId)) {
        for( var eventId in veEvents[ elementId ] ) {
          if(veEvents[ elementId ].hasOwnProperty(eventId)) {
            if( eventId == "load" ) {
              veCall( onloadEvent, document.getElementById( elementId ), veEvents[elementId][eventId].funct, veEvents[elementId][eventId].args );
            }
            else {
              veAddEvent( eventId, document.getElementById( elementId ), function( currentEvent ) {
              var currentEvent = currentEvent || window.event;

              if( veEvents[this.id][currentEvent.type].prevent ) currentEvent.preventDefault();
                veCall( currentEvent, this, veEvents[this.id][currentEvent.type].funct, veEvents[this.id][currentEvent.type].args );
              });
            }
          }
        }
      }
    }
  };
}(window));

