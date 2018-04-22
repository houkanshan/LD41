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
  maxLength: number
  isFocused: boolean

  constructor({ el, onChange, maxLength = 0, hint = '' }) {
    this.el = el
    this.onChange = onChange
    this.maxLength = maxLength
    this.hint = hint
    this.value = ''
    this.isFocused = false
    textareas.push(this)

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
    for (let i = 0; i < len; i++) {
      let char = ''
      if (i < inputLen) {
        if (originLen === 0 || input[i] === origin[i]) {
          char = input[i]
        } else {
          char = `<b>${input[i]}</b>`
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
    this.el[0].innerHTML = html
  }

  handleInput(char) {
    if (!this.isFocused) { return }
    this.value += char
    if (this.maxLength > 0) {
      this.value = this.value.slice(0, this.maxLength)
    }
    this.onChange.call(this, this.value)
    this.render()
  }
  handleDelete() {
    if (!this.isFocused) { return }
    this.value = this.value.slice(0, -1)
    this.onChange.call(this, this.value)
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