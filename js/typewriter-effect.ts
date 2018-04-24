import * as $ from 'jquery'

const head = $(document.head)

class TypewriterEffect {
  start: number
  end: number
  text: string
  cursor: number
  timer: number
  selector: string
  styleEl: JQuery

  constructor(selector) {
    this.start = 0
    this.end = 0
    this.text = ''
    this.cursor = 0
    this.styleEl = $('<style>')
    this.selector = selector
    head.append(this.styleEl)
  }
  startTyping(start, text) {
    this.start = start
    this.end = start + text.length
    this.text = text
    this.cursor = 0
    clearTimeout(this.timer)

    const typeNext = () => {
      this.cursor += 1
      const currChar = text[this.cursor]
      this.styleEl.text(`${this.selector} > :nth-child(n+${this.cursor + 1 + this.start}) { opacity: 0; }`)
      if (this.cursor < this.end - 1) {
        let delayTime = 30
        switch (currChar) {
          case ' ': delayTime = 60;break;
          case ',': delayTime = 100;break;
          case '.': delayTime = 200;break;
        }
        this.timer = setTimeout(typeNext, Math.random() * 30 + delayTime)
      }
    }
    typeNext()
  }
}

export default TypewriterEffect