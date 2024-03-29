//Globale Variablen

var anzBilder = 0;

function makeResizableDiv(div) {
  console.log("Funktionsaufruf");
    const element = document.querySelector(div);
    const resizers = document.querySelectorAll(div + ' .resizer')
    const minimum_size = 20;
    let original_width = 0;
    let original_height = 0;
    let original_x = 0;
    let original_y = 0;
    let original_mouse_x = 0;
    let original_mouse_y = 0;
    for (let i = 0;i < resizers.length; i++) {
      const currentResizer = resizers[i];
      currentResizer.addEventListener('mousedown', function(e) {
        e.preventDefault()
        original_width = parseFloat(getComputedStyle(element, null).getPropertyValue('width').replace('px', ''));
        original_height = parseFloat(getComputedStyle(element, null).getPropertyValue('height').replace('px', ''));
        original_x = element.getBoundingClientRect().left;
        original_y = element.getBoundingClientRect().top;
        original_mouse_x = e.pageX;
        original_mouse_y = e.pageY;
        window.addEventListener('mousemove', resize)
        window.addEventListener('mouseup', stopResize)
      })
      
      function resize(e) {
        if (currentResizer.classList.contains('bottom-right')) {
          const width = original_width + (e.pageX - original_mouse_x);
          const height = original_height + (e.pageY - original_mouse_y)
          if (width > minimum_size) {
            element.style.width = width + 'px'
          }
          if (height > minimum_size) {
            element.style.height = height + 'px'
          }
        }
        else if (currentResizer.classList.contains('bottom-left')) {
          const height = original_height + (e.pageY - original_mouse_y)
          const width = original_width - (e.pageX - original_mouse_x)
          if (height > minimum_size) {
            element.style.height = height + 'px'
          }
          if (width > minimum_size) {
            element.style.width = width + 'px'
            element.style.left = original_x + (e.pageX - original_mouse_x) + 'px'
          }
        }
        else if (currentResizer.classList.contains('top-right')) {
          const width = original_width + (e.pageX - original_mouse_x)
          const height = original_height - (e.pageY - original_mouse_y)
          if (width > minimum_size) {
            element.style.width = width + 'px'
          }
          if (height > minimum_size) {
            element.style.height = height + 'px'
            element.style.top = original_y + (e.pageY - original_mouse_y) + 'px'
          }
        }
        else {
          const width = original_width - (e.pageX - original_mouse_x)
          const height = original_height - (e.pageY - original_mouse_y)
          if (width > minimum_size) {
            element.style.width = width + 'px'
            element.style.left = original_x + (e.pageX - original_mouse_x) + 'px'
          }
          if (height > minimum_size) {
            element.style.height = height + 'px'
            element.style.top = original_y + (e.pageY - original_mouse_y) + 'px'
          }
        }
      }
      
      function stopResize() {
        window.removeEventListener('mousemove', resize)
      }
    }
  }
  
  //  makeResizableDiv('.resizable')


  function addAChild () {
    anzBilder++;
    var Ausgabebereich = document.getElementById('main');
    var imageBox = document.createElement('div');
    imageBox.className = 'resizable';
    imageBox.id = "imageBox"+anzBilder;
    imageBox.style.backgroundImage = "url('../Bilder/Banner.png')";
    imageBox.style.backgroundRepeat   = "no-repeat";
    imageBox.style.backgroundSize   = "contain";
    
    var resizersBox = document.createElement("div");
    resizersBox.className = 'resizers';

    var resizers1 = document.createElement("div");
    resizers1.className = 'resizer top-left';
    var resizers2 = document.createElement("div");
    resizers2.className = 'resizer top-right';
    var resizers3 = document.createElement("div");
    resizers3.className = 'resizer bottom-left';
    var resizers4 = document.createElement("div");
    resizers4.className = 'resizer bottom-right';

    resizersBox.appendChild(resizers1);
    resizersBox.appendChild(resizers2);
    resizersBox.appendChild(resizers3);
    resizersBox.appendChild(resizers4);
    imageBox.appendChild(resizersBox);
    Ausgabebereich.appendChild(imageBox);

    // makeResizableDiv('.resizable');
    makeResizableDiv('#imageBox'+anzBilder);
  }

  function init () {
    var element  = document.getElementById ('button');
    element.addEventListener ('click', addAChild);
  }
  
  document.addEventListener('DOMContentLoaded', init);