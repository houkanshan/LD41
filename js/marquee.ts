export function renderMarquee(el) {
  const width = el.outerWidth(true)
  const _el = el.clone()
  el.parent().append(_el)
  let currLeft = 0
  const els = el.parent()
  setTimeout(function next() {
    els.css('transform', `translateX(${-currLeft}px)`)
    currLeft += 1
    currLeft %= width
    setTimeout(next, 20)
  }, 20)
}