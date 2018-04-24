import * as $ from 'jquery'

const doc = $(document)
const win = $(window)

const textareas:Textarea[] = []

const backspaceCode = 8
doc.on('keydown', function(e) {
  const key = e.key
  const keyCode = e.keyCode
  const isDelete = keyCode === backspaceCode
  if (isDelete) {
    textareas.forEach((textarea) => {
      textarea.handleDelete()
    })
  } else if (/^[0-9a-zA-Z+,/\-\\:;"',.?!@#$%^&*()\[\]{}<>|_+~` ]$/.test(key)) {
    textareas.forEach((textarea) => {
      textarea.handleInput(key)
    })
  }
})

class Textarea {
  el: JQuery
  onChange: (string) => void
  hint: string
  value: string
  minLength: number
  maxLength: number
  isFocused: boolean
  wrongCount: number

  constructor({ el, onChange, maxLength = 0, minLength = 0, hint = '', value = '' }) {
    this.el = el
    this.onChange = onChange
    this.minLength = minLength
    this.maxLength = maxLength
    this.hint = hint
    this.value = value
    this.isFocused = false
    textareas.push(this)
    this.wrongCount = 0

    doc.on('click', (e) => {
      if ($(e.target).closest(this.el).length) {
        this.focus()
      } else {
        this.blur()
      }
    })
  }

  setHint(text: string) {
    this.hint = text
  }

  render() {
    let html = ''
    const input = this.value
    const origin = this.hint
    const inputLen = input.length
    const originLen = origin.length
    const len = Math.max(inputLen, originLen)
    let wrongCount = 0
    for (let i = 0; i < len; i++) {
      let char = ''
      if (i < inputLen) {
        if (originLen === 0 || input[i] === origin[i]) {
          char = `<span>${input[i]}</span>`
        } else {
          wrongCount += 1
          if (origin[i] === ' ') {
            char = `<b class='space'>${origin[i]}</b>`
          } else {
            char = `<b>${origin[i] || input[i]}</b>`
          }
        }
      } else if (i === inputLen) {
        char = `<i class="cursor">${origin[i]}</i>`
      } else {
        char = `<i>${origin[i]}</i>`
      }
      html += char
    }
    if (inputLen >= originLen) {
      html += '<i class="cursor"> </i>'
    }

    this.wrongCount = wrongCount


    let countHint = ''
    if (inputLen < this.minLength) {
      countHint = `<span class="count-hint">+${this.minLength - inputLen}</span>`
    } else if (this.maxLength && inputLen > this.maxLength) {
      countHint = `<span class="count-hint">-${inputLen - this.maxLength}</span>`
    }

    this.el[0].innerHTML = html + countHint
  }

  handleInput(char) {
    if (!this.isFocused) { return }
    this.value += char
    this.el.toggleClass('non-empty', this.value.length > 0)
    this.onChange.call(this, this.value, this.wrongCount)
    this.render()
  }
  handleDelete() {
    if (!this.isFocused) { return }
    this.value = this.value.slice(0, -1)
    this.el.toggleClass('non-empty', this.value.length > 0)
    this.onChange.call(this, this.value, this.wrongCount)
    this.render()
  }

  focus() {
    this.isFocused = true
    this.el.addClass('focused')
  }
  blur() {
    this.isFocused = false
    this.el.removeClass('focused')
  }
}

export default Textarea