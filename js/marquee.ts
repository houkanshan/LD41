(function() {
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame']
                                   || window[vendors[x]+'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function(callback) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() { callback(currTime + timeToCall); },
              timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };

    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
}());

export function renderMarquee(el) {
  const width = el.outerWidth(true)
  const _el = el.clone()
  el.parent().append(_el)
  let currLeft = 0
  const els = el.parent()
  let lastTime = null
  requestAnimationFrame(function next(time) {
    if (lastTime) {
      currLeft += (time - lastTime) / 20
      currLeft %= width
      els.css('transform', `translate3d(${-currLeft}px, 0, 0)`)
    }
    lastTime = time
    requestAnimationFrame(next)
  })
}