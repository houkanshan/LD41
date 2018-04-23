export function renderMarquee(el) {
  const width = el.outerWidth(true)
  const _el = el.clone()
  el.parent().append(_el)
  let currLeft = 0
  const els = el.parent()
  setTimeout(function next() {
    els.css('transform', `translate3d(${-currLeft}px, 0, 0)`)
    currLeft += 1
    currLeft %= width
    setTimeout(next, 20)
  }, 20)
}