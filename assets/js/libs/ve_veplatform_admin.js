(function (window, document){
  'use strict';

  function veAnimate(elem,style,unit,from,to,time,prop) {
    if( !elem) return;
    var start = new Date().getTime(),
        timer = setInterval(function() {
            var step = Math.min(1,(new Date().getTime()-start)/time);
            if (prop) {
                elem[style] = (from+step*(to-from))+unit;
            } else {
                elem.style[style] = (from+step*(to-from))+unit;
            }
            if( step == 1) clearInterval(timer);
        },25);

    elem.style[style] = from+unit;
  }

  function veAddEvent( evnt, elem, func ) {
    if( elem.addEventListener ) { // W3C DOM
      elem.addEventListener( evnt, func, false );
    }
    else if( elem.attachEvent ) { // IE DOM
      elem.attachEvent( "on"+evnt, func );
    }
    else { // No much to do
      elem[ evnt ] = func;
    }
  }

  function veQueryClass(matchClass) {
    var responseElems = [];
    var elems = document.getElementsByTagName('*'), i;

    for (i=0;i<elems.length;i++) {
      if((' ' + elems[i].className + ' ').indexOf(' ' + matchClass + ' ') > -1) {
          responseElems.push(elems[i]);
      }
    }

    return responseElems;
  }

  function veAddClass(elem, classToAdd) {
    if (elem.className.split(' ').indexOf(classToAdd) < 0) {
        elem.className = elem.className + ' ' + classToAdd;
    }
  }

  function veHasClass(elem, classToCheck) {
    return elem.className.match(new RegExp('(\\s|^)' + classToCheck + '(\\s|$)'));
  }

  function veRemoveClass(elem, classToRemove) {
    if (veHasClass(elem, classToRemove)) {
      var reg = new RegExp('(\\s|^)' + classToRemove + '(\\s|$)');
      elem.className = elem.className.replace(reg, ' ');
    }
  }

  function veCheckButton() {
    var confirmButton = document.getElementById('confirm-btn');
    var checkBoxes = veQueryClass('veplatform-checkbox');
    var itr;
    var allFalse = true;

    for (itr=0;itr<checkBoxes.length;itr++) {
      if(checkBoxes[itr].checked && !checkBoxes[itr].disabled) {
        allFalse = false;
      }
    }

    if(allFalse) {
      confirmButton.style.visibility = "hidden";
    }
    else {
      confirmButton.style.visibility = "visible";
    }
  }

  window.onload = function( onloadEvent ) {
    var iterator, logo, checkbox, button, closeButton, infoContentIterator;
    var buttons = veQueryClass('ve-open-info');
    var closeButtons = veQueryClass('ve-close-info');
    var infoContents = veQueryClass('ve-info-content');
    var checkBoxes = veQueryClass('veplatform-checkbox');
    var logos = veQueryClass('product-logo-clickable');

    // Check boxes
    for (iterator=0;iterator<logos.length;iterator++) {
      logo = logos[iterator];

      veAddEvent( 'click', logo, function(currentEvent) {
        var currentEvent = currentEvent || window.event;
        var that = this;
        var targetId = that.getAttribute('data-target');
        var target = document.getElementById(targetId);

        currentEvent.preventDefault();

        if(target.checked) {
          target.checked = false;
        }
        else {
          target.checked = true;
        }

        veCheckButton();
      });
    }

    // Check boxes
    for (iterator=0;iterator<checkBoxes.length;iterator++) {
      checkbox = checkBoxes[iterator];

      veAddEvent( 'change', checkbox, function(currentEvent) {
        veCheckButton();
      });
    }

    // Open buttons
    for (iterator=0;iterator<buttons.length;iterator++) {
      button = buttons[iterator];

      veAddEvent( 'click', button, function(currentEvent) {
        var currentEvent = currentEvent || window.event;
        var that = this;
        var infoContentIterator;
        var infoContent;
        var targetId = that.getAttribute('data-target');
        var target = document.getElementById(targetId);

        currentEvent.preventDefault();

        if(veHasClass(target, 'hidden')) {
          for(infoContentIterator=0;infoContentIterator<infoContents.length;infoContentIterator++) {
            infoContent = infoContents[infoContentIterator];
            veAddClass(infoContent, 'hidden');
          }

          veRemoveClass(target, 'hidden');
          veAnimate(document.documentElement, "scrollTop", "", document.documentElement.scrollTop, target.offsetTop, 300, true);
          veAnimate(document.body, "scrollTop", "", document.body.scrollTop, target.offsetTop, 300, true);
        }
        else {
          veAddClass(target, 'hidden');
        }
      });
    }

    // Close buttons
    for (iterator=0;iterator<closeButtons.length;iterator++) {
      closeButton = closeButtons[iterator];

      veAddEvent( 'click', closeButton, function(currentEvent) {
        var currentEvent = currentEvent || window.event;
        var that = this;
        var targetId = that.getAttribute('data-target');
        var target = document.getElementById(targetId);

        currentEvent.preventDefault();

        veAddClass(target, 'hidden');
      });
    }

    veCheckButton();
  };

}(window, document));
