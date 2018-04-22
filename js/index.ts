import * as $ from 'jquery'

const doc = $(document)
const win = $(window)
const textarea = $('#textarea')

const text = [
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
  'Curabitur egestas, elit sit amet tristique consequat, ',
  'mauris est placerat metus, et fermentum ■orci ante sed odio.'
]
const textLengthMap = text.reduce(function(acc, value) {
  return acc + value.length
}, 0)

function getOrigin(len) {
  for (let i = 0, ilen = text.length; i < ilen; i++) {
    if (textLengthMap[i] > len) {
      return text.slice(0, i + 1).join('')
    }
  }
  return text.join('')
}

function renderTextarea(textarea, input) {
  let html = ''
  const origin = getOrigin(input.length)
  const inputLen = input.length
  const originLen = origin.length
  for (let i = 0; i < originLen; i++) {
    let char = ''
    if (i < inputLen) {
      if (input[i] === origin[i]) {
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
  textarea[0].innerHTML = html
}

const backspaceCode = 8
let userText = ''
doc.on('keydown', function(e) {
  const key = e.key
  const keyCode = e.keyCode
  const isDelete = keyCode === backspaceCode
  if (isDelete) {
    userText = userText.slice(0, -1)
  } else if (/^[0-9a-zA-Z+,/\-\\:;"',.?!@#$%^&*()\[\]{}<>|_+~` ]$/.test(key)) {
    userText += key
  }

  renderTextarea(textarea, userText)
})

renderTextarea(textarea, userText)