import * as $ from 'jquery'
import Textarea from './textarea'

const doc = $(document)
const win = $(window)

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

const textareaWin = new Textarea({
  el: $('#textarea-win'),
  onChange: function(value) {
    this.setHint(getOrigin(value.length))
  },
  hint: getOrigin(0),
})
textareaWin.render()

const textareaLose = new Textarea({
  el: $('#textarea-lose'),
  onChange: function() {},
  maxLength: 2,
})
textareaLose.render()