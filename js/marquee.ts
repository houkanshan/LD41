export function renderMarquee(el) {
  const width = el.outerWidth(true)
  el.parent().append(el.clone())
  let currLeft = 0
  debugger
  setTimeout(function next() {
    el.css('margin-left', -currLeft)
    currLeft += 1
    currLeft %= width
    setTimeout(next, 20)
  }, 20)
}